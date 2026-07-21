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
        // 1. Validasi input dari form register
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'secret_code' => ['nullable', 'string'], // Menerima input kode khusus, boleh kosong
        ]);

        // 2. Logika cerdas penentuan Role
        $role = 'user'; // Nilai standar untuk pelanggan

        // Mengecek apakah ada kode yang dimasukkan dan apakah kodenya valid
        if ($request->secret_code === 'ARTIX-EO-PRO') {
            $role = 'eo';
        } elseif ($request->secret_code === 'PANITIA-ARTIX-26') {
            $role = 'panitia';
        }

        // 3. Menyimpan data ke dalam database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Menambahkan role hasil pengecekan ke database
        ]);

        event(new Registered($user));

        // 4. Proses login otomatis
        Auth::login($user);

        // 5. Mengarahkan pengguna kembali ke halaman utama
        return redirect('/');
    }
}
