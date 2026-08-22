<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Kelola Kategori')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
    <!-- ── HEADER HALAMAN DENGAN PENCARIAN ── -->
    <div class="px-8 pt-10 pb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Manajemen Kategori</h1>
            <p class="text-[14px] text-slate-500 font-medium">Kelola klasifikasi acara beserta gambarnya untuk mempermudah pencarian.</p>
        </div>

        <!-- FORM PENCARIAN -->
        <div class="flex items-center gap-3 no-print">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center gap-2 m-0">
                <div class="relative w-full sm:w-64 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..."
                            class="w-full bg-white pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm">
                </div>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0">
                    Cari
                </button>
                <!-- Tombol Reset (Muncul hanya jika ada pencarian aktif) -->
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 p-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0" title="Reset Pencarian">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="px-8 pb-12 max-w-5xl">

        <!-- Notifikasi Pesan -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                <span class="text-[14px]">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
                <i data-lucide="alert-triangle" class="w-5 h-5 mt-0.5 text-red-500 shrink-0"></i>
                <div class="text-[14px] font-medium">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ── FORM TAMBAH KATEGORI ── -->
        <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-200 mb-8">
            <h3 class="text-lg font-black text-slate-800 font-montserrat mb-4 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5 text-[#0066FF]"></i> Tambah Kategori Baru
            </h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Input Nama Kategori -->
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </span>
                        <input type="text" name="name" id="name" required placeholder="Contoh: Konser, Workshop..."
                                class="w-full bg-slate-50 border border-slate-200 rounded-[12px] py-3.5 pl-12 pr-4 text-sm font-bold text-slate-900 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 focus:bg-white transition-all placeholder:font-medium placeholder:text-slate-400">
                    </div>

                    <!-- Input Link Gambar -->
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="image" class="w-5 h-5"></i>
                        </span>
                        <input type="url" name="image" id="image" placeholder="Paste Link Gambar (Opsional)"
                                class="w-full bg-slate-50 border border-slate-200 rounded-[12px] py-3.5 pl-12 pr-4 text-sm font-medium text-slate-900 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 focus:bg-white transition-all placeholder:font-medium placeholder:text-slate-400">
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-md shadow-blue-500/20 whitespace-nowrap flex items-center justify-center gap-2 hover:-translate-y-0.5 shrink-0">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>

        <!-- ── TABEL DAFTAR KATEGORI ── -->
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-800 font-montserrat">Daftar Kategori Tersedia</h3>
                <span class="text-xs font-bold bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1.5 rounded-lg">{{ $categories->count() }} Kategori</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                            <th class="px-6 py-5 text-center w-20">ID</th>
                            <th class="px-6 py-5">Ubah Data Kategori & Gambar</th>
                            <th class="px-6 py-5 text-center w-32 no-print">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700">
                        @forelse($categories as $category)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <!-- ID Kategori -->
                            <td class="px-6 py-4 text-center text-slate-400 font-bold">
                                #{{ $category->id }}
                            </td>

                            <!-- Form Edit Kategori Langsung -->
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4 w-full">
                                    @csrf
                                    @method('PUT')

                                    <!-- Kotak Preview Gambar -->
                                    <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0 border border-slate-200 bg-slate-100 shadow-sm">
                                        <img src="{{ $category->image ?? 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=150&h=150&fit=crop' }}" class="w-full h-full object-cover">
                                    </div>

                                    <div class="flex flex-col gap-2 w-full max-w-sm">
                                        <input type="text" name="name" value="{{ $category->name }}" required placeholder="Nama Kategori"
                                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all">
                                        <input type="url" name="image" value="{{ $category->image }}" placeholder="Paste Link Gambar Baru"
                                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm font-medium text-slate-500 focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all placeholder:text-slate-300">
                                    </div>

                                    <button type="submit" class="bg-slate-100 hover:bg-[#0066FF] text-slate-600 hover:text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-1.5 h-fit shrink-0">
                                        <i data-lucide="save" class="w-4 h-4"></i> Simpan
                                    </button>
                                </form>
                            </td>

                            <!-- Form Hapus Kategori -->
                            <td class="px-6 py-4 no-print">
                                <div class="flex items-center justify-center">
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Event yang terhubung mungkin akan terdampak.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-[#FF3B30] hover:bg-red-50 p-2.5 rounded-xl transition-colors" title="Hapus Kategori">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        @if(request('search'))
                                            <i data-lucide="search-x" class="w-8 h-8"></i>
                                        @else
                                            <i data-lucide="tags" class="w-8 h-8"></i>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">
                                        {{ request('search') ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Kategori' }}
                                    </h3>
                                    <p class="text-slate-500 text-[14px] font-medium">
                                        {{ request('search') ? 'Tidak ada kategori yang cocok dengan kata kunci tersebut.' : 'Silakan tambahkan kategori baru melalui formulir di atas.' }}
                                    </p>
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
