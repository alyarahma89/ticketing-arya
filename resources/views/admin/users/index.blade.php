<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - ARTIX ID</title>

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
        body {
            font-feature-settings: "ss01" 1;
            -webkit-font-smoothing: antialiased;
        }
        .tabular-numeric {
            font-feature-settings: "tnum" 1;
        }

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
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🏷️</span> Kelola Kategori
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">💳</span> Data Transaksi
                </a>
                <!-- Menu ini AKTIF karena berada di halaman Kelola Pengguna -->
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
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
                <h1 class="text-[28px] font-normal text-ink mb-1">Database Pengguna</h1>
                <p class="text-[14px] text-ink-mute">Kelola semua akun Admin, EO, Panitia, dan Pelanggan.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.create') }}" class="bg-brand-dark hover:bg-ink text-white px-5 py-2 rounded-full text-[14px] font-medium transition-colors shadow-md flex items-center gap-2">
                    <span>➕</span> Tambah Pengguna Baru
                </a>
            </div>
        </div>

        <div class="px-8 pb-12">

            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                    <span class="text-xl">✅</span>
                    <span class="text-[14px] font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                    <span class="text-xl">⚠️</span>
                    <span class="text-[14px] font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabel Daftar Pengguna -->
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <h3 class="text-[16px] font-bold text-ink">Daftar Akun Terdaftar</h3>
                    <span class="text-[12px] font-medium bg-gray-100 text-gray-500 px-3 py-1 rounded-full">{{ count($users) }} Akun</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-[12px] uppercase tracking-wider text-ink-mute">
                                <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                                <th class="px-6 py-4 font-semibold">Profil Pengguna</th>
                                <th class="px-6 py-4 font-semibold">Alamat Email</th>
                                <th class="px-6 py-4 font-semibold">Hak Akses (Role)</th>
                                <th class="px-6 py-4 font-semibold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px]">
                            @forelse($users as $index => $user)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <!-- Nomor -->
                                <td class="px-6 py-4 text-center text-ink-mute font-medium">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Profil Pengguna (Avatar + Nama) -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary font-bold uppercase shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-ink text-[14px]">{{ $user->name }}</div>
                                            <div class="text-[12px] text-gray-400 mt-0.5">ID: #USR-{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 text-ink-mute">
                                    {{ $user->email }}
                                </td>

                                <!-- Role Badge -->
                                <td class="px-6 py-4">
                                    @if($user->role == 'admin')
                                        <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Admin</span>
                                    @elseif($user->role == 'panitia')
                                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Panitia</span>
                                    @elseif($user->role == 'eo')
                                        <span class="bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Event Organizer</span>
                                    @else
                                        <span class="bg-slate-50 text-slate-600 border border-slate-200 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider inline-block">Pelanggan</span>
                                    @endif
                                </td>

                                <!-- Aksi (Hapus) -->
                                <td class="px-6 py-4 text-center">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus akun akan menghilangkan semua data terkait pengguna ini. Yakin ingin menghapus permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-[12px] font-medium transition-colors">
                                                Hapus Akun
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[12px] font-medium text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg">
                                            Akun Anda
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-4xl mb-3 opacity-50">👥</span>
                                        <p class="text-ink text-[15px] font-medium">Belum Ada Pengguna Lain</p>
                                        <p class="text-ink-mute text-[13px] mt-1">Anda adalah satu-satunya pengguna di sistem saat ini.</p>
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
