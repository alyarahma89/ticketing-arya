<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ikhtisar Platform - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- 1. Panggil Script Eksternal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 2. Konfigurasi Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], },
                    colors: {
                        primary: '#696FC7',
                        'primary-deep': '#3D365C',
                        'primary-soft': '#C95792',
                        'primary-subdued': '#F8B55F',
                        'brand-dark': '#1c1e54',
                        ink: '#0d253d',
                        'ink-mute': '#64748d',
                        'canvas-soft': '#f8fafc',
                    }
                }
            }
        }
    </script>

    <!-- 3. CSS Kustom & Scrollbar -->
    <style>
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="bg-canvas-soft text-ink flex h-screen overflow-hidden font-sans">

    <!-- SIDEBAR KIRI (Hanya Logo & Menu Navigasi Penuh yang Bisa Di-scroll) -->
    <aside class="w-64 bg-brand-dark flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen">

        <!-- LOGO -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/5 pt-4">
            <span class="text-white font-light text-[24px] tracking-tight">
                ARTIX <span class="font-bold text-primary-subdued">ID</span>
            </span>
        </div>

        <!-- MENU NAVIGASI (Bisa di-scroll ke bawah untuk melihat menu Laporan) -->
        <nav class="p-5 space-y-2 flex-1 overflow-y-auto sidebar-scroll">

            <!-- MENU EO -->
            @if(Auth::user()->role == 'eo')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
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
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📈</span> Laporan Event Saya
                </a>

            <!-- MENU ADMIN UTAMA -->
            @elseif(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                    <span class="text-lg">📊</span> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Manajemen Event
                </a>
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
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📑</span> Laporan Keseluruhan
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

    <!-- KONTEN UTAMA DI KANAN -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#f4f7fb]">

        <!-- HEADER KANAN ATAS (Warna disamakan persis dengan main content) -->
        <header class="h-20 px-8 bg-[#f4f7fb] flex items-center justify-end gap-3 shrink-0">

            <!-- Kotak Identitas Pengguna -->
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-gray-200 shadow-sm">
                <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold uppercase">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[13px] font-semibold text-ink leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] text-primary font-bold uppercase tracking-wider">{{ Auth::user()->role == 'eo' ? 'Event Organizer' : 'Platform Admin' }}</span>
                </div>
            </div>

        </header>

        <!-- ISI KONTEN DASHBOARD -->
        <div class="px-8 pt-8 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-normal text-ink mb-1">Ikhtisar Platform</h1>
                <p class="text-[14px] text-ink-mute">Ringkasan performa sistem secara keseluruhan.</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[13px] text-ink-mute bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">Periode: <span class="font-bold text-ink">Tahun 2026</span></span>
                <a href="{{ route('admin.events.create') }}" class="bg-brand-dark hover:bg-ink text-white px-5 py-2 rounded-full text-[14px] font-medium transition-colors shadow-md">
                    + Tambah Event
                </a>
            </div>
        </div>

        <div class="px-8 pb-12">

            <!-- ALERT -->
            @if(Auth::user()->role === 'admin')
                <div class="mb-6 p-4 bg-blue-50 text-blue-700 rounded-xl border border-blue-200">
                    <strong>Halo Admin!</strong> Anda melihat data keseluruhan platform.
                </div>
            @else
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200">
                    <strong>Halo EO!</strong> Anda hanya melihat data statistik dari event milik Anda sendiri.
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-28 relative">
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-semibold text-gray-400 tracking-wider">OMSET TIKET</span>
                        <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-bold px-2 py-0.5 rounded">Sistem</span>
                    </div>
                    <div>
                        <span class="text-[20px] font-bold text-ink">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-28 relative">
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-semibold text-gray-400 tracking-wider">DANA SPONSOR</span>
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-bold px-2 py-0.5 rounded">Platform</span>
                    </div>
                    <div>
                        <span class="text-[20px] font-bold text-ink">Rp {{ number_format($pendapatanSponsor ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-28 relative">
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-semibold text-gray-400 tracking-wider">TIKET TERJUAL</span>
                        <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-bold px-2 py-0.5 rounded">Paid</span>
                    </div>
                    <div>
                        <span class="text-[20px] font-bold text-ink">{{ $tiketTerjual ?? 0 }} <span class="text-[13px] font-normal text-gray-400">Lembar</span></span>
                    </div>
                </div>

                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-28 relative">
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-semibold text-gray-400 tracking-wider">EVENT AKTIF</span>
                        <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-bold px-2 py-0.5 rounded">Katalog</span>
                    </div>
                    <div>
                        <span class="text-[20px] font-bold text-ink">{{ $eventAktif ?? 0 }} <span class="text-[13px] font-normal text-gray-400">Acara</span></span>
                    </div>
                </div>

                <div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-28 relative">
                    <div class="flex justify-between items-start">
                        <span class="text-[11px] font-semibold text-gray-400 tracking-wider">TOTAL PENGGUNA</span>
                        <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-bold px-2 py-0.5 rounded">Terdaftar</span>
                    </div>
                    <div>
                        <span class="text-[20px] font-bold text-ink">{{ $totalPengguna ?? 0 }} <span class="text-[13px] font-normal text-gray-400">Akun</span></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-[24px] p-6 shadow-sm border border-gray-100">
                    <h3 class="text-[16px] font-bold text-ink mb-6">Statistik Keuangan Bulanan (Juta Rp)</h3>
                    <div class="relative w-full h-72">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col items-center">
                    <h3 class="text-[16px] font-bold text-ink mb-4 w-full text-left">Proporsi Kategori</h3>
                    <div class="relative w-full h-60 flex items-center justify-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- SCRIPT GRAFIK CHART.JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            let salesDataValues = @json($salesData);

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: salesDataValues,
                        borderColor: '#696FC7',
                        backgroundColor: 'rgba(105, 111, 199, 0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#696FC7',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#6b7280' } },
                        x: { ticks: { color: '#6b7280' }, grid: { display: false } }
                    }
                }
            });

            const catCtx = document.getElementById('categoryChart').getContext('2d');
            let rawCategoryData = @json($categoryData);

            if (!rawCategoryData || Object.keys(rawCategoryData).length === 0) {
                rawCategoryData = {'Belum ada transaksi': 1};
            }

            const catLabels = Object.keys(rawCategoryData);
            const catValues = Object.values(rawCategoryData);
            const bgColors = Object.keys(rawCategoryData)[0] === 'Belum ada transaksi'
                             ? ['#e2e8f0']
                             : ['#696FC7', '#C95792', '#F8B55F', '#1c1e54', '#3b82f6'];

            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catValues,
                        backgroundColor: bgColors,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        });
    </script>
</body>
</html>
