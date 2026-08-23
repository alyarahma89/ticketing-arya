<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Revenue;
use App\Models\Category;
use App\Models\Sponsorship;
use App\Models\SponsorshipTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    // ==========================================
    // FUNGSI DASHBOARD (STATISTIK OTOMATIS & FILTER TAHUN)
    // ==========================================
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $selectedYear = $request->input('year', 2026);

        $queryEvent = Event::whereYear('event_date', $selectedYear);

        $queryTransaction = Transaction::whereIn('payment_status', ['paid', 'success', 'settlement'])
                                       ->whereYear('created_at', $selectedYear);

        $querySponsorApproved = SponsorshipTransaction::where('status', 'approved')
                                    ->where('payment_status', 'paid')
                                    ->whereYear('created_at', $selectedYear)
                                    ->with('sponsorship');

        if ($user->role === 'eo') {
            $queryEvent->where('user_id', $user->id);

            $queryTransaction->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            $querySponsorApproved->whereHas('sponsorship.event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $eventAktif = $queryEvent->count();
        $tiketTerjual = (clone $queryTransaction)->sum('quantity');
        $totalPendapatan = (clone $queryTransaction)->sum('total_amount');

        $pendapatanSponsor = $querySponsorApproved->get()->sum(function ($transaction) {
            return $transaction->sponsorship->price ?? 0;
        });

        $activeEvents = $queryEvent->latest()->take(5)->get();

        if ($user->role === 'eo') {
            $totalPengguna = (clone $queryTransaction)->distinct('user_id')->count('user_id');
        } else {
            $totalPengguna = User::whereYear('created_at', $selectedYear)->count();
        }

        $monthlySales = clone $queryTransaction;
        $monthlySales = $monthlySales->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = isset($monthlySales[$i]) ? $monthlySales[$i] / 1000000 : 0;
        }

        $categoryQuery = Event::join('transactions', 'events.id', '=', 'transactions.event_id')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->whereIn('transactions.payment_status', ['paid', 'success', 'settlement'])
            ->whereYear('transactions.created_at', $selectedYear);

        if ($user->role === 'eo') {
            $categoryQuery->where('events.user_id', $user->id);
        }

        $categoryData = $categoryQuery->select('categories.name as category_name', DB::raw('SUM(transactions.quantity) as total'))
            ->groupBy('categories.name')
            ->pluck('total', 'category_name')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'tiketTerjual',
            'eventAktif',
            'totalPengguna',
            'pendapatanSponsor',
            'salesData',
            'categoryData',
            'activeEvents',
            'selectedYear'
        ));
    }

    // ==========================================
    // FUNGSI MENAMPILKAN DAFTAR EVENT (DENGAN SEARCH & FILTER)
    // ==========================================
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Event::with('category');

        if ($user->role === 'eo') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $sekarang = \Carbon\Carbon::now();

            if ($request->status === 'active') {
                $query->where('event_date', '>=', $sekarang);
            } elseif ($request->status === 'inactive') {
                $query->where('event_date', '<', $sekarang);
            }
        }

        $events = $query->latest()->get();
        $sponsorships = Sponsorship::all();

        return view('admin.events.index', compact('events', 'sponsorships'));
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM TAMBAH EVENT
    // ==========================================
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN EVENT BARU (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1', // Total kapasitas seluruh gedung/acara
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'secret_code' => 'nullable|string|max:255',

            // ── VALIDASI KHUSUS PAKET TIKET DINAMIS ──
            'packages' => 'nullable|array',
            'packages.*.name' => 'required_with:packages|string|max:255',
            'packages.*.price' => 'required_with:packages|numeric|min:0',
            'packages.*.quota' => 'required_with:packages|numeric|min:1',
        ]);

        $validated['user_id'] = Auth::id();

        // Ambil harga dari paket pertama sebagai harga dasar (untuk ditampilkan di beranda)
        if ($request->has('packages') && count($request->packages) > 0) {
            $validated['price'] = $request->packages[0]['price'];
        } else {
            $validated['price'] = 0;
        }

        if (!$request->has('is_offline')) {
            $validated['location'] = null;
            $validated['price'] = 0;
        }

        if (!$request->has('is_online')) {
            $validated['youtube_link'] = null;
            $validated['online_price'] = 0;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('event-posters', 'public');
        }

        // Simpan Data Acara (Event)
        $event = Event::create($validated);

        // ── SIMPAN SETIAP PAKET TIKET KE TABEL BARU ──
        if ($request->has('packages') && $request->has('is_offline')) {
            foreach ($request->packages as $package) {
                \App\Models\TicketPackage::create([
                    'event_id' => $event->id,
                    'name' => $package['name'],
                    'price' => $package['price'],
                    'quota' => $package['quota'],
                ]);
            }
        }

        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $path = $file->store('event-galleries', 'public');
                \App\Models\Gallery::create([
                    'event_id' => $event->id,
                    'image'    => $path
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event baru beserta pilihan paket tiket berhasil ditambahkan!');
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM EDIT EVENT
    // ==========================================
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN PERUBAHAN EVENT (UPDATE)
    // ==========================================
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'price' => 'nullable|numeric|min:0',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'secret_code' => 'nullable|string|max:255', // <-- INI YANG BARU KITA TAMBAHKAN
        ]);

        if (!$request->has('is_offline')) {
            $validated['location'] = null;
            $validated['price'] = 0;
        }

        if (!$request->has('is_online')) {
            $validated['youtube_link'] = null;
            $validated['online_price'] = 0;
        }

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('event-posters', 'public');
        }

        // Karena 'secret_code' sudah divalidasi, ia akan otomatis ikut diperbarui di sini
        $event->update($validated);

        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $path = $file->store('event-galleries', 'public');
                \App\Models\Gallery::create([
                    'event_id' => $event->id,
                    'image'    => $path
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil diperbarui!');
    }

    // ==========================================
    // FUNGSI MENGHAPUS EVENT (DESTROY)
    // ==========================================
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus!');
    }

    // ==========================================
    // FUNGSI LAINNYA
    // ==========================================
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);
        $events = Event::where('category_id', $id)->get();
        $sponsorships = \App\Models\Sponsorship::all();

        return view('events.index', compact('events', 'category', 'sponsorships'));
    }

    public function sponsorship($id)
    {
        $event = \App\Models\Event::with('sponsorships')->findOrFail($id);
        return view('sponsorship', compact('event'));
    }
}
