@extends('layouts.main')

@section('title', $event->name . ' | ARTIX ID')

<!-- ── MENYUNTIKKAN CSS KHUSUS HALAMAN DETAIL ── -->
@push('styles')
    <!-- Library Swiper CSS untuk Galeri Foto -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        /* Gradasi Teks Khusus Tiket */
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
        html.light .ticket-card { background: #F8FAFC; border: 1px solid #E2E8F0; }
        html.light .ticket-card:hover { border-color: #93C5FD; background: #EFF6FF; transform: translateY(-2px); }
        html.light .ticket-card:has(input:checked) { border-color: #0066FF; background: #DBEAFE; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.15); }
        html.light .custom-radio { border-color: #CBD5E1; }
        html.light .ticket-card:has(input:checked) .custom-radio { border-color: #0066FF; }

        /* Dark Mode Styles */
        html.dark .ticket-card { background: #0F1730; border: 1px solid #1E2A4D; }
        html.dark .ticket-card:hover { border-color: #0066FF; background: rgba(0, 102, 255, 0.1); transform: translateY(-2px); }
        html.dark .ticket-card:has(input:checked) { border-color: #00C2FF; background: rgba(0, 102, 255, 0.2); box-shadow: 0 8px 30px rgba(0, 194, 255, 0.25); }
        html.dark .custom-radio { border-color: rgba(255,255,255,0.3); }
        html.dark .ticket-card:has(input:checked) .custom-radio { border-color: #00C2FF; }

        .ticket-card:has(input:checked) .radio-dot { opacity: 1; transform: scale(1); }
        .radio-dot { opacity: 0; transform: scale(0.5); transition: all 0.2s ease; }

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
                                    <!-- Slide 1: Poster Utama -->
                                    <div class="swiper-slide relative cursor-grab">
                                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent pointer-events-none"></div>
                                    </div>

                                    <!-- Slide Tambahan: Galeri -->
                                    @if($event->galleries && $event->galleries->count() > 0)
                                        @foreach($event->galleries as $gallery)
                                            <div class="swiper-slide relative cursor-grab">
                                                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent pointer-events-none"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Tombol Navigasi -->
                                <div class="swiper-button-next z-20 cursor-pointer !text-white after:!text-xl !w-10 !h-10 bg-black/30 hover:bg-black/60 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100"></div>
                                <div class="swiper-button-prev z-20 cursor-pointer !text-white after:!text-xl !w-10 !h-10 bg-black/30 hover:bg-black/60 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100"></div>
                            </div>
                        </div>

                        <!-- THUMBNAILS (KOTAK KECIL DI BAWAH) -->
                        @if($event->galleries && $event->galleries->count() > 0)
                        <div class="swiper thumbGallerySwiper w-full h-20 md:h-24 px-1 py-1">
                            <div class="swiper-wrapper">
                                <!-- Thumb 1: Poster Utama -->
                                <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden shadow-sm">
                                    <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Thumb Tambahan: Galeri -->
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

                <!-- Kolom Kanan: Panel Pembelian -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="rounded-3xl border overflow-hidden shadow-xl relative transition-colors bg-white border-slate-200 dark:bg-[#041B4A] dark:border-[#1E2A4D] dark:backdrop-blur-md">

                            <!-- Header Panel -->
                            <div class="p-6 text-center border-b relative z-10 bg-slate-50 border-slate-200 dark:bg-white/5 dark:border-white/5 transition-colors">
                            <h2 class="font-black text-lg tracking-widest uppercase font-montserrat">
                                <!-- Mengganti gradasi dengan warna biru solid yang kontras -->
                                <span class="text-[#0066FF] dark:text-[#00C2FF]">Pesan Tiketmu</span>
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
                                                        <span class="font-bold text-base block font-['Montserrat'] mb-0.5 text-slate-800 dark:text-white">Tiket Offline</span>
                                                        <span class="text-[11px] font-bold text-slate-500 dark:text-white/50 dark:font-medium">Acara Langsung di Tempat</span>
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

                                    <!-- Jumlah Pesanan -->
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

                                    <hr class="border-slate-200 dark:border-white/10 mb-6 transition-colors">

                                    <!-- Total Bayar -->
                                    <div class="flex items-center justify-between mb-8">
                                        <span class="text-sm font-bold text-slate-600 dark:text-white/70">Total Pembayaran</span>
                                        <span class="font-black text-2xl text-gradient-ticket font-montserrat" id="totalPriceDisplay"></span>
                                    </div>

                                    <!-- Tombol Submit -->
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
    </div>

@endsection

<!-- ── MENYUNTIKKAN SCRIPT KHUSUS HALAMAN DETAIL ── -->
@push('scripts')
    <!-- Library Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ── LOGIKA KALKULASI HARGA TIKET ──
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

        // ── SCRIPT GALERI GAYA SHOPEE ──
        // 1. Inisialisasi Thumbnail (Gambar Kecil di Bawah)
        var thumbSwiper = new Swiper(".thumbGallerySwiper", {
            spaceBetween: 12,
            slidesPerView: 4, // Menampilkan 4 kotak di HP
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                640: { slidesPerView: 5 }, // 5 kotak di layar sedang
                1024: { slidesPerView: 6 }, // 6 kotak di laptop
            }
        });

        // 2. Inisialisasi Gambar Utama (Besar)
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
            // Menghubungkan gambar besar dengan thumbnail kecil di bawahnya!
            thumbs: {
                swiper: thumbSwiper,
            },
        });
    </script>
@endpush
