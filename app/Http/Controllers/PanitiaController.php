<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Ditambahkan untuk persiapan memanggil data tiket
use App\Models\Event;       // Ditambahkan untuk persiapan memanggil data event

class PanitiaController extends Controller
{
    // Menampilkan halaman utama (Dashboard) Panitia
    public function index()
    {
        return view('panitia.dashboard');
    }

    // Menampilkan halaman Scanner
    public function scanner()
    {
        // Pastikan file blade scannermu ada di resources/views/admin/scanner.blade.php
        return view('admin.scanner');
    }

    // ==========================================
    // FUNGSI BARU: Menampilkan Daftar Hadir
    // ==========================================
    public function attendance()
    {
        // Mengambil semua transaksi yang sudah lunas beserta data pembeli dan event-nya
        // Pastikan model Transaction, User, dan Event sudah berelasi dengan benar
        $attendees = \App\Models\Transaction::with(['user', 'event'])
                        ->where('payment_status', 'paid')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('panitia.attendance', compact('attendees'));
    }

    // ==========================================
    // FUNGSI BARU: Menampilkan Info Event
    // ==========================================
    public function eventInfo()
    {
        // Mengambil satu data event terbaru dari database
        // (Jika nanti panitia ditugaskan ke event spesifik, logikanya bisa disesuaikan di sini)
        $event = \App\Models\Event::latest()->first();

        return view('panitia.event_info', compact('event'));
    }
}
