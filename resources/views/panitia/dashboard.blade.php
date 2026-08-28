<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Panitia - Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Tailwind CSS & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Konfigurasi Tailwind Sesuai Brand Guidelines -->
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
                        'artix-red': '#FF3B30',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Exo 2', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white min-h-screen flex flex-col">

    <!-- ── NAVBAR ATAS ── -->
    <nav class="bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10 sticky top-0 z-50">
        <div class="max-w-md mx-auto px-6 py-4 min-h-[5rem] flex items-center justify-between">
            <div class="flex items-center gap-3 pr-4">
                <!-- Inisial Nama Bulat -->
                <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-white/10 text-[#0066FF] dark:text-[#00C2FF] flex items-center justify-center font-black text-lg shadow-inner shrink-0">
                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-[14px] font-black font-montserrat leading-tight">{{ Auth::user()->name ?? 'Panitia Event' }}</span>
                    <!-- PERUBAHAN: Menghapus truncate, membiarkan teks turun ke bawah dengan rapi (maksimal 2 baris) -->
                    <span class="text-[10px] font-bold text-[#0066FF] dark:text-[#00C2FF] uppercase tracking-wider mt-0.5 flex items-start gap-1 leading-snug">
                        <i data-lucide="map-pin" class="w-3 h-3 shrink-0 mt-[1px]"></i>
                        <span class="line-clamp-2">{{ $event->name ?? 'Belum ada event' }}</span>
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <!-- Toggle Dark Mode -->
                <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-slate-100 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none">
                    <i id="theme-icon" data-lucide="moon" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- ── KONTEN UTAMA (Dioptimalkan untuk Layar HP) ── -->
    <main class="flex-grow max-w-md mx-auto w-full px-6 pt-8 pb-10">

        <!-- Header Halaman -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#0066FF] to-[#00C2FF] text-white shadow-lg shadow-blue-500/30 mb-4">
                <i data-lucide="shield-check" class="w-8 h-8"></i>
            </div>
            <h1 class="font-black text-2xl font-montserrat text-slate-900 dark:text-white mb-2">
                Portal Panitia
            </h1>

            <!-- Label/Badge Nama Event Tengah Layar -->
            <div class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-50 dark:bg-[#0066FF]/10 text-[#0066FF] dark:text-[#00C2FF] text-[11px] font-bold uppercase tracking-widest border border-blue-100 dark:border-[#0066FF]/30 mb-2 max-w-full">
                <i data-lucide="calendar-check" class="w-3.5 h-3.5 mr-1.5 shrink-0"></i>
                <span class="truncate">{{ $event->name ?? 'Akses Lapangan' }}</span>
            </div>

            <p class="text-sm font-medium text-slate-500 dark:text-white/60 mt-1">
                Pilih menu di bawah ini untuk memulai tugas Anda di lapangan.
            </p>
        </div>

        <!-- ── NOTIFIKASI ERROR / SUKSES ── -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-600 border border-red-200 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
                <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- ── MENU UTAMA (GRID LAYOUT) ── -->
        <div class="grid grid-cols-2 gap-4">

            <!-- Menu 1: Scanner -->
            <a href="{{ route('panitia.scanner') }}" class="col-span-2 group block bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl p-6 text-center shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-[#0066FF] dark:hover:border-[#00C2FF] transition-all relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-[#0066FF]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 mx-auto bg-blue-50 dark:bg-white/10 text-[#0066FF] dark:text-[#00C2FF] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i data-lucide="scan-line" class="w-8 h-8"></i>
                </div>
                <h2 class="text-xl font-black font-montserrat text-slate-900 dark:text-white mb-1">Buka Scanner</h2>
                <p class="text-xs font-medium text-slate-500 dark:text-white/60">Scan QR Code tiket peserta di gerbang masuk.</p>
            </a>

            <!-- Menu 2: Daftar Hadir -->
            <a href="{{ route('panitia.attendance') }}" class="group block bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl p-5 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 mx-auto bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h2 class="text-sm font-black font-montserrat text-slate-900 dark:text-white mb-1">Daftar Hadir</h2>
                <p class="text-[10px] font-medium text-slate-500 dark:text-white/60">Cek peserta yang sudah masuk.</p>
            </a>

            <!-- Menu 3: Info Event -->
            <a href="{{ route('panitia.event_info') }}" class="group block bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl p-5 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 mx-auto bg-orange-50 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar-days" class="w-6 h-6"></i>
                </div>
                <h2 class="text-sm font-black font-montserrat text-slate-900 dark:text-white mb-1">Info Event</h2>
                <p class="text-[10px] font-medium text-slate-500 dark:text-white/60">Jadwal & denah acara.</p>
            </a>

        </div>

        <!-- Tombol Logout di Bawah -->
        <div class="mt-10">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri sesi tugas?');">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-slate-100 dark:bg-white/10 text-red-500 dark:text-red-400 font-bold text-sm hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/20 transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Akhiri Sesi (Logout)
                </button>
            </form>
        </div>

    </main>

    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        // Logika Dark Mode
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            lucide.createIcons();
        });
    </script>
</body>
</html>
