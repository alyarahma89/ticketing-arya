<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Event;

class SponsorshipController extends Controller
{
    // ==========================================
    // FUNGSI MENAMPILKAN DAFTAR SPONSOR (INDEX)
    // ==========================================
    public function index()
    {
        // Mengambil semua data sponsorship beserta data event yang terelasi, diurutkan dari yang terbaru
        $sponsorships = Sponsorship::with('event')->latest()->get();

        // Mengarahkan ke file resources/views/admin/sponsorships/index.blade.php
        return view('admin.sponsorships.index', compact('sponsorships'));
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        // Mengambil semua data event untuk ditampilkan di pilihan dropdown
        $events = Event::all();

        return view('admin.sponsorships.create', compact('events'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN DATA BARU (STORE)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Validasi Inputan
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'benefits' => 'required|string',
            'quota'    => 'required|integer|min:1',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);

        // 2. Proses Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'storage/app/public/sponsors'
            $validated['image'] = $request->file('image')->store('sponsors', 'public');
        }

        // 3. Simpan ke database
        Sponsorship::create($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil ditambahkan!');
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM EDIT (EDIT) ---> INI YANG TADI HILANG!
    // ==========================================
    public function edit($id)
    {
        $sponsor = Sponsorship::findOrFail($id);
        $events = Event::all(); // Untuk dropdown pilihan event

        return view('admin.sponsorships.edit', compact('sponsor', 'events'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN PERUBAHAN (UPDATE) ---> INI JUGA TADI HILANG!
    // ==========================================
    public function update(Request $request, $id)
    {
        $sponsor = Sponsorship::findOrFail($id);

        // 1. Validasi Inputan Baru
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'benefits' => 'required|string',
            'quota'    => 'required|integer|min:1',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Proses Upload Gambar Baru (Jika admin ganti gambar)
        if ($request->hasFile('image')) {
            // Hapus gambar lama agar tidak menumpuk di memori
            if ($sponsor->image && \Storage::disk('public')->exists($sponsor->image)) {
                \Storage::disk('public')->delete($sponsor->image);
            }
            // Simpan gambar baru
            $validated['image'] = $request->file('image')->store('sponsors', 'public');
        }

        // 3. Update Database
        $sponsor->update($validated);

        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil diperbarui!');
    }

    // ==========================================
    // FUNGSI MENGHAPUS SPONSOR (DESTROY)
    // ==========================================
    public function destroy($id)
    {
        $sponsor = Sponsorship::findOrFail($id);

        // Hapus gambar dari folder komputermu (jika ada) agar tidak penuh
        if ($sponsor->image && \Storage::disk('public')->exists($sponsor->image)) {
            \Storage::disk('public')->delete($sponsor->image);
        }

        // Hapus datanya dari database
        $sponsor->delete();

        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil dihapus!');
    }

    // ==========================================
    // FUNGSI UNTUK MENAMPILKAN FORMULIR PENGAJUAN (PUBLIK)
    // ==========================================
    public function apply($id)
    {
        // Mengambil data paket sponsor beserta event-nya
        $sponsorship = \App\Models\Sponsorship::with('event')->findOrFail($id);

        // Menampilkan halaman form
        return view('sponsorship-apply', compact('sponsorship'));
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN DATA PENGAJUAN (PUBLIK)
    // ==========================================
    public function submitApplication(Request $request, $id)
    {
        // 1. Validasi data yang diisi perusahaan
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        // 2. Simpan ke tabel sponsorship_transactions
        \App\Models\SponsorshipTransaction::create([
            'sponsorship_id' => $id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'message' => $request->message,
            'status' => 'pending', // Status otomatis pending (menunggu persetujuan EO)
        ]);

        // 3. Arahkan kembali ke beranda dengan pesan sukses
        return redirect('/')->with('success', 'Pengajuan sponsorship berhasil dikirim! Silakan tunggu EO menghubungi Anda.');
    }

    // ==========================================
    // FUNGSI UNTUK MENAMPILKAN DAFTAR PENGAJUAN (DI DASBOR EO/ADMIN)
    // ==========================================
    public function requests()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Mulai query untuk mengambil data transaksi pengajuan beserta relasinya
        $query = \App\Models\SponsorshipTransaction::with(['sponsorship.event', 'user'])->latest();

        // Jika yang login adalah EO, pastikan dia hanya melihat pengajuan untuk event miliknya
        if ($user->role === 'eo') {
            $query->whereHas('sponsorship.event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $requests = $query->get();

        return view('admin.sponsorships.requests', compact('requests'));
    }

    // ==========================================
    // FUNGSI UNTUK MENGUBAH STATUS PENGAJUAN (TERIMA/TOLAK)
    // ==========================================
    // ==========================================
    // FUNGSI UNTUK MENGUBAH STATUS ATAU PEMBAYARAN PENGAJUAN
    // ==========================================
    public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        $transaction = \App\Models\SponsorshipTransaction::findOrFail($id);

        // Jika EO mengubah status (Terima/Tolak)
        if ($request->has('status')) {
            $request->validate(['status' => 'required|in:pending,approved,rejected']);
            $transaction->update(['status' => $request->status]);
        }

        // Jika EO menekan tombol "Tandai Lunas"
        if ($request->has('payment_status')) {
            $request->validate(['payment_status' => 'required|in:unpaid,paid']);
            $transaction->update(['payment_status' => $request->payment_status]);
        }

        return back()->with('success', 'Data pengajuan sponsor berhasil diperbarui!');
    }
}
