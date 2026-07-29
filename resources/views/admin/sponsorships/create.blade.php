<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Paket Sponsor - ARTIX ID</title>

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

        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-track { background: transparent; }
        textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        textarea::-webkit-scrollbar-thumb:hover { background: #0066FF; }

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
    </style>
</head>
<body class="bg-canvas-soft text-slate-800 flex h-screen overflow-hidden">

    <!-- ── SIDEBAR KIRI (Deep Navy) ── -->
    <aside class="w-64 bg-artix-navy flex flex-col hidden lg:flex relative z-20 shrink-0 h-screen shadow-xl border-r border-white/5">

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

                <!-- Disorot karena ini bagian dari Sponsorship (EO) -->
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
                    <i data-lucide="handshake" class="w-5 h-5"></i> Kerjasama Sponsor
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

                <!-- Disorot karena ini bagian dari Sponsorship (Admin) -->
                <a href="{{ route('admin.sponsorships.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0066FF] text-white rounded-xl text-[14px] font-bold transition-all shadow-md shadow-blue-500/20">
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
        <header class="h-20 px-8 flex items-center justify-end gap-3 shrink-0 bg-white/50 backdrop-blur-md border-b border-slate-200/50 sticky top-0 z-50">
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-artix-blue flex items-center justify-center text-white text-xs font-bold uppercase shadow-inner">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[13px] font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] text-artix-blue font-bold uppercase tracking-wider">Sponsor Creator</span>
                </div>
            </div>
        </header>

        <!-- ── HERO SECTION (Clean UI Tanpa Blok Gelap) ── -->
        <div class="pt-10 pb-6 px-8 relative">
            <div class="max-w-6xl w-full mx-auto relative z-10">
                <!-- Tombol Kembali Minimalis -->
                <a href="{{ route('admin.sponsorships.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] transition-colors group mb-6 w-max">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Daftar Sponsor
                </a>

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div>
                        <span class="text-[#0066FF] font-bold text-xs uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100 inline-block mb-3">Kemitraan Komersial</span>
                        <h1 class="text-3xl font-black tracking-tight font-montserrat text-slate-900 mb-2">Buat Paket Sponsor Baru</h1>
                        <p class="text-[14px] text-slate-500 font-medium max-w-xl">Rancang instrumen pendanaan, buat penawaran, dan tetapkan benefit sponsor untuk ditawarkan kepada brand dan mitra korporat.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── MAIN FORM AREA ── -->
        <div class="flex-1 max-w-6xl w-full mx-auto pb-10 px-6 relative z-20">

            <form action="{{ route('admin.sponsorships.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ALERT ERROR -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 p-5 rounded-2xl mb-6 text-sm flex gap-3 items-start shadow-sm font-medium">
                        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5 text-red-500"></i>
                        <div>
                            <span class="font-bold block mb-1 text-red-700">Gagal mendaftarkan paket sponsor:</span>
                            <ul class="list-disc list-inside space-y-0.5 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">

                    <!-- ── KOLOM KIRI (Informasi Kemitraan Utama) ── -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-8 space-y-6 relative overflow-hidden">
                            <!-- Hiasan Garis Atas (Blue ke Cyan) -->
                            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

                            <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                                <div class="p-1.5 bg-blue-50 text-[#0066FF] rounded-lg"><i data-lucide="award" class="w-5 h-5"></i></div>
                                Detail Informasi Kemitraan
                            </h2>

                            <!-- Field: Event -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Hubungkan ke Event / Acara</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="calendar-check" class="w-5 h-5"></i></span>
                                    <select name="event_id" required class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 appearance-none cursor-pointer">
                                        <option value="" disabled {{ old('event_id') ? '' : 'selected' }}>-- Pilih Event yang membutuhkan sponsor --</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                                {{ $event->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400"><i data-lucide="chevron-down" class="w-4 h-4"></i></span>
                                </div>
                            </div>

                            <!-- Field: Nama Paket -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Nama Paket Kemitraan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="bookmark" class="w-5 h-5"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Platinum Sponsor Tier"
                                        class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                                </div>
                            </div>

                            <!-- Field: Benefit -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Klausa Benefit / Keuntungan Kontraprestasi</label>
                                <textarea name="benefits" rows="6" required placeholder="Contoh: Eksklusivitas logo di panggung utama, Space booth ukuran 4x4 meter, Penyebutan ad-lips oleh MC disetiap sesi..."
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-medium rounded-[12px] px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:text-slate-400">{{ old('benefits') }}</textarea>
                                <div class="flex items-center gap-1.5 mt-2 text-slate-500 font-medium">
                                    <i data-lucide="info" class="w-3.5 h-3.5 text-[#0066FF]"></i>
                                    <span class="text-[11px]">Gunakan tanda koma (,) sebagai pemisah poin benefit agar otomatis terpecah menjadi daftar list di halaman penawaran.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── KOLOM KANAN (Harga, Kuota & Poster) ── -->
                    <div class="space-y-6">

                        <!-- Card: Nilai Finansial -->
                        <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-6 relative overflow-hidden">
                            <!-- Hiasan Garis Atas (Orange ke Red) -->
                            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#FF7A00] to-[#FF3B30]"></div>

                            <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                                <div class="p-1.5 bg-orange-50 text-[#FF7A00] rounded-lg"><i data-lucide="banknote" class="w-5 h-5"></i></div>
                                Nilai Kontrak Finansial
                            </h2>

                            <!-- Field: Harga Valuasi -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Harga Valuasi Paket</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-600 font-black text-sm">Rp</span>
                                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="Contoh: 15000000"
                                        class="w-full bg-emerald-50 focus:bg-white border border-emerald-200 focus:border-emerald-500 text-emerald-700 text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all duration-200">
                                </div>
                            </div>

                            <!-- Field: Kuota -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Batas Maksimal Kuota (Slot)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="users" class="w-5 h-5"></i></span>
                                    <input type="number" name="quota" value="{{ old('quota', 1) }}" required min="1"
                                        class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200">
                                </div>
                                <span class="text-[11px] text-slate-500 font-medium mt-2 block leading-relaxed">Jumlah korporat maksimal yang diizinkan untuk menandatangani paket komitmen investasi ini.</span>
                            </div>
                        </div>

                        <!-- Card: Ilustrasi / Badge -->
                        <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                            <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                                <div class="p-1.5 bg-purple-50 text-[#A100FF] rounded-lg"><i data-lucide="image" class="w-4 h-4"></i></div>
                                Ilustrasi / Badge <span class="text-[11px] font-medium text-slate-400 font-exo">(Opsional)</span>
                            </h2>

                            <div class="relative group aspect-square w-full max-w-[220px] mx-auto rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center shadow-inner transition-colors hover:border-[#0066FF]/50">
                                <div class="text-center p-4 transition-opacity duration-200" id="placeholder-box">
                                    <i data-lucide="shield-plus" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <span class="text-[#0066FF] text-xs font-bold block">Unggah Gambar</span>
                                    <span class="text-slate-400 text-[10px] font-medium block mt-1">Rasio Kotak (1:1)</span>
                                </div>
                                <img id="badge-preview" class="w-full h-full object-cover hidden transition-transform duration-300 group-hover:scale-105">
                                <div id="hover-overlay" class="absolute inset-0 bg-[#041B4A]/70 opacity-0 group-hover:opacity-100 transition-opacity hidden items-center justify-center backdrop-blur-sm">
                                    <span class="text-white text-xs font-bold bg-[#0066FF] px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Ganti Gambar</span>
                                </div>
                            </div>

                            <div>
                                <input type="file" name="image" id="badge-input" accept="image/*"
                                    class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── ACTION BAR BAWAH ── -->
                <div class="mt-8 bg-white border border-slate-200 rounded-[24px] p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-40">
                    <span class="text-[13px] text-slate-500 font-medium flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-[#0066FF]"></i> Paket sponsor yang diterbitkan akan otomatis terdistribusi di katalog eksternal.
                    </span>
                    <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                        <a href="{{ route('admin.sponsorships.index') }}" class="text-sm text-slate-500 hover:text-slate-800 font-bold px-6 py-3.5 transition-colors rounded-[12px] hover:bg-slate-100 border border-transparent w-full sm:w-auto text-center">Batal</a>
                        <button type="submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                            Daftarkan Paket Sponsor <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        // --- Logika Preview Gambar / Badge ---
        const badgeInput = document.getElementById('badge-input');
        const badgePreview = document.getElementById('badge-preview');
        const placeholderBox = document.getElementById('placeholder-box');
        const hoverOverlay = document.getElementById('hover-overlay');

        if(badgeInput) {
            badgeInput.addEventListener('change', function() {
                const file = this.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.addEventListener('load', function() {
                        if(placeholderBox) placeholderBox.classList.add('hidden');
                        if(hoverOverlay) {
                            hoverOverlay.classList.remove('hidden');
                            hoverOverlay.classList.add('flex');
                        }
                        badgePreview.classList.remove('hidden');
                        badgePreview.setAttribute('src', this.result);
                    });
                    reader.readAsDataURL(file);
                } else {
                    badgePreview.classList.add('hidden');
                    if(placeholderBox) placeholderBox.classList.remove('hidden');
                    if(hoverOverlay) {
                        hoverOverlay.classList.add('hidden');
                        hoverOverlay.classList.remove('flex');
                    }
                    badgePreview.removeAttribute('src');
                }
            });
        }
    </script>
</body>
</html>
