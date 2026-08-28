<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir - Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

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
            <h1 class="font-montserrat font-black text-lg">Daftar Hadir</h1>
            <div class="w-8"></div> <!-- Spacer -->
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow max-w-md mx-auto w-full px-4 pt-6 pb-10">

        <!-- Kolom Pencarian -->
        <div class="relative mb-6">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
            <input type="text" id="searchInput" placeholder="Cari nama peserta..." class="w-full pl-10 pr-4 py-3 bg-white dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 rounded-xl text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 shadow-sm transition-all">
        </div>

        <div class="space-y-3" id="pesertaList">

            <!-- Loop Data dari Database -->
            @forelse ($attendees as $trx)
                @php
                    // Mengambil nama user dari relasi
                    $nama = $trx->user->name ?? 'Tanpa Nama';

                    // Inisial untuk ikon
                    $inisial = strtoupper(substr($nama, 0, 1));

                    // MENGGUNAKAN KOLOM ASLI DARI TABEL TRANSACTIONS
                    $isHadir = $trx->is_checked_in;
                @endphp

                <!-- Kartu Peserta (Data-nama digunakan untuk fitur pencarian JS) -->
                <div class="peserta-card bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-4 flex items-center justify-between shadow-sm transition-all" data-nama="{{ strtolower($nama) }}">
                    <div class="flex items-center gap-3">
                        <!-- Ikon Inisial Warna Dinamis -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $isHadir ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-500 dark:bg-white/10 dark:text-white/60' }}">
                            {{ $inisial }}
                        </div>
                        <div>
                            <h3 class="font-bold text-sm">{{ $nama }}</h3>
                            <!-- Menampilkan Order ID dan Ticket Type dari tabel asli -->
                            <p class="text-[11px] text-slate-500 dark:text-white/60 mt-0.5">
                                <span class="font-bold text-slate-700 dark:text-white/80">#{{ $trx->order_id }}</span> • {{ ucfirst($trx->ticket_type) }}
                            </p>
                            <p class="text-[10px] text-slate-400 dark:text-white/40 truncate max-w-[150px]">
                                {{ $trx->event->name ?? 'Event' }}
                            </p>
                        </div>
                    </div>

                    <!-- Label Status Kehadiran -->
                    @if($isHadir)
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/20 dark:border-emerald-500/30 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                            <i data-lucide="check" class="w-3 h-3"></i> Hadir
                        </span>
                    @else
                        <span class="bg-slate-100 text-slate-500 border border-slate-200 dark:bg-white/10 dark:border-white/20 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                            Belum
                        </span>
                    @endif
                </div>
            @empty
                <!-- Tampilan jika tidak ada tiket yang lunas -->
                <div class="text-center py-12">
                    <i data-lucide="inbox" class="w-12 h-12 text-slate-300 dark:text-white/20 mx-auto mb-3"></i>
                    <p class="text-slate-500 dark:text-white/60 text-sm font-medium">Belum ada data peserta yang lunas.</p>
                </div>
            @endforelse

        </div>

    </main>

    <script>
        lucide.createIcons();

        // Fitur Pencarian Real-time
        const searchInput = document.getElementById('searchInput');
        const pesertaCards = document.querySelectorAll('.peserta-card');

        searchInput.addEventListener('keyup', function(e) {
            const keyword = e.target.value.toLowerCase();

            pesertaCards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                if(nama.includes(keyword)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
