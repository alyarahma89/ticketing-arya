@extends('layouts.main')

@section('title', 'ARTIX ID | Integrated Event Ecosystem')

@section('content')

    <!-- ── HERO ────────────────────────────────────────── -->
    <section class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-[#F8FAFC] dark:bg-transparent transition-colors duration-300">

        <!-- Latar Belakang Gelap (Ditampilkan hanya saat dark mode) -->
        <div class="absolute inset-0 pointer-events-none hidden dark:block" style="background: radial-gradient(ellipse 90% 70% at 50% -10%, #0A2A6E 0%, #041B4A 65%); z-index: -1;"></div>

        <!-- Grid Overlay -->
        <div class="absolute inset-0 pointer-events-none opacity-40 dark:hidden" style="background-image: linear-gradient(#CBD5E1 1px, transparent 1px), linear-gradient(90deg, #CBD5E1 1px, transparent 1px); background-size: 56px 56px;"></div>

        <!-- Orbs Cahaya -->
        <div class="absolute rounded-full pointer-events-none opacity-15 dark:opacity-10" style="width: 520px; height: 520px; top: 5%; left: 5%; background: #0066FF; filter: blur(120px); animation: orb1 8s ease-in-out infinite;"></div>
        <div class="absolute rounded-full pointer-events-none opacity-10 dark:opacity-10" style="width: 400px; height: 400px; bottom: 5%; right: 5%; background: #FF7A00; filter: blur(100px); animation: orb2 10s ease-in-out infinite 2s;"></div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center pt-28 pb-10 flex flex-col items-center">

            <!-- LOGO UTAMA -->
            <div class="relative flex justify-center w-full max-w-3xl mx-auto mb-6">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-white/40 blur-[70px] rounded-full hidden dark:block pointer-events-none z-0"></div>
                <img src="{{ asset('main_logo.png') }}"
                     alt="ARTIX ID Primary Logo"
                     class="relative z-10 h-48 md:h-64 lg:h-80 w-auto object-contain border-none outline-none drop-shadow-2xl hover:scale-105 transition-transform duration-500"
                     style="clip-path: inset(5px);">
            </div>

            <!-- Headline Teks -->
            <h1 class="font-black leading-none tracking-tight mb-7 font-montserrat" style="font-size: clamp(3rem, 9vw, 6.5rem);">
                <span class="text-gradient-dark dark:text-gradient-glow">
                    ONE PLATFORM<br>FOR EVERY<br>
                </span>
                <span class="text-gradient-orange dark:text-gradient-neon">EVENT</span>
            </h1>

            <p class="text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed font-medium text-slate-600 dark:text-white/55 transition-colors">
                Dari ticketing hingga livestream, sponsorship hingga tournament — semua terintegrasi dalam satu ekosistem digital untuk event Indonesia yang lebih besar.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="#event-list" class="group inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-xl font-montserrat" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                    Cari Tiket Event
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#packages" class="group inline-flex items-center justify-center gap-3 px-8 py-4 font-bold rounded-xl border transition-all shadow-sm text-slate-700 bg-white border-slate-200 hover:bg-slate-50 dark:bg-transparent dark:text-white dark:border-white/20 dark:hover:bg-white/5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-orange-100 dark:bg-[#0066FF55]">
                        <i data-lucide="handshake" class="w-4 h-4 text-orange-600 dark:text-white"></i>
                    </div>
                    Sponsorship
                </a>
            </div>

            <form action="{{ url('/') }}" method="GET" class="max-w-3xl mx-auto p-4 rounded-2xl border shadow-xl relative z-20 transition-colors bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 dark:backdrop-blur-md">
                <div class="flex flex-col md:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event atau kategori..." class="flex-1 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 transition-all bg-slate-50 border border-slate-200 text-slate-900 focus:border-[#0066FF] focus:ring-[#0066FF]/20 dark:bg-[#020C1F] dark:border-white/10 dark:text-white dark:focus:border-[#00C2FF]">
                    <select name="location" class="rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 transition-all bg-slate-50 border border-slate-200 text-slate-900 focus:border-[#0066FF] focus:ring-[#0066FF]/20 dark:bg-[#020C1F] dark:border-white/10 dark:text-white dark:focus:border-[#00C2FF]">
                        <option value="">Semua Lokasi</option>
                        <option value="Medan" {{ request('location') == 'Medan' ? 'selected' : '' }}>Medan</option>
                        <option value="Jakarta" {{ request('location') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                    </select>
                    <button type="submit" class="px-8 py-3 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="absolute bottom-0 inset-x-0 h-32 pointer-events-none transition-colors bg-gradient-to-t from-white to-transparent dark:from-[#030F2E] dark:to-transparent"></div>
    </section>

    <!-- ── DAFTAR EVENT DINAMIS ──────────────────────── -->
    <section id="event-list" class="py-20 transition-colors bg-white border-t border-slate-200 dark:bg-[#030F2E] dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12 flex items-center justify-between">
                <h2 class="font-black text-3xl font-montserrat text-slate-900 dark:text-white">⚡ Event Mendatang</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="group relative p-4 rounded-3xl border shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF55] dark:hover:shadow-[0_8px_40px_rgba(0,102,255,0.35)]">

                    <div class="h-44 w-full relative overflow-hidden rounded-2xl mb-5 bg-slate-100 dark:bg-[#0A1A3A]">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 px-3 py-1 text-[10px] font-bold rounded-full tracking-wider shadow-sm text-white font-montserrat" style="background: #0066FF;">
                            {{ strtoupper($event->category->name ?? 'TANPA KATEGORI') }}
                        </div>
                    </div>

                    <h3 class="font-bold text-lg mb-2 font-montserrat text-slate-900 dark:text-white">{{ $event->name }}</h3>
                    <p class="text-sm mb-4 line-clamp-2 font-medium text-slate-500 dark:text-white/50">{{ $event->description }}</p>

                    <div class="flex items-center gap-2 text-xs font-bold mb-2 text-slate-500 dark:text-white/40">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500 dark:text-white/40"></i> {{ $event->location ?? 'Lokasi Belum Ditentukan' }}
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold mb-4 pb-4 border-b text-slate-500 border-slate-100 dark:text-white/40 dark:border-white/10">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-orange-500 dark:text-white/40"></i> {{ date('d M Y', strtotime($event->event_date)) }}
                    </div>

                    <div class="mt-auto flex items-center justify-between">
                        <span class="font-black text-xl font-montserrat text-gradient-blue dark:text-gradient-orange">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ url('/event/' . $event->id) }}" class="px-5 py-2.5 text-xs font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">Beli Tiket</a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 rounded-3xl border border-dashed bg-slate-50 border-slate-300 dark:bg-transparent dark:border-white/20">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto mb-3 text-slate-400 dark:text-white/30"></i>
                    <h3 class="font-bold text-lg text-slate-600 dark:text-white">Tidak ada event ditemukan</h3>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ── KATALOG EVENT UNTUK SPONSORSHIP ────────────────── -->
    <section id="packages" class="py-20 border-t transition-colors bg-slate-50 border-slate-200 dark:bg-[#020C1F] dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest border mb-4 bg-purple-100 border-purple-200 text-purple-700 dark:bg-[#A100FF18] dark:border-[#A100FF45] dark:text-[#A100FF]">
                    SPONSORSHIP MARKETPLACE
                </div>
                <h2 class="font-black text-3xl md:text-4xl font-montserrat text-slate-900 dark:text-white">Dukung Event Terbaik</h2>
                <p class="mt-4 max-w-2xl mx-auto font-medium text-slate-600 dark:text-white/50">Pilih event yang sesuai dengan target audiens brand kamu dan lihat berbagai penawaran paket sponsorship yang tersedia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="group relative p-4 rounded-3xl border shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col bg-white border-slate-200 dark:bg-white/5 dark:border-white/10">
                    <div class="h-44 w-full relative overflow-hidden rounded-2xl mb-5 bg-slate-100 dark:bg-[#0A1A3A]">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <h3 class="font-bold text-lg mb-2 font-montserrat text-slate-900 dark:text-white">{{ $event->name }}</h3>
                    <p class="text-sm mb-4 line-clamp-2 font-medium text-slate-500 dark:text-white/50">{{ $event->description }}</p>

                    <div class="flex items-center gap-2 text-xs font-bold mb-4 text-slate-500 dark:text-white/40">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500 dark:text-white/40"></i> {{ $event->location ?? 'Lokasi Belum Ditentukan' }}
                    </div>

                    <div class="mt-auto pt-4 border-t border-slate-100 dark:border-white/10">
                        <a href="{{ url('/event/' . $event->id . '/sponsorship') }}" class="w-full text-center block px-4 py-3 text-sm font-bold border rounded-xl transition-all shadow-sm text-purple-700 bg-purple-50 border-purple-200 hover:bg-purple-600 hover:text-white dark:bg-transparent dark:text-[#c5a3ff] dark:border-[#A100FF80] dark:hover:bg-white/10">
                            Lihat Paket Sponsor
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-3 text-center py-10 text-sm font-medium text-slate-500 dark:text-white/40">
                    Saat ini belum ada event yang membuka sponsorship.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ── STATS ───────────────────────────────────────── -->
    <section class="py-16 border-y transition-colors bg-white border-slate-200 dark:bg-[#030F2E] dark:border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4">
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue font-montserrat">10K+</div>
                    <div class="text-sm mt-2 font-bold text-slate-500 dark:text-white/45">Event Sukses</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue font-montserrat">2.5M+</div>
                    <div class="text-sm mt-2 font-bold text-slate-500 dark:text-white/45">Tiket Terjual</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue font-montserrat">500+</div>
                    <div class="text-sm mt-2 font-bold text-slate-500 dark:text-white/45">Brand Partner</div>
                </div>
                <div class="text-center">
                    <div class="font-black text-4xl md:text-5xl text-gradient-blue font-montserrat">98%</div>
                    <div class="text-sm mt-2 font-bold text-slate-500 dark:text-white/45">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── INFOGRAFIS FITUR ────────────────────────────────── -->
    <section class="py-28 transition-colors bg-[#F8FAFC] dark:bg-[#030F2E]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest border mb-6 bg-blue-50 border-blue-200 text-blue-600 dark:bg-[#0066FF18] dark:border-[#0066FF45] dark:text-[#00C2FF]">
                    <i data-lucide="globe" class="w-3 h-3"></i> PLATFORM ECOSYSTEM
                </div>
                <h2 class="font-black text-4xl md:text-5xl leading-tight font-montserrat text-slate-900 dark:text-white">
                    Semua yang Kamu Butuhkan<br>
                    <span class="text-gradient-blue">Dalam Satu Platform</span>
                </h2>
                <p class="text-lg max-w-xl mx-auto mt-5 leading-relaxed font-medium text-slate-600 dark:text-white/50">
                    Tidak perlu tools terpisah. ARTIX ID mengintegrasikan seluruh kebutuhan event management dalam satu ekosistem.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- 1. Ticketing -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF55] dark:hover:shadow-[0_8px_40px_rgba(0,102,255,0.35)] dark:hover:bg-[#0066FF08]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-50 dark:bg-[#0066FF1E]">
                        <img src="{{ asset('images/ticketing.svg') }}"
                             alt="Smart Ticketing"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Smart Ticketing</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Jual tiket dengan sistem manajemen kapasitas, multi-kategori harga, dan payment gateway terintegrasi.</p>
                </div>

                <!-- 2. Livestream -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#FF3B3055] dark:hover:shadow-[0_8px_40px_rgba(255,59,48,0.35)] dark:hover:bg-[#FF3B3008]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-50 dark:bg-[#0066FF1E]">
                        <img src="{{ asset('images/livestream.svg') }}"
                             alt="Livestream HD"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Livestream HD</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Broadcast ke seluruh Indonesia dengan latensi rendah. Monetisasi lewat tiket virtual dan sponsorship slot.</p>
                </div>

                <!-- 3. Sponsorship -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#A100FF55] dark:hover:shadow-[0_8px_40px_rgba(161,0,255,0.35)] dark:hover:bg-[#A100FF08]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-50 dark:bg-[#0066FF1E]">
                        <img src="{{ asset('images/sponsorship.svg') }}"
                             alt="Sponsorship Marketplace"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Sponsorship Marketplace</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">AI-matching antara brand dan event. Proposal, kontrak, dan pembayaran dalam satu platform.</p>
                </div>

                <!-- 4. Tournament -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF55] dark:hover:shadow-[0_8px_40px_rgba(0,102,255,0.35)] dark:hover:bg-[#0066FF08]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-50 dark:bg-[#0066FF1E]">
                        <img src="{{ asset('images/tournament.svg') }}"
                             alt="Tournament System"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Tournament System</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Kelola bracket kompetisi secara real-time untuk event E-Sports, olahraga, maupun kompetisi akademik.</p>
                </div>

                <!-- 5. Community -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#FF3B3055] dark:hover:shadow-[0_8px_40px_rgba(255,59,48,0.35)] dark:hover:bg-[#FF3B3008]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-orange-50 dark:bg-[#FF3B301E]">
                        <img src="{{ asset('images/community.svg') }}"
                             alt="Community Engagement"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Community Engagement</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Bangun koneksi peserta sebelum, selama, dan setelah event untuk loyalitas komunitas jangka panjang.</p>
                </div>

                <!-- 6. Analytics -->
                <div class="p-8 rounded-3xl border shadow-sm transition-all hover:-translate-y-1 bg-white border-slate-200 hover:shadow-xl dark:bg-white/5 dark:border-white/10 dark:hover:border-[#A100FF55] dark:hover:shadow-[0_8px_40px_rgba(161,0,255,0.35)] dark:hover:bg-[#A100FF08]">
                    <div class="mb-6 w-14 h-14 flex items-center justify-center rounded-2xl bg-purple-50 dark:bg-[#A100FF1E]">
                        <img src="{{ asset('images/analytics.svg') }}"
                             alt="Analytics & Report"
                             class="w-8 h-8">
                    </div>
                    <h3 class="font-bold text-xl mb-3 font-montserrat text-slate-900 dark:text-white">Analytics & Report</h3>
                    <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Data demografi, laporan penjualan tiket, hingga engagement secara live untuk optimasi event berikutnya.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ── HOW IT WORKS ────────────────────────────────── -->
    <section class="py-28 transition-colors border-t bg-white border-slate-200 dark:bg-gradient-to-br dark:from-[#041B4A] dark:to-[#060E28] dark:border-transparent relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full pointer-events-none hidden dark:block" style="background: #0066FF; opacity: 0.07; filter: blur(90px);"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest border mb-6 bg-orange-50 border-orange-200 text-orange-600 dark:bg-[#FF7A0018] dark:border-[#FF7A0045] dark:text-[#FF7A00]">
                        HOW IT WORKS
                    </div>
                    <h2 class="font-black text-4xl md:text-5xl leading-tight mb-6 font-montserrat text-slate-900 dark:text-white">
                        Mulai dalam <span class="text-gradient-orange">3 Langkah</span>
                    </h2>
                    <p class="text-lg leading-relaxed font-medium text-slate-600 dark:text-white/50">
                        Dari setup hingga go-live, ARTIX ID dirancang untuk kecepatan dan kemudahan bagi penyelenggara di semua skala — dari indie sampai enterprise.
                    </p>
                    <a href="{{ route('register') }}" class="group inline-flex items-center gap-2 mt-8 font-bold text-sm text-[#0066FF] hover:text-blue-700 dark:hover:text-blue-400">
                        Pelajari selengkapnya <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <div class="flex flex-col gap-5">
                    <!-- Step 1 -->
                    <div class="flex gap-5 items-start p-6 rounded-3xl border transition-all duration-300 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF66] dark:hover:bg-[#0066FF10]">
                        <div class="font-black text-4xl md:text-3xl shrink-0 leading-none text-gradient-blue font-montserrat">01</div>
                        <div>
                            <h3 class="font-bold text-lg mb-1 font-montserrat text-slate-900 dark:text-white">Daftar & Konfigurasi</h3>
                            <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Buat akun dalam hitungan menit. Atur profil event dan pilih fitur yang kamu butuhkan.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex gap-5 items-start p-6 rounded-3xl border transition-all duration-300 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF66] dark:hover:bg-[#0066FF10]">
                        <div class="font-black text-4xl md:text-3xl shrink-0 leading-none text-gradient-blue font-montserrat">02</div>
                        <div>
                            <h3 class="font-bold text-lg mb-1 font-montserrat text-slate-900 dark:text-white">Publish & Promote</h3>
                            <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Go-live dengan ticketing, livestream, atau tournament. Sebarkan ke komunitas kamu.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex gap-5 items-start p-6 rounded-3xl border transition-all duration-300 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF66] dark:hover:bg-[#0066FF10]">
                        <div class="font-black text-4xl md:text-3xl shrink-0 leading-none text-gradient-blue font-montserrat">03</div>
                        <div>
                            <h3 class="font-bold text-lg mb-1 font-montserrat text-slate-900 dark:text-white">Grow & Monetize</h3>
                            <p class="text-sm leading-relaxed font-medium text-slate-600 dark:text-white/50">Analisis data real-time, tarik sponsor lewat marketplace, dan kembangkan komunitas event.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── VISUAL SHOWCASE ─────────────────────────────── -->
    <section class="py-28 transition-colors bg-[#F8FAFC] border-t border-slate-200 dark:bg-[#020C1F] dark:border-transparent">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-black text-3xl md:text-4xl font-montserrat text-slate-900 dark:text-white">Untuk Semua Jenis Event</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">

                @foreach(\App\Models\Category::all() as $cat)
                <a href="{{ route('events.byCategory', $cat->id) }}" class="relative rounded-3xl overflow-hidden group cursor-pointer block shadow-md bg-slate-800 dark:bg-[#0A1A3A]" style="height: 340px;">

                    <!-- ── LOGIKA LINK GAMBAR DINAMIS (DIPERBAIKI) ── -->
                    <!-- Menggunakan ?: (Elvis Operator) agar teks kosong ("") tetap memunculkan gambar default -->
                    <img src="{{ $cat->image ?: 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&h=600&fit=crop' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" style="opacity: 0.6;">

                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-[#0F172A]/30 to-transparent dark:from-[#020C1F] dark:via-[#020C1F]/30"></div>
                    <div class="absolute bottom-8 left-8 right-8">
                        <div class="text-xs font-bold px-4 py-1.5 rounded-full mb-3 inline-block tracking-wider font-montserrat bg-white text-slate-900 shadow-sm dark:bg-[#0066FFCC] dark:text-white dark:shadow-none">
                            {{ strtoupper($cat->name) }}
                        </div>
                        <h3 class="font-bold text-white text-2xl font-montserrat">Lihat Event {{ $cat->name }}</h3>
                    </div>
                </a>
                @endforeach

            </div>
        </div>
    </section>

    <!-- ── CTA BANNER ──────────────────────────────────── -->
    <section class="py-28 relative overflow-hidden transition-colors border-t bg-white border-slate-200 dark:bg-gradient-to-br dark:from-[#001F6E] dark:via-[#041B4A] dark:to-[#1A0040] dark:border-transparent">
        <!-- Overlay Terang -->
        <div class="absolute inset-0 pointer-events-none opacity-40 dark:hidden" style="background-image: linear-gradient(#E2E8F0 1px, transparent 1px), linear-gradient(90deg, #E2E8F0 1px, transparent 1px); background-size: 56px 56px;"></div>
        <div class="absolute inset-0 pointer-events-none dark:hidden" style="background-image: radial-gradient(circle at 15% 50%, rgba(0,102,255,0.08) 0%, transparent 50%), radial-gradient(circle at 85% 50%, rgba(255,122,0,0.05) 0%, transparent 50%);"></div>

        <!-- Overlay Gelap -->
        <div class="absolute inset-0 pointer-events-none hidden dark:block" style="background-image: radial-gradient(circle at 15% 50%, rgba(0,102,255,0.35) 0%, transparent 50%), radial-gradient(circle at 85% 50%, rgba(161,0,255,0.25) 0%, transparent 50%);"></div>
        <div class="absolute inset-0 opacity-5 pointer-events-none hidden dark:block" style="background-image: linear-gradient(rgba(0,102,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(0,102,255,0.5) 1px, transparent 1px); background-size: 56px 56px;"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-black leading-tight mb-6 font-montserrat text-slate-900 dark:text-white" style="font-size: clamp(2.25rem, 6vw, 4rem);">
                <span class="dark:text-gradient-main">Siap Kembangkan<br></span>
                <span class="text-gradient-blue dark:hidden">Event Kamu?</span>
                <span class="hidden dark:inline">Event Kamu?</span>
            </h2>
            <p class="text-lg mb-10 max-w-xl mx-auto leading-relaxed font-medium text-slate-600 dark:text-white/55">
                Bergabung dengan ribuan event organizer yang sudah menggunakan ARTIX ID. Mulai gratis, upgrade kapan saja.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="group inline-flex items-center justify-center gap-2 px-8 py-4 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-xl hover:shadow-2xl font-montserrat dark:shadow-[0_0_50px_rgba(0,102,255,0.6)]" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                    Daftar Gratis Sekarang <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-2 px-8 py-4 font-bold rounded-xl border transition-all text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:shadow-md dark:bg-transparent dark:text-white dark:border-white/20 dark:hover:bg-white/5 dark:shadow-none">
                    Hubungi Sales
                </a>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 mt-10">
                <div class="flex items-center gap-2 text-sm font-bold text-slate-500 dark:font-medium dark:text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-blue-500 dark:text-[#00C2FF]"></i> Setup 5 menit
                </div>
                <div class="flex items-center gap-2 text-sm font-bold text-slate-500 dark:font-medium dark:text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-blue-500 dark:text-[#00C2FF]"></i> Gratis 30 hari
                </div>
                <div class="flex items-center gap-2 text-sm font-bold text-slate-500 dark:font-medium dark:text-white/50">
                    <i data-lucide="check-circle" class="w-4 h-4 text-blue-500 dark:text-[#00C2FF]"></i> Tanpa kartu kredit
                </div>
            </div>
        </div>
    </section>

@endsection
