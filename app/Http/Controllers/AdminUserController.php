<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Wajib ditambahkan: Alat untuk mengenkripsi password agar aman

class AdminUserController extends Controller
{
    // 1. Tampilkan semua daftar pengguna di platform
    public function index()
    {
        // Mengambil seluruh user, urutkan dari yang paling baru mendaftar
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    // 2. Tampilkan halaman formulir tambah pengguna baru
    public function create()
    {
        // Mengarahkan ke file resources/views/admin/users/create.blade.php
        return view('admin.users.create');
    }

    // 3. Proses menyimpan data pengguna baru ke database
    public function store(Request $request)
    {
        // A. Validasi Data
        // Memeriksa apakah data yang diketik sudah sesuai aturan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // unique: memastikan email belum pernah terdaftar
            'password' => 'required|string|min:8', // Password minimal 8 huruf/angka
            'role' => 'required|in:admin,eo,panitia,user' // Role harus sesuai pilihan yang ada
        ]);

        // B. Simpan ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // C. Enkripsi Password
            // Hash::make mengubah password asli menjadi teks acak agar aman dari peretas
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // D. Kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan ke sistem!');
    }

    // 4. Aksi hapus akun pengguna jika melanggar ketentuan
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah admin menghapus akunnya sendiri secara tidak sengaja
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Gagal! Kamu tidak bisa menghapus akun kamu sendiri yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }
}
