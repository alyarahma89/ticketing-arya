<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // Atau jika kamu memindahkannya ke folder panitia, ganti menjadi 'panitia.scanner'
        return view('admin.scanner');
    }
}
