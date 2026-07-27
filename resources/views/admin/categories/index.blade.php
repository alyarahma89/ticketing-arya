<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], },
                    colors: {
                        primary: '#696FC7',
                        'primary-deep': '#3D365C',
                        'primary-soft': '#C95792',
                        'primary-subdued': '#F8B55F',
                        'brand-dark': '#1c1e54',
                        ink: '#0d253d',
                        'ink-mute': '#64748d',
                        'canvas-soft': '#f8fafc',
                    }
                }
            }
        }
    </script>

     <!-- 3. CSS Kustom & Scrollbar (KHUSUS CSS) -->
    <style>
        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        /* Aturan untuk cetak PDF */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; overflow: visible !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
</head>
<body class="bg-canvas-soft text-ink flex h-screen overflow-hidden font-sans">

    <!-- SIDEBAR DINAMIS -->
    <aside class="w-64 bg-brand-dark flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen">

        <!-- 1. BAGIAN ATAS: LOGO (Ukurannya Tetap) -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/5 pt-4">
            <span class="text-white font-light text-[24px] tracking-tight">
                ARTIX <span class="font-bold text-primary-subdued">ID</span>
            </span>
        </div>

        <!-- 2. BAGIAN TENGAH: MENU (Bisa di-scroll) -->
        <nav class="p-5 space-y-2 flex-1 overflow-y-auto sidebar-scroll">
            <!-- MENU EO -->
            @if(Auth::user()->role == 'eo')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Dasbor Saya
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Event Saya
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">💳</span> Penjualan Tiket
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kerjasama Sponsor
                </a>

            <!-- MENU ADMIN UTAMA -->
            @elseif(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Manajemen Event
                </a>
                <!-- Menu ini disorot (aktif) karena kita sedang di halaman Kategori -->
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                    <span class="text-lg">🏷️</span> Kelola Kategori
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">💳</span> Data Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">👥</span> Kelola Pengguna
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Laporan Keseluruhan
                </a>

            @endif
        </nav>

        <!-- 3. BAGIAN BAWAH: PROFIL & LOGOUT (Selalu terlihat di bawah) -->
        <div class="p-5 border-t border-white/5 shrink-0 bg-brand-dark">

            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-left text-[13px] font-medium text-red-300 bg-red-500/10 hover:bg-red-500/25 border border-red-500/20 px-4 py-2.5 rounded-xl transition-all flex items-center gap-3 shadow-sm">
                    <span class="text-lg">🚪</span> Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#f4f7fb]">

        <!-- Header Halaman -->
        <div class="px-8 pt-10 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-normal text-ink mb-1">Manajemen Kategori</h1>
                <p class="text-[14px] text-ink-mute">Kelola klasifikasi acara untuk mempermudah pencarian pengguna.</p>
            </div>
        </div>

        <div class="px-8 pb-12 max-w-5xl">

            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                    <span class="text-xl">✅</span>
                    <span class="text-[14px] font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
                    <span class="text-xl mt-0.5">⚠️</span>
                    <div class="text-[14px] font-medium">
                        <ul class="list-disc pl-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Tambah Kategori -->
            <div class="bg-white rounded-[20px] p-6 shadow-sm border border-gray-100 mb-8">
                <h3 class="text-[16px] font-bold text-ink mb-4">Tambah Kategori Baru</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🏷️</span>
                        <input type="text" name="name" id="name" required placeholder="Contoh: Konser Musik, Seminar, dll..." class="w-full bg-canvas-soft border border-gray-200 rounded-xl py-2.5 pl-12 pr-4 text-[14px] text-ink focus:outline-none focus:border-primary focus:bg-white transition-colors">
                    </div>
                    <button type="submit" class="bg-brand-dark hover:bg-ink text-white px-6 py-2.5 rounded-xl text-[14px] font-medium transition-colors shadow-md whitespace-nowrap">
                        + Simpan Kategori
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <h3 class="text-[16px] font-bold text-ink">Daftar Kategori Tersedia</h3>
                    <span class="text-[12px] font-medium bg-gray-100 text-gray-500 px-3 py-1 rounded-full">{{ $categories->count() }} Kategori</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-[12px] uppercase tracking-wider text-ink-mute">
                                <th class="px-6 py-4 font-semibold text-center w-20">ID</th>
                                <th class="px-6 py-4 font-semibold">Nama Kategori (Edit Label)</th>
                                <th class="px-6 py-4 font-semibold text-center w-32">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px]">
                            @forelse($categories as $category)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <!-- ID Kategori -->
                                <td class="px-6 py-4 text-center text-ink-mute font-medium">
                                    #{{ $category->id }}
                                </td>

                                <!-- Form Edit Kategori Langsung -->
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="flex gap-2 w-full max-w-sm">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $category->name }}" required class="flex-1 border border-gray-200 rounded-lg px-3 py-1.5 text-[14px] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                                        <button type="submit" class="bg-primary hover:bg-primary-deep text-white px-4 py-1.5 rounded-lg text-[13px] font-medium transition-colors">
                                            Update
                                        </button>
                                    </form>
                                </td>

                                <!-- Form Hapus Kategori -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Event yang terhubung mungkin akan terdampak.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus Data">
                                                <!-- Icon Trash SVG -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-4xl mb-3 opacity-50">📂</span>
                                        <p class="text-ink text-[15px] font-medium">Belum Ada Kategori</p>
                                        <p class="text-ink-mute text-[13px] mt-1">Silakan tambahkan kategori baru melalui form di atas.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
