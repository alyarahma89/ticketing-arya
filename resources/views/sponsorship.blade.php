<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsorship: {{ $event->name }} | ARTIX ID</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { background: #041B4A; color: #ffffff; font-family: 'Exo 2', sans-serif; overflow-x: hidden; }

        /* Animasi Bola Cahaya (Orb) */
        @keyframes orb1 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.15) translate(30px, -20px); }
        }
        @keyframes orb2 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.1) translate(-25px, 15px); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; background: #020C1F; }
        ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }

        /* Utility Class untuk Teks Bergradien */
        .text-gradient-main {
            background: linear-gradient(135deg,#ffffff 0%,#b8d4ff 60%,#00C2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-orange {
            background: linear-gradient(135deg,#FF7A00,#FF3B30);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-blue {
            background: linear-gradient(135deg,#0066FF,#00C2FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen relative">

    <!-- Latar Belakang Estetik (Sama dengan Tampilan Awal) -->
    <div class="fixed inset-0 pointer-events-none z-0" style="background: radial-gradient(ellipse 90% 70% at 50% -10%, #0A2A6E 0%, #041B4A 65%);">
        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(0,102,255,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(0,102,255,0.07) 1px, transparent 1px); background-size: 56px 56px;"></div>
        <div class="absolute rounded-full pointer-events-none" style="width: 520px; height: 520px; top: -10%; left: -5%; background: #0066FF; opacity: 0.12; filter: blur(100px); animation: orb1 7s ease-in-out infinite;"></div>
        <div class="absolute rounded-full pointer-events-none" style="width: 400px; height: 400px; bottom: 10%; right: -5%; background: #A100FF; opacity: 0.1; filter: blur(90px); animation: orb2 9s ease-in-out infinite 1.5s;"></div>
    </div>


    <!-- Header Sederhana -->
    <nav class="relative z-50 w-full p-6 lg:px-10 flex items-center justify-between border-b transition-all duration-300" style="background: rgba(4,27,74,0.8); backdrop-filter: blur(16px); border-color: rgba(255,255,255,0.05);">

        <!-- Bagian Logo yang Sudah Diganti dengan Gambar -->
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('main_logo.png') }}" alt="ARTIX ID Logo" class="h-8 md:h-10 object-contain" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
        </a>

        <a href="{{ url('/#packages') }}" class="text-sm font-bold transition-all text-white/70 hover:text-[#00C2FF] flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Katalog
        </a>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Info Event Singkat -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest border mb-6" style="background: #0066FF18; border-color: #0066FF45; color: #00C2FF;">
                    <i data-lucide="handshake" class="w-3 h-3"></i> PAKET SPONSOR RESMI
                </div>
                <h1 class="font-black text-4xl md:text-5xl text-white mb-6" style="font-family: 'Montserrat', sans-serif;">
                    Sponsorship <br> <span class="text-gradient-blue">{{ $event->name }}</span>
                </h1>
                <p class="text-lg text-white/50 max-w-2xl mx-auto leading-relaxed">
                    Dukung event ini dan jadikan brand kamu bagian dari kesuksesan {{ $event->name }}. Pilih paket yang sesuai dengan strategi marketing kamu.
                </p>
            </div>

            <!-- Daftar Paket Sponsor -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($event->sponsorships as $sponsor)
                <!-- Kartu Sponsor dengan Efek Hover Menyala -->
                <div class="p-8 rounded-3xl border transition-all duration-300 flex flex-col group cursor-default"
                     style="background: rgba(255,255,255,0.025); border-color: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.borderColor='#0066FF55'; this.style.boxShadow='0 8px 40px rgba(0,102,255,0.35)'; this.style.transform='translateY(-8px)';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.boxShadow='none'; this.style.transform='translateY(0)';">

                    <h3 class="font-black text-white text-2xl mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $sponsor->name }}</h3>

                    <div class="font-black text-4xl text-gradient-blue my-4" style="font-family: 'Montserrat', sans-serif;">
                        Rp {{ number_format($sponsor->price, 0, ',', '.') }}
                    </div>

                    <!-- Indikator Kuota -->
                    <div class="mb-6 p-4 rounded-2xl border flex items-center justify-between" style="background: rgba(0,102,255,0.05); border-color: rgba(0,102,255,0.2);">
                        <span class="text-[11px] font-bold text-white/60 uppercase tracking-widest">Sisa Slot</span>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-[#00C2FF]" style="background: rgba(0,102,255,0.2); border: 1px solid rgba(0,102,255,0.4);">
                            {{ $sponsor->quota }} Tersedia
                        </span>
                    </div>

                    <div class="text-sm text-white/70 flex-1 whitespace-pre-line leading-relaxed mb-8">
                        <strong class="text-white block mb-2 font-['Montserrat']">Benefit yang didapat:</strong>
                        {{ $sponsor->benefits }}
                    </div>

                    @if($sponsor->quota > 0)
                        <!-- Link Pembelian -->
                        <a href="https://wa.me/6282160762279?text=Halo%20ARTIX%20ID,%20saya%20tertarik%20mengambil%20paket%20sponsorship%20*{{ urlencode($sponsor->name) }}*%20untuk%20event%20*{{ urlencode($event->name) }}*." target="_blank" class="w-full text-center px-4 py-4 text-sm font-bold text-white rounded-xl transition-all group-hover:scale-[1.02]" style="background: linear-gradient(135deg, #0066FF, #00C2FF); box-shadow: 0 5px 20px rgba(0,102,255,0.4);">
                            Ajukan Sponsor
                        </a>
                    @else
                        <!-- Tombol Habis -->
                        <button disabled class="w-full text-center px-4 py-4 text-sm font-bold text-white/40 border rounded-xl" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                            Slot Habis
                        </button>
                    @endif
                </div>
                @empty
                <!-- Tampilan Kosong Jika Belum Ada Paket Sponsor -->
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-24 rounded-3xl border border-dashed transition-all" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.1);">
                    <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-4" style="background: rgba(0,102,255,0.1); color: #00C2FF;">
                        <i data-lucide="folder-open" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-bold text-white text-xl font-['Montserrat']">Belum Ada Paket</h3>
                    <p class="text-white/50 mt-2">Panitia belum menambahkan paket sponsor untuk event ini.</p>
                </div>
                @endforelse

            </div>
        </div>
    </main>

    <!-- Footer Sangat Sederhana -->
    <footer class="py-8 border-t text-center relative z-10" style="background: #020C1F; border-color: rgba(255,255,255,0.05);">
        <p class="text-xs font-medium text-white/30 tracking-wide">© {{ date('Y') }} ARTIX ID. Platform Sponsorship & Ticketing.</p>
    </footer>

    <!-- Render Ikon -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
