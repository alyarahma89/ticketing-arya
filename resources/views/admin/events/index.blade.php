<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', Auth::user()->role == 'eo' ? 'Event Saya' : 'Manajemen Event')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
    <!-- Header Halaman -->
    <div class="px-8 pt-10 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">
                {{ Auth::user()->role == 'eo' ? 'Event Saya' : 'Manajemen Event' }}
            </h1>
            <p class="text-[14px] text-slate-500 font-medium">Kelola semua daftar acara, jadwal, dan ketersediaan tiket.</p>
        </div>
        <div class="flex items-center gap-4 no-print">
            <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Event Baru
            </a>
        </div>
    </div>

    <div class="px-8 pb-12">

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                <span class="text-[14px]">{{ session('success') }}</span>
            </div>
        @endif

        <!-- ── FORM PENCARIAN & FILTER BARU ── -->
        <form method="GET" action="{{ route('admin.events.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3 no-print">

            <!-- Input Search -->
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event atau lokasi..."
                        class="w-full bg-white pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm">
            </div>

            <!-- Dropdown Status -->
            <div class="w-full sm:w-56 shrink-0 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </span>
                <select name="status" onchange="this.form.submit()" class="w-full bg-white pl-11 pr-8 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>🟢 Aktif (Akan Datang)</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>🔴 Selesai (Berlalu)</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>

            <!-- Tombol Cari -->
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-2 shrink-0">
                Cari
            </button>

            <!-- Tombol Reset (Muncul hanya jika ada filter yang sedang dipakai) -->
            @if(request('search') || request('status'))
                <a href="{{ route('admin.events.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-3 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0" title="Reset Filter">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <!-- ── TABEL DATA ── -->
        <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                            <th class="px-6 py-5 text-center w-16">No</th>
                            <th class="px-6 py-5">Detail Event</th>
                            <th class="px-6 py-5">Kategori</th>
                            <th class="px-6 py-5">Pelaksanaan & Status</th>
                            <th class="px-6 py-5">Harga & Kuota</th>
                            <th class="px-6 py-5 text-center w-32 no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700">
                        @forelse($events as $index => $event)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <!-- Nomor -->
                            <td class="px-6 py-4 text-center text-slate-400 font-bold">
                                {{ $index + 1 }}
                            </td>

                            <!-- Nama Event & Poster -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-[15px] mb-1.5">{{ $event->name }}</div>
                                <div class="flex items-center gap-2 text-[12px] text-slate-500 font-medium">
                                    <span class="flex items-center gap-1 pr-2 border-r border-slate-200 truncate max-w-[150px]" title="{{ $event->location }}">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $event->location ?? 'Online' }}
                                    </span>
                                    @if($event->image)
                                        <span class="text-emerald-600 flex items-center gap-1 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                            <i data-lucide="image" class="w-3.5 h-3.5"></i> Ada Poster
                                        </span>
                                    @else
                                        <span class="text-slate-400 flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                            <i data-lucide="image-off" class="w-3.5 h-3.5"></i> Tanpa Poster
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1 rounded-lg text-xs font-bold inline-block uppercase tracking-wider">
                                    {{ $event->category->name ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Tanggal, Jam & Label Status -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="text-slate-800 font-bold">{{ date('d M Y', strtotime($event->event_date)) }}</div>

                                    <!-- Logika Pengecekan Waktu untuk Label Status -->
                                    @if(strtotime($event->event_date) >= time())
                                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-500 border border-slate-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Selesai</span>
                                    @endif
                                </div>
                                <div class="text-slate-500 text-[12px] flex items-center gap-1.5 mt-1 font-medium">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ date('H:i', strtotime($event->event_date)) }} WIB
                                </div>
                            </td>

                            <!-- Harga & Kuota -->
                            <td class="px-6 py-4">
                                <div class="mb-1">
                                    <!-- Jika punya banyak paket tiket -->
                                    @if($event->ticketPackages && $event->ticketPackages->count() > 1)
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">{{ $event->ticketPackages->count() }} Kategori Tiket</span>
                                        <span class="text-[#0066FF] font-black text-[15px] font-montserrat">
                                            Mulai Rp {{ number_format($event->ticketPackages->min('price'), 0, ',', '.') }}
                                        </span>

                                    <!-- Jika hanya punya 1 paket tiket -->
                                    @elseif($event->ticketPackages && $event->ticketPackages->count() == 1)
                                        @if($event->ticketPackages->first()->price == 0)
                                            <span class="text-emerald-500 font-black text-[15px]">Gratis</span>
                                        @else
                                            <span class="text-[#0066FF] font-black text-[15px] font-montserrat">Rp {{ number_format($event->ticketPackages->first()->price, 0, ',', '.') }}</span>
                                        @endif

                                    <!-- Jika data lama (sebelum ada sistem paket) -->
                                    @else
                                        @if($event->price == 0 && $event->online_price == 0)
                                            <span class="text-emerald-500 font-black text-[15px]">Gratis</span>
                                        @else
                                            <span class="text-[#0066FF] font-black text-[15px] font-montserrat">Rp {{ number_format($event->price > 0 ? $event->price : $event->online_price, 0, ',', '.') }}</span>
                                        @endif
                                    @endif
                                </div>

                                <div class="text-slate-500 text-[12px] font-medium flex flex-col gap-1 mt-1">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="users" class="w-3.5 h-3.5"></i> Total Kuota: <strong class="text-slate-800">{{ $event->quota }}</strong>
                                    </div>
                                    @if($event->ticketPackages && $event->ticketPackages->count() > 0)
                                        <div class="text-[10px] text-slate-400 font-bold flex flex-wrap gap-1 mt-0.5">
                                            @foreach($event->ticketPackages as $pkg)
                                                <span class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border border-slate-200">
                                                    {{ $pkg->name }}: {{ $pkg->quota }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="px-6 py-4 no-print">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="text-slate-400 hover:text-[#0066FF] transition-colors p-1.5 hover:bg-blue-50 rounded-lg" title="Edit Data">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </a>

                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Data yang terhapus tidak dapat dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-[#FF3B30] transition-colors p-1.5 hover:bg-red-50 rounded-lg" title="Hapus Data">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State Ketika Tidak Ada Data atau Pencarian Tidak Ditemukan -->
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        @if(request('search') || request('status'))
                                            <i data-lucide="search-x" class="w-8 h-8"></i>
                                        @else
                                            <i data-lucide="ticket" class="w-8 h-8"></i>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">
                                        {{ (request('search') || request('status')) ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Event' }}
                                    </h3>
                                    <p class="text-slate-500 text-[14px] mb-6 font-medium">
                                        {{ (request('search') || request('status')) ? 'Coba gunakan kata kunci atau filter status yang lain.' : 'Anda belum menambahkan data acara apa pun ke dalam sistem.' }}
                                    </p>

                                    @if(!(request('search') || request('status')))
                                    <a href="{{ route('admin.events.create') }}" class="bg-[#0066FF] hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-blue-500/20 flex items-center gap-2">
                                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Event Sekarang
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
