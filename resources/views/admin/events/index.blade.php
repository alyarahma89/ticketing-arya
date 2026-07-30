<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event - ARTIX ID</title>
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
                <!-- Disorot karena ini halaman Manajemen Event -->
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="ticket" class="w-5 h-5"></i> Event Saya
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Penjualan Tiket
                </a>
                <!-- MENU PENGAJUAN SPONSOR (EO) -->
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
                <!-- Disorot karena ini halaman Manajemen Event -->
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
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
                <!-- MENU PENGAJUAN SPONSOR (ADMIN) -->
                <a href="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <i data-lucide="inbox" class="w-5 h-5"></i> Pengajuan Masuk
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
                <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">
                    {{ Auth::user()->role == 'eo' ? 'Event Saya' : 'Manajemen Event' }}
                </h1>
                <p class="text-[14px] text-slate-500 font-medium">Kelola semua daftar acara, jadwal, dan ketersediaan tiket.</p>
            </div>
            <div class="flex items-center gap-4 no-print">
                <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Event Baru
                </a>
            </div>
        </div>

        <div class="px-8 pb-12">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                    <span class="text-[14px]">{{ session('success') }}</span>
                </div>
            @endif

            <!-- ── TABEL DATA ── -->
            <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                                <th class="px-6 py-5 text-center w-16">No</th>
                                <th class="px-6 py-5">Detail Event</th>
                                <th class="px-6 py-5">Kategori</th>
                                <th class="px-6 py-5">Pelaksanaan</th>
                                <th class="px-6 py-5">Harga & Kuota</th>
                                <th class="px-6 py-5 text-center w-32 no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] text-slate-700">
                            @forelse($events as $index => $event)
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                <!-- Nomor -->
                                <td class="px-6 py-4 text-center text-slate-400 font-bold">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama Event & Poster -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-[15px] mb-1.5">{{ $event->name }}</div>
                                    <div class="flex items-center gap-2 text-[12px] text-slate-500 font-medium">
                                        <span class="flex items-center gap-1 pr-2 border-r border-slate-200 truncate max-w-[150px]" title="{{ $event->location }}">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i> {{ $event->location }}
                                        </span>
                                        @if($event->image)
                                            <span class="text-emerald-600 flex items-center gap-1 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                <i data-lucide="image" class="w-3.5 h-3.5"></i> Ada Poster
                                            </span>
                                        @else
                                            <span class="text-slate-400 flex items-center gap-1 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                                <i data-lucide="image-off" class="w-3.5 h-3.5"></i> Tanpa Poster
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1 rounded-lg text-xs font-bold inline-block uppercase tracking-wider">
                                        {{ $event->category->name ?? 'Umum' }}
                                    </span>
                                </td>

                                <!-- Tanggal & Jam -->
                                <td class="px-6 py-4">
                                    <div class="text-slate-800 font-bold">{{ date('d M Y', strtotime($event->event_date)) }}</div>
                                    <div class="text-slate-500 text-[12px] flex items-center gap-1.5 mt-1 font-medium">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ date('H:i', strtotime($event->event_date)) }} WIB
                                    </div>
                                </td>

                                <!-- Harga & Kuota -->
                                <td class="px-6 py-4">
                                    <div class="mb-1">
                                        @if($event->price == 0)
                                            <span class="text-emerald-500 font-black text-[15px]">Gratis</span>
                                        @else
                                            <span class="text-[#0066FF] font-black text-[15px] font-montserrat">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <div class="text-slate-500 text-[12px] font-medium flex items-center gap-1.5">
                                        <i data-lucide="users" class="w-3.5 h-3.5"></i> Sisa Kuota: <strong class="text-slate-800">{{ $event->quota }}</strong>
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="px-6 py-4 no-print">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-slate-400 hover:text-[#0066FF] transition-colors p-1.5 hover:bg-blue-50 rounded-lg" title="Edit Data">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Data yang terhapus tidak dapat dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-[#FF3B30] transition-colors p-1.5 hover:bg-red-50 rounded-lg" title="Hapus Data">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="ticket" class="w-8 h-8"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Belum Ada Event</h3>
                                        <p class="text-slate-500 text-[14px] mb-6 font-medium">Anda belum menambahkan data acara apa pun ke dalam sistem.</p>
                                        <a href="{{ route('admin.events.create') }}" class="bg-[#0066FF] hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-blue-500/20 flex items-center gap-2">
                                            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Event Sekarang
                                        </a>
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
    </script>
</body>
</html>
