<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticks ID | Integrated Event Ecosystem')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="@yield('meta_description', 'Ticks ID adalah ekosistem event terintegrasi di Indonesia untuk ticketing, sponsorship marketplace, livestreaming, dan tournament management.')">
    <meta name="keywords" content="beli tiket event, tiket konser, sponsorship event, event organizer medan, event organizer indonesia, ticks id, beli tiket online">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Ticks ID | Integrated Event Ecosystem')">
    <meta property="og:description" content="@yield('meta_description', 'Ticks ID adalah ekosistem event terintegrasi di Indonesia untuk ticketing, sponsorship marketplace, livestreaming, dan tournament management.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('logoticksid.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Ticks ID | Integrated Event Ecosystem')">
    <meta name="twitter:description" content="@yield('meta_description', 'Ticks ID adalah ekosistem event terintegrasi di Indonesia untuk ticketing, sponsorship marketplace, livestreaming, dan tournament management.')">
    <meta name="twitter:image" content="{{ asset('logoticksid.png') }}">

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- JSON-LD Structured Data for Search Engines & AI Agent Indexing -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "{{ url('/') }}#organization",
          "name": "Ticks ID",
          "url": "{{ url('/') }}",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('logoticksid.png') }}",
            "width": 400,
            "height": 176
          },
          "sameAs": [
            "https://www.instagram.com/eventorganizermedan"
          ],
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-821-6076-2279",
            "contactType": "Customer Service",
            "areaServed": "ID",
            "availableLanguage": ["id", "en"]
          }
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "Ticks ID",
          "description": "Integrated Event Ecosystem di Indonesia untuk Ticketing, Sponsorship Marketplace, Livestreaming, dan Turnamen.",
          "publisher": {
            "@id": "{{ url('/') }}#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/') }}?search={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>

    <!-- Preconnect Font Providers -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        /* Optimized Navbar Scrolled State */
        .navbar-scrolled {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        html.dark .navbar-scrolled {
            background: rgba(4, 27, 74, 0.9) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        html.light .navbar-scrolled {
            background: rgba(255, 255, 255, 0.9) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }
    </style>

    <!-- Slot khusus jika halaman anak butuh style tambahan -->
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen relative">

    <!-- ── AKSESIBILITAS: SKIP LINK ── -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999] focus:px-4 focus:py-2 focus:bg-[#0066FF] focus:text-white focus:font-bold focus:rounded-xl focus:shadow-2xl">
        Lewati ke Konten Utama
    </a>

    <!-- ── DEFINISI GRADIEN UNTUK IKON SVG BRAND GUIDELINE ── -->
    <svg width="0" height="0" class="hidden" aria-hidden="true">
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

    <!-- ── NAVBAR (LANDMARK HEADER) ────────────────────── -->
    <header class="relative z-50">
        <nav id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-transparent border-transparent" aria-label="Navigasi Utama">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between py-4">

                <!-- Logo Dinamis -->
                <a href="{{ url('/') }}" class="flex items-center shrink-0" aria-label="Ticks ID Beranda">
                    <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID Logo" width="160" height="48" class="h-10 md:h-12 w-auto object-contain transition-all duration-300 block dark:hidden">
                    <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" width="160" height="48" class="h-10 md:h-12 w-auto object-contain transition-all duration-300 hidden dark:block">
                </a>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/') }}#event-list" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white">Event</a>
                    <a href="{{ url('/') }}#packages" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white">Sponsorship</a>
                </div>

                <!-- Desktop CTA & Theme Toggle -->
                <div class="hidden md:flex items-center gap-5">
                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white">Dashboard</a>
                        @endif

                        <!-- LINK RIWAYAT -->
                        <a href="{{ route('transaction.history') }}" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-4 h-4"></i> Riwayat
                        </a>

                        <!-- LINK PROFIL -->
                        <a href="{{ route('profile.edit') }}" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white">
                            Halo, {{ explode(' ', Auth::user()->name)[0] }}
                        </a>

                        <!-- TOMBOL LOGOUT -->
                        <form action="{{ route('logout') }}" method="POST" class="m-0 flex items-center">
                            @csrf
                            <button type="submit" aria-label="Keluar dari akun" class="text-sm font-bold transition-colors text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold transition-colors text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 hover:scale-105 shadow-md"
                            style="background: linear-gradient(135deg, #0066FF, #00C2FF); font-family: 'Montserrat', sans-serif;">
                            Mulai Gratis
                        </a>
                    @endauth

                    <!-- Tombol Toggle Mode Gelap/Terang Desktop -->
                    <button id="theme-toggle-desktop" aria-label="Ganti tema gelap atau terang" class="p-2.5 ml-2 rounded-full text-slate-600 bg-slate-200 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/80 dark:hover:text-white transition-all focus:outline-none shadow-inner">
                        <i id="theme-icon-desktop" data-lucide="moon" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Mobile Toggle -->
                <div class="flex items-center gap-3 md:hidden">
                    <button id="theme-toggle-mobile" aria-label="Ganti tema gelap atau terang" class="p-2 rounded-full text-slate-600 bg-slate-200 dark:bg-white/10 dark:text-white/80 transition-all focus:outline-none shadow-inner">
                        <i id="theme-icon-mobile" data-lucide="moon" class="w-5 h-5"></i>
                    </button>
                    <button id="mobile-menu-btn" aria-label="Buka menu navigasi" aria-expanded="false" class="text-slate-800 dark:text-white p-1 focus:outline-none">
                        <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div id="mobile-drawer" class="hidden md:hidden px-6 py-5 flex-col gap-4 border-t bg-white border-slate-200 dark:bg-[#041B4A] dark:border-white/10 shadow-xl transition-colors duration-300">
                <a href="{{ url('/') }}#event-list" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors">Event</a>
                <a href="{{ url('/') }}#packages" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors">Sponsorship</a>
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors">Dashboard</a>
                    @endif
                    <a href="{{ route('transaction.history') }}" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4"></i> Riwayat
                    </a>
                    <a href="{{ route('profile.edit') }}" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                        @csrf
                        <button type="submit" aria-label="Keluar dari akun" class="w-full text-left text-red-600 hover:text-red-700 dark:text-red-400 py-1 text-sm font-bold transition-colors flex items-center gap-2">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-[#0066FF] dark:text-white/80 dark:hover:text-white py-1 text-sm font-bold transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="mt-2 px-5 py-3 text-sm font-bold text-white rounded-xl text-center shadow-md" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                        Mulai Gratis
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- ── LUBANG KONTEN HALAMAN (LANDMARK MAIN) ───────── -->
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="py-16 transition-colors bg-[#F8FAFC] border-t border-slate-200 dark:bg-[#020C1F] dark:border-white/10" aria-label="Bagian Kaki Halaman">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center mb-5">
                        <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID Logo" width="128" height="32" class="h-8 object-contain block dark:hidden">
                        <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" width="128" height="32" class="h-8 object-contain hidden dark:block">
                    </div>
                    <p class="text-sm leading-relaxed mb-6 font-medium text-slate-600 dark:text-white/70">
                        Platform event ecosystem terbesar di Indonesia. Menghubungkan penyelenggara, sponsor, dan peserta.
                    </p>
                    <div class="flex items-center gap-3">
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/eventorganizermedan?utm_source=ig_web_button_share_sheet&igsi=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl flex items-center justify-center border transition-all shadow-sm bg-white border-slate-200 text-slate-600 hover:border-pink-500 hover:text-pink-500 hover:scale-105 dark:bg-white/5 dark:border-white/10 dark:text-white/70 dark:hover:border-pink-500/60 dark:hover:text-pink-400" aria-label="Instagram Event Organizer Medan" title="Instagram Event Organizer Medan">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp CS -->
                        <a href="https://wa.me/6282160762279?text=Halo%20Admin%20Ticks%20ID,%20saya%20ingin%20bertanya%20seputar%20event" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl flex items-center justify-center border transition-all shadow-sm bg-white border-slate-200 text-slate-600 hover:border-emerald-500 hover:text-emerald-500 hover:scale-105 dark:bg-white/5 dark:border-white/10 dark:text-white/70 dark:hover:border-emerald-500/60 dark:hover:text-emerald-400" aria-label="WhatsApp Customer Service Ticks ID" title="WhatsApp CS (+62 821-6076-2279)">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Platform</h3>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Smart Ticketing</a></li>
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Livestream HD</a></li>
                        <li><a href="{{ route('explore.sponsorships') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Sponsorship Marketplace</a></li>
                        <li><a href="{{ url('/') }}#features" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Tournament System</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Company</h3>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ url('/') }}#features" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Tentang Kami</a></li>
                        <li><a href="{{ route('explore.events') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Eksplorasi Event</a></li>
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20Ticks%20ID,%20saya%20ingin%20konsultasi%20kemitraan%20dan%20kerjasama%20event" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Konsultasi EO & Sponsorship</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Daftar Event Organizer</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-black text-sm mb-5 tracking-wide uppercase font-montserrat text-slate-900 dark:text-white">Support & Legal</h3>
                    <ul class="flex flex-col gap-3">
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20Ticks%20ID,%20saya%20butuh%20bantuan%20seputar%20tiket" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white flex items-center gap-1.5"><i data-lucide="help-circle" class="w-3.5 h-3.5 text-blue-500"></i> Help Center</a></li>
                        <li><a href="https://wa.me/6282160762279?text=Halo%20Admin%20Ticks%20ID" target="_blank" rel="noopener noreferrer" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white flex items-center gap-1.5"><i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-500"></i> Kontak</a></li>
                        <li><a href="{{ route('terms') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('refund') }}" class="text-sm font-medium transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Kebijakan Refund</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t gap-3 border-slate-200 dark:border-white/10">
                <p class="text-sm font-semibold text-slate-500 dark:font-normal dark:text-white/50">© {{ date('Y') }} TICKS ID. All rights reserved.</p>
                <p class="text-sm font-semibold text-slate-500 dark:font-normal dark:text-white/50 flex items-center gap-3">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=growaryacommunication@gmail.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#0066FF] transition-colors flex items-center gap-1.5" title="Kirim Email ke growaryacommunication@gmail.com" aria-label="Email growaryacommunication@gmail.com">
                        <i data-lucide="mail" class="w-4 h-4 text-[#0066FF]"></i> growaryacommunication@gmail.com
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Lucide Icons (Non-blocking) -->
    <script src="https://unpkg.com/lucide@latest"></script>

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

        // ── LOGIKA NAVBAR SAAT SCROLL (OPTIMIZED DENGAN REQUESTANIMATIONFRAME) ──
        const navbar = document.getElementById('navbar');
        let isTicking = false;
        window.addEventListener('scroll', () => {
            if (!isTicking) {
                window.requestAnimationFrame(() => {
                    if (window.scrollY > 40) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                    isTicking = false;
                });
                isTicking = true;
            }
        }, { passive: true });

        // ── LOGIKA MOBILE MENU ──
        const menuBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const menuIcon = document.getElementById('menu-icon');
        let isMenuOpen = false;

        if(menuBtn) {
            menuBtn.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                menuBtn.setAttribute('aria-expanded', isMenuOpen);
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
