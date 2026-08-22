<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cek email dan password
        $request->authenticate();

        // 2. Buat sesi baru (keamanan)
        $request->session()->regenerate();

        // 3. LOGIKA REDIRECT CERDAS BERDASARKAN ROLE
        $role = $request->user()->role;

        if ($role === 'admin' || $role === 'eo') {
            // Paksa masuk ke Dashboard dengan notifikasi
            return redirect('/admin/dashboard')->with('success', 'Berhasil login! Selamat datang di Dasbor Utama.');
        } elseif ($role === 'panitia') {
            // Paksa masuk ke Scanner dengan notifikasi
            return redirect('/scanner')->with('success', 'Berhasil login! Selamat bertugas di lapangan.');
        } else {
            // User biasa dilempar ke Halaman Depan dengan notifikasi
            return redirect('/')->with('success', 'Berhasil login! Selamat datang kembali di ARTIX ID.');
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        // 1. Mengeluarkan pengguna dari sistem keamanan
        Auth::guard('web')->logout();

        // 2. Menghapus semua data sesi pengguna tersebut
        $request->session()->invalidate();

        // 3. Membuat ulang token keamanan baru untuk tamu (mencegah error keamanan)
        $request->session()->regenerateToken();

        // 4. Mengalihkan kembali ke Beranda (/) dengan membawa pesan notifikasi
        return redirect('/')->with('success', 'Anda telah berhasil keluar. Sampai jumpa kembali di ARTIX ID!');
    }
}

