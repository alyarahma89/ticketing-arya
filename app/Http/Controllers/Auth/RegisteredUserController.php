<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dasar dengan Keamanan Tingkat Tinggi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8) // Minimal 8 karakter
                    ->letters()          // Wajib mengandung huruf
                    ->mixedCase()        // Wajib ada kombinasi huruf BESAR dan kecil
                    ->numbers()          // Wajib mengandung angka
                    ->symbols()          // Wajib mengandung simbol (seperti @, #, $, dll)
                    ->uncompromised()    // SUPER AMAN: Mengecek database global untuk memastikan sandi ini belum pernah bocor di internet
            ],
        ], [
            // Pesan error kustom (opsional, agar pengguna tidak bingung saat gagal)
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.letters' => 'Kata sandi harus mengandung setidaknya satu huruf.',
            'password.mixed' => 'Kata sandi harus memiliki kombinasi huruf besar dan huruf kecil.',
            'password.numbers' => 'Kata sandi harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Kata sandi harus mengandung setidaknya satu karakter simbol (contoh: @, #, $, dll).',
            'password.uncompromised' => 'Kata sandi ini terlalu umum atau pernah bocor di internet. Silakan pilih kata sandi lain yang lebih aman.',
        ]);

        // 2. Siapkan nilai bawaan (default)
        $eventId = null;
        $userRole = 'user'; // Bawaan untuk pelanggan biasa

        // 3. LOGIKA KOMBINASI (HARDCODE EO & DATABASE PANITIA)
        if ($request->account_type === 'staff') {

            $request->validate([
                'secret_code' => ['required', 'string'],
                'role_type' => ['required', 'string'],
            ]);

            if ($request->role_type === 'eo') {
                // ==========================================
                // JALUR 1: HARDCODE UNTUK EO (MASTER KEY)
                // ==========================================
                $masterKeyEO = 'ARTIX-EO-PRO';

                if ($request->secret_code !== $masterKeyEO) {
                    return back()->withErrors([
                        'secret_code' => 'Kode Akses EO (Master Key) tidak valid!'
                    ])->withInput();
                }

                $userRole = 'eo';

            } else {
                // ==========================================
                // JALUR 2: DATABASE UNTUK PANITIA
                // ==========================================
                $event = \App\Models\Event::where('secret_code', $request->secret_code)->first();

                if (!$event) {
                    return back()->withErrors([
                        'secret_code' => 'Kode Akses Event tidak valid atau event tidak ditemukan!'
                    ])->withInput();
                }

                $eventId = $event->id; // Mengikat panitia ke event
                $userRole = 'panitia'; // Menyatukan panitia_tiket & panitia_lapangan ke 'panitia'
            }
        }

        // 4. Buat Akun Pengguna Baru ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $userRole,
            'event_id' => $eventId,
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        // 5. Pengarahan Halaman Setelah Login
        if ($userRole === 'panitia') {
            // Jika dia panitia, arahkan ke dashboard panitia
            return redirect()->route('panitia.dashboard');
        } elseif (in_array($userRole, ['eo', 'admin'])) {
            // Jika dia EO atau Admin, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        } else {
            // Jika pelanggan biasa, arahkan ke beranda
            return redirect()->route('home'); // Sesuaikan 'home' dengan nama route beranda kamu
        }
    }
}
