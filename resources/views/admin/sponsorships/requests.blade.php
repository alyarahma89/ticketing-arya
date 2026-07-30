<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan Sponsor - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

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
                        'canvas-soft': '#F8FAFC',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Exo 2', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 10px; }
    </style>
</head>
<body class="bg-canvas-soft text-slate-800 flex h-screen overflow-hidden">

    <!-- ── SIDEBAR KIRI ── -->
    <aside class="w-64 bg-artix-navy flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen shadow-xl border-r border-white/5">
        <div class="h-20 shrink-0 flex items-center px-8 border-b border-white/10">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('main_logo.png') }}" alt="ARTIX ID Logo" class="h-10 w-auto object-contain">
                <span class="text-white font-black text-xl tracking-tight font-montserrat">ARTIX <span class="text-[#FF7A00]">ID</span></span>
            </a>
        </div>

        <nav class="p-5 space-y-1.5 flex-1 overflow-y-auto sidebar-scroll">
            <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-4 mb-2 mt-2">Menu Navigasi</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dasbor
            </a>
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                <i data-lucide="ticket" class="w-5 h-5"></i> Manajemen Event
            </a>
            <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                <i data-lucide="handshake" class="w-5 h-5"></i> Katalog Sponsor
            </a>
            <!-- Menu Pengajuan Sponsor (Aktif) -->
            <a href="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md">
                <i data-lucide="inbox" class="w-5 h-5"></i> Pengajuan Masuk
            </a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-xl text-[14px] font-medium transition-all">
                <i data-lucide="file-bar-chart-2" class="w-5 h-5"></i> Laporan Event
            </a>
        </nav>

        <div class="p-5 border-t border-white/10 shrink-0 bg-artix-navy">
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full text-left text-[13px] font-bold text-red-400 bg-red-500/10 hover:bg-red-500/20 px-4 py-3 rounded-xl transition-all flex items-center gap-3">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- ── AREA KONTEN UTAMA ── -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 w-full bg-[#F8FAFC]">
        <header class="h-20 px-8 flex items-center justify-end shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-50">
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-artix-blue flex items-center justify-center text-white text-xs font-bold uppercase">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                <div class="flex flex-col text-left">
                    <span class="text-[13px] font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-artix-blue font-bold uppercase tracking-wider">Mitra Management</span>
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-900 font-montserrat tracking-tight mb-2">Pengajuan Kemitraan Masuk</h1>
                <p class="text-[14px] text-slate-500 font-medium">Tinjau, terima, atau tolak penawaran kerja sama dari berbagai perusahaan untuk event Anda.</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                    <span class="text-[14px]">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                                <th class="px-6 py-5 w-[25%]">Data Perusahaan</th>
                                <th class="px-6 py-5 w-[25%]">Event & Paket</th>
                                <th class="px-6 py-5 w-[25%]">Pesan Spesial</th>
                                <th class="px-6 py-5 w-[10%] text-center">Status</th>
                                <th class="px-6 py-5 w-[15%] text-center">Aksi Lanjutan</th>
                            </tr>
                        </thead>
                        <tbody class="text-[14px] text-slate-700 divide-y divide-slate-100">
                            @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <!-- Data Perusahaan -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-[15px] mb-1">{{ $req->company_name }}</div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1.5 mb-1">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <a href="mailto:{{ $req->company_email }}" class="hover:text-[#0066FF] transition-colors">{{ $req->company_email }}</a>
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1.5">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                        {{ $req->company_phone }}
                                    </div>
                                </td>

                                <!-- Event & Paket -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#0066FF] text-[14px] mb-1">{{ $req->sponsorship->name }}</div>
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 bg-slate-100 inline-flex items-center gap-1 px-2 py-1 rounded-md border border-slate-200">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $req->sponsorship->event->name ?? 'Event Terhapus' }}
                                    </div>
                                </td>

                                <!-- Pesan -->
                                <td class="px-6 py-4">
                                    <p class="text-xs text-slate-500 italic line-clamp-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        "{{ $req->message ?? 'Tidak ada pesan yang dilampirkan.' }}"
                                    </p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    @if($req->status === 'pending')
                                        <span class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Menunggu</span>
                                    @elseif($req->status === 'approved')

                                        @if($req->payment_status === 'unpaid')
                                            <!-- JIKA BELUM LUNAS: Munculkan Chat WA dan Tombol Tandai Lunas -->
                                            <div class="flex flex-col gap-2 items-center justify-center">
                                                @php
                                                    $wa_number = preg_replace('/^0/', '62', $req->company_phone);
                                                    $wa_text = "Halo tim {$req->company_name}, pengajuan sponsor Anda untuk event {$req->sponsorship->event->name} telah kami terima. Mari diskusikan detail kontrak dan pembayarannya.";
                                                @endphp
                                                <a href="https://wa.me/{{ $wa_number }}?text={{ urlencode($wa_text) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-500 hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                    <i data-lucide="message-circle" class="w-4 h-4"></i> Chat WA
                                                </a>

                                                <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menandai sponsor ini sudah Lunas?');" class="w-full">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="payment_status" value="paid">
                                                    <button type="submit" class="w-full bg-[#0066FF] hover:bg-blue-700 text-white px-3 py-2 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                                        <i data-lucide="banknote" class="w-4 h-4"></i> Tandai Lunas
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- JIKA SUDAH LUNAS -->
                                            <div class="inline-flex items-center gap-1.5 bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-2 rounded-xl text-xs font-bold">
                                                <i data-lucide="check-circle-2" class="w-4 h-4"></i> Pembayaran Lunas
                                            </div>
                                        @endif

                                    @else
                                        <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-center">
                                    @if($req->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima kemitraan ini?');">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2 rounded-xl transition-all shadow-sm hover:shadow-md" title="Terima Pengajuan">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak kemitraan ini?');">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-xl transition-all shadow-sm hover:shadow-md" title="Tolak Pengajuan">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @elseif($req->status === 'approved')
                                        <!-- TOMBOL CHAT WHATSAPP OTOMATIS (MENGGANTIKAN TULISAN SELESAI) -->
                                        @php
                                            // Mengubah nomor "08..." menjadi "628..." agar format WA valid
                                            $wa_number = preg_replace('/^0/', '62', $req->company_phone);
                                            // Menyiapkan pesan otomatis
                                            $wa_text = "Halo tim {$req->company_name}, pengajuan sponsor Anda untuk event {$req->sponsorship->event->name} telah kami terima. Mari diskusikan detail kontrak dan pembayarannya.";
                                        @endphp
                                        <a href="https://wa.me/{{ $wa_number }}?text={{ urlencode($wa_text) }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-500 hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md">
                                            <i data-lucide="message-circle" class="w-4 h-4"></i> Chat WA
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 font-bold bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">- Ditolak -</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mb-4 border border-slate-100">
                                            <i data-lucide="inbox" class="w-8 h-8"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Belum Ada Pengajuan</h3>
                                        <p class="text-slate-500 text-[14px] font-medium">Belum ada perusahaan yang mengajukan kemitraan untuk event Anda.</p>
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

    <script>lucide.createIcons();</script>
</body>
</html>
