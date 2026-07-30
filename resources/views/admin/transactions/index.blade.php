<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Menggunakan Font Sesuai Brand Guidelines -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Panggil Script Eksternal -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                <!-- Disorot karena ini halaman Transaksi -->
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Penjualan Tiket
                </a>
                <!-- MENU PENGAJUAN SPONSOR (ADMIN) -->
                <a href="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="inbox" class="w-5 h-5"></i> Pengajuan Masuk
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
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
                <!-- Disorot karena ini halaman Transaksi -->
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
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

    <!-- ── AREA KONTEN UTAMA ── -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#F8FAFC]">

        <!-- HEADER KANAN ATAS -->
        <header class="h-20 px-8 flex items-center justify-end gap-3 shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-10 no-print">
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

        <!-- Header Halaman -->
        <div class="px-8 pt-10 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Data Transaksi</h1>
                <p class="text-[14px] text-slate-500 font-medium">Pantau seluruh riwayat pembelian dan status pembayaran tiket.</p>
            </div>

            <!-- Tombol Export dengan event onclick -->
            <button onclick="exportTableToCSV('data_transaksi_artix.csv')" class="bg-white border border-slate-200 text-slate-600 hover:text-[#0066FF] hover:border-[#0066FF] hover:bg-blue-50 px-6 py-2.5 rounded-[12px] text-sm font-bold transition-all shadow-sm flex items-center gap-2 no-print">
                <i data-lucide="download" class="w-4 h-4"></i> Export Data (CSV)
            </button>
        </div>

        <div class="px-8 pb-12 relative z-10 flex-1">

            <!-- ── TABEL DATA TRANSAKSI ── -->
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="transactionTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                                <th class="px-6 py-5 w-[15%]">Order ID / Waktu</th>
                                <th class="px-6 py-5 w-[25%]">Pembeli</th>
                                <th class="px-6 py-5 w-[25%]">Event</th>
                                <th class="px-6 py-5 w-[10%] text-center">Jml Tiket</th>
                                <th class="px-6 py-5 w-[15%] text-right">Total (Rp)</th>
                                <th class="px-6 py-5 w-[10%] text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] text-slate-700">

                            @forelse($transactions as $trx)
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">

                                <!-- Order ID & Waktu -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#0066FF] text-[13px] mb-1.5 flex items-center gap-1.5">
                                        <i data-lucide="hash" class="w-3.5 h-3.5"></i>{{ $trx->order_id ?? $trx->id }}
                                    </div>
                                    <div class="text-[12px] text-slate-500 font-medium flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $trx->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>

                                <!-- Data Pembeli -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-[14px] mb-1 truncate max-w-[180px]">
                                        {{ $trx->user->name ?? 'User Terhapus' }}
                                    </div>
                                    <div class="text-[12px] text-slate-500 font-medium flex items-center gap-1.5 truncate max-w-[180px]">
                                        <i data-lucide="mail" class="w-3.5 h-3.5"></i> {{ $trx->user->email ?? '-' }}
                                    </div>
                                </td>

                                <!-- Nama Event -->
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-slate-100 border border-slate-200 text-slate-700 text-[12px] px-3 py-1.5 rounded-lg font-bold truncate max-w-[180px]">
                                        {{ $trx->event->name ?? 'Event Terhapus' }}
                                    </span>
                                </td>

                                <!-- Jumlah Tiket -->
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-slate-800 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">{{ $trx->quantity }}</span>
                                </td>

                                <!-- Total Harga -->
                                <td class="px-6 py-4 text-right">
                                    <span class="font-black text-slate-800 font-montserrat">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</span>
                                </td>

                                <!-- Status Pembayaran -->
                                <td class="px-6 py-4 text-center">
                                    @if($trx->payment_status == 'paid' || $trx->payment_status == 'success' || $trx->payment_status == 'settlement')
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Berhasil
                                        </span>
                                    @elseif($trx->payment_status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Gagal
                                        </span>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="inbox" class="w-8 h-8"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Belum Ada Transaksi</h3>
                                        <p class="text-slate-500 text-[14px] font-medium">Saat ini belum ada pengguna yang melakukan pembelian tiket.</p>
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

    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        // ── FUNGSI EXPORT KE CSV ──
        function exportTableToCSV(filename) {
            let csv = [];
            // Mengambil elemen tabel berdasarkan ID
            let table = document.getElementById("transactionTable");
            let rows = table.querySelectorAll("tr");

            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll("td, th");

                for (let j = 0; j < cols.length; j++) {
                    // Mengambil teks dalam sel, menghapus baris baru dan spasi berlebih
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                    // Mengganti tanda kutip ganda menjadi dua tanda kutip ganda agar sesuai format CSV
                    data = data.replace(/"/g, '""');
                    // Memasukkan data ke dalam baris dengan dibungkus tanda kutip
                    row.push('"' + data + '"');
                }
                // Menggabungkan setiap kolom dengan koma
                csv.push(row.join(","));
            }

            // Membuat file CSV untuk diunduh
            let csvFile = new Blob([csv.join("\n")], {type: "text/csv"});

            // Membuat elemen <a> sementara untuk memicu proses download
            let downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
</body>
</html>
