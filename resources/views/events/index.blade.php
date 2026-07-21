<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTIX ID | Integrated Event Ecosystem</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { background: #041B4A; color: #ffffff; font-family: 'Exo 2', sans-serif; overflow-x: hidden; }

        /* Animasi Bola Cahaya (Orb) */
        @keyframes orb1 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.15) translate(30px, -20px); }
        }
        @keyframes orb2 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.1) translate(-25px, 15px); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; background: #020C1F; }
        ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }

        /* Utility Class untuk Teks Bergradien */
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
</head>
<body>

    <!-- ── NAVBAR ──────────────────────────────────────── -->
    <nav id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-transparent">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-white text-base shrink-0"
                     style="background: linear-gradient(135deg, #0066FF 0%, #00C2FF 100%); box-shadow: 0 0 20px rgba(0,102,255,0.5); font-family: 'Montserrat', sans-serif;">
                    A
                </div>
                <span class="font-black text-lg tracking-tight text-white" style="font-family: 'Montserrat', sans-serif;">
                    ARTIX <span style="color: #0066FF;">ID</span>
                </span>
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#event-list" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Event</a>
                <a href="#packages" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Sponsorship</a>
                <a href="#" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Harga</a>
                <a href="#" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Komunitas</a>
            </div>

            <!-- Desktop CTA Dinamis dengan Database -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium transition-colors text-white/65 hover:text-white">
                        Halo, {{ explode(' ', Auth::user()->name)[0] }}
                    </a>

                    <!-- TAMBAHAN: Tombol Logout Desktop -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0 flex items-center">
                        @csrf
                        <button type="submit" class="text-sm font-medium transition-colors text-red-400 hover:text-red-300">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium transition-colors text-white/65 hover:text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold text-white rounded-xl transition-all hover:opacity-90 hover:scale-105"
                        style="background: linear-gradient(135deg, #0066FF, #00C2FF); box-shadow: 0 0 24px rgba(0,102,255,0.45); font-family: 'Montserrat', sans-serif;">
                        Mulai Gratis
                    </a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button id="mobile-menu-btn" class="md:hidden text-white p-1">
                <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
            </button>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-drawer" class="hidden md:hidden px-6 py-5 flex-col gap-4 border-t" style="background: rgba(4,27,74,0.98); border-color: rgba(0,102,255,0.2);">
            <a href="#event-list" class="text-white/70 hover:text-white py-1 text-sm font-medium transition-colors">Event</a>
            <a href="#packages" class="text-white/70 hover:text-white py-1 text-sm font-medium transition-colors">Sponsorship</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="text-white/70 hover:text-white py-1 text-sm font-medium transition-colors">Profil Saya</a>

                <!-- TAMBAHAN: Tombol Logout Mobile -->
                <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 py-1 text-sm font-medium transition-colors">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white/70 hover:text-white py-1 text-sm font-medium transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="mt-2 px-5 py-3 text-sm font-bold text-white rounded-xl text-center" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                    Mulai Gratis
                </a>
            @endauth
        </div>
    </nav>

    <!-- ── HERO ────────────────────────────────────────── -->
    <section class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden" style="background: radial-gradient(ellipse 90% 70% at 50% -10%, #0A2A6E 0%, #041B4A 65%);">

        <!-- Grid Overlay & Glow -->
        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(0,102,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(0,102,255,0.07) 1px, transparent 1px); background-size: 56px 56px;"></div>
        <div class="absolute rounded-full pointer-events-none" style="width: 520px; height: 520px; top: 10%; left: 5%; background: #0066FF; opacity: 0.12; filter: blur(100px); animation: orb1 7s ease-in-out infinite;"></div>
        <div class="absolute rounded-full pointer-events-none" style="width: 400px; height: 400px; bottom: 10%; right: 5%; background: #A100FF; opacity: 0.1; filter: blur(90px); animation: orb2 9s ease-in-out infinite 1.5s;"></div>

        <!-- Hero Image -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=1600&h=900&fit=crop&auto=format" alt="Concert crowd" class="w-full h-full object-cover" style="opacity: 0.08;">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(4,27,74,0.2) 0%, #041B4A 100%);"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center pt-28 pb-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest border mb-6" style="background: #0066FF18; border-color: #0066FF45; color: #00C2FF;">
                <i data-lucide="zap" class="w-3 h-3"></i> INTEGRATED EVENT ECOSYSTEM PLATFORM
            </div>

            <h1 class="font-black leading-none tracking-tight mb-7" style="font-family: 'Montserrat', sans-serif; font-size: clamp(3rem, 9vw, 6.5rem);">
                <span class="text-gradient-main">
                    ONE PLATFORM<br>FOR EVERY<br>
                </span>
                <span class="text-gradient-orange">EVENT</span>
            </h1>

            <p class="text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed text-white/55">
                Dari ticketing hingga livestream, sponsorship hingga tournament — semua terintegrasi dalam satu ekosistem digital untuk event Indonesia yang lebih besar.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="#event-list" class="group inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-xl transition-all hover:scale-105" style="background: linear-gradient(135deg, #0066FF, #00C2FF); box-shadow: 0 0 40px rgba(0,102,255,0.55); font-family: 'Montserrat', sans-serif;">
                    Cari Tiket Event
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#packages" class="group inline-flex items-center justify-center gap-3 px-8 py-4 font-semibold text-white rounded-xl border transition-all hover:bg-white/5" style="border-color: rgba(255,255,255,0.18);">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background: rgba(0,102,255,0.35);">
                        <i data-lucide="handshake" class="w-3 h-3 text-white"></i>
                    </div>
                    Sponsorship
                </a>
            </div>

            <!-- Form Pencarian Database -->
            <form action="{{ url('/') }}" method="GET" class="max-w-3xl mx-auto bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-md relative z-20">
                <div class="flex flex-col md:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event atau kategori..." class="flex-1 bg-[#020C1F] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#00C2FF]">
                    <select name="location" class="bg-[#020C1F] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#00C2FF]">
                        <option value="">Semua Lokasi</option>
                        <option value="Medan" {{ request('location') == 'Medan' ? 'selected' : '' }}>Medan</option>
                        <option value="Jakarta" {{ request('location') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                    </select>
                    <button type="submit" class="px-6 py-3 font-bold text-white rounded-xl transition-all hover:scale-105" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="absolute bottom-0 inset-x-0 h-40 pointer-events-none" style="background: linear-gradient(to bottom, transparent, #030F2E);"></div>
    </section>

    <!-- ── DAFTAR EVENT DINAMIS DARI DATABASE ──────────────────────── -->
    <section id="event-list" class="py-20 border-t" style="background: #030F2E; border-color: rgba(0,102,255,0.18);">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12 flex items-center justify-between">
                <h2 class="font-black text-3xl text-white" style="font-family: 'Montserrat', sans-serif;">⚡ Event Mendatang</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Looping Database Event -->
                @forelse($events as $event)
                <div class="group relative p-4 rounded-2xl border transition-all duration-300 hover:-translate-y-2 flex flex-col"
                     style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.borderColor='#0066FF55'; this.style.boxShadow='0 8px 40px rgba(0,102,255,0.35)';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none';">

                    <div class="h-44 w-full relative overflow-hidden rounded-xl bg-[#0A1A3A] mb-5">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 px-3 py-1 text-[10px] font-bold rounded-full tracking-wider" style="background: #0066FF; color: white; font-family: 'Montserrat', sans-serif;">
                            <!-- PERBAIKAN: Memanggil ->name dari relasi kategori dengan aman -->
                            {{ strtoupper($event->category->name ?? 'TANPA KATEGORI') }}
                        </div>
                    </div>

                    <h3 class="font-bold text-white text-lg mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $event->name }}</h3>
                    <p class="text-sm text-white/50 mb-4 line-clamp-2">{{ $event->description }}</p>

                    <div class="flex items-center gap-2 text-xs text-white/40 mb-2">
                        <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $event->location ?? 'Lokasi Belum Ditentukan' }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-white/40 mb-4 pb-4 border-b border-white/10">
                        <i data-lucide="calendar" class="w-3 h-3"></i> {{ date('d M Y', strtotime($event->event_date)) }}
                    </div>

                    <div class="mt-auto flex items-center justify-between">
                        <span class="font-bold text-lg text-gradient-orange" style="font-family: 'Montserrat', sans-serif;">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ url('/event/' . $event->id) }}" class="px-5 py-2 text-xs font-bold text-white rounded-lg transition-all hover:scale-105" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">Beli Tiket</a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 rounded-2xl border border-dashed border-white/20">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto text-white/30 mb-3"></i>
                    <h3 class="font-bold text-white text-lg">Tidak ada event ditemukan</h3>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ── DAFTAR SPONSORSHIP DINAMIS DARI DATABASE ────────────────── -->
    <section id="packages" class="py-20 border-t" style="background: #020C1F; border-color: rgba(0,102,255,0.15);">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest border mb-4" style="background: #A100FF18; border-color: #A100FF45; color: #A100FF;">
                    MARKETPLACE
                </div>
                <h2 class="font-black text-3xl md:text-4xl text-white" style="font-family: 'Montserrat', sans-serif;">Sponsorship Platform</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Looping Database Sponsorship -->
                @forelse($sponsorships as $sponsor)
                <div class="p-6 rounded-2xl border transition-all hover:-translate-y-1 flex flex-col" style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);">
                    <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-2">EVENT: {{ $sponsor->event->name ?? 'N/A' }}</div>
                    <h3 class="font-bold text-white text-xl" style="font-family: 'Montserrat', sans-serif;">{{ $sponsor->name }}</h3>
                    <div class="font-black text-3xl text-gradient-blue my-3" style="font-family: 'Montserrat', sans-serif;">Rp {{ number_format($sponsor->price, 0, ',', '.') }}</div>
                    <p class="text-xs text-white/40 mb-4 pb-4 border-b border-white/10">Sisa Kuota: {{ $sponsor->quota }}</p>

                    <div class="text-sm text-white/70 flex-1 whitespace-pre-line leading-relaxed mb-6">
                        {{ $sponsor->benefits }}
                    </div>

                    <a href="https://wa.me/6282160762279?text=Halo%20ARTIX%20ID,%20saya%20tertarik%20mengambil%20paket%20sponsorship%20{{ urlencode($sponsor->name) }}." target="_blank" class="w-full text-center px-4 py-3 text-sm font-bold text-white border rounded-xl hover:bg-white/10 transition-all" style="border-color: rgba(255,255,255,0.2);">
                        Ajukan Sponsor
                    </a>
                </div>
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-10 text-white/40 text-sm">
                    Saat ini belum ada paket sponsor yang tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ── STATS ───────────────────────────────────────── -->
    <section class="py-16 border-y" style="background: #030F2E; border-color: rgba(0,102,255,0.18);">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4">

                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">10K+</div>
                    <div class="text-sm mt-2 font-medium text-white/45">Event Sukses</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">2.5M+</div>
                    <div class="text-sm mt-2 font-medium text-white/45">Tiket Terjual</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">500+</div>
                    <div class="text-sm mt-2 font-medium text-white/45">Brand Partner</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">98%</div>
                    <div class="text-sm mt-2 font-medium text-white/45">Satisfaction Rate</div>
                </div>

            </div>
        </div>
    </section>

    <!-- ── FEATURES ────────────────────────────────────── -->
    <section class="py-28" style="background: #030F2E;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest border mb-6" style="background: #0066FF18; border-color: #0066FF45; color: #00C2FF;">
                    <i data-lucide="globe" class="w-3 h-3"></i> PLATFORM ECOSYSTEM
                </div>
                <h2 class="font-black text-4xl md:text-5xl leading-tight" style="font-family: 'Montserrat', sans-serif;">
                    Semua yang Kamu Butuhkan<br>
                    <span class="text-gradient-blue">Dalam Satu Platform</span>
                </h2>
                <p class="text-lg max-w-xl mx-auto mt-5 leading-relaxed text-white/50">
                    Tidak perlu tools terpisah. ARTIX ID mengintegrasikan seluruh kebutuhan event management dalam satu ekosistem.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                <!-- Feature 1 -->
                <div class="group relative p-6 rounded-2xl border cursor-default transition-all duration-300 hover:-translate-y-1"
                     style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.borderColor='#0066FF55'; this.style.boxShadow='0 8px 40px rgba(0,102,255,0.35)'; this.style.background='#0066FF08';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none'; this.style.background='rgba(255,255,255,0.025';">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-all" style="background: #0066FF1E; color: #0066FF;">
                        <i data-lucide="ticket" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2" style="font-family: 'Montserrat', sans-serif;">Smart Ticketing</h3>
                    <p class="text-sm leading-relaxed text-white/50">Jual tiket dengan sistem manajemen kapasitas, multi-kategori harga, dan payment gateway terintegrasi.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group relative p-6 rounded-2xl border cursor-default transition-all duration-300 hover:-translate-y-1"
                     style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.borderColor='#00C2FF55'; this.style.boxShadow='0 8px 40px rgba(0,194,255,0.35)'; this.style.background='#00C2FF08';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none'; this.style.background='rgba(255,255,255,0.025';">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-all" style="background: #00C2FF1E; color: #00C2FF;">
                        <i data-lucide="radio" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2" style="font-family: 'Montserrat', sans-serif;">Livestream HD</h3>
                    <p class="text-sm leading-relaxed text-white/50">Broadcast ke seluruh Indonesia dengan latensi rendah. Monetisasi lewat tiket virtual dan sponsorship slot.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group relative p-6 rounded-2xl border cursor-default transition-all duration-300 hover:-translate-y-1"
                     style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.borderColor='#A100FF55'; this.style.boxShadow='0 8px 40px rgba(161,0,255,0.35)'; this.style.background='#A100FF08';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none'; this.style.background='rgba(255,255,255,0.025';">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-all" style="background: #A100FF1E; color: #A100FF;">
                        <i data-lucide="handshake" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2" style="font-family: 'Montserrat', sans-serif;">Sponsorship Marketplace</h3>
                    <p class="text-sm leading-relaxed text-white/50">AI-matching antara brand dan event. Proposal, kontrak, dan pembayaran dalam satu platform.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ── HOW IT WORKS ────────────────────────────────── -->
    <section class="py-28 relative overflow-hidden" style="background: linear-gradient(135deg, #041B4A 0%, #060E28 100%);">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full pointer-events-none" style="background: #0066FF; opacity: 0.07; filter: blur(90px);"></div>
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest border mb-6" style="background: #FF7A0018; border-color: #FF7A0045; color: #FF7A00;">
                        HOW IT WORKS
                    </div>
                    <h2 class="font-black text-4xl md:text-5xl leading-tight mb-6" style="font-family: 'Montserrat', sans-serif;">
                        Mulai dalam <span class="text-gradient-orange">3 Langkah</span>
                    </h2>
                    <p class="text-lg leading-relaxed text-white/50">
                        Dari setup hingga go-live, ARTIX ID dirancang untuk kecepatan dan kemudahan bagi penyelenggara di semua skala — dari indie sampai enterprise.
                    </p>
                    <a href="#" class="group inline-flex items-center gap-2 mt-8 font-bold text-sm text-[#0066FF]">
                        Pelajari selengkapnya <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <div class="flex flex-col gap-5">
                    <!-- Step 1 -->
                    <div class="flex gap-5 items-start p-6 rounded-2xl border transition-all duration-300 group cursor-default" style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);" onmouseenter="this.style.borderColor='rgba(0,102,255,0.4)'; this.style.background='rgba(0,102,255,0.06)';" onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='rgba(255,255,255,0.025)';">
                        <div class="font-black text-3xl shrink-0 leading-none text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">01</div>
                        <div>
                            <h3 class="font-bold text-white text-base mb-1" style="font-family: 'Montserrat', sans-serif;">Daftar & Konfigurasi</h3>
                            <p class="text-sm leading-relaxed text-white/50">Buat akun dalam hitungan menit. Atur profil event dan pilih fitur yang kamu butuhkan.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex gap-5 items-start p-6 rounded-2xl border transition-all duration-300 group cursor-default" style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);" onmouseenter="this.style.borderColor='rgba(0,102,255,0.4)'; this.style.background='rgba(0,102,255,0.06)';" onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='rgba(255,255,255,0.025)';">
                        <div class="font-black text-3xl shrink-0 leading-none text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">02</div>
                        <div>
                            <h3 class="font-bold text-white text-base mb-1" style="font-family: 'Montserrat', sans-serif;">Publish & Promote</h3>
                            <p class="text-sm leading-relaxed text-white/50">Go-live dengan ticketing, livestream, atau tournament. Sebarkan ke komunitas kamu.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex gap-5 items-start p-6 rounded-2xl border transition-all duration-300 group cursor-default" style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);" onmouseenter="this.style.borderColor='rgba(0,102,255,0.4)'; this.style.background='rgba(0,102,255,0.06)';" onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='rgba(255,255,255,0.025)';">
                        <div class="font-black text-3xl shrink-0 leading-none text-gradient-blue" style="font-family: 'Montserrat', sans-serif;">03</div>
                        <div>
                            <h3 class="font-bold text-white text-base mb-1" style="font-family: 'Montserrat', sans-serif;">Grow & Monetize</h3>
                            <p class="text-sm leading-relaxed text-white/50">Analisis data real-time, tarik sponsor lewat marketplace, dan kembangkan komunitas event.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── VISUAL SHOWCASE ─────────────────────────────── -->
    <section class="py-28" style="background: #020C1F;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="font-black text-3xl md:text-4xl text-white" style="font-family: 'Montserrat', sans-serif;">Untuk Semua Jenis Event</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Loop Data Kategori dari Database -->
            @foreach(\App\Models\Category::all() as $cat)
            <a href="{{ route('events.byCategory', $cat->id) }}" class="relative rounded-2xl overflow-hidden bg-[#0A1A3A] group cursor-pointer block" style="height: 340px;">
                <!-- Kamu bisa tambahkan logika gambar sendiri di masa depan -->
                <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&h=600&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" style="opacity: 0.55;">
                <div class="absolute inset-0" style="background: linear-gradient(to top, #020C1F 0%, rgba(2,12,31,0.3) 60%, transparent 100%);"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <div class="text-xs font-bold px-3 py-1 rounded-full mb-2.5 inline-block tracking-wider" style="background: #0066FFCC; color: #ffffff; font-family: 'Montserrat', sans-serif;">
                        {{ strtoupper($cat->name) }}
                    </div>
                    <h3 class="font-bold text-white text-xl" style="font-family: 'Montserrat', sans-serif;">Lihat Event {{ $cat->name }}</h3>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</section>

    <!-- ── CTA BANNER ──────────────────────────────────── -->
    <section class="py-28 relative overflow-hidden" style="background: linear-gradient(135deg, #001F6E 0%, #041B4A 50%, #1A0040 100%);">
        <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle at 15% 50%, rgba(0,102,255,0.35) 0%, transparent 50%), radial-gradient(circle at 85% 50%, rgba(161,0,255,0.25) 0%, transparent 50%);"></div>
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: linear-gradient(rgba(0,102,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(0,102,255,0.5) 1px, transparent 1px); background-size: 56px 56px;"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-black leading-tight mb-6" style="font-family: 'Montserrat', sans-serif; font-size: clamp(2.25rem, 6vw, 4rem);">
                <span class="text-gradient-main">Siap Kembangkan<br>Event Kamu?</span>
            </h2>
            <p class="text-lg mb-10 max-w-xl mx-auto leading-relaxed text-white/55">
                Bergabung dengan ribuan event organizer yang sudah menggunakan ARTIX ID. Mulai gratis, upgrade kapan saja.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="group inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-xl transition-all hover:scale-105" style="background: linear-gradient(135deg, #0066FF, #00C2FF); box-shadow: 0 0 50px rgba(0,102,255,0.6); font-family: 'Montserrat', sans-serif;">
                    Daftar Gratis Sekarang <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-2 px-8 py-4 font-semibold text-white rounded-xl border transition-all hover:bg-white/5" style="border-color: rgba(255,255,255,0.2);">
                    Hubungi Sales
                </a>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 mt-10">
                <div class="flex items-center gap-2 text-sm font-medium text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-[#00C2FF]"></i> Setup 5 menit
                </div>
                <div class="flex items-center gap-2 text-sm font-medium text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-[#00C2FF]"></i> Gratis 30 hari
                </div>
                <div class="flex items-center gap-2 text-sm font-medium text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-[#00C2FF]"></i> Tanpa kartu kredit
                </div>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ──────────────────────────────────────── -->
    <footer class="py-16 border-t" style="background: #020C1F; border-color: rgba(0,102,255,0.15);">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-white text-base" style="background: linear-gradient(135deg, #0066FF, #00C2FF); font-family: 'Montserrat', sans-serif;">A</div>
                        <span class="font-black text-lg text-white" style="font-family: 'Montserrat', sans-serif;">
                            ARTIX <span style="color: #0066FF;">ID</span>
                        </span>
                    </div>
                    <p class="text-sm leading-relaxed mb-5 text-white/40">
                        Platform event ecosystem terbesar di Indonesia. Menghubungkan penyelenggara, sponsor, dan peserta.
                    </p>
                    <div class="flex gap-2">
                        <a href="#" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border transition-all hover:border-[#0066FF]/60 hover:text-white" style="border-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.4);">IG</a>
                        <a href="#" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border transition-all hover:border-[#0066FF]/60 hover:text-white" style="border-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.4);">TW</a>
                        <a href="#" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border transition-all hover:border-[#0066FF]/60 hover:text-white" style="border-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.4);">YT</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm mb-4 tracking-wide" style="font-family: 'Montserrat', sans-serif;">Platform</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Ticketing</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Livestream</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Tournament</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm mb-4 tracking-wide" style="font-family: 'Montserrat', sans-serif;">Company</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Tentang Kami</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Karir</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm mb-4 tracking-wide" style="font-family: 'Montserrat', sans-serif;">Support</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Help Center</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Kontak</a></li>
                        <li><a href="#" class="text-sm transition-colors text-white/40 hover:text-white/80">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t gap-3" style="border-color: rgba(255,255,255,0.07);">
                <p class="text-sm text-white/30">© 2026 ARTIX ID. All rights reserved.</p>
                <p class="text-sm text-white/30">hello@artix.id · artix.id</p>
            </div>
        </div>
    </footer>

    <!-- Tambahan Script Sederhana -->
    <script>
        // Mengaktifkan Ikon Lucide
        lucide.createIcons();

        // Logika Navbar Transparan saat di-scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                navbar.style.background = 'rgba(4,27,74,0.96)';
                navbar.style.backdropFilter = 'blur(16px)';
                navbar.style.borderBottom = '1px solid rgba(0,102,255,0.2)';
            } else {
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom = 'none';
            }
        });

        // Logika Tombol Menu Mobile
        const menuBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const menuIcon = document.getElementById('menu-icon');
        let isOpen = false;

        menuBtn.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                drawer.classList.remove('hidden');
                drawer.classList.add('flex');
                menuIcon.setAttribute('data-lucide', 'x');
            } else {
                drawer.classList.add('hidden');
                drawer.classList.remove('flex');
                menuIcon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons(); // Muat ulang ikon agar X / Menu terganti
        });
    </script>
</body>
</html>
