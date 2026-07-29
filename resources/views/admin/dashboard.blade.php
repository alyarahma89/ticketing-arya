<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ikhtisar Platform - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Menggunakan Font Sesuai Brand Guidelines -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Panggil Script Eksternal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Konfigurasi Tailwind Sesuai Brand Guidelines -->
    <script>
        tailwind.config = {
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
                        'artix-purple': '#A100FF',
                        'artix-cyan': '#00C2FF',
                        'canvas-soft': '#F8FAFC',
                    }
                }
            }
        }
    </script>

    <!-- CSS Kustom & Scrollbar -->
    <style>
        body { font-family: 'Exo 2', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        /* Utility Class untuk Teks Bergradien */
        .text-gradient-orange {
            background: linear-gradient(135deg, #FF7A00, #FF3B30);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-canvas-soft text-slate-800 flex h-screen overflow-hidden">

    <!-- ── SIDEBAR KIRI (Deep Navy) ── -->
    <aside class="w-64 bg-artix-navy flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen shadow-xl border-r border-white/5">

        <!-- LOGO MAIN & TEKS DITAMBAHKAN DI SINI -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/10">
            <!-- Mengubah tag <a> menjadi flex container -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">

                <!-- Gambar Logo (Sebaiknya gunakan versi Icon Only agar teks tidak dobel) -->
                <img src="{{ asset('main_logo.png') }}"
                     alt="ARTIX ID Logo"
                     class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-300"
                     style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.4)); clip-path: inset(2px);">

                <!-- Teks ARTIX ID -->
                <span class="text-white font-black text-xl tracking-tight font-montserrat group-hover:opacity-90 transition-opacity">
                    ARTIX <span class="text-gradient-orange">ID</span>
                </span>

            </a>
        </div>

        <!-- MENU NAVIGASI -->
        <nav class="p-5 space-y-1.5 flex-1 overflow-y-auto sidebar-scroll">

            <!-- MENU EO -->
            @if(Auth::user()->role == 'eo')
                <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Menu Utama</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dasbor Saya
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="ticket" class="w-5 h-5"></i> Event Saya
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Penjualan Tiket
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="handshake" class="w-5 h-5"></i> Kerjasama Sponsor
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Event
                </a>

            <!-- MENU ADMIN UTAMA -->
            @elseif(Auth::user()->role == 'admin')
                <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Sistem Admin</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="ticket" class="w-5 h-5"></i> Manajemen Event
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="tags" class="w-5 h-5"></i> Kelola Kategori
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Data Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="users" class="w-5 h-5"></i> Kelola Pengguna
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="handshake" class="w-5 h-5"></i> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Keseluruhan
                </a>
            @endif

        </nav>

        <!-- BAGIAN BAWAH: LOGOUT -->
        <div class="p-5 border-t border-white/10 shrink-0 bg-artix-navy">
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full text-left text-[13px] font-bold text-red-400 bg-red-500/10 hover:bg-red-500/20 hover:text-red-300 border border-red-500/20 px-4 py-3 rounded-xl transition-all flex items-center gap-3 shadow-sm group">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- ── KONTEN UTAMA DI KANAN ── -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#F8FAFC]">

        <!-- HEADER KANAN ATAS -->
        <header class="h-20 px-8 flex items-center justify-end gap-3 shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-10">
            <!-- Kotak Identitas Pengguna -->
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-artix-blue flex items-center justify-center text-white text-xs font-bold uppercase shadow-inner">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[13px] font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] text-artix-blue font-bold uppercase tracking-wider">{{ Auth::user()->role == 'eo' ? 'Event Organizer' : 'Platform Admin' }}</span>
                </div>
            </div>
        </header>

        <!-- ISI KONTEN DASHBOARD -->
        <div class="px-8 pt-8 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Ikhtisar Platform</h1>
                <p class="text-[14px] text-slate-500 font-medium">Ringkasan performa sistem secara keseluruhan.</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[13px] text-slate-500 bg-white px-4 py-2.5 rounded-xl shadow-sm border border-slate-200 font-medium">Periode: <span class="font-bold text-slate-800">Tahun {{ date('Y') }}</span></span>
                <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Event
                </a>
            </div>
        </div>

        <div class="px-8 pb-12">

            <!-- ALERT -->
            @if(Auth::user()->role === 'admin')
                <div class="mb-8 p-4 bg-blue-50 text-blue-700 rounded-xl border border-blue-200 flex items-center gap-3 font-medium shadow-sm">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500"></i>
                    <span><strong>Halo Admin!</strong> Anda melihat data keseluruhan platform ARTIX ID.</span>
                </div>
            @else
                <div class="mb-8 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 flex items-center gap-3 font-medium shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                    <span><strong>Halo EO!</strong> Anda hanya melihat data statistik dari event milik Anda sendiri.</span>
                </div>
            @endif

            <!-- ── KARTU STATISTIK (Menggunakan Aksen Warna Brand) ── -->
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5 mb-8">

                <!-- Card 1: Omset (Aksen Blue) -->
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1 h-full bg-artix-blue"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Omset Tiket</span>
                        <div class="bg-blue-50 text-artix-blue p-1.5 rounded-lg"><i data-lucide="banknote" class="w-4 h-4"></i></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 font-montserrat">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Card 2: Sponsor (Aksen Purple) -->
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1 h-full bg-artix-purple"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Dana Sponsor</span>
                        <div class="bg-purple-50 text-artix-purple p-1.5 rounded-lg"><i data-lucide="handshake" class="w-4 h-4"></i></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 font-montserrat">Rp {{ number_format($pendapatanSponsor ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Card 3: Tiket Terjual (Aksen Orange) -->
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1 h-full bg-artix-orange"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Tiket Terjual</span>
                        <div class="bg-orange-50 text-artix-orange p-1.5 rounded-lg"><i data-lucide="ticket" class="w-4 h-4"></i></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($tiketTerjual ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Lembar</span></span>
                    </div>
                </div>

                <!-- Card 4: Event Aktif (Aksen Red) -->
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1 h-full bg-artix-red"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Event Aktif</span>
                        <div class="bg-red-50 text-artix-red p-1.5 rounded-lg"><i data-lucide="calendar-check" class="w-4 h-4"></i></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($eventAktif ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Acara</span></span>
                    </div>
                </div>

                <!-- Card 5: Pengguna (Aksen Cyan) -->
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1 h-full bg-artix-cyan"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Total Pengguna</span>
                        <div class="bg-cyan-50 text-artix-cyan p-1.5 rounded-lg"><i data-lucide="users" class="w-4 h-4"></i></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($totalPengguna ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Akun</span></span>
                    </div>
                </div>
            </div>

            <!-- ── BAGIAN GRAFIK ── -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Line Chart -->
                <div class="lg:col-span-2 bg-white rounded-[24px] p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-slate-800 font-montserrat">Statistik Keuangan Bulanan</h3>
                        <span class="text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-lg">Juta Rupiah</span>
                    </div>
                    <div class="relative w-full h-72">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart -->
                <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-200 flex flex-col items-center">
                    <h3 class="text-lg font-black text-slate-800 font-montserrat w-full text-left mb-6">Proporsi Kategori</h3>
                    <div class="relative w-full h-64 flex items-center justify-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- SCRIPT GRAFIK & IKON -->
    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        document.addEventListener("DOMContentLoaded", function() {
            // ── Konfigurasi Chart Garis (Sales) ──
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            let salesDataValues = @json($salesData);

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: salesDataValues,
                        borderColor: '#0066FF', // ARTIX BLUE
                        backgroundColor: 'rgba(0, 102, 255, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0066FF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4 // Membuat garis melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#041B4A',
                            titleFont: { family: 'Montserrat', size: 13 },
                            bodyFont: { family: 'Exo 2', size: 14 },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#64748b', font: { family: 'Exo 2' } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { color: '#64748b', font: { family: 'Exo 2' } },
                            grid: { display: false }
                        }
                    }
                }
            });

            // ── Konfigurasi Chart Donat (Kategori) ──
            const catCtx = document.getElementById('categoryChart').getContext('2d');
            let rawCategoryData = @json($categoryData);

            if (!rawCategoryData || Object.keys(rawCategoryData).length === 0) {
                rawCategoryData = {'Belum ada data': 1};
            }

            const catLabels = Object.keys(rawCategoryData);
            const catValues = Object.values(rawCategoryData);

            // Menggunakan palet warna dari Brand Guidelines
            const bgColors = Object.keys(rawCategoryData)[0] === 'Belum ada data'
                             ? ['#e2e8f0']
                             : ['#0066FF', '#FF7A00', '#A100FF', '#FF3B30', '#00C2FF'];

            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catValues,
                        backgroundColor: bgColors,
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Lubang tengah yang lebih besar (modern)
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Exo 2', size: 12 },
                                color: '#475569',
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#041B4A',
                            bodyFont: { family: 'Montserrat', size: 13, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
