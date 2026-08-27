<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Revenue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Exception;

class CheckoutController extends Controller
{
    // 1. Memproses Checkout awal
    public function processCheckout(Request $request, $eventId)
    {
        // ─── PERBAIKAN: Validasi mendukung ID Paket Tiket atau Tipe Lama ───
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'ticket_type' => 'nullable|in:offline,online',
            'ticket_package_id' => 'nullable' // Menerima ID paket dari halaman detail
        ]);

        $user = Auth::user();
        $jumlahBeli = $request->input('quantity');
        $maksimalTiket = 5;

        return DB::transaction(function () use ($request, $eventId, $user, $jumlahBeli, $maksimalTiket) {
            $event = Event::where('id', $eventId)->lockForUpdate()->firstOrFail();

            $tiketSudahDibeli = Transaction::where('user_id', $user->id)
                ->where('event_id', $eventId)
                ->whereIn('payment_status', ['pending', 'paid'])
                ->sum('quantity');

            if (($tiketSudahDibeli + $jumlahBeli) > $maksimalTiket) {
                return redirect()->back()->with('error', "Gagal! Maksimal $maksimalTiket tiket per user.");
            }

            // ─── PERBAIKAN: VALIDASI & PENGURANGAN KUOTA BERDASARKAN PAKET TIKET ───
            $hargaSatuan = 0;
            $tipeTiketDisimpan = 'offline';

            if ($request->filled('ticket_package_id')) {
                // Jika event menggunakan sistem Paket (VIP, Reguler, dll)
                $paket = $event->ticketPackages()->where('id', $request->ticket_package_id)->lockForUpdate()->first();
                if (!$paket) {
                    return redirect()->back()->with('error', 'Paket tiket yang dipilih tidak ditemukan.');
                }

                if ($paket->quota < $jumlahBeli) {
                    return redirect()->back()->with('error', "Maaf, kuota untuk paket {$paket->name} tidak mencukupi (sisa {$paket->quota} tiket).");
                }

                // Kurangi kuota paket spesifik
                $paket->decrement('quota', $jumlahBeli);

                $hargaSatuan = $paket->price;
                $tipeTiketDisimpan = $paket->name; // Simpan nama paket (cth: VIP) ke riwayat
            } else {
                // Fallback: Jika event masih menggunakan sistem lama (Offline/Online)
                if ($event->quota < $jumlahBeli) {
                    return redirect()->back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
                }

                $tipeTiket = $request->input('ticket_type', 'offline');
                $tipeTiketDisimpan = $tipeTiket;

                if ($tipeTiket === 'offline') {
                    $hargaSatuan = $event->price;
                } else {
                    $hargaSatuan = $event->online_price ?? 0;
                }
            }

            // Kurangi kuota total event
            $event->decrement('quota', $jumlahBeli);

            $totalHarga = $hargaSatuan * $jumlahBeli;

            // Jika total 0 (Gratis), langsung lunas. Jika tidak, pending ke Midtrans.
            $statusPembayaran = ($totalHarga == 0) ? 'paid' : 'pending';

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'order_id' => 'TRX-' . strtoupper(Str::random(10)),
                'quantity' => $jumlahBeli,
                'ticket_type' => $tipeTiketDisimpan, // Menyimpan nama paket tiket
                'total_amount' => $totalHarga,
                'payment_status' => $statusPembayaran
            ]);

            // BYPASS MIDTRANS JIKA TIKET GRATIS (Rp 0)
            if ($totalHarga == 0) {
                // Langsung cetak tiket
                for ($i = 0; $i < $transaction->quantity; $i++) {
                    \App\Models\Ticket::create([
                        'transaction_id' => $transaction->id,
                        'ticket_code' => $transaction->order_id . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                        'is_scanned' => false,
                    ]);
                }

                $transaction->load('tickets');

                // Kirim email
                if ($user->email) {
                    try {
                        Mail::to($user->email)->send(new TicketMail($transaction));
                    } catch (\Exception $e) {
                        Log::error("Gagal kirim email tiket gratis: " . $e->getMessage());
                    }
                }

                return redirect()->route('transaction.history')->with('success', 'Tiket gratis berhasil diklaim & dikirim ke email!');
            }

            // Jika berbayar, arahkan ke halaman Invoice (Midtrans)
            return redirect()->route('transaction.show', $transaction->id)
                             ->with('success', 'Pesanan berhasil dibuat!');
        });
    }

    // 2. Menampilkan halaman Invoice / Pembayaran
    public function show($id)
    {
        $transaction = Transaction::with(['event.category', 'event.ticketPackages', 'user'])->findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Maaf, Anda tidak memiliki akses.');
        }

        if ($transaction->payment_status === 'paid') {
            return redirect()->route('transaction.history')->with('success', 'Transaksi ini sudah lunas.');
        }

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = '';
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error("Midtrans Error: " . $e->getMessage());
        }

        return view('transactions.show', compact('transaction', 'snapToken'));
    }

    /**
     * Helper privat untuk memproses transaksi yang sudah lunas:
     * - Mengubah status transaksi menjadi paid & completed
     * - Membuat tiket fisik/QR jika belum ada
     * - Mencatat pendapatan (revenue)
     * - Mengirim email konfirmasi tiket
     */
    private function markAsPaid(Transaction $transaction)
    {
        if ($transaction->payment_status !== 'paid') {
            $transaction->update([
                'payment_status' => 'paid',
                'status' => 'completed'
            ]);

            if ($transaction->tickets->count() == 0) {
                for ($i = 0; $i < $transaction->quantity; $i++) {
                    \App\Models\Ticket::create([
                        'transaction_id' => $transaction->id,
                        'ticket_code' => $transaction->order_id . '-' . strtoupper(Str::random(4)),
                        'is_scanned' => false,
                    ]);
                }
            }

            $transaction->load('tickets');

            Revenue::firstOrCreate(['order_id' => $transaction->order_id], [
                'amount' => $transaction->total_amount,
                'description' => 'Pendapatan dari event: ' . ($transaction->event->name ?? 'Event')
            ]);

            if ($transaction->user && $transaction->user->email) {
                try {
                    Mail::to($transaction->user->email)->send(new TicketMail($transaction));
                } catch (\Exception $e) {
                    Log::error("Gagal kirim email: " . $e->getMessage());
                }
            }
        }
    }

    // 3. Callback dari Midtrans (Webhook Server-to-Server)
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transaction = Transaction::with(['event', 'user', 'tickets'])->where('order_id', $request->order_id)->first();

            if ($transaction) {
                if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                    $this->markAsPaid($transaction);
                } elseif (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
                    if ($transaction->payment_status === 'pending') {
                        $transaction->update(['payment_status' => 'failed']);
                        if ($transaction->event) {
                            $transaction->event->increment('quota', $transaction->quantity);
                        }
                    }
                }
            }
        }
        return response()->json(['message' => 'OK']);
    }

    // 4. Cek Status saat kembali dari Midtrans Snap Redirect
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        if (!$orderId) return redirect()->route('transaction.history')->with('error', 'Transaksi tidak ditemukan.');

        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

        try {
            $statusInfo = \Midtrans\Transaction::status($orderId);
            $trxStatus = is_object($statusInfo) ? ($statusInfo->transaction_status ?? '') : ($statusInfo['transaction_status'] ?? '');
            $transaction = Transaction::with(['event', 'user', 'tickets'])->where('order_id', $orderId)->first();

            if ($transaction) {
                if (in_array($trxStatus, ['capture', 'settlement'])) {
                    $this->markAsPaid($transaction);
                    return redirect()->route('transaction.history')->with('success', 'Pembayaran berhasil dikonfirmasi dan Tiket telah dikirim!');
                } elseif (in_array($trxStatus, ['deny', 'expire', 'cancel'])) {
                    if ($transaction->payment_status === 'pending') {
                        $transaction->update(['payment_status' => 'failed']);
                        if ($transaction->event) {
                            $transaction->event->increment('quota', $transaction->quantity);
                        }
                    }
                    return redirect()->route('transaction.history')->with('error', 'Status pembayaran di Midtrans: ' . strtoupper($trxStatus) . '. Pesanan dibatalkan.');
                }
            }
            return redirect()->route('transaction.history')->with('info', 'Pembayaran masih berstatus pending. Harap selesaikan pembayaran.');
        } catch (\Exception $e) {
            return redirect()->route('transaction.history')->with('info', 'Pesanan Anda tersimpan. Silakan periksa status berkala di riwayat.');
        }
    }

    // 4b. Cek Status Manual dari Riwayat atau Invoice (Sangat berguna saat di HP/Simulator)
    public function checkStatus($id)
    {
        $transaction = Transaction::with(['event', 'user', 'tickets'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Jika sudah lunas, langsung info
        if ($transaction->payment_status === 'paid') {
            return redirect()->route('transaction.history')->with('success', 'Transaksi ini sudah lunas.');
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

        try {
            $statusInfo = \Midtrans\Transaction::status($transaction->order_id);
            $trxStatus = is_object($statusInfo) ? ($statusInfo->transaction_status ?? '') : ($statusInfo['transaction_status'] ?? '');

            if (in_array($trxStatus, ['capture', 'settlement'])) {
                $this->markAsPaid($transaction);
                return redirect()->route('transaction.history')->with('success', 'Status terverifikasi! Pembayaran BERHASIL (LUNAS) & E-tiket telah diterbitkan.');
            } elseif (in_array($trxStatus, ['deny', 'expire', 'cancel'])) {
                $transaction->update(['payment_status' => 'failed']);
                if ($transaction->event) {
                    $transaction->event->increment('quota', $transaction->quantity);
                    $pkg = $transaction->event->ticketPackages()->where('name', $transaction->ticket_type)->first();
                    if ($pkg) {
                        $pkg->increment('quota', $transaction->quantity);
                    }
                }
                return redirect()->route('transaction.history')->with('error', 'Status pembayaran di Midtrans: ' . strtoupper($trxStatus) . '. Pesanan tiket otomatis dibatalkan.');
            } else {
                return redirect()->route('transaction.history')->with('info', 'Status pembayaran di Midtrans: MENUNGGU PEMBAYARAN (Pending). Silakan selesaikan pembayaran Anda.');
            }
        } catch (\Exception $e) {
            Log::error("Midtrans checkStatus error: " . $e->getMessage());
            return redirect()->route('transaction.history')->with('error', 'Belum ada transaksi pembayaran yang terdaftar di Midtrans untuk pesanan ini. Silakan klik "Bayar" terlebih dahulu.');
        }
    }

    // 4c. Batalkan Pesanan Tiket (Mengembalikan Kuota Event)
    public function cancelTransaction($id)
    {
        $transaction = Transaction::with('event')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($transaction->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya transaksi yang berstatus Menunggu Pembayaran yang dapat dibatalkan.');
        }

        // Coba batalkan di Midtrans (jika sudah teregister)
        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        try {
            \Midtrans\Transaction::cancel($transaction->order_id);
        } catch (\Exception $e) {
            // Abaikan jika order belum terdaftar di server Midtrans
        }

        $transaction->update(['payment_status' => 'failed']);

        // Kembalikan kuota event & kuota paket tiket spesifik agar tiket dapat dibeli pengguna lain
        if ($transaction->event) {
            $transaction->event->increment('quota', $transaction->quantity);
            $pkg = $transaction->event->ticketPackages()->where('name', $transaction->ticket_type)->first();
            if ($pkg) {
                $pkg->increment('quota', $transaction->quantity);
            }
        }

        return redirect()->route('transaction.history')->with('success', 'Pesanan berhasil dibatalkan. Kuota tiket event telah dikembalikan.');
    }

    // 5. Download PDF
    public function downloadTicket($id)
    {
        $transaction = Transaction::with(['event.category', 'event.ticketPackages', 'user', 'tickets'])->findOrFail($id);
        if ($transaction->user_id !== Auth::id() || $transaction->payment_status !== 'paid') {
            abort(403, 'Akses ditolak.');
        }

        $pdf = Pdf::loadView('transactions.pdf_ticket', compact('transaction'));
        return $pdf->download('Tiket-Event-' . $transaction->order_id . '.pdf');
    }

    // 6. Debugging status (Hapus jika sudah live)
    public function debugPaid($id)
    {
        $transaction = Transaction::with(['event.category', 'event.ticketPackages', 'user', 'tickets'])->findOrFail($id);
        $transaction->update([
            'payment_status' => 'paid',
            'status' => 'completed'
        ]);

        if ($transaction->tickets->count() == 0) {
            for ($i = 0; $i < $transaction->quantity; $i++) {
                \App\Models\Ticket::create([
                    'transaction_id' => $transaction->id,
                    'ticket_code' => $transaction->order_id . '-' . strtoupper(Str::random(4)),
                    'is_scanned' => false,
                ]);
            }
        }

        $transaction->load('tickets');

        Revenue::firstOrCreate(['order_id' => $transaction->order_id], [
            'amount' => $transaction->total_amount,
            'description' => 'Pendapatan dari event: ' . ($transaction->event->name ?? 'Event')
        ]);

        // Kirim email tiket
        if ($transaction->user && $transaction->user->email) {
            try {
                Mail::to($transaction->user->email)->send(new TicketMail($transaction));
            } catch (\Exception $e) {
                Log::error("Gagal kirim email tiket debug: " . $e->getMessage());
            }
        }

        return redirect()->route('transaction.history')->with('success', 'Transaksi berhasil diubah menjadi LUNAS untuk pengujian.');
    }

    // 7. Riwayat Pemesanan Tiket Pengguna
    public function history()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        $ticketTransactions = \App\Models\Transaction::with(['event.category', 'event.ticketPackages'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $sponsorshipTransactions = \App\Models\SponsorshipTransaction::with('sponsorship.event')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('history', compact('ticketTransactions', 'sponsorshipTransactions'));
    }

    // ==========================================
    // FUNGSI: Mengajukan Pengembalian Dana (Refund)
    // ==========================================
    public function requestRefund(Request $request, $id)
    {
        $request->validate([
            'refund_reason'  => 'required|string|max:255',
            'refund_account' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $transaction = Transaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if ($transaction->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Refund hanya dapat diajukan untuk transaksi yang sudah lunas.');
        }

        $transaction->update([
            'payment_status' => 'refund_requested',
            'refund_reason'  => $request->refund_reason,
            'refund_account' => $request->refund_account
        ]);

        return redirect()->back()->with('success', 'Pengajuan Refund berhasil dikirim beserta detail rekening Anda. Tim kami akan segera memprosesnya.');
    }
}
