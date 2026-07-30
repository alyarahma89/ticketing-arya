<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Event - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    <style> body { font-family: 'Exo 2', sans-serif; } </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10 sticky top-0 z-50">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('panitia.dashboard') }}" class="flex items-center gap-2 text-slate-500 hover:text-[#0066FF] dark:text-white/70 dark:hover:text-white font-bold text-sm transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i> Dasbor
            </a>
            <h1 class="font-montserrat font-black text-lg">Detail Event</h1>
            <div class="w-8"></div> <!-- Spacer -->
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow max-w-md mx-auto w-full px-4 pt-6 pb-10">

        @if($event)
            <!-- Kartu Banner & Judul -->
            <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-sm mb-6">
                <div class="h-36 bg-gradient-to-r from-[#0066FF] to-[#00C2FF] flex items-center justify-center relative overflow-hidden">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover opacity-90">
                    @else
                        <i data-lucide="image" class="w-10 h-10 text-white/50"></i>
                    @endif
                </div>
                <div class="p-5 text-center">
                    <div class="inline-flex items-center gap-1.5 bg-blue-50 text-[#0066FF] dark:bg-[#0066FF20] px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border border-blue-100 dark:border-[#0066FF30]">
                        Sedang Berlangsung
                    </div>
                    <h2 class="font-black font-montserrat text-2xl leading-tight mb-1">{{ $event->name }}</h2>
                    <p class="text-xs font-medium text-slate-500 dark:text-white/60">
                        Diselenggarakan oleh {{ $event->user->name ?? 'EO Management' }}
                    </p>
                </div>
            </div>

            <!-- Kartu Info Waktu & Tempat -->
            <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl p-5 shadow-sm space-y-4 mb-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-500/20 text-[#FF7A00] flex items-center justify-center shrink-0">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white mb-0.5">Waktu Pelaksanaan</h3>
                        <p class="text-xs text-slate-500 dark:text-white/60 font-medium">
                            {{ date('d F Y', strtotime($event->event_date)) }}<br>
                            Sesuai Jadwal Tiket
                        </p>
                    </div>
                </div>

                <div class="h-px w-full bg-slate-100 dark:bg-white/10"></div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/20 text-emerald-500 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white mb-0.5">Lokasi Acara</h3>
                        <p class="text-xs text-slate-500 dark:text-white/60 font-medium">
                            {{ $event->location ?? 'Lokasi belum ditentukan' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kartu Catatan Panitia (Diambil dari Deskripsi Event) -->
            <div class="bg-blue-50 dark:bg-[#0066FF15] border border-blue-100 dark:border-[#0066FF30] rounded-2xl p-5">
                <h3 class="font-bold text-sm text-[#0066FF] flex items-center gap-2 mb-2">
                    <i data-lucide="info" class="w-4 h-4"></i> Catatan & Deskripsi Event
                </h3>
                <p class="text-xs text-slate-600 dark:text-white/70 leading-relaxed font-medium">
                    {{ $event->description ?? 'Tidak ada catatan tambahan untuk event ini.' }}
                </p>
            </div>
        @else
            <!-- Tampilan jika tidak ada event di database -->
            <div class="text-center py-16 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl mt-6">
                <i data-lucide="calendar-x" class="w-16 h-16 text-slate-300 dark:text-white/20 mx-auto mb-4"></i>
                <h3 class="font-black text-lg text-slate-900 dark:text-white font-montserrat mb-1">Belum Ada Event</h3>
                <p class="text-sm font-medium text-slate-500 dark:text-white/60 px-4">
                    Saat ini tidak ada event aktif yang sedang berjalan di sistem.
                </p>
            </div>
        @endif

    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
