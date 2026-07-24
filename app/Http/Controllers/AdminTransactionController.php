<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <-- Jangan lupa tambahkan ini untuk mengecek siapa yang login

class AdminTransactionController extends Controller
{
    public function index()
    {
        // 1. Ambil data pengguna yang sedang login saat ini
        $user = Auth::user();

        // 2. Cek apakah peran (role) pengguna tersebut adalah EO
        if ($user->role === 'eo') {

            // Jika EO: Saring transaksi HANYA untuk event yang dia buat
            $transactions = Transaction::with(['user', 'event'])
                ->whereHas('event', function ($query) use ($user) {
                    // Cek di tabel event, pastikan pembuat eventnya adalah EO yang sedang login
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->get();

        } else {
            // Jika Admin: Ambil semua data transaksi dari semua event tanpa saringan
            $transactions = Transaction::with(['user', 'event'])
                ->latest()
                ->get();
        }

        // 3. Kirim data yang sudah disaring ke halaman view (tampilan)
        return view('admin.transactions.index', compact('transactions'));
    }
}
