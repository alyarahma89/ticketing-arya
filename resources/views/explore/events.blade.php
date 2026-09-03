<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event - Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Menggunakan icon Lucide yang profesional dan bersih -->
    <script src="https://unpkg.com/lucide@latest"></script>

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
        body { font-family: 'Exo 2', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        .text-gradient-blue { background: linear-gradient(135deg,#0066FF,#00C2FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-orange { background: linear-gradient(135deg,#FF7A00,#FF3B30); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* ── ANIMASI REVEAL SMOOTH ── */
        .reveal-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay untuk Efek Kartu Berurutan (Stagger) */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen transition-colors duration-300">

    <!-- Navbar Sederhana -->
    <nav class="sticky top-0 z-50 bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10 py-4">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-slate-600 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali
            </a>

            <h1 class="font-montserrat font-black text-xl">Katalog <span class="text-[#0066FF] dark:text-[#00C2FF]">Event</span></h1>

            <!-- Tempat Tombol Toggle Tema (Pengganti Spacer) -->
            <div class="flex justify-end w-24">
                <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-slate-100 border border-slate-200 shadow-sm hover:text-[#0066FF] dark:bg-white/10 dark:border-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none">
                    <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-12">
        <div class="max-w-7xl mx-auto px-6">

            <!-- ── HEADER & INLINE SEARCH BAR (Desain Kapsul + Animasi) ── -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-12 gap-6">

                <!-- Judul dengan Animasi -->
                <div class="reveal-up">
                    <h2 class="font-black text-3xl md:text-4xl font-montserrat leading-tight">
                        Temukan Event <span class="text-gradient-blue">Favoritmu</span>
                    </h2>
                    <p class="text-xs md:text-sm font-medium text-slate-500 dark:text-white/50 mt-1">
                        Jelajahi dan dapatkan tiket event terbaik di seluruh Indonesia.
                    </p>
                </div>

                <!-- Bar Pencarian Kapsul dengan Animasi -->
                <form action="{{ route('explore.events') }}" method="GET" class="reveal-up delay-100 flex flex-wrap lg:flex-nowrap items-center bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 p-2 rounded-2xl lg:rounded-full shadow-lg gap-2">

                    <!-- 1. Ikon & Input Pencarian Nama -->
                    <div class="relative flex-1 min-w-[180px] flex items-center px-3 border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-white/10 py-1.5">
                        <i data-lucide="search" class="w-4 h-4 text-[#0066FF] dark:text-[#00C2FF] shrink-0"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event..." class="w-full bg-transparent text-xs md:text-sm font-medium pl-2.5 pr-2 focus:outline-none text-slate-900 dark:text-white placeholder-slate-400">
                    </div>

                    <!-- 2. Ikon & Dropdown Kategori -->
                    <div class="relative flex-1 min-w-[150px] flex items-center px-3 border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-white/10 py-1.5">
                        <i data-lucide="grid" class="w-4 h-4 text-purple-500 shrink-0"></i>
                        <select name="category_id" class="w-full bg-transparent text-xs md:text-sm font-medium pl-2 pr-2 focus:outline-none text-slate-900 dark:text-white cursor-pointer appearance-none">
                            <option value="" class="dark:bg-[#041B4A]">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" class="dark:bg-[#041B4A]" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Ikon & Dropdown Lokasi -->
                    <div class="relative flex-1 min-w-[140px] flex items-center px-3 py-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[#FF7A00] shrink-0"></i>
                        <select name="location" class="w-full bg-transparent text-xs md:text-sm font-medium pl-2 pr-2 focus:outline-none text-slate-900 dark:text-white cursor-pointer appearance-none">
                            <option value="" class="dark:bg-[#041B4A]">Semua Lokasi</option>
                            <option value="Medan" class="dark:bg-[#041B4A]" {{ request('location') == 'Medan' ? 'selected' : '' }}>Medan</option>
                            <option value="Jakarta" class="dark:bg-[#041B4A]" {{ request('location') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                        </select>
                    </div>

                    <!-- Tombol Terapkan (Cari) -->
                    <button type="submit" class="w-full lg:w-auto px-6 py-2.5 rounded-xl lg:rounded-full font-bold text-xs text-white transition-all hover:scale-105 shadow-md flex items-center justify-center gap-2 shrink-0" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        <span class="lg:hidden">Cari Event</span>
                    </button>

                    <!-- Tombol Reset (Muncul jika ada filter yang aktif) -->
                    @if(request('search') || request('category_id') || request('location'))
                        <a href="{{ route('explore.events') }}" class="p-2.5 rounded-full bg-slate-100 dark:bg-white/10 text-slate-400 hover:text-red-500 transition-colors shrink-0" title="Reset Filter">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Grid Kartu Event -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                @php
                    // Menghitung jeda animasi bertahap (100ms, 200ms, 300ms) berdasarkan urutan index kartu
                    $delayClass = 'delay-' . ((($loop->index % 3) + 1) * 100);
                @endphp
                <div class="reveal-up {{ $delayClass }} group relative p-4 rounded-3xl border shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#0066FF55]">
                    <div class="h-44 w-full relative overflow-hidden rounded-2xl mb-5 bg-slate-100 dark:bg-[#0A1A3A]">
                        <img src="{{ $event->image ? (Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : asset('storage/' . $event->image)) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80' }}" 
                             alt="{{ $event->name }}" 
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80';"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 px-3 py-1 text-[10px] font-bold rounded-full text-white font-montserrat bg-[#0066FF]">
                            {{ strtoupper($event->category->name ?? 'TANPA KATEGORI') }}
                        </div>
                    </div>
                    <h3 class="font-bold text-lg mb-2 font-montserrat text-slate-900 dark:text-white">{{ $event->name }}</h3>
                    <p class="text-sm mb-4 line-clamp-2 font-medium text-slate-500 dark:text-white/50">{{ $event->description }}</p>

                    <div class="flex items-center gap-2 text-xs font-bold mb-2 text-slate-500 dark:text-white/40">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500"></i> {{ $event->location ?? 'Lokasi Belum Ditentukan' }}
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold mb-4 pb-4 border-b text-slate-500 border-slate-100 dark:border-white/10 dark:text-white/40">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-orange-500"></i> {{ date('d M Y', strtotime($event->event_date)) }}
                    </div>

                    <div class="mt-auto flex items-center justify-between">
                        <span class="font-black text-xl font-montserrat text-gradient-blue dark:text-gradient-orange">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ url('/event/' . $event->id) }}" class="px-5 py-2.5 text-xs font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">Beli Tiket</a>
                    </div>
                </div>
                @empty
                <div class="reveal-up col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 rounded-3xl border border-dashed bg-slate-50 border-slate-300 dark:bg-transparent dark:border-white/20">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto mb-3 text-slate-400 dark:text-white/30"></i>
                    <h3 class="font-bold text-lg text-slate-600 dark:text-white">Tidak ada event yang sesuai pencarian</h3>
                </div>
                @endforelse
            </div>

            <!-- Paginasi (Next/Prev) -->
            <div class="mt-12 flex justify-center reveal-up">
                {{ $events->withQueryString()->links() }}
            </div>

        </div>
    </main>

    <script>
        // Render ikon Lucide
        lucide.createIcons();

        // ── LOGIKA DARK MODE TOGGLE ──
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        // Cek LocalStorage untuk mengingat preferensi tema dari halaman sebelumnya
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
            if (themeIcon) themeIcon.setAttribute('data-lucide', 'sun');
            lucide.createIcons(); // Render ulang ikon setelah ubah atribut
        }

        // Fungsi ketika tombol ditekan
        function toggleTheme() {
            const isDark = html.classList.toggle('dark');
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');

            // Simpan pilihan ke memori browser
            localStorage.setItem('theme', isDark ? 'dark' : 'light');

            lucide.createIcons(); // Render ulang ikon
        }

        if(themeToggle) themeToggle.addEventListener('click', toggleTheme);


        // ── LOGIKA SKRIP ANIMASI OBSERVER ──
        document.addEventListener("DOMContentLoaded", function () {
            const observerOptions = {
                root: null,
                rootMargin: "0px 0px -50px 0px", // Memicu animasi sedikit sebelum elemen berada di posisi tengah layar
                threshold: 0.1
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target); // Hanya beranimasi sekali agar performa tetap ringan
                    }
                });
            }, observerOptions);

            // Daftarkan semua elemen dengan class reveal-up untuk dipantau
            document.querySelectorAll('.reveal-up').forEach(el => revealObserver.observe(el));
        });
    </script>
</body>
</html>
