<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $event->name }} | ARTIX ID</title>
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

        /* Gradasi Teks Sesuai Panduan */
        .text-gradient-main {
            background: linear-gradient(135deg, #0066FF 0%, #00C2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-ticket {
            background: linear-gradient(135deg, #FF3B30 0%, #FFB000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== KUSTOMISASI KARTU TIKET (LIGHT & DARK) ===== */
        .ticket-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Light Mode Styles */
        html.light .ticket-card {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
        }
        html.light .ticket-card:hover {
            border-color: #93C5FD;
            background: #EFF6FF;
            transform: translateY(-2px);
        }
        html.light .ticket-card:has(input:checked) {
            border-color: #0066FF;
            background: #DBEAFE;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.15);
        }
        html.light .custom-radio { border-color: #CBD5E1; }
        html.light .ticket-card:has(input:checked) .custom-radio { border-color: #0066FF; }

        /* Dark Mode Styles (Sesuai UI/UX Guideline) */
        html.dark .ticket-card {
            background: #0F1730;
            border: 1px solid #1E2A4D;
        }
        html.dark .ticket-card:hover {
            border-color: #0066FF;
            background: rgba(0, 102, 255, 0.1);
            transform: translateY(-2px);
        }
        html.dark .ticket-card:has(input:checked) {
            border-color: #00C2FF;
            background: rgba(0, 102, 255, 0.2);
            box-shadow: 0 8px 30px rgba(0, 194, 255, 0.25);
        }
        html.dark .custom-radio { border-color: rgba(255,255,255,0.3); }
        html.dark .ticket-card:has(input:checked) .custom-radio { border-color: #00C2FF; }

        .ticket-card:has(input:checked) .radio-dot { opacity: 1; transform: scale(1); }
        .radio-dot { opacity: 0; transform: scale(0.5); transition: all 0.2s ease; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen relative">

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
                <a href="{{ url('/#event-list') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Event</a>
                <a href="{{ url('/#packages') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Sponsorship</a>
            </div>

            <!-- Desktop CTA & Theme Toggle -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold transition-colors text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white">
                        Halo, {{ explode(' ', Auth::user()->name)[0] }}
                    </a>

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

                <!-- Tombol Toggle Mode -->
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
            <a href="{{ url('/#event-list') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Event</a>
            <a href="{{ url('/#packages') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Sponsorship</a>
            @auth
                <a href="{{ route('profile.edit') }}" class="text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white py-1 text-sm font-bold transition-colors">Profil Saya</a>
                <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-500 hover:text-red-600 dark:text-red-400 py-1 text-sm font-bold transition-colors">
                        Logout
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

    <!-- Orbs Latar Belakang -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute rounded-full pointer-events-none opacity-15 dark:opacity-10" style="width: 400px; height: 400px; top: 10%; left: -10%; background: #0066FF; filter: blur(100px); animation: orb1 8s ease-in-out infinite;"></div>
        <div class="absolute rounded-full pointer-events-none opacity-10 dark:opacity-10" style="width: 300px; height: 300px; bottom: 10%; right: -5%; background: #A100FF; filter: blur(90px); animation: orb2 10s ease-in-out infinite 2s;"></div>
    </div>

    <!-- ── KONTEN UTAMA DETAIL EVENT ───────────────────── -->
    <main class="flex-grow pt-32 pb-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6">

            <!-- BAGIAN PESAN ERROR / SUKSES -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl text-sm font-medium border flex items-center gap-3 bg-emerald-50 border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400 transition-colors">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl text-sm font-medium border flex items-center gap-3 bg-red-50 border-red-200 text-red-600 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400 transition-colors">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl text-sm font-medium border flex items-start gap-3 bg-red-50 border-red-200 text-red-600 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400 transition-colors">
                    <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                    <ul class="mb-0 ps-3 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold border transition-all shadow-sm bg-white border-slate-200 text-slate-600 hover:bg-slate-50 dark:bg-transparent dark:border-white/15 dark:text-white/70 dark:hover:text-white dark:hover:bg-white/5">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Kolom Kiri: Poster, Judul, Info, & S&K -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <!-- Poster Event -->
                    <div class="relative w-full h-[400px] rounded-3xl overflow-hidden border shadow-lg group bg-slate-100 border-slate-200 dark:bg-[#0A1A3A] dark:border-white/10 transition-colors">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent dark:from-[#041B4A]/90 transition-colors"></div>
                    </div>

                    <!-- Informasi Utama Event -->
                    <div class="p-8 rounded-3xl border relative overflow-hidden bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 transition-colors shadow-sm">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-[#0066FF] rounded-full blur-[100px] opacity-5 dark:opacity-10 pointer-events-none"></div>

                        <div class="inline-block px-4 py-1.5 text-xs font-bold rounded-full tracking-wider mb-5 bg-blue-50 border-blue-200 text-blue-600 dark:bg-[#0066FF18] dark:border-[#0066FF45] dark:text-[#00C2FF] font-montserrat transition-colors">
                            {{ strtoupper($event->category->name ?? $event->category ?? 'UMUM') }}
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black mb-8 leading-tight font-montserrat text-slate-900 dark:text-white">{{ $event->name }}</h1>

                        <!-- Detail Waktu & Lokasi -->
                        <div class="grid sm:grid-cols-2 gap-4 p-5 rounded-2xl mb-8 border bg-slate-50 border-slate-200 dark:bg-[#020C1F]/50 dark:border-white/5 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-orange-50 text-orange-500 dark:bg-[#0066FF22] dark:text-[#00C2FF]">
                                    <i data-lucide="calendar-days" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] block mb-1 uppercase tracking-wider font-bold text-slate-400 dark:text-white/40">Tanggal & Waktu</span>
                                    <span class="font-bold text-sm text-slate-700 dark:text-white">{{ date('d M Y - H:i', strtotime($event->event_date)) }} WIB</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-blue-50 text-blue-500 dark:bg-[#0066FF22] dark:text-[#00C2FF]">
                                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] block mb-1 uppercase tracking-wider font-bold text-slate-400 dark:text-white/40">Lokasi Acara</span>
                                    <span class="font-bold text-sm text-slate-700 dark:text-white">{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="font-bold text-xl mb-4 font-montserrat text-slate-900 dark:text-white">Deskripsi Event</h3>
                        <div class="text-base leading-relaxed whitespace-pre-line mb-0 font-medium text-slate-600 dark:text-white/60">
                            {{ $event->description }}
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div class="p-8 rounded-3xl border bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 transition-colors shadow-sm">
                        <h3 class="font-bold text-lg mb-5 flex items-center gap-2 font-montserrat text-slate-900 dark:text-white">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-red-500 dark:text-[#00C2FF]"></i> Syarat & Ketentuan
                        </h3>
                        <ul class="text-sm flex flex-col gap-3 ps-5 list-disc m-0 leading-relaxed font-medium text-slate-600 dark:text-white/60">
                            <li>Tiket yang sudah dibeli bersifat <strong class="text-slate-900 dark:text-white">Non-Refundable</strong> (tidak dapat diuangkan kembali).</li>
                            <li>Pengunjung <em class="text-slate-900 dark:text-white">offline</em> wajib menunjukkan e-tiket (QR Code) resmi dari ARTIX ID saat registrasi di lokasi.</li>
                            <li>Pembeli tiket <em class="text-slate-900 dark:text-white">online (livestream)</em> dilarang menyebarkan ulang link siaran ke pihak lain.</li>
                            <li>Satu tiket hanya berlaku untuk satu orang / satu akun.</li>
                        </ul>
                    </div>

                </div>

                <!-- Kolom Kanan: Panel Pembelian Diperbarui -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="rounded-3xl border overflow-hidden shadow-xl relative transition-colors bg-white border-slate-200 dark:bg-[#041B4A] dark:border-[#1E2A4D] dark:backdrop-blur-md">

                            <!-- Header Panel -->
                            <div class="p-6 text-center border-b relative z-10 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/5 transition-colors">
                                <h2 class="font-black text-lg tracking-widest uppercase font-montserrat">
                                    <span class="text-gradient-main">Pesan Tiketmu</span>
                                </h2>
                            </div>

                            <div class="p-6 relative z-10">
                                <form action="/checkout/{{ $event->id }}" method="POST">
                                    @csrf

                                    <!-- KUSTOMISASI KARTU PILIHAN TIKET -->
                                    <div class="mb-6">
                                        <label class="block text-[11px] font-bold uppercase tracking-widest mb-3 text-slate-400 dark:text-white/50">Pilih Kategori Akses</label>
                                        <div class="flex flex-col gap-4">

                                            <!-- Pilihan Offline -->
                                            <label class="ticket-card relative p-5 rounded-2xl cursor-pointer flex flex-col xl:flex-row xl:items-center justify-between gap-4 overflow-hidden">
                                                <div class="flex items-center gap-4 relative z-10">
                                                    <!-- Custom Radio Circle -->
                                                    <div class="w-5 h-5 rounded-full border-2 custom-radio flex items-center justify-center shrink-0 transition-colors">
                                                        <div class="w-2.5 h-2.5 rounded-full bg-[#0066FF] dark:bg-[#00C2FF] radio-dot"></div>
                                                    </div>
                                                    <input type="radio" name="ticket_type" value="offline" class="hidden" checked onchange="updateTotal()">
                                                    <div>
                                                        <span class="font-bold text-base block font-['Montserrat'] mb-0.5 text-slate-800 dark:text-white">🎫 Tiket Offline</span>
                                                        <span class="text-[11px] font-bold text-slate-500 dark:text-white/50 dark:font-medium">Akses langsung di Venue</span>
                                                    </div>
                                                </div>
                                                <span class="font-black text-xl text-gradient-ticket relative z-10 xl:text-right" data-price="{{ $event->price }}">
                                                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                                </span>
                                            </label>

                                            <!-- Pilihan Online (Jika Tersedia) -->
                                            @if($event->online_price > 0 && !empty($event->youtube_link))
                                            <label class="ticket-card relative p-5 rounded-2xl cursor-pointer flex flex-col xl:flex-row xl:items-center justify-between gap-4 overflow-hidden">
                                                <div class="flex items-center gap-4 relative z-10">
                                                    <!-- Custom Radio Circle -->
                                                    <div class="w-5 h-5 rounded-full border-2 custom-radio flex items-center justify-center shrink-0 transition-colors">
                                                        <div class="w-2.5 h-2.5 rounded-full bg-[#0066FF] dark:bg-[#00C2FF] radio-dot"></div>
                                                    </div>
                                                    <input type="radio" name="ticket_type" value="online" class="hidden" onchange="updateTotal()">
                                                    <div>
                                                        <span class="font-bold text-base block font-['Montserrat'] mb-0.5 text-slate-800 dark:text-white">🌐 Tiket Livestream</span>
                                                        <span class="text-[11px] font-bold text-slate-500 dark:text-white/50 dark:font-medium">Akses siaran (Virtual)</span>
                                                    </div>
                                                </div>
                                                <span class="font-black text-xl text-gradient-ticket relative z-10 xl:text-right" data-price="{{ $event->online_price }}">
                                                    {{ $event->online_price == 0 ? 'Gratis' : 'Rp ' . number_format($event->online_price, 0, ',', '.') }}
                                                </span>
                                            </label>
                                            @endif

                                        </div>
                                    </div>

                                    <!-- Sisa Kuota -->
                                    <div class="mb-6 p-4 rounded-xl border flex items-center justify-between transition-colors bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/5">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-white/50">Ketersediaan</span>
                                        <span class="px-3 py-1 rounded-lg text-xs font-bold text-white transition-colors bg-blue-500 border-blue-600 dark:bg-[#0066FF]/40 dark:border-[#0066FF] border">
                                            {{ $event->quota }} Tiket
                                        </span>
                                    </div>

                                    <!-- Jumlah Pesanan (Sesuai Gaya Input Field Guideline) -->
                                    <div class="mb-6">
                                        <label class="block text-[11px] font-bold uppercase tracking-widest mb-3 text-slate-400 dark:text-white/50">Jumlah Pesanan</label>
                                        <div class="relative">
                                            <select class="w-full border rounded-[12px] px-5 py-4 text-base font-bold focus:outline-none transition-colors cursor-pointer appearance-none text-center bg-slate-50 border-slate-300 text-slate-900 focus:border-[#0066FF] dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF]" name="quantity" id="ticketQuantity" onchange="updateTotal()">
                                                <option value="1">1 Tiket</option>
                                                <option value="2">2 Tiket</option>
                                                <option value="3">3 Tiket</option>
                                                <option value="4">4 Tiket</option>
                                                <option value="5">5 Tiket (Maks)</option>
                                            </select>
                                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-white/50">
                                                <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Garis Pembatas -->
                                    <hr class="border-slate-200 dark:border-white/10 mb-6 transition-colors">

                                    <!-- Total Bayar -->
                                    <div class="flex items-center justify-between mb-8">
                                        <span class="text-sm font-bold text-slate-600 dark:text-white/70">Total Pembayaran</span>
                                        <span class="font-black text-2xl text-gradient-ticket font-montserrat" id="totalPriceDisplay"></span>
                                    </div>

                                    <!-- Tombol Submit (Sesuai Gaya Button Primary Guideline) -->
                                    @if($event->quota > 0)
                                        <button type="submit" class="w-full py-4 font-bold text-[#FFFFFF] rounded-[12px] transition-all hover:-translate-y-1 flex items-center justify-center gap-2 font-montserrat bg-[#0066FF] hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30">
                                            Proses Pembayaran <i data-lucide="credit-card" class="w-5 h-5"></i>
                                        </button>
                                        <div class="flex items-center justify-center gap-2 text-[11px] mt-4 font-bold text-slate-400 dark:font-medium dark:text-white/30">
                                            <i data-lucide="lock" class="w-3 h-3"></i> Transaksi terenkripsi & aman
                                        </div>
                                    @else
                                        <button type="button" class="w-full py-4 font-bold rounded-[12px] cursor-not-allowed border flex items-center justify-center gap-2 bg-slate-100 border-slate-200 text-slate-400 dark:bg-white/5 dark:border-white/10 dark:text-white/40 transition-colors" disabled>
                                            <i data-lucide="x-circle" class="w-5 h-5"></i> Maaf, Tiket Habis
                                        </button>
                                    @endif

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

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

    <script>
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

        // ── LOGIKA KALKULASI HARGA ──
        function updateTotal() {
            const qtySelect = document.getElementById('ticketQuantity');
            if (!qtySelect) return;
            const qty = parseInt(qtySelect.value);

            const selectedRadio = document.querySelector('input[name="ticket_type"]:checked');
            if (!selectedRadio) return;

            const priceSpan = selectedRadio.closest('label').querySelector('[data-price]');
            const price = parseInt(priceSpan.getAttribute('data-price'));

            const displayEl = document.getElementById('totalPriceDisplay');
            if (price === 0) {
                displayEl.innerText = 'Gratis';
            } else {
                const total = qty * price;
                const formatted = 'Rp ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                displayEl.innerText = formatted;
            }
        }

        document.addEventListener('DOMContentLoaded', updateTotal);
    </script>
</body>
</html>
