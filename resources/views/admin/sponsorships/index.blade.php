<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Kelola Sponsorship')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
    <!-- ── HEADER HALAMAN DENGAN PENCARIAN & FILTER ── -->
    <div class="px-8 pt-10 pb-6 flex flex-col xl:flex-row xl:items-end justify-between gap-6">

        <!-- Bagian Kiri: Judul -->
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Marketplace Sponsorship</h1>
            <p class="text-[14px] text-slate-500 font-medium">Kelola penawaran paket sponsor untuk seluruh event Anda.</p>
        </div>

        <!-- Bagian Kanan: Pencarian, Filter & Tambah -->
        <div class="flex flex-col sm:flex-row sm:flex-wrap items-center justify-start xl:justify-end gap-3 no-print w-full xl:w-auto">

            <form method="GET" action="{{ route('admin.sponsorships.index') }}" class="flex flex-col sm:flex-row items-center gap-2 m-0 w-full sm:w-auto">
                <!-- Kotak Pencarian -->
                <div class="relative w-full sm:w-56 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari paket/event..."
                           class="w-full bg-white pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm">
                </div>

                <!-- Dropdown Filter Status -->
                <div class="relative w-full sm:w-48 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                    </span>
                    <select name="status" onchange="this.form.submit()" class="w-full bg-white pl-11 pr-8 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>🟢 Event Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>🔴 Event Selesai</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Tombol Cari -->
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0 w-full sm:w-auto">
                    Cari
                </button>

                <!-- Tombol Reset -->
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.sponsorships.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 p-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0" title="Reset Filter">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Tambah Paket -->
            <a href="{{ route('admin.sponsorships.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 shrink-0 w-full sm:w-auto justify-center">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Paket
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

        <!-- ── TABEL DAFTAR SPONSORSHIP ── -->
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-800 font-montserrat">Katalog Paket Sponsor</h3>
                <span class="text-xs font-bold bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1.5 rounded-lg">{{ count($sponsorships) }} Paket Ditemukan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[950px]">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                            <th class="px-6 py-5 text-center w-[5%]">No</th>
                            <th class="px-6 py-5 w-[30%]">Nama Paket & Event</th>
                            <th class="px-6 py-5 w-[25%]">Benefit / Keuntungan</th>
                            <th class="px-6 py-5 w-[15%] text-right">Harga (Rp)</th>
                            <th class="px-6 py-5 w-[10%] text-center">Kuota</th>
                            <th class="px-6 py-5 w-[15%] text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700">
                        @forelse($sponsorships as $index => $sponsor)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <!-- Nomor -->
                            <td class="px-6 py-4 text-center text-slate-400 font-bold">
                                {{ $index + 1 }}
                            </td>

                            <!-- Nama & Event & Status Badge -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-[12px] bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($sponsor->image)
                                            <img src="{{ asset('storage/' . $sponsor->image) }}" alt="{{ $sponsor->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-[15px] mb-1.5">{{ $sponsor->name }}</div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <div class="text-[11px] font-bold uppercase tracking-wider text-[#0066FF] bg-blue-50 border border-blue-100 inline-flex items-center gap-1 px-2.5 py-1 rounded-md">
                                                <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $sponsor->event->name ?? 'Event Dihapus' }}
                                            </div>

                                            <!-- Logika Label Status Event -->
                                            @if($sponsor->event && strtotime($sponsor->event->event_date) >= time())
                                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Event Aktif</span>
                                            @elseif($sponsor->event)
                                                <span class="bg-slate-100 text-slate-500 border border-slate-200 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">Event Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Benefit -->
                            <td class="px-6 py-4">
                                <ul class="text-[13px] text-slate-600 font-medium list-disc list-inside space-y-1">
                                    @foreach(explode(',', $sponsor->benefits) as $benefit)
                                        <li>{{ trim($benefit) }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <!-- Harga -->
                            <td class="px-6 py-4 text-right">
                                <span class="font-black text-slate-800 font-montserrat text-base">
                                    {{ number_format($sponsor->price, 0, ',', '.') }}
                                </span>
                            </td>

                            <!-- Kuota -->
                            <td class="px-6 py-4 text-center">
                                <span class="bg-slate-100 border border-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-[8px] text-[13px]">
                                    {{ $sponsor->quota }}
                                </span>
                            </td>

                            <!-- Aksi (Edit / Hapus) -->
                            <td class="px-6 py-4 text-center no-print">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.sponsorships.edit', $sponsor->id) }}" class="text-slate-400 hover:text-[#0066FF] bg-white hover:bg-blue-50 border border-transparent hover:border-blue-200 p-2 rounded-xl transition-all" title="Edit Paket">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('admin.sponsorships.destroy', $sponsor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket sponsor ini?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-[#FF3B30] bg-white hover:bg-red-50 border border-transparent hover:border-red-200 p-2 rounded-xl transition-all" title="Hapus Paket">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        @if(request('search') || request('status'))
                                            <i data-lucide="search-x" class="w-8 h-8"></i>
                                        @else
                                            <i data-lucide="package-open" class="w-8 h-8"></i>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">
                                        {{ (request('search') || request('status')) ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Paket Sponsor' }}
                                    </h3>
                                    <p class="text-slate-500 text-[14px] font-medium mb-6">
                                        {{ (request('search') || request('status')) ? 'Coba gunakan kata kunci atau filter status yang lain.' : 'Buat paket sponsor pertama Anda untuk menarik minat calon mitra acara.' }}
                                    </p>

                                    @if(!(request('search') || request('status')))
                                        <a href="{{ route('admin.sponsorships.create') }}" class="bg-[#0066FF] hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-blue-500/20 flex items-center gap-2">
                                            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Paket Sekarang
                                        </a>
                                    @endif
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
