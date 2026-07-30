<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <!-- Tailwind CSS & Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
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
    <style>
        body { font-family: 'Exo 2', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 6px; }
        html.light ::-webkit-scrollbar { background: #F1F5F9; }
        html.light ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        html.dark ::-webkit-scrollbar { background: #020C1F; }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white min-h-screen flex flex-col">

    <!-- ── NAVBAR ── -->
    <nav class="bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10 fixed top-0 inset-x-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center shrink-0">
                <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID" class="h-8 block dark:hidden">
                <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID" class="h-8 hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="text-sm font-bold text-slate-500 hover:text-[#0066FF] dark:text-white/60 dark:hover:text-white transition-colors flex items-center gap-2">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <!-- Toggle Dark Mode -->
                <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-slate-200 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none shadow-inner">
                    <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- ── KONTEN UTAMA ── -->
    <main class="flex-grow max-w-5xl mx-auto w-full px-6 pt-32 pb-16">

        <div class="mb-10 text-center md:text-left">
            <h1 class="font-black text-3xl md:text-4xl font-montserrat text-slate-900 dark:text-white mb-2">
                Riwayat Pesanan
            </h1>
            <p class="text-base font-medium text-slate-500 dark:text-white/60">
                Pantau pembelian tiket event dan status pengajuan kemitraan Anda.
            </p>
        </div>

        <!-- ── SISTEM TAB ── -->
        <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] shadow-sm overflow-hidden">

            <!-- Header Tab Navigasi -->
            <div class="flex border-b border-slate-200 dark:border-white/10">
                <button onclick="switchTab('tiket')" id="tab-tiket" class="flex-1 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2 text-[#0066FF] border-[#0066FF] dark:text-[#00C2FF] dark:border-[#00C2FF]">
                    <i data-lucide="ticket" class="w-4 h-4"></i> Tiket Saya
                </button>
                <button onclick="switchTab('sponsor')" id="tab-sponsor" class="flex-1 py-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-white/50 dark:hover:text-white transition-all flex items-center justify-center gap-2">
                    <i data-lucide="handshake" class="w-4 h-4"></i> Pengajuan Sponsor
                </button>
            </div>

            <!-- ── TAB KONTEN 1: TIKET SAYA ── -->
            <div id="content-tiket" class="p-6 md:p-8 block">
                @if(count($ticketTransactions) > 0)
                    <div class="space-y-6">
                        @foreach($ticketTransactions as $ticket)
                        <div class="border border-slate-200 dark:border-white/10 rounded-2xl p-5 flex flex-col md:flex-row gap-5 items-start md:items-center hover:bg-slate-50 dark:hover:bg-white/5 transition-colors relative overflow-hidden">
                            <!-- Garis Status -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ in_array($ticket->payment_status, ['paid', 'success', 'settlement']) ? 'bg-[#0066FF]' : 'bg-orange-500' }}"></div>

                            <div class="flex-grow pl-2">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-white/40">ID: #{{ $ticket->order_id }}</span>
                                    @if(in_array($ticket->payment_status, ['paid', 'success', 'settlement']))
                                        <span class="bg-blue-50 text-[#0066FF] dark:bg-[#0066FF20] dark:text-[#00C2FF] px-2 py-0.5 rounded text-[10px] font-bold uppercase">Lunas</span>
                                    @else
                                        <span class="bg-orange-50 text-orange-600 dark:bg-[#FF7A0020] dark:text-[#FFB000] px-2 py-0.5 rounded text-[10px] font-bold uppercase">Menunggu Pembayaran</span>
                                    @endif
                                </div>
                                <h3 class="font-black text-lg font-montserrat text-slate-800 dark:text-white">{{ $ticket->event->name ?? 'Event Terhapus' }}</h3>
                                <p class="text-sm font-medium text-slate-500 dark:text-white/60 flex items-center gap-1.5 mt-1">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> Dibeli pada {{ $ticket->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div class="flex flex-col items-start md:items-end w-full md:w-auto shrink-0 gap-3 border-t md:border-t-0 md:border-l border-slate-100 dark:border-white/10 pt-4 md:pt-0 md:pl-6">
                                <div class="text-left md:text-right">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Harga</p>
                                    <p class="font-black text-xl text-slate-800 dark:text-white">Rp {{ number_format($ticket->total_amount, 0, ',', '.') }}</p>
                                    <p class="text-xs font-bold text-slate-500 dark:text-white/50">{{ $ticket->quantity }} Tiket</p>
                                </div>

                                @if(in_array($ticket->payment_status, ['paid', 'success', 'settlement']))
                                    <a href="{{ route('ticket.download', $ticket->id) }}" class="w-full md:w-auto text-center bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/20 text-slate-700 dark:text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2">
                                        <i data-lucide="download" class="w-4 h-4"></i> Unduh E-Ticket
                                    </a>
                                @else
                                    <button onclick="alert('Silakan cek email Anda untuk instruksi pembayaran lebih lanjut.')" class="w-full md:w-auto text-center bg-gradient-to-r from-[#FF7A00] to-[#FF3B30] text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md transition-all hover:scale-[1.02]">
                                        Bayar Sekarang
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <i data-lucide="ticket" class="w-16 h-16 text-slate-300 dark:text-white/20 mx-auto mb-4"></i>
                        <h3 class="text-lg font-black text-slate-800 font-montserrat mb-1 dark:text-white">Belum Ada Tiket</h3>
                        <p class="text-sm text-slate-500 font-medium dark:text-white/50 mb-6">Anda belum pernah melakukan pembelian tiket event.</p>
                        <a href="{{ url('/') }}#event-list" class="inline-block bg-gradient-to-r from-[#0066FF] to-[#00C2FF] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-md transition-all hover:scale-[1.02]">Cari Event Sekarang</a>
                    </div>
                @endif
            </div>

            <!-- ── TAB KONTEN 2: PENGAJUAN SPONSOR ── -->
            <div id="content-sponsor" class="p-6 md:p-8 hidden">
                @if(count($sponsorshipTransactions) > 0)
                    <div class="space-y-6">
                        @foreach($sponsorshipTransactions as $sponsor)
                        <div class="border border-slate-200 dark:border-white/10 rounded-2xl p-5 flex flex-col md:flex-row gap-5 items-start md:items-center hover:bg-slate-50 dark:hover:bg-white/5 transition-colors relative overflow-hidden">
                            <!-- Garis Status -->
                            @php
                                $statusColor = 'bg-orange-500';
                                if($sponsor->status == 'approved') $statusColor = 'bg-emerald-500';
                                if($sponsor->status == 'rejected') $statusColor = 'bg-red-500';
                            @endphp
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $statusColor }}"></div>

                            <div class="flex-grow pl-2">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-white/40">Tanggal Pengajuan: {{ $sponsor->created_at->format('d M Y') }}</span>
                                </div>
                                <h3 class="font-black text-lg font-montserrat text-slate-800 dark:text-white mb-0.5">{{ $sponsor->sponsorship->name ?? 'Paket Terhapus' }}</h3>
                                <p class="text-sm font-bold text-[#0066FF] dark:text-[#00C2FF] flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> Event: {{ $sponsor->sponsorship->event->name ?? '-' }}
                                </p>
                            </div>

                            <div class="flex flex-col items-start md:items-end w-full md:w-auto shrink-0 gap-3 border-t md:border-t-0 md:border-l border-slate-100 dark:border-white/10 pt-4 md:pt-0 md:pl-6 min-w-[180px]">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest text-left md:text-right w-full">Status Kemitraan</p>

                                @if($sponsor->status === 'pending')
                                    <div class="bg-amber-50 border border-amber-200 text-amber-700 dark:bg-[#FFB00020] dark:border-[#FFB00030] dark:text-[#FFB000] px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 w-full md:w-auto justify-center">
                                        <i data-lucide="clock" class="w-4 h-4"></i> Sedang Ditinjau EO
                                    </div>
                                @elseif($sponsor->status === 'approved')
                                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-500/20 dark:border-emerald-500/30 dark:text-emerald-400 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 w-full md:w-auto justify-center">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i> Pengajuan Diterima
                                    </div>
                                @else
                                    <div class="bg-red-50 border border-red-200 text-red-700 dark:bg-red-500/20 dark:border-red-500/30 dark:text-red-400 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 w-full md:w-auto justify-center">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i> Pengajuan Ditolak
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <i data-lucide="handshake" class="w-16 h-16 text-slate-300 dark:text-white/20 mx-auto mb-4"></i>
                        <h3 class="text-lg font-black text-slate-800 font-montserrat mb-1 dark:text-white">Belum Ada Pengajuan</h3>
                        <p class="text-sm text-slate-500 font-medium dark:text-white/50 mb-6">Perusahaan Anda belum melakukan pengajuan sponsorship event apa pun.</p>
                        <a href="{{ url('/') }}#packages" class="inline-block bg-white dark:bg-white/10 border border-slate-300 dark:border-white/20 text-slate-700 dark:text-white px-6 py-3 rounded-xl text-sm font-bold shadow-sm transition-all hover:bg-slate-50 dark:hover:bg-white/20">Lihat Katalog Sponsor</a>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- SCRIPT LOGIKA TAB & DARK MODE -->
    <script>
        lucide.createIcons();

        // Logika Perpindahan Tab
        function switchTab(tabName) {
            const contentTiket = document.getElementById('content-tiket');
            const contentSponsor = document.getElementById('content-sponsor');
            const tabTiket = document.getElementById('tab-tiket');
            const tabSponsor = document.getElementById('tab-sponsor');

            // Reset semua style ke default tidak aktif
            tabTiket.className = "flex-1 py-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-white/50 dark:hover:text-white transition-all flex items-center justify-center gap-2";
            tabSponsor.className = "flex-1 py-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-white/50 dark:hover:text-white transition-all flex items-center justify-center gap-2";

            if(tabName === 'tiket') {
                contentTiket.classList.remove('hidden');
                contentSponsor.classList.add('hidden');
                // Set Tab Tiket Aktif
                tabTiket.className = "flex-1 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2 text-[#0066FF] border-[#0066FF] dark:text-[#00C2FF] dark:border-[#00C2FF]";
            } else {
                contentTiket.classList.add('hidden');
                contentSponsor.classList.remove('hidden');
                // Set Tab Sponsor Aktif
                tabSponsor.className = "flex-1 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2 text-[#A100FF] border-[#A100FF] dark:text-[#c5a3ff] dark:border-[#c5a3ff]";
            }
        }

        // Logika Dark Mode
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            lucide.createIcons();
        });
    </script>
</body>
</html>
