<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
            <!-- MENU UMUM: BISA DIAKSES ADMIN & EO -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                <span class="text-lg">📊</span> Ikhtisar Platform
            </a>

            <!-- Menu ini disorot (aktif) karena kita sedang di halaman Manajemen Event -->
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 text-white rounded-xl text-[14px] font-medium transition-all shadow-sm">
                <span class="text-lg">🎟️</span> Manajemen Event
            </a>

            <!-- MENU KHUSUS: HANYA MUNCUL JIKA ROLE = EO -->
            @if(Auth::user()->role === 'eo')
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                    <span class="text-lg">📈</span> Laporan Event Saya
                </a>
            @endif

            <!-- MENU KHUSUS: HANYA MUNCUL JIKA ROLE = ADMIN -->
            @if(Auth::user()->role === 'admin')
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
                <!-- Perbaikan desain difokuskan pada class button di bawah ini -->
                <button type="submit" class="w-full text-left text-[13px] font-medium text-red-300 bg-red-500/10 hover:bg-red-500/25 border border-red-500/20 px-4 py-2.5 rounded-xl transition-all flex items-center gap-3 shadow-sm">
                    <span class="text-lg">🚪</span> Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#f4f7fb]">

        <!-- Header Halaman -->
        <div class="px-8 pt-10 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-normal text-ink mb-1">
                    {{ Auth::user()->role == 'eo' ? 'Event Saya' : 'Manajemen Event' }}
                </h1>
                <p class="text-[14px] text-ink-mute">Kelola semua daftar acara, jadwal, dan ketersediaan tiket.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.events.create') }}" class="bg-brand-dark hover:bg-ink text-white px-5 py-2 rounded-full text-[14px] font-medium transition-colors shadow-md flex items-center gap-2">
                    <span>➕</span> Tambah Event Baru
                </a>
            </div>
        </div>

        <div class="px-8 pb-12">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                    <span class="text-xl">✅</span>
                    <span class="text-[14px] font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabel Data -->
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[12px] uppercase tracking-wider text-ink-mute">
                                <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                                <th class="px-6 py-4 font-semibold">Detail Event</th>
                                <th class="px-6 py-4 font-semibold">Kategori</th>
                                <th class="px-6 py-4 font-semibold">Pelaksanaan</th>
                                <th class="px-6 py-4 font-semibold">Harga & Kuota</th>
                                <th class="px-6 py-4 font-semibold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px]">
                            @forelse($events as $index => $event)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <!-- Nomor -->
                                <td class="px-6 py-4 text-center text-ink-mute font-medium">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama Event & Poster -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-ink text-[15px] mb-1">{{ $event->name }}</div>
                                    <div class="flex items-center gap-1.5 text-[12px] text-ink-mute">
                                        <span class="text-gray-400 pr-2 border-r border-gray-200 truncate max-w-[150px]">📍 {{ $event->location }}</span>
                                        @if($event->image)
                                            <span class="text-emerald-600 flex items-center gap-1"><span class="text-[10px]">🖼️</span> Ada Poster</span>
                                        @else
                                            <span class="text-red-400 flex items-center gap-1"><span class="text-[10px]">📄</span> Tanpa Poster</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="px-6 py-4">
                                    <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 px-3 py-1 rounded-md text-[12px] font-semibold inline-block">
                                        {{ $event->category->name ?? 'Umum' }}
                                    </span>
                                </td>

                                <!-- Tanggal & Jam -->
                                <td class="px-6 py-4">
                                    <div class="text-ink font-medium">{{ date('d M Y', strtotime($event->event_date)) }}</div>
                                    <div class="text-ink-mute text-[12px] flex items-center gap-1 mt-0.5">
                                        ⏱️ {{ date('H:i', strtotime($event->event_date)) }} WIB
                                    </div>
                                </td>

                                <!-- Harga & Kuota -->
                                <td class="px-6 py-4">
                                    <div>
                                        @if($event->price == 0)
                                            <span class="text-emerald-500 font-bold">Gratis</span>
                                        @else
                                            <span class="text-ink font-bold">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <div class="text-ink-mute text-[12px] mt-0.5">
                                        Sisa Kuota: <strong class="text-ink">{{ $event->quota }}</strong>
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-primary hover:text-brand-dark transition-colors" title="Edit Data">
                                            <!-- Icon Edit SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Data yang terhapus tidak dapat dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus Data">
                                                <!-- Icon Trash SVG -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">🎟️</span>
                                        <h3 class="text-lg font-bold text-ink mb-1">Belum Ada Event</h3>
                                        <p class="text-ink-mute text-[14px] mb-4">Anda belum menambahkan data acara apa pun.</p>
                                        <a href="{{ route('admin.events.create') }}" class="bg-primary hover:bg-brand-dark text-white px-5 py-2.5 rounded-xl text-[13px] font-medium transition-colors shadow-sm">
                                            + Tambah Event Sekarang
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

</body>
</html>
