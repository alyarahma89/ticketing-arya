<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - ARTIX ID</title>

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

        /* Custom scrollbar untuk sidebar */
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

        /* Aturan untuk cetak PDF */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; overflow: visible !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
            canvas { max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-canvas-soft text-slate-800 flex h-screen overflow-hidden">

    <!-- ── SIDEBAR KIRI (Deep Navy) ── -->
    <aside class="w-64 bg-artix-navy flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen shadow-xl border-r border-white/5 no-print">

        <!-- LOGO MAIN & TEKS -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('main_logo.png') }}" alt="ARTIX ID Logo" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-300" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.4)); clip-path: inset(2px);">
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

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
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

                <!-- Disorot karena ini halaman Laporan Event (EO) -->
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Event
                </a>

            <!-- MENU ADMIN UTAMA -->
            @elseif(Auth::user()->role == 'admin')
                <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Sistem Admin</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
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

                <!-- Disorot karena ini halaman Laporan Keseluruhan (Admin) -->
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
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

    <!-- ── AREA KONTEN UTAMA ── -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#F8FAFC]">

        <!-- HEADER KANAN ATAS -->
        <header class="h-20 px-8 flex items-center justify-end gap-3 shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-50 no-print">
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

        <!-- ── KONTEN UTAMA LAPORAN ── -->
        <div class="px-8 pt-10 pb-12">

            <!-- Judul Halaman & Tombol Export -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Laporan Keuangan</h1>
                    <p class="text-[14px] text-slate-500 font-medium">
                        @if(Auth::user()->role === 'eo') Ringkasan pendapatan event Anda. @else Ringkasan pendapatan seluruh event di platform. @endif
                    </p>
                </div>

                <!-- TOMBOL EXPORT (Sembunyikan saat cetak PDF) -->
                <div class="flex flex-wrap gap-3 no-print">
                    <!-- Download PDF -->
                    <button type="submit" form="filterForm" name="export" value="pdf" class="bg-gradient-to-r from-red-500 to-[#FF3B30] text-white px-6 py-2.5 rounded-[12px] text-sm font-bold hover:shadow-lg hover:shadow-red-500/30 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                        <i data-lucide="file-text" class="w-4 h-4"></i> Download PDF
                    </button>
                    <!-- Download Excel -->
                    <button type="submit" form="filterForm" name="export" value="excel" class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-2.5 rounded-[12px] text-sm font-bold hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Download Excel
                    </button>
                </div>
            </div>

            <!-- ── FORM FILTER TANGGAL ── -->
            <div class="bg-white p-6 rounded-[24px] border border-slate-200 shadow-sm mb-8 no-print">
                <form id="filterForm" action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Dari Tanggal</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-[12px] text-[14px] font-bold text-slate-700 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all cursor-pointer">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Sampai Tanggal</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-[12px] text-[14px] font-bold text-slate-700 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all cursor-pointer">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-[#041B4A] hover:bg-slate-800 text-white px-6 py-3 rounded-[12px] text-sm font-bold transition-all shadow-md flex items-center gap-2">
                            <i data-lucide="search" class="w-4 h-4"></i> Filter Data
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 hover:border-slate-300 px-6 py-3 rounded-[12px] text-sm font-bold transition-all flex items-center gap-2">
                            <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- ── KARTU RINGKASAN (SUMMARY) ── -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Total Pendapatan -->
                <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-[#0066FF]"></div>
                    <div class="pl-2">
                        <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Total Pendapatan Tiket</p>
                        <h3 class="text-3xl font-black text-slate-800 font-montserrat">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0066FF] shadow-inner border border-blue-100">
                        <i data-lucide="banknote" class="w-7 h-7"></i>
                    </div>
                </div>
                <!-- Total Tiket Terjual -->
                <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-[#FF7A00]"></div>
                    <div class="pl-2">
                        <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Total Tiket Terjual</p>
                        <h3 class="text-3xl font-black text-slate-800 font-montserrat">{{ number_format($totalTiket, 0, ',', '.') }} <span class="text-sm font-bold text-slate-400 font-exo">Tiket</span></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7A00] shadow-inner border border-orange-100">
                        <i data-lucide="ticket" class="w-7 h-7"></i>
                    </div>
                </div>
            </div>

            <!-- ── GRAFIK PENDAPATAN HARIAN ── -->
            <div class="bg-white p-8 rounded-[24px] border border-slate-200 shadow-sm mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-black text-slate-800 font-montserrat flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#0066FF]"></i> Grafik Pendapatan Harian
                    </h2>
                    <span class="text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-lg">Rupiah (Rp)</span>
                </div>
                <div class="relative h-[320px] w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- ── TABEL RINCIAN TRANSAKSI ── -->
            <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-base font-black text-slate-800 font-montserrat">Rincian Transaksi Event</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-widest font-montserrat">
                            <tr>
                                <th class="py-5 px-6">Tanggal Transaksi</th>
                                <th class="py-5 px-6">Nama Event</th>
                                <th class="py-5 px-6 text-center">Jml Tiket</th>
                                <th class="py-5 px-6 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] text-slate-700 divide-y divide-slate-100">
                            @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                                        {{ $report->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $report->event->name ?? 'Event Terhapus' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-slate-100 border border-slate-200 text-slate-700 font-bold px-3 py-1 rounded-lg text-xs">
                                        {{ $report->quantity }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-slate-800 font-montserrat">Rp {{ number_format($report->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="inbox" class="w-8 h-8"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Tidak Ada Data</h3>
                                        <p class="text-slate-500 text-[14px] font-medium">Belum ada transaksi pendapatan pada rentang waktu ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- ── SCRIPT GRAFIK CHART.JS ── -->
    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data yang dikirim dari Controller
            const labels = @json($chartLabels);
            const dataValues = @json($chartValues);

            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Membuat efek gradasi warna di bawah garis grafik
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(0, 102, 255, 0.4)'); // Artix Blue transparan
            gradient.addColorStop(1, 'rgba(0, 102, 255, 0.0)'); // Memudar ke transparan penuh

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: dataValues,
                        borderColor: '#0066FF', // Artix Blue
                        backgroundColor: gradient, // Menggunakan gradasi yang dibuat di atas
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0066FF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#0066FF',
                        pointHoverBorderColor: '#ffffff',
                        fill: true, // Mengaktifkan warna area di bawah garis
                        tension: 0.4 // Membuat garis melengkung (smooth)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#041B4A', // Deep Navy background
                            titleFont: { family: 'Montserrat', size: 13, weight: 'bold' },
                            bodyFont: { family: 'Exo 2', size: 14, weight: '600' },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Exo 2', weight: '600' },
                                padding: 10,
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000) + ' Jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000) + ' Rb';
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Exo 2', weight: '600' },
                                padding: 10
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
