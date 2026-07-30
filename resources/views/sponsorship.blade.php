<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Sponsorship - {{ $event->name }} | ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <!-- Tailwind CSS & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
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
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Exo 2', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 6px; }
        html.light ::-webkit-scrollbar { background: #F1F5F9; }
        html.light ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        html.dark ::-webkit-scrollbar { background: #020C1F; }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen">

    <!-- ── NAVBAR PUBLIK ── -->
    <nav id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between py-4">
            <a href="{{ url('/') }}" class="flex items-center shrink-0">
                <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID" class="h-10 w-auto object-contain block dark:hidden">
                <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID" class="h-10 w-auto object-contain hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}#event-list" class="text-sm font-bold text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white transition-colors">Event</a>
                <a href="{{ url('/') }}#packages" class="text-sm font-bold text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white transition-colors">Marketplace</a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <a href="{{ url('/') }}" class="text-sm font-bold text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white transition-colors">Kembali ke Beranda</a>
                <button id="theme-toggle-desktop" class="p-2.5 ml-2 rounded-full text-slate-500 bg-slate-200 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none shadow-inner">
                    <i id="theme-icon-desktop" data-lucide="moon" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Mobile Toggle -->
            <button id="theme-toggle-mobile" class="md:hidden p-2 rounded-full text-slate-500 bg-slate-200 dark:bg-white/10 dark:text-white/70 transition-all">
                <i id="theme-icon-mobile" data-lucide="moon" class="w-5 h-5"></i>
            </button>
        </div>
    </nav>

    <!-- ── HERO SECTION: DETAIL EVENT ── -->
    <section class="relative pt-32 pb-16 overflow-hidden bg-white dark:bg-transparent transition-colors border-b border-slate-200 dark:border-white/10">
        <div class="absolute inset-0 pointer-events-none hidden dark:block" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, #0A2A6E 0%, transparent 70%); z-index: 0;"></div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest border mb-6 bg-purple-50 border-purple-200 text-purple-700 dark:bg-[#A100FF18] dark:border-[#A100FF45] dark:text-[#c5a3ff]">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i> PROPOSAL SPONSORSHIP
            </div>

            <h1 class="font-black text-4xl md:text-5xl leading-tight font-montserrat text-slate-900 dark:text-white mb-6">
                {{ $event->name }}
            </h1>

            <p class="text-base md:text-lg max-w-2xl mx-auto leading-relaxed font-medium text-slate-600 dark:text-white/60 mb-8">
                {{ $event->description }}
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4 text-sm font-bold">
                <div class="flex items-center gap-2 bg-slate-100 text-slate-700 dark:bg-white/10 dark:text-white px-5 py-2.5 rounded-full">
                    <i data-lucide="calendar" class="w-4 h-4 text-orange-500"></i> {{ date('d F Y', strtotime($event->event_date)) }}
                </div>
                <div class="flex items-center gap-2 bg-slate-100 text-slate-700 dark:bg-white/10 dark:text-white px-5 py-2.5 rounded-full">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i> {{ $event->location }}
                </div>
            </div>
        </div>
    </section>

    <!-- ── KATALOG PAKET SPONSOR EVENT INI ── -->
    <section class="py-16 flex-grow transition-colors bg-[#F8FAFC] dark:bg-[#020C1F]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between mb-10">
                <h2 class="font-black text-2xl font-montserrat text-slate-900 dark:text-white">Pilihan Paket Kemitraan</h2>
                <span class="text-xs font-bold bg-blue-50 text-[#0066FF] px-3 py-1.5 rounded-lg border border-blue-100 dark:bg-[#0066FF22] dark:border-[#0066FF55] dark:text-[#00C2FF]">
                    {{ count($event->sponsorships) }} Paket Tersedia
                </span>
            </div>

            @if(count($event->sponsorships) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($event->sponsorships as $sponsor)
                    <div class="group p-5 rounded-3xl border shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#A100FF55] dark:hover:shadow-[0_8px_40px_rgba(161,0,255,0.25)]">

                        <!-- Header Kartu -->
                        <div class="flex items-start gap-4 mb-6 pb-6 border-b border-slate-100 dark:border-white/10">
                            <!-- Gambar Badge (Bisa Logo EO atau Gambar Paket) -->
                            <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-[#0A1A3A] flex items-center justify-center border border-slate-200 dark:border-white/10">
                                @if($sponsor->image)
                                    <img src="{{ asset('storage/' . $sponsor->image) }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="shield" class="w-8 h-8 text-slate-300 dark:text-white/20"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-black text-lg leading-tight font-montserrat text-slate-900 dark:text-white mb-1.5">{{ $sponsor->name }}</h3>
                                <p class="text-lg font-black text-[#FF7A00] dark:text-[#FFB000]">
                                    Rp {{ number_format($sponsor->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Daftar Benefit (Full List) -->
                        <div class="flex-grow mb-8">
                            <p class="text-[11px] font-bold text-slate-400 dark:text-white/40 uppercase tracking-widest mb-4">Benefit Eksklusif:</p>
                            <ul class="space-y-3">
                                @php
                                    $benefits = explode(',', $sponsor->benefits);
                                @endphp

                                @foreach($benefits as $benefit)
                                    @if(trim($benefit) != '')
                                    <li class="flex items-start gap-2.5 text-[14px] font-medium text-slate-600 dark:text-white/70">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
                                        <span class="leading-snug">{{ trim($benefit) }}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- Tombol CTA & Kuota -->
                        <div class="mt-auto">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-500 dark:text-white/50 flex items-center gap-1.5">
                                    <i data-lucide="users" class="w-4 h-4"></i> {{ $sponsor->quota }} Slot Tersedia
                                </span>
                            </div>
                            <a href="{{ route('sponsorship.apply', $sponsor->id) }}" class="w-full block text-center py-3.5 rounded-xl text-sm font-bold text-white shadow-md transition-all hover:scale-[1.02] hover:shadow-xl" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                                Sepakati & Ajukan Sponsor
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State Jika Event Belum Menambahkan Sponsor -->
                <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 dark:bg-white/5 dark:border-white/10 shadow-sm max-w-3xl mx-auto">
                    <i data-lucide="folder-x" class="w-20 h-20 text-slate-300 dark:text-white/20 mx-auto mb-5"></i>
                    <h3 class="text-2xl font-black text-slate-800 font-montserrat mb-3 dark:text-white">Proposal Belum Tersedia</h3>
                    <p class="text-base text-slate-500 font-medium dark:text-white/60 mb-6">Penyelenggara acara ini belum merilis paket kemitraan ke dalam sistem marketplace.</p>
                    <a href="{{ url('/') }}#packages" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 dark:border-white/20 dark:text-white dark:hover:bg-white/10 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Lihat Event Lainnya
                    </a>
                </div>
            @endif

        </div>
    </section>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="py-16 transition-colors bg-[#F8FAFC] border-t border-slate-200 dark:bg-[#020C1F] dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <!-- Logo Footer -->
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

    <!-- SCRIPT DARK MODE -->
    <script>
        lucide.createIcons();

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
    </script>
</body>
</html>
