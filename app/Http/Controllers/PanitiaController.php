<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class PanitiaController extends Controller
{
    // ==========================================
    // 1. Menampilkan Halaman Dashboard
    // ==========================================
    public function index()
    {
        // PERBAIKAN: Cari event berdasarkan 'event_id' yang menempel di akun user panitia
        $event = Event::find(Auth::user()->event_id);

        return view('panitia.dashboard', compact('event'));
    }

    // ==========================================
    // 2. Menampilkan Halaman Scanner
    // ==========================================
    public function scanner()
    {
        $event = Event::find(Auth::user()->event_id);

        // Jika panitia belum punya event, cegah masuk ke scanner
        if (!$event) {
            return redirect()->route('panitia.dashboard')->with('error', 'Akses ditolak: Anda belum terikat dengan event apa pun.');
        }

        // Catatan: Pastikan file blade scanner milikmu bernama admin/scanner.blade.php
        return view('admin.scanner', compact('event'));
    }

    // ==========================================
    // 3. Menampilkan Daftar Hadir
    // ==========================================
    public function attendance()
    {
        $event = Event::find(Auth::user()->event_id);

        // Jika tidak ada event, kembalikan ke dashboard
        if (!$event) {
            return redirect()->route('panitia.dashboard')->with('error', 'Akses ditolak: Sistem tidak menemukan event Anda.');
        }

        // Ambil SEMUA transaksi LUNAS untuk event ini
        $attendees = Transaction::with(['user', 'event'])
                        ->where('event_id', $event->id)
                        ->where('payment_status', 'paid')
                        // Urutkan: Yang belum hadir (0) di atas, yang sudah hadir (1) di bawah
                        ->orderBy('is_checked_in', 'asc')
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Hitung statistik untuk informasi tambahan panitia
        $totalPeserta = $attendees->count();
        $totalHadir = $attendees->where('is_checked_in', true)->count();
        $totalBelum = $totalPeserta - $totalHadir;

        return view('panitia.attendance', compact('attendees', 'event', 'totalPeserta', 'totalHadir', 'totalBelum'));
    }

    // ==========================================
    // 4. Menampilkan Info Event
    // ==========================================
    public function eventInfo()
    {
        $event = Event::find(Auth::user()->event_id);

        if (!$event) {
            return redirect()->route('panitia.dashboard')->with('error', 'Akses ditolak: Anda belum ditugaskan mengelola event apa pun.');
        }

        return view('panitia.event_info', compact('event'));
    }

    // ==========================================
    // 5. Memproses Hasil Scan QR Code dari Kamera
    // ==========================================
    public function processScan(Request $request)
    {
        // 1. Tangkap kode QR yang dikirim oleh kamera HP panitia
        $qrCode = $request->input('ticket_code');

        // 2. Kenali event yang sedang dijaga oleh panitia ini
        $event = Event::find(Auth::user()->event_id);

        // 3. Cari data tiket di database berdasarkan kode QR tersebut
        $ticket = \App\Models\Ticket::with('transaction.user')
                    ->where('ticket_code', $qrCode)
                    ->first();

        // ─── MULAI VALIDASI KEAMANAN ───

        // Validasi 1: Apakah tiket ada di database?
        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket palsu atau tidak ditemukan di sistem!'
            ]);
        }

        // Validasi 2: Apakah tiket ini untuk event yang benar?
        // (Mencegah tiket konser A dipakai untuk masuk konser B)
        if ($ticket->transaction->event_id != $event->id) {
             return response()->json([
                 'status' => 'error',
                 'message' => 'Tiket ini berlaku untuk event lain, bukan event ini!'
             ]);
        }

        // Validasi 3: Apakah tiket sudah pernah di-scan sebelumnya? (Mencegah tiket ganda/fotokopi)
        if ($ticket->is_scanned) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak! Tiket ini sudah digunakan sebelumnya.'
            ]);
        }

        // ─── TIKET VALID ───

        // 4. Jika lolos semua validasi di atas, ubah status tiket menjadi "Sudah digunakan" (Hadir)
        $ticket->update(['is_scanned' => true]);

        // 5. Ambil nama pembeli untuk ditampilkan di layar sukses panitia
        $namaPembeli = $ticket->transaction->user->name;

        // 6. Kirim respon sukses ke layar HP panitia
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil! Tiket atas nama ' . $namaPembeli . ' valid. Silakan masuk.'
        ]);
    }
}
