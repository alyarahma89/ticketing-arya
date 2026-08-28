<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul Halaman Dinamis -->
    <title>@yield('title', 'Admin Panel') - Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'exo': ['"Exo 2"', 'sans-serif'],
                    },
                    colors: {
                        'artix-blue': '#0066FF',
                        'artix-navy': '#041B4A',
                        'artix-orange': '#FF7A00',
                        'artix-red': '#FF3B30',
                        'artix-purple': '#A100FF',
                        'artix-cyan': '#00C2FF',
                        'canvas-soft': '#F8FAFC',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Exo 2', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        .text-gradient-orange {
            background: linear-gradient(135deg, #FF7A00, #FF3B30);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; overflow: visible !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-canvas-soft text-slate-800 flex h-screen overflow-hidden">

    <!-- ── OVERLAY GELAP UNTUK HP (Saat menu terbuka) ── -->
    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden transition-opacity opacity-0 lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ── SIDEBAR KIRI ── -->
    <!-- PERBAIKAN: Menambahkan animasi transform agar bisa digeser masuk/keluar di layar kecil -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-artix-navy flex flex-col z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl border-r border-white/5 no-print">

        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/10">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" class="h-10 w-auto object-contain">
            </a>
        </div>

        <nav class="p-5 space-y-1.5 flex-1 overflow-y-auto sidebar-scroll">
            <!-- ============================== -->
            <!-- MENU UNTUK EO (PEMILIK EVENT)  -->
            <!-- ============================== -->
            @if(Auth::user()->role == 'eo')
                <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Menu Utama</div>

                <!-- Logika Menu Dinamis (Warna Biru Otomatis) -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dasbor Saya
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.events.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="ticket" class="w-5 h-5"></i> Event Saya
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.transactions.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Penjualan Tiket
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.sponsorships.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="handshake" class="w-5 h-5"></i> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.sponsorship_requests.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="inbox" class="w-5 h-5"></i> Pengajuan Masuk
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Event
                </a>

            <!-- ============================== -->
            <!-- MENU UNTUK ADMIN PUSAT         -->
            <!-- ============================== -->
            @elseif(Auth::user()->role == 'admin')
                <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Sistem Admin</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.events.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="ticket" class="w-5 h-5"></i> Manajemen Event
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="tags" class="w-5 h-5"></i> Kelola Kategori
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.transactions.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Data Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="users" class="w-5 h-5"></i> Kelola Pengguna
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.sponsorships.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="handshake" class="w-5 h-5"></i> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.sponsorship_requests.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="inbox" class="w-5 h-5"></i> Pengajuan Masuk
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-medium transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-[#0066FF] text-white font-bold shadow-md shadow-blue-500/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Keseluruhan
                </a>
            @endif
        </nav>

        <div class="p-5 border-t border-white/10 shrink-0 bg-artix-navy">
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full text-left text-[13px] font-bold text-red-400 bg-red-500/10 hover:bg-red-500/20 px-4 py-3 rounded-xl transition-all flex items-center gap-3">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- ── AREA KONTEN UTAMA ── -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#F8FAFC]">

        <!-- HEADER ATAS -->
        <header class="h-20 px-6 sm:px-8 flex items-center justify-between lg:justify-end shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-20 no-print">

            <!-- Tombol Hamburger untuk Layar Kecil (Hanya muncul di HP/Tablet) -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <!-- Profil User -->
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-artix-blue flex items-center justify-center text-white text-xs font-bold uppercase">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                <div class="flex flex-col text-left hidden sm:flex">
                    <span class="text-[13px] font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-artix-blue font-bold uppercase tracking-wider">{{ Auth::user()->role == 'eo' ? 'Event Organizer' : 'Platform Admin' }}</span>
                </div>
            </div>
        </header>

        <!-- ── AREA INJEKSI KONTEN DINAMIS DARI HALAMAN LAIN ── -->
        @yield('content')

    </main>

    <!-- ── SCRIPT UNTUK ANIMASI MENU HP ── -->
    <script>
        lucide.createIcons();

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobileOverlay');

        // Fungsi membuka dan menutup sidebar
        function toggleSidebar() {
            // Geser masuk/keluar
            sidebar.classList.toggle('-translate-x-full');

            // Munculkan/hilangkan bayangan gelap
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300); // Tunggu animasi pudar selesai
            }
        }
    </script>

    <!-- ── AREA INJEKSI SCRIPT TAMBAHAN ── -->
    @stack('scripts')
</body>
</html>
