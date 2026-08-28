<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticks ID | Integrated Event Ecosystem')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

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
                <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID Logo" class="h-10 md:h-12 w-auto object-contain transition-all duration-300 block dark:hidden">
                <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" class="h-10 md:h-12 w-auto object-contain transition-all duration-300 hidden dark:block">
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
                        <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID Logo" class="h-8 object-contain block dark:hidden">
                        <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" class="h-8 object-contain hidden dark:block">
                    </div>
                    <p class="text-sm leading-relaxed mb-6 font-medium text-slate-500 dark:text-white/40">
                        Platform event ecosystem terbesar di Indonesia. Menghubungkan penyelenggara, sponsor, dan peserta.
                    </p>
                    <div class="flex items-center gap-3">
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/eventorganizermedan?utm_source=ig_web_button_share_sheet&igsi=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl flex items-center justify-center border transition-all shadow-sm bg-white border-slate-200 text-slate-500 hover:border-pink-500 hover:text-pink-500 hover:scale-105 dark:bg-white/5 dark:border-white/10 dark:text-white/60 dark:hover:border-pink-500/60 dark:hover:text-pink-400" title="Instagram Event Organizer Medan">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp CS -->
                        <a href="https://wa.me/6282160762279?text=Halo%20Admin%20ARTIX%20ID,%20saya%20ingin%20bertanya%20seputar%20event" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl flex items-center justify-center border transition-all shadow-sm bg-white border-slate-200 text-slate-500 hover:border-emerald-500 hover:text-emerald-500 hover:scale-105 dark:bg-white/5 dark:border-white/10 dark:text-white/60 dark:hover:border-emerald-500/60 dark:hover:text-emerald-400" title="WhatsApp CS (+62 821-6076-2279)">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Platform</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Smart Ticketing</a></li>
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Livestream HD</a></li>
                        <li><a href="{{ route('explore.sponsorships') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Sponsorship Marketplace</a></li>
                        <li><a href="{{ url('/') }}#features" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Tournament System</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Company</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ url('/') }}#features" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Tentang Kami</a></li>
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Eksplorasi Event</a></li>
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20ARTIX%20ID,%20saya%20ingin%20konsultasi%20kemitraan%20dan%20kerjasama%20event" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Konsultasi EO & Sponsorship</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Daftar Event Organizer</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Support & Legal</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20ARTIX%20ID,%20saya%20butuh%20bantuan%20seputar%20tiket" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80 flex items-center gap-1.5"><i data-lucide="help-circle" class="w-3.5 h-3.5 text-blue-500"></i> Help Center</a></li>
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20ARTIX%20ID" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80 flex items-center gap-1.5"><i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-500"></i> Kontak</a></li>
                        <li><a href="{{ route('terms') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('refund') }}" class="text-sm font-medium transition-colors text-slate-500 hover:text-[#0066FF] dark:text-white/40 dark:hover:text-white/80">Kebijakan Refund</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t gap-3 border-slate-200 dark:border-white/10">
                <p class="text-sm font-bold text-slate-400 dark:font-normal dark:text-white/30">© {{ date('Y') }} TICKS ID. All rights reserved.</p>
                <p class="text-sm font-bold text-slate-400 dark:font-normal dark:text-white/30 flex items-center gap-3">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=growaryacommunication@gmail.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#0066FF] transition-colors flex items-center gap-1.5" title="Kirim Email ke growaryacommunication@gmail.com">
                        <i data-lucide="mail" class="w-4 h-4 text-[#0066FF]"></i> growaryacommunication@gmail.com
                    </a>
                </p>
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
