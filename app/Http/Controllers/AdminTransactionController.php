<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminTransactionController extends Controller
{
    // ==========================================
    // FUNGSI MENAMPILKAN DAFTAR TRANSAKSI (DENGAN PENCARIAN)
    // ==========================================
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Siapkan query dasar dengan relasi tabel user dan event
        $query = Transaction::with(['user', 'event']);

        // 2. Batasi khusus EO (Hanya lihat transaksi dari event miliknya)
        if ($user->role === 'eo') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. MESIN PENCARI (Berdasarkan Order ID, Nama Pembeli, Email, atau Nama Event)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Order ID
                $q->where('order_id', 'like', '%' . $search . '%')
                  // ATAU cari di dalam data User (Nama & Email)
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
                  })
                  // ATAU cari di dalam data Event (Nama Event)
                  ->orWhereHas('event', function($eq) use ($search) {
                      $eq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // 4. Eksekusi query (Urutkan dari yang terbaru)
        $transactions = $query->latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    // ==========================================
    // FUNGSI UNTUK MEMPROSES REFUND (DUA TAHAP)
    // ==========================================
    public function processRefund(Request $request, $id)
    {
        $transaction = Transaction::with(['event', 'user'])->findOrFail($id);
        $user = Auth::user();

        // PENGAMANAN: Pastikan EO hanya bisa mengelola transaksi dari event miliknya
        if ($user->role === 'eo' && $transaction->event->user_id !== $user->id) {
            return back()->with('error', 'Akses ditolak!');
        }

        // TAHAP 1: EO Membatalkan Tiket
        if (in_array($transaction->payment_status, ['paid', 'success', 'settlement'])) {
            $transaction->update(['payment_status' => 'refund_processing']);

            // --- LOGIKA MENGIRIM EMAIL OTOMATIS KE PEMBELI ---
            $pesanEmail = "Halo " . ($transaction->user->name ?? 'Pembeli') . ",\n\n"
                        . "Pesanan tiket Anda untuk event *" . ($transaction->event->name ?? 'Event') . "* telah dibatalkan oleh pihak penyelenggara.\n\n"
                        . "Mohon balas email ini dengan melampirkan informasi berikut agar kami dapat mentransfer kembali dana Anda:\n"
                        . "1. Nama Bank\n"
                        . "2. Nomor Rekening\n"
                        . "3. Nama Pemilik Rekening\n\n"
                        . "Terima kasih,\n"
                        . "Tim Panitia " . ($transaction->event->name ?? 'Event');

            // Menggunakan Mail::raw untuk mengirim teks sederhana
            try {
                Mail::raw($pesanEmail, function ($message) use ($transaction) {
                    $message->to($transaction->user->email)
                            ->subject('Pengembalian Dana Tiket - ' . ($transaction->event->name ?? 'ARTIX ID'));
                });
            } catch (\Exception $e) {
                // Jika email gagal terkirim (misal karena settingan belum lengkap), transaksi tetap dibatalkan
                return back()->with('success', 'Pesanan dibatalkan, tetapi email otomatis gagal terkirim. Silakan hubungi pembeli secara manual.');
            }
            // --------------------------------------------------

            return back()->with('success', 'Pesanan dibatalkan. Email permintaan nomor rekening telah otomatis dikirim ke pembeli!');
        }

        // TAHAP 2: EO menekan tombol Selesai (uang sudah ditransfer)
        if ($transaction->payment_status === 'refund_processing' || $transaction->payment_status === 'refund_requested') {
            $transaction->update(['payment_status' => 'refunded']);

            // Kembalikan kuota tiket agar tiket bisa dibeli orang lain lagi
            if ($transaction->event) {
                $transaction->event->increment('quota', $transaction->quantity);
            }

            return back()->with('success', 'Refund Selesai! Uang telah dikembalikan dan kuota tiket telah diperbarui.');
        }

        return back()->with('error', 'Aksi tidak valid untuk status transaksi ini.');
    }
}
