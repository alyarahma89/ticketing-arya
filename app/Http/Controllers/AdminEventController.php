<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Revenue;
use App\Models\Category;
use App\Models\Sponsorship;
use App\Models\SponsorshipTransaction; // <-- PERBAIKAN: Menambahkan model ini
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // 1. KITA BUAT PERSIAPAN PENGAMBILAN DATA
        $queryEvent = Event::query();
        $queryTransaction = Transaction::where('payment_status', 'paid');
        $queryRevenue = Revenue::query();

        // PERBAIKAN FINAL: Ambil transaksi yang statusnya DITERIMA & SUDAH LUNAS
        $querySponsorApproved = SponsorshipTransaction::where('status', 'approved')
                                    ->where('payment_status', 'paid') // <-- TAMBAHAN BARU
                                    ->with('sponsorship');

        // 2. GERBANG LOGIKA ISOLASI: JIKA EO, KUNCI DATANYA HANYA UNTUK DIA
        if ($user->role === 'eo') {
            // Hanya ambil event milik EO ini
            $queryEvent->where('user_id', $user->id);

            // Hanya ambil transaksi tiket untuk event milik EO ini
            $queryTransaction->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            // Hanya ambil pendapatan tiket dari event milik EO ini
            $queryRevenue->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            // Hanya ambil transaksi sponsor yang terhubung ke event milik EO ini
            $querySponsorApproved->whereHas('sponsorship.event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. EKSEKUSI PENGHITUNGAN KARTU STATISTIK
        $eventAktif = $queryEvent->count();
        $tiketTerjual = $queryTransaction->sum('quantity');
        $totalPendapatan = $queryRevenue->sum('amount');

        // PERBAIKAN: Menjumlahkan harga sponsor HANYA dari pengajuan yang disetujui dan lunas
        $pendapatanSponsor = $querySponsorApproved->get()->sum(function ($transaction) {
            return $transaction->sponsorship->price ?? 0;
        });

        // Mengambil 5 event terakhir
        $activeEvents = $queryEvent->latest()->take(5)->get();

        // Khusus untuk jumlah pengguna
        if ($user->role === 'eo') {
            $totalPengguna = Transaction::whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->distinct('user_id')->count('user_id');
        } else {
            $totalPengguna = User::count();
        }

        // 4. EKSEKUSI DATA GRAFIK (Dengan filter yang sama)

        // A. Grafik Penjualan Bulanan
        $salesQuery = Revenue::whereYear('created_at', 2026);
        if ($user->role === 'eo') {
            $salesQuery->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $monthlySales = $salesQuery->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = isset($monthlySales[$i]) ? $monthlySales[$i] / 1000000 : 0;
        }

        // B. Grafik Proporsi Kategori
        $categoryQuery = Event::join('transactions', 'events.id', '=', 'transactions.event_id')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('transactions.payment_status', 'paid');

        if ($user->role === 'eo') {
            $categoryQuery->where('events.user_id', $user->id);
        }

        $categoryData = $categoryQuery->select('categories.name as category_name', DB::raw('SUM(transactions.quantity) as total'))
            ->groupBy('categories.name')
            ->pluck('total', 'category_name')
            ->toArray();

        // 5. KIRIM DATA KE HALAMAN VIEW
        return view('admin.dashboard', compact(
            'totalPendapatan',
            'tiketTerjual',
            'eventAktif',
            'totalPengguna',
            'pendapatanSponsor',
            'salesData',
            'categoryData',
            'activeEvents'
        ));
    }


    // ==========================================
    // FUNGSI UNTUK MANAJEMEN EVENT
    // ==========================================
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'eo') {
            $events = Event::with('category')->where('user_id', $user->id)->get();
        } else {
            $events = Event::with('category')->get();
        }

        $sponsorships = Sponsorship::all();

        return view('admin.events.index', compact('events', 'sponsorships'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        $kategoriDipilih = Category::find($request->category_id);
        $hybridCategories = ['LIVE CONCERT', 'WORKSHOP', 'STAND UP COMEDY'];

        if ($kategoriDipilih && !in_array(strtoupper($kategoriDipilih->name), $hybridCategories)) {
            $validated['youtube_link'] = null;
            $validated['online_price'] = 0;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('event-posters', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        $kategoriDipilih = Category::find($request->category_id);
        $hybridCategories = ['LIVE CONCERT', 'WORKSHOP', 'STAND UP COMEDY'];

        if ($kategoriDipilih && !in_array(strtoupper($kategoriDipilih->name), $hybridCategories)) {
            $validated['youtube_link'] = null;
            $validated['online_price'] = 0;
        }

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('event-posters', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus!');
    }

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
