<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ARTIX ID | Integrated Event Ecosystem')</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Konfigurasi Tailwind untuk Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'exo': ['"Exo 2"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Pengaturan Dasar Transisi Mode */
        body {
            font-family: 'Exo 2', sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Animasi Bola Cahaya (Orb) */
        @keyframes orb1 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.15) translate(30px, -20px); }
        }
        @keyframes orb2 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.1) translate(-25px, 15px); }
        }

        /* Custom Scrollbar Dinamis */
        ::-webkit-scrollbar { width: 6px; }
        html.light ::-webkit-scrollbar { background: #F1F5F9; }
        html.light ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        html.dark ::-webkit-scrollbar { background: #020C1F; }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }

        /* Utility Class untuk Teks Bergradien */
        .text-gradient-dark {
            background: linear-gradient(135deg, #214587 0%, #1e66d3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-main {
            background: linear-gradient(135deg,#ffffff 0%,#b8d4ff 60%,#00C2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-orange {
            background: linear-gradient(135deg,#FF7A00,#FF3B30);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-blue {
            background: linear-gradient(135deg,#0066FF,#00C2FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <!-- Slot khusus jika halaman anak butuh style tambahan -->
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen relative">

    <!-- ── DEFINISI GRADIEN UNTUK IKON SVG BRAND GUIDELINE ── -->
    <svg width="0" height="0" class="hidden">
        <defs>
            <linearGradient id="grad-blue" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#0066FF" />
                <stop offset="100%" stop-color="#00C2FF" />
            </linearGradient>
            <linearGradient id="grad-orange" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FF3B30" />
                <stop offset="100%" stop-color="#FFB000" />
            </linearGradient>
            <linearGradient id="grad-purple" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#A100FF" />
                <stop offset="100%" stop-color="#0066FF" />
            </linearGradient>
        </defs>
    </svg>

    <!-- ── NAVBAR ──────────────────────────────────────── -->
    <nav id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-transparent border-transparent">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between py-4">

            <!-- Logo Dinamis -->
            <a href="{{ url('/') }}" class="flex items-center shrink-0">
                <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID Logo Hitam" class="h-10 md:h-14 w-auto object-contain transition-all duration-300 block dark:hidden">
                <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID Logo Putih" class="h-10 md:h-14 w-auto object-contain transition-all duration-300 hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}#event-list" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Event</a>
                <a href="{{ url('/') }}#packages" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Sponsorship</a>
            </div>

            <!-- Desktop CTA & Theme Toggle -->
            <div class="hidden md:flex items-center gap-5">
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Dashboard</a>
                    @endif

                    <!-- LINK RIWAYAT -->
                    <a href="{{ route('transaction.history') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-4 h-4"></i> Riwayat
                    </a>

                    <!-- LINK PROFIL -->
                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">
                        Halo, {{ explode(' ', Auth::user()->name)[0] }}
                    </a>

                    <!-- TOMBOL LOGOUT -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0 flex items-center">
                        @csrf
                        <button type="submit" class="text-sm font-bold transition-colors text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 hover:scale-105 shadow-md"
                        style="background: linear-gradient(135deg, #0066FF, #00C2FF); font-family: 'Montserrat', sans-serif;">
                        Mulai Gratis
                    </a>
                @endauth

                <!-- Tombol Toggle Mode Gelap/Terang Desktop -->
                <button id="theme-toggle-desktop" class="p-2.5 ml-2 rounded-full text-slate-500 bg-slate-200 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none shadow-inner">
                    <i id="theme-icon-desktop" data-lucide="moon" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Mobile Toggle -->
            <div class="flex items-center gap-3 md:hidden">
                <button id="theme-toggle-mobile" class="p-2 rounded-full text-slate-500 bg-slate-200 dark:bg-white/10 dark:text-white/70 transition-all focus:outline-none shadow-inner">
                    <i id="theme-icon-mobile" data-lucide="moon" class="w-5 h-5"></i>
                </button>
                <button id="mobile-menu-btn" class="text-slate-800 dark:text-white p-1 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-drawer" class="hidden md:hidden px-6 py-5 flex-col gap-4 border-t bg-white border-slate-200 dark:bg-[#041B4A] dark:border-white/10 shadow-xl transition-colors duration-300">
            <a href="{{ url('/') }}#event-list" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Event</a>
            <a href="{{ url('/') }}#packages" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Sponsorship</a>
            @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Dashboard</a>
                @endif
                <a href="{{ route('transaction.history') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4"></i> Riwayat
                </a>
                <a href="{{ route('profile.edit') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-500 hover:text-red-600 dark:text-red-400 py-1 text-sm font-bold transition-colors flex items-center gap-2">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="mt-2 px-5 py-3 text-sm font-bold text-white rounded-xl text-center shadow-md" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                    Mulai Gratis
                </a>
            @endauth
        </div>
    </nav>

    <!-- ── LUBANG KONTEN HALAMAN ───────────────────────── -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="py-16 transition-colors bg-[#F8FAFC] border-t border-slate-200 dark:bg-[#020C1F] dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center mb-5">
                        <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID Logo Hitam" class="h-8 object-contain block dark:hidden">
                        <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID Logo Putih" class="h-8 object-contain hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.3));">
                    </div>
                    <p class="text-sm leading-relaxed mb-6 font-medium text-slate-500 dark:text-white/40">
                        Platform event ecosystem terbesar di Indonesia. Menghubungkan penyelenggara, sponsor, dan peserta.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold border transition-all shadow-sm bg-white border-slate-200 text-slate-500 hover:border-[#0066FF] hover:text-[#0066FF] dark:bg-transparent dark:border-white/10 dark:text-white/40 dark:hover:border-[#0066FF]/60 dark:hover:text-white">IG</a>
                        <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold border transition-all shadow-sm bg-white border-slate-200 text-slate-500 hover:border-[#0066FF] hover:text-[#0066FF] dark:bg-transparent dark:border-white/10 dark:text-white/40 dark:hover:border-[#0066FF]/60 dark:hover:text-white">TW</a>
                        <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold border transition-all shadow-sm bg-white border-slate-200 text-slate-500 hover:border-[#0066FF] hover:text-[#0066FF] dark:bg-transparent dark:border-white/10 dark:text-white/40 dark:hover:border-[#0066FF]/60 dark:hover:text-white">YT</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Platform</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Ticketing</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Livestream</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Tournament</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Company</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Tentang Kami</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Karir</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Support</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Help Center</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Kontak</a></li>
                        <li><a href="#" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t gap-3 border-slate-200 dark:border-white/10">
                <p class="text-sm font-bold text-slate-400 dark:font-normal dark:text-white/30">© {{ date('Y') }} ARTIX ID. All rights reserved.</p>
                <p class="text-sm font-bold text-slate-400 dark:font-normal dark:text-white/30">hello@artix.id · artix.id</p>
            </div>
        </div>
    </footer>

    <script>
        // Inisialisasi ikon
        lucide.createIcons();

        // ── LOGIKA DARK MODE TOGGLE ──
        const themeToggleDesktop = document.getElementById('theme-toggle-desktop');
        const themeIconDesktop = document.getElementById('theme-icon-desktop');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');
        const themeIconMobile = document.getElementById('theme-icon-mobile');
        const html = document.documentElement;

        function toggleTheme() {
            const isDark = html.classList.toggle('dark');
            const iconName = isDark ? 'sun' : 'moon';
            if(themeIconDesktop) themeIconDesktop.setAttribute('data-lucide', iconName);
            if(themeIconMobile) themeIconMobile.setAttribute('data-lucide', iconName);
            lucide.createIcons();
        }

        if(themeToggleDesktop) themeToggleDesktop.addEventListener('click', toggleTheme);
        if(themeToggleMobile) themeToggleMobile.addEventListener('click', toggleTheme);

        // ── LOGIKA NAVBAR SAAT SCROLL ──
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                if (html.classList.contains('dark')) {
                    navbar.style.background = 'rgba(4, 27, 74, 0.9)';
                    navbar.style.borderBottom = '1px solid rgba(255, 255, 255, 0.05)';
                } else {
                    navbar.style.background = 'rgba(255, 255, 255, 0.9)';
                    navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.05)';
                }
                navbar.style.backdropFilter = 'blur(16px)';
            } else {
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom = 'none';
            }
        });

        // ── LOGIKA MOBILE MENU ──
        const menuBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const menuIcon = document.getElementById('menu-icon');
        let isMenuOpen = false;

        if(menuBtn) {
            menuBtn.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                if (isMenuOpen) {
                    drawer.classList.remove('hidden');
                    drawer.classList.add('flex');
                    menuIcon.setAttribute('data-lucide', 'x');
                } else {
                    drawer.classList.add('hidden');
                    drawer.classList.remove('flex');
                    menuIcon.setAttribute('data-lucide', 'menu');
                }
                lucide.createIcons();
            });
        }
    </script>

    <!-- Slot khusus untuk script tambahan halaman anak -->
    @stack('scripts')
</body>
</html>
