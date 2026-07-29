<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Menggunakan Font Sesuai Brand Guidelines -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

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
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Exo 2', sans-serif; }

        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-track { background: transparent; }
        textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        textarea::-webkit-scrollbar-thumb:hover { background: #0066FF; }

        /* Memperbaiki tampilan icon kalender bawaan browser pada input datetime */
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            transition: 0.2s;
        }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        /* Utility Class untuk Teks Bergradien */
        .text-gradient-orange {
            background: linear-gradient(135deg, #FF7A00, #FF3B30);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- ── HEADER (Deep Navy) ── -->
    <header class="h-20 bg-artix-navy border-b border-white/10 flex items-center justify-between px-8 sticky top-0 z-50 shadow-md">
        <div class="flex items-center w-1/4">
            <a href="{{ route('admin.events.index') }}" class="text-white/70 hover:text-white flex items-center gap-2 text-sm font-bold transition-all duration-200 group">
                <i data-lucide="arrow-left" class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform"></i> Kembali
            </a>
        </div>

        <div class="flex items-center justify-center w-2/4">
            <!-- LOGO MAIN & TEKS -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('main_logo.png') }}" alt="ARTIX ID Logo" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-300" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.4)); clip-path: inset(2px);">
                <span class="text-white font-black text-xl tracking-tight font-montserrat group-hover:opacity-90 transition-opacity">
                    ARTIX <span class="text-gradient-orange">ID</span>
                </span>
            </a>
        </div>

        <div class="flex items-center justify-end w-1/4">
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10 shadow-inner">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[11px] font-bold text-white tracking-widest uppercase">Event Editor</span>
            </div>
        </div>
    </header>

    <!-- ── HERO SECTION ── -->
    <div class="bg-artix-navy text-white py-12 px-8 relative overflow-hidden">
        <!-- Ambient Glow Background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#0066FF] rounded-full blur-[120px] opacity-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-64 h-64 bg-[#A100FF] rounded-full blur-[100px] opacity-20 pointer-events-none"></div>

        <div class="max-w-6xl w-full mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4 relative z-10">
            <div>
                <span class="text-[#00C2FF] font-bold text-xs uppercase tracking-widest bg-[#0066FF]/20 px-3 py-1.5 rounded-full border border-[#0066FF]/30">Edit Data Acara</span>
                <h1 class="text-4xl font-black tracking-tight font-montserrat mt-4 mb-2">{{ $event->name }}</h1>
                <p class="text-[15px] text-white/60 font-medium max-w-xl">Perbarui informasi event, harga tiket, kuota, atau poster promosi di bawah ini.</p>
            </div>
            <div class="text-right hidden md:block">
                <i data-lucide="edit-3" class="w-24 h-24 text-white/5 opacity-50 transform -rotate-12"></i>
            </div>
        </div>
    </div>

    <!-- ── MAIN FORM AREA ── -->
    <main class="flex-1 max-w-6xl w-full mx-auto py-10 px-6 -mt-8 relative z-20">

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-5 rounded-2xl mb-6 text-sm flex gap-3 items-start shadow-sm font-medium">
                    <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5 text-red-500"></i>
                    <div>
                        <span class="font-bold block mb-1 text-red-700">Gagal memperbarui event:</span>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ── KOLOM KIRI (Detail Utama Event) ── -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-8 space-y-6 relative overflow-hidden">
                        <!-- Hiasan Garis Atas -->
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

                        <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                            <div class="p-1.5 bg-blue-50 text-[#0066FF] rounded-lg"><i data-lucide="file-text" class="w-5 h-5"></i></div>
                            Informasi Dasar Event
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Nama Resmi Event</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="type" class="w-5 h-5"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required placeholder="Contoh: Artix Music Festival 2026"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kategori / Klaster</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="layout-grid" class="w-5 h-5"></i></span>
                                    <select name="category_id" id="category-select" required class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 appearance-none cursor-pointer">
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400"><i data-lucide="chevron-down" class="w-4 h-4"></i></span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Waktu Pelaksanaan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="calendar-clock" class="w-5 h-5"></i></span>
                                    <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date', date('Y-m-d\TH:i', strtotime($event->event_date))) }}" required
                                        class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 cursor-text">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Lokasi / Venue</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="map-pin" class="w-5 h-5"></i></span>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required placeholder="Contoh: Gelora Bung Karno, Jakarta"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Deskripsi Lengkap Acara</label>
                            <textarea name="description" id="description" rows="5" required placeholder="Jelaskan detail acara, rundown, syarat dan ketentuan tiket..."
                                class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-medium rounded-[12px] px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:text-slate-400">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- HIDDEN YOUTUBE FIELD (Aksen Merah) -->
                        <div id="online-options" class="hidden animate-[fadeIn_0.3s_ease-in-out]">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest flex items-center gap-1.5"><i data-lucide="youtube" class="w-4 h-4"></i> Link Livestream YouTube</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30]/60"><i data-lucide="link" class="w-5 h-5"></i></span>
                                <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $event->youtube_link) }}" placeholder="https://youtube.com/live/..."
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200 placeholder:font-medium placeholder:text-red-300">
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block">*Kolom ini muncul khusus untuk kategori hybrid/online (Live Concert, Workshop, dll).</span>
                        </div>
                    </div>
                </div>

                <!-- ── KOLOM KANAN (Harga, Kuota & Poster) ── -->
                <div class="space-y-6">

                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-6 relative overflow-hidden">
                        <!-- Hiasan Garis Atas -->
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#FF7A00] to-[#FF3B30]"></div>

                        <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                            <div class="p-1.5 bg-orange-50 text-[#FF7A00] rounded-lg"><i data-lucide="ticket" class="w-5 h-5"></i></div>
                            Tiket & Kapasitas
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Harga Tiket Offline</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#0066FF] font-black text-sm">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" required min="0" placeholder="0"
                                    class="w-full bg-blue-50 focus:bg-white border border-blue-200 focus:border-[#0066FF] text-[#0066FF] text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200">
                            </div>
                        </div>

                        <!-- HIDDEN ONLINE PRICE FIELD -->
                        <div id="online-price-wrapper" class="hidden animate-[fadeIn_0.3s_ease-in-out]">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest">Harga Tiket Online</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30] font-black text-sm">Rp</span>
                                <input type="number" name="online_price" id="online_price" value="{{ old('online_price', $event->online_price) }}" min="0" placeholder="0"
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-[#FF3B30] text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kuota Maksimal (Tiket)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="users" class="w-5 h-5"></i></span>
                                <input type="number" name="quota" id="quota" value="{{ old('quota', $event->quota) }}" required min="1" placeholder="Contoh: 500"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                        <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                            <div class="p-1.5 bg-purple-50 text-[#A100FF] rounded-lg"><i data-lucide="image" class="w-4 h-4"></i></div>
                            Poster Promosi
                        </h2>

                        <div class="relative group aspect-[4/5] w-full max-w-[220px] mx-auto rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center shadow-inner transition-colors hover:border-[#0066FF]/50">

                            <!-- Placeholder: Sembunyikan jika gambar sudah ada -->
                            <div class="text-center p-4 transition-opacity duration-200 {{ $event->image ? 'hidden' : '' }}" id="placeholder-box">
                                <i data-lucide="upload-cloud" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <span class="text-[#0066FF] text-xs font-bold block">Unggah Baru</span>
                                <span class="text-slate-400 text-[10px] font-medium block mt-1">Rasio Potret (4:5)</span>
                            </div>

                            <!-- Menampilkan gambar lama jika ada -->
                            <img id="badge-preview" src="{{ $event->image ? asset('storage/' . $event->image) : '' }}" class="w-full h-full object-cover {{ $event->image ? '' : 'hidden' }} transition-transform duration-300 group-hover:scale-105">

                            <!-- Hover Overlay -->
                            <div id="hover-overlay" class="absolute inset-0 bg-[#041B4A]/70 opacity-0 group-hover:opacity-100 transition-opacity hidden items-center justify-center backdrop-blur-sm {{ $event->image ? '!flex' : '' }}">
                                <span class="text-white text-xs font-bold bg-[#0066FF] px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Ganti Poster</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-medium text-slate-400 block mb-2 text-center">Biarkan kosong jika tidak ingin mengubah poster</span>
                            <input type="file" name="image" id="badge-input" accept="image/*"
                                class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── ACTION BAR BAWAH ── -->
            <div class="mt-8 bg-white border border-slate-200 rounded-[24px] p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-40">
                <span class="text-[13px] text-slate-500 font-medium flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-[#0066FF]"></i> Pastikan untuk memeriksa ulang data sebelum menyimpan perubahan.
                </span>
                <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                    <a href="{{ route('admin.events.index') }}" class="text-sm text-slate-500 hover:text-slate-800 font-bold px-6 py-3.5 transition-colors rounded-[12px] hover:bg-slate-100 border border-transparent w-full sm:w-auto text-center">Batal</a>
                    <button type="submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        Simpan Perubahan <i data-lucide="save" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Inisialisasi ikon Lucide
        lucide.createIcons();

        // --- SCRIPT 1: Preview Poster/Image ---
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
                            hoverOverlay.classList.add('!flex');
                        }
                        badgePreview.classList.remove('hidden');
                        badgePreview.setAttribute('src', this.result);
                    });
                    reader.readAsDataURL(file);
                } else {
                    // Jika user membatalkan pilihan file baru, kembali ke file lama jika ada
                    const oldImage = "{{ $event->image ? asset('storage/' . $event->image) : '' }}";
                    if(oldImage) {
                        badgePreview.setAttribute('src', oldImage);
                    } else {
                        badgePreview.classList.add('hidden');
                        if(placeholderBox) placeholderBox.classList.remove('hidden');
                        if(hoverOverlay) {
                            hoverOverlay.classList.remove('!flex');
                            hoverOverlay.classList.add('hidden');
                        }
                        badgePreview.removeAttribute('src');
                    }
                }
            });
        }

        // --- SCRIPT 2: Logika Form Hybrid (YouTube & Harga Online) ---
        const categorySelect = document.getElementById('category-select');
        const onlineOptions = document.getElementById('online-options');
        const onlinePriceWrapper = document.getElementById('online-price-wrapper');

        const hybridCategories = ['LIVE CONCERT', 'WORKSHOP', 'STAND UP COMEDY'];

        function toggleOnlineFields() {
            if(categorySelect.selectedIndex >= 0) {
                // Ambil teks dari opsi yang dipilih
                const selectedText = categorySelect.options[categorySelect.selectedIndex].text.trim().toUpperCase();

                if (hybridCategories.includes(selectedText)) {
                    // Tampilkan kolom
                    onlineOptions.classList.remove('hidden');
                    onlinePriceWrapper.classList.remove('hidden');
                } else {
                    // Sembunyikan kolom (Tidak mereset value saat diedit agar data lama tidak terhapus tak sengaja)
                    onlineOptions.classList.add('hidden');
                    onlinePriceWrapper.classList.add('hidden');
                }
            }
        }

        // Jalankan pengecekan saat pertama kali halaman dimuat
        toggleOnlineFields();

        // Jalankan pengecekan setiap kali pilihan dropdown berubah
        categorySelect.addEventListener('change', toggleOnlineFields);
    </script>
</body>
</html>
