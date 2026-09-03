@extends('layouts.main')

@section('title', $event->name . ' | Ticks ID')

<!-- ── MENYUNTIKKAN CSS KHUSUS HALAMAN DETAIL ── -->
@push('styles')
    <!-- Library Swiper CSS untuk Galeri Foto -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        /* Gradasi Teks Khusus */
        .text-gradient-primary {
            background: linear-gradient(135deg, #0066FF 0%, #00C2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== KUSTOMISASI KARTU TIKET MODERN ===== */
        .ticket-label {
            transition: all 0.3s ease;
        }

        /* Mode Terang (Light) */
        html.light .ticket-label { background: #FFFFFF; border: 1.5px solid #E2E8F0; }
        html.light .ticket-label:hover { border-color: #93C5FD; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        html.light .ticket-label:has(input:checked) { border-color: #0066FF; background: #F4F9FF; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15); }
        html.light .radio-ring { border-color: #CBD5E1; transition: all 0.2s ease; }
        html.light .ticket-label:has(input:checked) .radio-ring { border-color: #0066FF; border-width: 6px; }

        /* Mode Gelap (Dark) */
        html.dark .ticket-label { background: rgba(255,255,255,0.03); border: 1.5px solid rgba(255,255,255,0.1); }
        html.dark .ticket-label:hover { border-color: rgba(0, 102, 255, 0.4); transform: translateY(-2px); }
        html.dark .ticket-label:has(input:checked) { border-color: #00C2FF; background: rgba(0, 194, 255, 0.08); box-shadow: 0 8px 30px rgba(0, 194, 255, 0.2); }
        html.dark .radio-ring { border-color: rgba(255,255,255,0.3); transition: all 0.2s ease; }
        html.dark .ticket-label:has(input:checked) .radio-ring { border-color: #00C2FF; border-width: 6px; }

        /* ===== CSS KHUSUS THUMBNAIL GAYA SHOPEE ===== */
        .thumbGallerySwiper .swiper-slide { opacity: 0.4; border: 2px solid transparent; transition: all 0.3s ease; }
        .thumbGallerySwiper .swiper-slide-thumb-active { opacity: 1; border-color: #0066FF; }
    </style>
@endpush

@section('content')

    <!-- Orbs Latar Belakang -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute rounded-full pointer-events-none opacity-15 dark:opacity-10" style="width: 400px; height: 400px; top: 10%; left: -10%; background: #0066FF; filter: blur(100px); animation: orb1 8s ease-in-out infinite;"></div>
        <div class="absolute rounded-full pointer-events-none opacity-10 dark:opacity-10" style="width: 300px; height: 300px; bottom: 10%; right: -5%; background: #A100FF; filter: blur(90px); animation: orb2 10s ease-in-out infinite 2s;"></div>
    </div>

    <!-- ── KONTEN UTAMA DETAIL EVENT ───────────────────── -->
    <div class="pt-32 pb-20 relative z-10">
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

                    <!-- ── GALERI EVENT (STYLE SHOPEE) ── -->
                    <div class="flex flex-col gap-3">
                        <!-- GAMBAR UTAMA BESAR -->
                        <div class="relative w-full h-[400px] rounded-3xl overflow-hidden border shadow-sm group bg-slate-100 border-slate-200 dark:bg-[#0A1A3A] dark:border-white/10 transition-colors">
                            <div class="swiper mainGallerySwiper w-full h-full">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide relative cursor-grab">
                                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent pointer-events-none"></div>
                                    </div>

                                    @if($event->galleries && $event->galleries->count() > 0)
                                        @foreach($event->galleries as $gallery)
                                            <div class="swiper-slide relative cursor-grab">
                                                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent pointer-events-none"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="swiper-button-next z-20 cursor-pointer !text-white after:!text-xl !w-10 !h-10 bg-black/30 hover:bg-black/60 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100"></div>
                                <div class="swiper-button-prev z-20 cursor-pointer !text-white after:!text-xl !w-10 !h-10 bg-black/30 hover:bg-black/60 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100"></div>
                            </div>
                        </div>

                        <!-- THUMBNAILS (KOTAK KECIL DI BAWAH) -->
                        @if($event->galleries && $event->galleries->count() > 0)
                        <div class="swiper thumbGallerySwiper w-full h-20 md:h-24 px-1 py-1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden shadow-sm">
                                    <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" class="w-full h-full object-cover">
                                </div>
                                @foreach($event->galleries as $gallery)
                                    <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden shadow-sm">
                                        <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Informasi Utama Event -->
                    <div class="p-8 rounded-3xl border relative overflow-hidden bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 transition-colors shadow-sm">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-[#0066FF] rounded-full blur-[100px] opacity-5 dark:opacity-10 pointer-events-none"></div>

                        @php
                            $hasOffline = ($event->location || $event->price > 0 || ($event->ticketPackages && $event->ticketPackages->count() > 0));
                            $hasOnline = ($event->youtube_link || ($event->online_price !== null && $event->online_price > 0));
                        @endphp

                        <div class="flex items-center flex-wrap gap-2 mb-5">
                            <div class="inline-block px-4 py-1.5 text-xs font-bold rounded-full tracking-wider bg-blue-50 border-blue-200 text-blue-600 dark:bg-[#0066FF18] dark:border-[#0066FF45] dark:text-[#00C2FF] font-montserrat transition-colors">
                                {{ strtoupper($event->category->name ?? $event->category ?? 'UMUM') }}
                            </div>

                            @if($hasOffline && $hasOnline)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-purple-50 border border-purple-200 text-purple-600 dark:bg-purple-500/10 dark:border-purple-500/30 dark:text-purple-400 font-montserrat">
                                    <i data-lucide="layers" class="w-3.5 h-3.5"></i> HYBRID (VENUE & ONLINE)
                                </div>
                            @elseif($hasOnline)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-red-50 border border-red-200 text-red-600 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400 font-montserrat">
                                    <i data-lucide="video" class="w-3.5 h-3.5"></i> ONLINE LIVESTREAM
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400 font-montserrat">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> OFFLINE VENUE
                                </div>
                            @endif
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black mb-8 leading-tight font-montserrat text-slate-900 dark:text-white">{{ $event->name }}</h1>

                        <!-- Detail Waktu & Lokasi -->
                        <div class="grid sm:grid-cols-2 gap-4 p-5 rounded-2xl mb-8 border bg-slate-50 border-slate-200 dark:bg-[#020C1F]/50 dark:border-white/5 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-gradient-to-br from-[#FF7A00] to-[#FF3B30] text-white shadow-md">
                                    <i data-lucide="calendar-days" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] block mb-1 uppercase tracking-wider font-bold text-slate-400 dark:text-white/40">Jadwal Acara</span>
                                    <span class="font-bold text-sm text-slate-700 dark:text-white">{{ date('d M Y - H:i', strtotime($event->event_date)) }} WIB</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-gradient-to-br from-[#0066FF] to-[#00C2FF] text-white shadow-md">
                                    <i data-lucide="{{ $event->location ? 'map-pin' : 'video' }}" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] block mb-1 uppercase tracking-wider font-bold text-slate-400 dark:text-white/40">Titik Kumpul / Format</span>
                                    <span class="font-bold text-sm text-slate-700 dark:text-white">{{ $event->location ?? 'Online / Livestream via YouTube' }}</span>
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
                            <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 dark:bg-red-500/20 dark:text-red-400 flex items-center justify-center">
                                <i data-lucide="shield-alert" class="w-4 h-4"></i>
                            </div>
                            Syarat & Ketentuan
                        </h3>
                        <ul class="text-sm flex flex-col gap-3 ps-5 list-disc m-0 leading-relaxed font-medium text-slate-600 dark:text-white/60">
                            <li>Tiket yang sudah dibeli bersifat <strong class="text-slate-900 dark:text-white">Non-Refundable</strong> (tidak dapat diuangkan kembali).</li>
                            <li>Pengunjung wajib menunjukkan e-tiket (QR Code) resmi dari Ticks ID saat registrasi di lokasi.</li>
                            <li>Pembeli tiket livestream dilarang menyebarkan ulang link siaran ke pihak lain.</li>
                            <li>Satu tiket hanya berlaku untuk satu orang pengunjung.</li>
                        </ul>
                    </div>

                </div>

                <!-- Kolom Kanan: Panel Pembelian -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="rounded-3xl border shadow-xl relative transition-colors bg-white border-slate-200 dark:bg-[#041B4A] dark:border-[#1E2A4D] overflow-hidden">

                            <!-- Header Panel -->
                            <div class="p-6 text-center border-b relative z-10 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/5 transition-colors">
                                <h2 class="font-black text-lg tracking-widest uppercase font-montserrat text-slate-800 dark:text-white">
                                    Detail Pemesanan
                                </h2>
                            </div>

                            <div class="p-6 relative z-10">
                                <form action="/checkout/{{ $event->id }}" method="POST">
                                    @csrf

                                    <!-- Hidden input untuk sinkronisasi nilai ke Controller -->
                                    <input type="hidden" name="ticket_package_id" id="hidden_ticket_package_id" value="">
                                    <input type="hidden" name="ticket_type" id="hidden_ticket_type" value="offline">

                                    <!-- ── KARTU PILIHAN TIKET (MODERN) ── -->
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-white/60">Pilih Tiket Kamu</label>
                                        </div>

                                        <div class="flex flex-col gap-3">

                                            @php
                                                $firstAvailableChecked = false;
                                                $hasPackages = $event->ticketPackages && $event->ticketPackages->count() > 0;
                                                $showOnlineTicket = ($event->youtube_link || ($event->online_price !== null && $event->online_price > 0) || (!$event->location && !$hasPackages));
                                            @endphp

                                            {{-- 1. OPSI PAKET TIKET OFFLINE (JIKA ADA) --}}
                                            @if($hasPackages)
                                                @foreach($event->ticketPackages as $index => $paket)
                                                    @php
                                                        $isAvailable = $paket->quota > 0;
                                                        $shouldCheck = false;
                                                        if ($isAvailable && !$firstAvailableChecked) {
                                                            $shouldCheck = true;
                                                            $firstAvailableChecked = true;
                                                        }
                                                    @endphp
                                                    <label class="ticket-label p-4 rounded-2xl cursor-pointer flex flex-col gap-3 relative transition-all {{ !$isAvailable ? 'opacity-50 cursor-not-allowed bg-slate-100/60 dark:bg-white/5' : '' }}">
                                                        <div class="flex items-start gap-4">
                                                            <div class="w-5 h-5 rounded-full border-2 radio-ring flex shrink-0 mt-0.5"></div>
                                                            <input type="radio" name="ticket_choice_radio" value="pkg_{{ $paket->id }}" class="hidden"
                                                                {{ $shouldCheck ? 'checked' : '' }} {{ !$isAvailable ? 'disabled' : '' }}
                                                                onchange="updateTotal()"
                                                                data-kind="package"
                                                                data-package-id="{{ $paket->id }}"
                                                                data-quota="{{ $paket->quota }}"
                                                                data-name="{{ $paket->name }}"
                                                                data-price="{{ $paket->price }}">

                                                            <div class="flex-1">
                                                                <div class="flex items-center justify-between gap-2 mb-1">
                                                                    <span class="font-bold text-base block font-montserrat text-slate-800 dark:text-white">{{ strtoupper($paket->name) }}</span>
                                                                    @if($isAvailable)
                                                                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-[#0066FF] dark:bg-blue-500/20 dark:text-[#00C2FF]">
                                                                            Sisa {{ $paket->quota }} Tiket
                                                                        </span>
                                                                    @else
                                                                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                                                                            Habis (Sold Out)
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                @if($paket->description)
                                                                    <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">{{ $paket->description }}</span>
                                                                @elseif(stripos($paket->name, 'vip') !== false || stripos($paket->name, 'vvip') !== false)
                                                                    <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Akses area premium VIP & fasilitas eksklusif</span>
                                                                @elseif(stripos($paket->name, 'reguler') !== false || stripos($paket->name, 'regular') !== false || stripos($paket->name, 'festival') !== false)
                                                                    <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Akses masuk area festival & seating reguler</span>
                                                                @elseif(stripos($paket->name, 'early') !== false || stripos($paket->name, 'presale') !== false)
                                                                    <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Penawaran tiket presale dengan kuota terbatas</span>
                                                                @else
                                                                    <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Kategori Tiket {{ $paket->name }}</span>
                                                                @endif

                                                                <span class="font-black text-lg text-gradient-primary inline-block" data-price="{{ $paket->price }}">
                                                                    {{ $paket->price == 0 ? 'Gratis' : 'Rp ' . number_format($paket->price, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            @elseif($event->location || $event->price > 0)
                                                {{-- 2. OPSI AKSES VENUE DEFAULT (JIKA EVENT OFFLINE TANPA PAKET) --}}
                                                @php
                                                    $isAvailable = $event->quota > 0;
                                                    $shouldCheck = false;
                                                    if ($isAvailable && !$firstAvailableChecked) {
                                                        $shouldCheck = true;
                                                        $firstAvailableChecked = true;
                                                    }
                                                @endphp
                                                <label class="ticket-label p-4 rounded-2xl cursor-pointer flex flex-col gap-3 relative transition-all {{ !$isAvailable ? 'opacity-50 cursor-not-allowed bg-slate-100/60 dark:bg-white/5' : '' }}">
                                                    <div class="flex items-start gap-4">
                                                        <div class="w-5 h-5 rounded-full border-2 radio-ring flex shrink-0 mt-0.5"></div>
                                                        <input type="radio" name="ticket_choice_radio" value="offline" class="hidden"
                                                            {{ $shouldCheck ? 'checked' : '' }} {{ !$isAvailable ? 'disabled' : '' }}
                                                            onchange="updateTotal()"
                                                            data-kind="offline"
                                                            data-package-id=""
                                                            data-quota="{{ $event->quota }}"
                                                            data-name="Akses Venue"
                                                            data-price="{{ $event->price }}">

                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                                <span class="font-bold text-base block font-montserrat text-slate-800 dark:text-white">Akses Venue</span>
                                                                @if($isAvailable)
                                                                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-[#0066FF] dark:bg-blue-500/20 dark:text-[#00C2FF]">
                                                                        Sisa {{ $event->quota }} Tiket
                                                                    </span>
                                                                @else
                                                                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                                                                        Habis (Sold Out)
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Hadir langsung di lokasi acara</span>

                                                            <span class="font-black text-lg text-gradient-primary inline-block" data-price="{{ $event->price }}">
                                                                {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endif

                                            {{-- 3. OPSI TIKET LIVESTREAM / VIRTUAL (ONLINE) --}}
                                            @if($showOnlineTicket)
                                                @php
                                                    $isOnlineAvailable = $event->quota > 0;
                                                    $shouldCheckOnline = false;
                                                    if ($isOnlineAvailable && !$firstAvailableChecked) {
                                                        $shouldCheckOnline = true;
                                                        $firstAvailableChecked = true;
                                                    }
                                                    $onlinePrice = $event->online_price ?? 0;
                                                @endphp
                                                <label class="ticket-label p-4 rounded-2xl cursor-pointer flex flex-col gap-3 relative transition-all {{ !$isOnlineAvailable ? 'opacity-50 cursor-not-allowed bg-slate-100/60 dark:bg-white/5' : '' }}">
                                                    <div class="flex items-start gap-4">
                                                        <div class="w-5 h-5 rounded-full border-2 radio-ring flex shrink-0 mt-0.5"></div>
                                                        <input type="radio" name="ticket_choice_radio" value="online" class="hidden"
                                                            {{ $shouldCheckOnline ? 'checked' : '' }} {{ !$isOnlineAvailable ? 'disabled' : '' }}
                                                            onchange="updateTotal()"
                                                            data-kind="online"
                                                            data-package-id=""
                                                            data-quota="{{ $event->quota }}"
                                                            data-name="Akses Virtual (Livestream)"
                                                            
                                                            data-price="{{ $onlinePrice }}">

                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                                <span class="font-bold text-base block font-montserrat text-slate-800 dark:text-white flex items-center gap-1.5">
                                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                                                                        <i data-lucide="video" class="w-3 h-3"></i>
                                                                    </span>
                                                                    AKSES VIRTUAL
                                                                </span>
                                                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                                                                    Livestream YouTube
                                                                </span>
                                                            </div>
                                                            <span class="text-xs font-medium text-slate-500 dark:text-white/50 block mb-2">Saksikan siaran langsung (Livestream) via tautan resmi</span>

                                                            <span class="font-black text-lg text-gradient-primary inline-block" data-price="{{ $onlinePrice }}">
                                                                {{ $onlinePrice == 0 ? 'Gratis' : 'Rp ' . number_format($onlinePrice, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endif

                                        </div>
                                    </div>

                                    <!-- Sisa Kuota & Jumlah Pesanan -->
                                    <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-4 mb-6 transition-colors">
                                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200 dark:border-white/10">
                                            <span class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-white/60">Sisa Tiket</span>
                                            <span id="quotaDisplayBadge" class="px-3 py-1.5 rounded-lg text-xs font-bold text-blue-700 bg-blue-100 dark:bg-[#0066FF]/20 dark:text-[#00C2FF]">
                                                Tersedia {{ $event->quota }} Kuota
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-bold text-slate-700 dark:text-white/80">Pilih Jumlah</span>
                                            <div class="relative w-28">
                                                <select class="w-full border rounded-xl pl-4 pr-8 py-2.5 text-sm font-bold focus:outline-none transition-colors cursor-pointer appearance-none bg-white border-slate-300 text-slate-900 focus:border-[#0066FF] dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF]" name="quantity" id="ticketQuantity" onchange="updateTotal()">
                                                    <option value="1">1 Tiket</option>
                                                    <option value="2">2 Tiket</option>
                                                    <option value="3">3 Tiket</option>
                                                    <option value="4">4 Tiket</option>
                                                    <option value="5">5 Tiket</option>
                                                </select>
                                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Bayar -->
                                    <div class="flex items-end justify-between mb-8 px-1">
                                        <span class="text-sm font-bold text-slate-500 dark:text-white/60 mb-1">Total Pembayaran</span>
                                        <span class="font-black text-2xl text-slate-900 dark:text-white font-montserrat" id="totalPriceDisplay"></span>
                                    </div>

                                    <!-- Tombol Submit -->
                                    @if($event->quota > 0)
                                        <button type="submit" class="group relative w-full flex items-center justify-center gap-2 px-4 py-4 text-sm font-bold text-white rounded-[14px] overflow-hidden transition-all shadow-lg hover:shadow-blue-500/40 hover:-translate-y-1">
                                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-[#0066FF] to-[#00C2FF] transition-transform duration-300 group-hover:scale-110"></div>
                                            <span class="relative z-10 font-montserrat tracking-wide">Beli Tiket Sekarang</span>
                                            <i data-lucide="arrow-right" class="w-4 h-4 relative z-10 transition-transform group-hover:translate-x-1"></i>
                                        </button>
                                        <div class="flex items-center justify-center gap-2 text-[11px] mt-5 font-bold text-slate-400 dark:font-medium dark:text-white/40">
                                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Pembayaran Aman & Terenkripsi
                                        </div>
                                    @else
                                        <button type="button" class="w-full py-4 font-bold rounded-[14px] cursor-not-allowed border flex items-center justify-center gap-2 bg-slate-100 border-slate-200 text-slate-400 dark:bg-white/5 dark:border-white/10 dark:text-white/40 transition-colors" disabled>
                                            <i data-lucide="x-circle" class="w-5 h-5"></i> Maaf, Tiket Telah Habis
                                        </button>
                                    @endif

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

<!-- ── MENYUNTIKKAN SCRIPT KHUSUS HALAMAN DETAIL ── -->
@push('scripts')
    <!-- Library Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ── LOGIKA KALKULASI HARGA TIKET & UPDATE KUOTA PAKET DINAMIS ──
        function updateTotal() {
            const qtySelect = document.getElementById('ticketQuantity');
            if (!qtySelect) return;

            // Deteksi radio button yang aktif dan tidak disabled
            const selectedRadio = document.querySelector('input[name="ticket_choice_radio"]:checked:not(:disabled)') || document.querySelector('input[name="ticket_choice_radio"]:not(:disabled)');
            if (!selectedRadio) return;

            if (!selectedRadio.checked) {
                selectedRadio.checked = true;
            }

            // Update hidden inputs untuk dikirim ke backend CheckoutController
            const kind = selectedRadio.getAttribute('data-kind');
            const packageId = selectedRadio.getAttribute('data-package-id') || '';
            const hiddenPkgId = document.getElementById('hidden_ticket_package_id');
            const hiddenType = document.getElementById('hidden_ticket_type');

            if (hiddenPkgId) hiddenPkgId.value = packageId;
            if (hiddenType) hiddenType.value = (kind === 'online') ? 'online' : 'offline';

            const price = parseInt(selectedRadio.getAttribute('data-price')) || 0;

            // Update Sisa Kuota Dinamis di Kotak Ringkasan
            const quotaBadge = document.getElementById('quotaDisplayBadge');
            if (quotaBadge && selectedRadio.hasAttribute('data-quota')) {
                const quota = parseInt(selectedRadio.getAttribute('data-quota'));
                const pkgName = selectedRadio.getAttribute('data-name') || 'Tiket';

                if (quota > 0) {
                    quotaBadge.innerText = `Sisa ${quota} Tiket (${pkgName})`;
                    quotaBadge.className = "px-3 py-1.5 rounded-lg text-xs font-bold text-blue-700 bg-blue-100 dark:bg-[#0066FF]/20 dark:text-[#00C2FF]";
                } else {
                    quotaBadge.innerText = `Habis / Sold Out (${pkgName})`;
                    quotaBadge.className = "px-3 py-1.5 rounded-lg text-xs font-bold text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-400";
                }

                // Batasi jumlah maksimal quantity sesuai sisa kuota paket (maks 5 tiket)
                const maxAllowed = Math.min(5, Math.max(1, quota));
                const currentVal = parseInt(qtySelect.value) || 1;
                
                qtySelect.innerHTML = '';
                for (let i = 1; i <= maxAllowed; i++) {
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.innerText = `${i} Tiket`;
                    if (i === currentVal || (currentVal > maxAllowed && i === maxAllowed)) {
                        opt.selected = true;
                    }
                    qtySelect.appendChild(opt);
                }
            }

            const qty = parseInt(qtySelect.value) || 1;
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

        // ── SCRIPT GALERI GAYA SHOPEE ──
        var thumbSwiper = new Swiper(".thumbGallerySwiper", {
            spaceBetween: 12,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                640: { slidesPerView: 5 },
                1024: { slidesPerView: 6 },
            }
        });

        var mainSwiper = new Swiper(".mainGallerySwiper", {
            loop: true,
            spaceBetween: 10,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
        });
    </script>
@endpush
