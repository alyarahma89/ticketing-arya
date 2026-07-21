<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Alat untuk mengecek siapa yang sedang login
use App\Models\Event;
use App\Models\Transaction;

class EOEventController extends Controller
{
    public function dashboard()
{
    // 1. Ambil ID dari EO yang sedang login saat ini
    $eoId = Auth::id();

    // 2. Data Statistik (Filter berdasarkan ID EO)
    $eventAktif = Event::where('user_id', $eoId)->count();

    // Tiket terjual (mengambil transaksi dari event milik EO ini)
    $tiketTerjual = Transaction::whereHas('event', function ($query) use ($eoId) {
        $query->where('user_id', $eoId);
    })->where('payment_status', 'paid')->sum('quantity');

    // Total pendapatan (mengambil revenue dari event milik EO ini)
    // Pastikan model Revenue memiliki relasi ke Event atau User
    $totalPendapatan = Revenue::whereHas('event', function ($query) use ($eoId) {
        $query->where('user_id', $eoId);
    })->sum('amount');

    // Total Pengguna (Jumlah peserta yang pernah mendaftar di event EO ini)
    $totalPengguna = Transaction::whereHas('event', function ($query) use ($eoId) {
        $query->where('user_id', $eoId);
    })->distinct('user_id')->count('user_id');

    // Pendapatan Sponsor (Khusus event milik EO ini)
    $pendapatanSponsor = Sponsorship::whereHas('event', function ($query) use ($eoId) {
        $query->where('user_id', $eoId);
    })->sum('price');

    // 5 Event terakhir milik EO ini
    $activeEvents = Event::where('user_id', $eoId)->latest()->take(5)->get();

    // Data Penjualan Bulanan (Untuk Grafik)
    $monthlySales = Revenue::whereHas('event', function ($query) use ($eoId) {
        $query->where('user_id', $eoId);
    })
    ->whereYear('created_at', 2026)
    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
    ->groupBy('month')
    ->pluck('total', 'month')
    ->toArray();

    $salesData = [];
    for ($i = 1; $i <= 12; $i++) {
        $salesData[] = isset($monthlySales[$i]) ? $monthlySales[$i] / 1000000 : 0;
    }

    // Data Penjualan per Kategori (Milik EO ini)
    $categoryData = Event::join('transactions', 'events.id', '=', 'transactions.event_id')
        ->join('categories', 'events.category_id', '=', 'categories.id')
        ->where('events.user_id', $eoId)
        ->where('transactions.payment_status', 'paid')
        ->select('categories.name as category_name', DB::raw('SUM(transactions.quantity) as total'))
        ->groupBy('categories.name')
        ->pluck('total', 'category_name')
        ->toArray();

    // Mengirim data ke view dashboard yang sama dengan Admin
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
}
