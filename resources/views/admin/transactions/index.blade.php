<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- 1. Panggil Script Eksternal -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2. Konfigurasi Tailwind (KHUSUS JAVASCRIPT) -->
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

    <!-- 3. CSS Kustom & Scrollbar (KHUSUS CSS) -->
    <style>
        body {
            font-feature-settings: "ss01" 1;
            -webkit-font-smoothing: antialiased;
        }
        .tabular-numeric {
            font-feature-settings: "tnum" 1;
        }

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
<body class="bg-canvas-soft text-ink flex h-screen overflow-hidden font-sans">

    <!-- SIDEBAR DINAMIS -->
    <aside class="w-64 bg-brand-dark flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen">

        <!-- 1. BAGIAN ATAS: LOGO (Ukurannya Tetap) -->
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/5 pt-4">
            <span class="text-white font-light text-[24px] tracking-tight">
                ARTIX <span class="font-bold text-primary-subdued">ID</span>
            </span>
        </div>

        <!-- 2. BAGIAN TENGAH: MENU (Bisa di-scroll) -->
        <nav class="p-5 space-y-2 flex-1 overflow-y-auto sidebar-scroll">
            <!-- PENGECEKAN SESUAI DATABASE: Jika role adalah 'eo' -->
            @if(Auth::user()->role == 'eo')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Dasbor Saya
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Event Saya
                </a>
                <!-- Menu ini AKTIF karena kita sedang di halaman Transaksi -->
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                    <span class="text-lg">💳</span> Penjualan Tiket
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kerjasama Sponsor
                </a>

            <!-- PENGECEKAN SESUAI DATABASE: Jika role adalah 'admin' -->
            @elseif(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📊</span> Ikhtisar Platform
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🎟️</span> Manajemen Event
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🏷️</span> Kelola Kategori
                </a>
                <!-- Menu ini AKTIF karena kita sedang di halaman Transaksi -->
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                    <span class="text-lg">💳</span> Data Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">👥</span> Kelola Pengguna
                </a>
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">🤝</span> Kelola Sponsorship
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
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

    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10">

        <!-- Latar belakang gradient -->
        <div class="absolute top-0 left-0 w-full h-[300px] bg-gradient-to-tr from-white via-primary-soft/10 to-primary-subdued/20 blur-[90px] opacity-80 z-0 pointer-events-none"></div>

        <div class="h-20 px-10 flex items-center justify-end relative z-10 shrink-0">

        </div>

        <div class="px-10 mb-8 relative z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-[32px] font-light tracking-[-0.64px] text-ink mb-1">Data Transaksi</h1>
                <p class="text-[15px] text-ink-mute font-light">Pantau seluruh riwayat pembelian dan status pembayaran tiket.</p>
            </div>

            <button class="bg-white border border-hairline text-ink hover:text-primary hover:border-primary px-5 py-2.5 rounded-full text-[13px] font-medium transition-colors shadow-sm flex items-center gap-2">
                <span class="text-lg">📥</span> Export Data
            </button>
        </div>

        <div class="px-10 pb-12 relative z-10 flex-1">

            <div class="bg-white border border-hairline rounded-[16px] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-canvas-soft border-b border-hairline text-[12px] font-semibold text-ink-mute uppercase tracking-wider">
                                <th class="py-4 px-6 w-[15%]">Order ID / Waktu</th>
                                <th class="py-4 px-6 w-[25%]">Pembeli</th>
                                <th class="py-4 px-6 w-[25%]">Event</th>
                                <th class="py-4 px-6 w-[10%] text-center">Jml Tiket</th>
                                <th class="py-4 px-6 w-[15%] text-right">Total (Rp)</th>
                                <th class="py-4 px-6 w-[10%] text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] text-ink divide-y divide-hairline">

                            @forelse($transactions as $trx)
                            <tr class="hover:bg-canvas-soft/30 transition-colors">

                                <td class="py-4 px-6">
                                    <div class="font-medium text-primary text-[13px] tabular-numeric mb-1">
                                        #{{ $trx->order_id ?? $trx->id }}
                                    </div>
                                    <div class="text-[12px] text-ink-mute">
                                        {{ $trx->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="font-medium text-[14px] text-ink mb-1 truncate max-w-[180px]">
                                        {{ $trx->user->name ?? 'User Terhapus' }}
                                    </div>
                                    <div class="text-[12px] text-ink-mute truncate max-w-[180px]">
                                        {{ $trx->user->email ?? '-' }}
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <span class="inline-block bg-canvas-soft border border-hairline text-ink-secondary text-[12px] px-3 py-1.5 rounded-md font-medium leading-snug truncate max-w-[180px]">
                                        {{ $trx->event->name ?? 'Event Terhapus' }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <span class="tabular-numeric font-medium text-ink">{{ $trx->quantity }}</span>
                                </td>

                                <td class="py-4 px-6 text-right font-medium">
                                    <span class="tabular-numeric text-ink">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</span>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @if($trx->payment_status == 'paid' || $trx->payment_status == 'success' || $trx->payment_status == 'settlement')
                                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 text-[11px] px-2.5 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Berhasil
                                        </span>
                                    @elseif($trx->payment_status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 bg-yellow-50 text-yellow-700 text-[11px] px-2.5 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-ruby/10 text-ruby text-[11px] px-2.5 py-1 rounded-full font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-ruby"></span> Gagal
                                        </span>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-canvas-soft mb-4 border border-hairline">
                                        <span class="text-2xl opacity-50">📭</span>
                                    </div>
                                    <h5 class="text-[16px] font-medium text-ink mb-1">Belum Ada Transaksi</h5>
                                    <p class="text-[14px] text-ink-mute mb-4">Belum ada pengguna yang melakukan pembelian tiket.</p>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
