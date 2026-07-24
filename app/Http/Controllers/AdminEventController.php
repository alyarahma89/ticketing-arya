<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Revenue;
use App\Models\Category; // <-- JANGAN LUPA TAMBAHKAN INI
use App\Models\Sponsorship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // 1. KITA BUAT PERSIAPAN PENGAMBILAN DATA (Belum dieksekusi)
        $queryEvent = Event::query();
        $queryTransaction = Transaction::where('payment_status', 'paid');
        $queryRevenue = Revenue::query();
        $querySponsorship = Sponsorship::query();

        // 2. GERBANG LOGIKA ISOLASI: JIKA EO, KUNCI DATANYA HANYA UNTUK DIA
        if ($user->role === 'eo') {
            // Hanya ambil event yang user_id-nya sama dengan ID EO yang login
            $queryEvent->where('user_id', $user->id);

            // Hanya ambil transaksi yang terhubung ke event milik EO ini
            $queryTransaction->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            // Hanya ambil pendapatan yang terhubung ke event milik EO ini
            $queryRevenue->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            // Hanya ambil sponsorship yang terhubung ke event milik EO ini
            $querySponsorship->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. EKSEKUSI PENGHITUNGAN KARTU STATISTIK
        // (Akan otomatis menghitung semua untuk Admin, atau menghitung sebagian untuk EO)
        $eventAktif = $queryEvent->count();
        $tiketTerjual = $queryTransaction->sum('quantity');
        $totalPendapatan = $queryRevenue->sum('amount');
        $pendapatanSponsor = $querySponsorship->sum('price');

        // Mengambil 5 event terakhir (akan otomatis terfilter)
        $activeEvents = $queryEvent->latest()->take(5)->get();

        // Khusus untuk jumlah pengguna (karena logikanya sedikit berbeda)
        if ($user->role === 'eo') {
            // EO hanya melihat total peserta unik yang pernah membeli tiket acaranya
            $totalPengguna = Transaction::whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->distinct('user_id')->count('user_id');
        } else {
            // Admin melihat semua akun (User, EO, Panitia) yang terdaftar di aplikasi
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

    
    // HANYA UNTUK MANAJEMEN EVENT (Tabel)
    public function index()
    {
        $user = Auth::user();

        // Cek jika yang login adalah EO
        if ($user->role === 'eo') {
            // EO hanya mengambil event miliknya sendiri beserta relasi kategorinya
            $events = Event::with('category')->where('user_id', $user->id)->get();
        } else {
            // Admin mengambil semua event beserta relasi kategorinya
            $events = Event::with('category')->get();
        }

        $sponsorships = Sponsorship::all();

        return view('admin.events.index', compact('events', 'sponsorships'));
    }

    // DIPERBARUI: Mengirim variabel $categories ke tampilan form tambah
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN EVENT BARU (CREATE)
    // ==========================================
    public function store(Request $request)
    {
        // Validasi diperbarui: category menjadi category_id
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // <-- Harus ada di tabel categories
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        // DIPERBARUI: Logika Hybrid. Kita ambil dulu nama kategorinya berdasarkan category_id yang dipilih
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

    // DIPERBARUI: Mengirim variabel $categories ke tampilan form edit
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all(); // <-- Menambahkan data kategori

        return view('admin.events.edit', compact('event', 'categories'));
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN EDIT EVENT (UPDATE)
    // ==========================================
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validasi diperbarui: category menjadi category_id
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // <-- Diperbarui
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'online_price' => 'nullable|numeric|min:0',
            'quota' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        // DIPERBARUI: Logika Hybrid
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

    // ==========================================
    // FUNGSI UNTUK MENGHAPUS EVENT (DESTROY)
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

    public function byCategory($id)
    {
        // Mengambil data kategori untuk judul halaman
        $category = \App\Models\Category::findOrFail($id);

        // Mengambil semua event yang memiliki category_id tersebut
        $events = \App\Models\Event::where('category_id', $id)->get();

        // Mengirim ke view (kamu bisa buat view baru atau pakai index.blade.php)
        return view('events.index', compact('events', 'category'));
    }
}
