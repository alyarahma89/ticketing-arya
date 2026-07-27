<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - TICKS ID</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Panggil Library Chart.js dari Internet -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        primary: '#696FC7', 'primary-subdued': '#F8B55F',
                        'brand-dark': '#1c1e54', ink: '#0d253d', 'ink-mute': '#64748d',
                        canvas: '#ffffff', 'canvas-soft': '#f6f9fc', hairline: '#e3e8ee'
                    }
                }
            }
        }
    </script>

    <style>
        /* TRIK RAHASIA CETAK PDF: Sembunyikan elemen yang tidak perlu saat dicetak! */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; overflow: visible !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
     <!-- 3. CSS Kustom & Scrollbar (KHUSUS CSS) -->
    <style>
        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        /* Aturan untuk cetak PDF */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; overflow: visible !important; }
            .shadow-sm { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
</head>
<body class="bg-canvas-soft text-ink flex h-screen overflow-hidden">

    <aside class="w-64 bg-brand-dark flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen">

        <!-- 1. BAGIAN ATAS: LOGO (Ukurannya Tetap) -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/5 pt-4">
            <span class="text-white font-light text-[24px] tracking-tight">
                ARTIX <span class="font-bold text-primary-subdued">ID</span>
            </span>
        </div>

        <!-- 2. BAGIAN TENGAH: MENU (Bisa di-scroll) -->
        <nav class="p-5 space-y-2 flex-1 overflow-y-auto sidebar-scroll">
            <!-- MENU EO -->
            @if(Auth::user()->role == 'eo')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Dasbor Saya
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Event Saya
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">💳</span> Penjualan Tiket
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kerjasama Sponsor
                </a>

            <!-- MENU ADMIN UTAMA -->
            @elseif(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Manajemen Event
                </a>
                <!-- Menu ini disorot (aktif) karena kita sedang di halaman Kategori -->
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🏷️</span> Kelola Kategori
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">💳</span> Data Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">👥</span> Kelola Pengguna
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                    <span class="text-lg">📊</span> Laporan Keseluruhan
                </a>

            @endif
        </nav>

        <!-- 3. BAGIAN BAWAH: PROFIL & LOGOUT (Selalu terlihat di bawah) -->
        <div class="p-5 border-t border-white/5 shrink-0 bg-brand-dark">

            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-left text-[13px] font-medium text-red-300 bg-red-500/10 hover:bg-red-500/25 border border-red-500/20 px-4 py-2.5 rounded-xl transition-all flex items-center gap-3 shadow-sm">
                    <span class="text-lg">🚪</span> Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-y-auto p-10 relative z-10">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-[32px] font-light tracking-[-0.64px] text-ink mb-1">Laporan Keseluruhan</h1>
                <p class="text-[15px] text-ink-mute font-light">
                    @if(Auth::user()->role === 'eo') Ringkasan pendapatan event Anda. @else Ringkasan pendapatan seluruh event. @endif
                </p>
            </div>


            <!-- TOMBOL EXPORT (Sembunyikan saat cetak) -->
            <div class="flex gap-2 no-print">
                <!-- Tombol Export PDF sekarang akan mengirimkan instruksi ke Controller -->
                <button type="submit" form="filterForm" name="export" value="pdf" class="bg-red-500 text-white px-5 py-2.5 rounded-full text-[13px] font-medium hover:bg-red-600 transition shadow-sm flex items-center gap-2">
                    📄 Download PDF
                </button>
                <!-- Tombol Export Excel memicu form filter dengan nilai export=excel -->
                <button type="submit" form="filterForm" name="export" value="excel" class="bg-green-600 text-white px-5 py-2.5 rounded-full text-[13px] font-medium hover:bg-green-700 transition shadow-sm flex items-center gap-2">
                    Download Excel
                </button>
            </div>
        </div>

        <!-- FORM FILTER TANGGAL (Sembunyikan saat cetak) -->
        <div class="bg-white p-5 rounded-[16px] border border-hairline shadow-sm mb-6 no-print">
            <form id="filterForm" action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-[13px] font-medium text-ink mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-4 py-2 border border-hairline rounded-lg text-[14px] outline-none focus:border-primary">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-ink mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-4 py-2 border border-hairline rounded-lg text-[14px] outline-none focus:border-primary">
                </div>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg text-[14px] font-medium hover:bg-opacity-90 transition">
                    🔍 Filter Data
                </button>
                <a href="{{ route('admin.reports.index') }}" class="bg-canvas-soft text-ink border border-hairline px-6 py-2 rounded-lg text-[14px] font-medium hover:bg-gray-100 transition">
                    Reset
                </a>
            </form>
        </div>

        <!-- GRAFIK PENDAPATAN -->
        <div class="bg-white p-6 rounded-[16px] border border-hairline shadow-sm mb-6">
            <h2 class="text-[16px] font-semibold text-ink mb-4">Grafik Pendapatan Harian</h2>
            <div class="relative h-[300px] w-full">
                <!-- Tempat grafik akan digambar oleh Chart.js -->
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- KARTU RINGKASAN (SUMMARY) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-[16px] border border-hairline shadow-sm flex items-center justify-between border-l-4 border-l-primary">
                <div>
                    <p class="text-[14px] text-ink-mute font-medium mb-1">Total Pendapatan Tiket</p>
                    <h3 class="text-[28px] font-bold text-ink">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl">💰</div>
            </div>
            <div class="bg-white p-6 rounded-[16px] border border-hairline shadow-sm flex items-center justify-between border-l-4 border-l-primary-subdued">
                <div>
                    <p class="text-[14px] text-ink-mute font-medium mb-1">Total Tiket Terjual</p>
                    <h3 class="text-[28px] font-bold text-ink">{{ number_format($totalTiket, 0, ',', '.') }} Tiket</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-subdued/10 flex items-center justify-center text-primary-subdued text-2xl">🎟️</div>
            </div>
        </div>

        <!-- TABEL LAPORAN -->
        <div class="bg-white border border-hairline rounded-[16px] overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-canvas-soft border-b border-hairline text-[12px] font-semibold text-ink-mute uppercase">
                    <tr>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Event</th>
                        <th class="py-4 px-6 text-center">Jml Tiket</th>
                        <th class="py-4 px-6 text-right">Total Pendapatan (Rp)</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-ink divide-y divide-hairline">
                    @forelse($reports as $report)
                    <tr class="hover:bg-canvas-soft/50 transition">
                        <td class="py-4 px-6 text-ink-mute text-[13px]">{{ $report->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-4 px-6 font-medium">{{ $report->event->name ?? 'Event Terhapus' }}</td>
                        <td class="py-4 px-6 text-center tabular-numeric">{{ $report->quantity }}</td>
                        <td class="py-4 px-6 text-right font-semibold tabular-numeric">Rp {{ number_format($report->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-ink-mute">Tidak ada data pendapatan pada rentang waktu ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- SCRIPT UNTUK MENGGAMBAR GRAFIK -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data yang dikirim dari Controller
            const labels = @json($chartLabels);
            const dataValues = @json($chartValues);

            const ctx = document.getElementById('revenueChart').getContext('2d');

            new Chart(ctx, {
                type: 'line', // Jenis grafik: Garis (bisa diganti 'bar' untuk batang)
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataValues,
                        borderColor: '#696FC7', // Warna garis (Sesuai tema primary)
                        backgroundColor: 'rgba(105, 111, 199, 0.1)', // Warna area bawah garis
                        borderWidth: 3,
                        pointBackgroundColor: '#C95792',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#C95792',
                        fill: true, // Mengisi warna di bawah garis
                        tension: 0.4 // Membuat garis melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Menyembunyikan label legend di atas
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    // Format angka di tooltip (saat disentuh mouse) jadi Rupiah
                                    let value = context.parsed.y;
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    // Format angka di sumbu Y (kiri)
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
