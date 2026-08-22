<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Kelola Pengguna')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')

    <!-- Header Halaman -->
    <div class="px-8 pt-10 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Database Pengguna</h1>
            <p class="text-[14px] text-slate-500 font-medium">Kelola semua akun Admin, EO, Panitia, dan Pelanggan.</p>
        </div>
        <div class="flex items-center gap-4 no-print">
            <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <div class="px-8 pb-12">

        <!-- Notifikasi Pesan -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                <span class="text-[14px]">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                <span class="text-[14px]">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ── TABEL DAFTAR PENGGUNA ── -->
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-800 font-montserrat">Daftar Akun Terdaftar</h3>
                <span class="text-xs font-bold bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1.5 rounded-lg">{{ count($users) }} Akun</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                            <th class="px-6 py-5 text-center w-16">No</th>
                            <th class="px-6 py-5">Profil Pengguna</th>
                            <th class="px-6 py-5">Alamat Email</th>
                            <th class="px-6 py-5">Hak Akses (Role)</th>
                            <th class="px-6 py-5 text-center w-32 no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700">
                        @forelse($users as $index => $user)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <!-- Nomor -->
                            <td class="px-6 py-4 text-center text-slate-400 font-bold">
                                {{ $index + 1 }}
                            </td>

                            <!-- Profil Pengguna (Avatar + Nama) -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0066FF] font-bold uppercase shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-[14px]">{{ $user->name }}</div>
                                        <div class="text-[12px] text-slate-400 font-medium mt-0.5">ID: #USR-{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4">
                                <span class="text-slate-600 font-medium flex items-center gap-2">
                                    <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i> {{ $user->email }}
                                </span>
                            </td>

                            <!-- Role Badge -->
                            <td class="px-6 py-4">
                                @if($user->role == 'admin')
                                    <span class="bg-indigo-50 text-indigo-600 border border-indigo-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Admin</span>
                                @elseif($user->role == 'panitia')
                                    <span class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Panitia</span>
                                @elseif($user->role == 'eo')
                                    <span class="bg-purple-50 text-purple-600 border border-purple-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Event Organizer</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 border border-slate-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Pelanggan</span>
                                @endif
                            </td>

                            <!-- Aksi (Hapus / Label Sendiri) -->
                            <td class="px-6 py-4 text-center no-print">
                                @if($user->id !== auth()->id())
                                    <div class="flex justify-center">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus akun akan menghilangkan semua data terkait pengguna ini. Yakin ingin menghapus permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-[#FF3B30] hover:bg-red-50 p-2.5 rounded-xl transition-colors" title="Hapus Akun">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg uppercase tracking-wider">
                                        Akun Anda
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        <i data-lucide="users" class="w-8 h-8"></i>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Belum Ada Pengguna Lain</h3>
                                    <p class="text-slate-500 text-[14px] font-medium">Anda adalah satu-satunya pengguna di sistem saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
