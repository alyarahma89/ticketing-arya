<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        primary: '#696FC7',
                        'primary-deep': '#3D365C',
                        'primary-press': '#7C4585',
                        'primary-soft': '#C95792',
                        'primary-subdued': '#F8B55F',
                        'brand-dark': '#1c1e54',
                        ink: '#0d253d',
                        'ink-secondary': '#273951',
                        'ink-mute': '#64748d',
                        canvas: '#ffffff',
                        'canvas-soft': '#f0f4f8',
                        hairline: '#e3e8ee',
                        ruby: '#ea2261',
                    },
                    boxShadow: {
                        'level-1': '0 4px 20px rgba(28, 30, 84, 0.04), 0 1px 3px rgba(28, 30, 84, 0.02)',
                        'level-2': '0 20px 40px rgba(28, 30, 84, 0.08), 0 1px 10px rgba(28, 30, 84, 0.03)',
                    }
                }
            }
        }
    </script>
    <style>
        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-track { background: transparent; }
        textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        textarea::-webkit-scrollbar-thumb:hover { background: #696FC7; }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            transition: 0.2s;
        }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-canvas-soft text-ink font-sans antialiased min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="h-20 bg-brand-dark border-b border-white/10 flex items-center justify-between px-8 sticky top-0 z-50 shadow-md">
        <div class="flex items-center w-1/4">
            <a href="{{ route('admin.events.index') }}" class="text-white/70 hover:text-white flex items-center gap-2 text-[14px] font-semibold transition-all duration-200 group">
                <span class="transform group-hover:-translate-x-1 transition-transform">&larr;</span> Kembali
            </a>
        </div>

        <div class="flex items-center justify-center gap-1.5 w-2/4">
            <span class="font-syne font-extrabold text-[22px] tracking-tight text-white block">ARTIX</span>
            <span class="font-syne font-extrabold text-[22px] tracking-tight text-primary-subdued block">ID</span>
        </div>

        <div class="flex items-center justify-end w-1/4">
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10">
                <span class="w-2 h-2 rounded-full bg-primary-subdued animate-pulse"></span>
                <span class="text-[11px] font-bold text-white tracking-wide uppercase">Event Editor</span>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <div class="bg-gradient-to-r from-brand-dark via-primary-deep to-primary text-white py-12 px-8 shadow-inner">
        <div class="max-w-6xl w-full mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="text-primary-subdued font-bold text-xs uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full border border-white/10">Edit Data Acara</span>
                <h1 class="text-[36px] font-bold tracking-tight font-syne mt-2">{{ $event->name }}</h1>
                <p class="text-[14px] text-white/70 font-light mt-1">Perbarui informasi event, harga tiket, kuota, atau poster promosi di bawah ini.</p>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-[28px] opacity-20 font-syne font-black tracking-wider">ARTIX ID EVENTS</span>
            </div>
        </div>
    </div>

    <!-- MAIN FORM AREA -->
    <main class="flex-1 max-w-6xl w-full mx-auto py-10 px-6 -mt-8">

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="bg-ruby/10 border border-ruby/20 text-ruby p-4 rounded-xl mb-6 text-[14px] flex gap-3 items-start shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill text-[18px] mt-0.5"></i>
                    <div>
                        <span class="font-bold block mb-1">Gagal memperbarui event:</span>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI (Detail Utama Event) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-hairline rounded-[24px] shadow-level-1 p-8 space-y-6 relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-primary to-primary-soft"></div>

                        <h2 class="text-[18px] font-bold text-brand-dark border-b border-hairline pb-3 flex items-center gap-2">
                            <i class="bi bi-card-text text-primary"></i> Informasi Dasar Event
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Nama Resmi Event</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-type"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required
                                    class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Kategori / Klaster</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-grid-fill"></i></span>
                                    <select name="category_id" id="category-select" required class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 appearance-none cursor-pointer">
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-ink-mute/50"><i class="bi bi-chevron-down text-xs"></i></span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Waktu Pelaksanaan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60 pointer-events-none"><i class="bi bi-clock-fill"></i></span>
                                    <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date', date('Y-m-d\TH:i', strtotime($event->event_date))) }}" required
                                        class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 cursor-text">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Lokasi / Venue</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required
                                    class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Deskripsi Lengkap Acara</label>
                            <textarea name="description" id="description" rows="5" required
                                class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] rounded-xl px-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 shadow-inner">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- HIDDEN YOUTUBE FIELD -->
                        <div id="online-options" class="hidden animate-[fadeIn_0.3s_ease-in-out]">
                            <label class="block text-[11px] font-bold text-ruby mb-2 uppercase tracking-wider flex items-center gap-1.5"><i class="bi bi-youtube"></i> Link Livestream YouTube</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-ruby/60"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $event->youtube_link) }}" placeholder="https://youtube.com/live/..."
                                    class="w-full bg-ruby/5 focus:bg-white border border-ruby/20 focus:border-ruby text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-ruby/10 transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (Harga, Kuota & Poster) -->
                <div class="space-y-6">

                    <div class="bg-white border border-hairline rounded-[24px] shadow-level-1 p-6 space-y-5 relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-primary-soft to-primary-subdued"></div>

                        <h2 class="text-[18px] font-bold text-brand-dark border-b border-hairline pb-3 flex items-center gap-2">
                            <i class="bi bi-ticket-perforated text-primary"></i> Tiket & Kapasitas
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Harga Tiket Offline</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-600 font-bold text-[14px]">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" required min="0"
                                    class="w-full bg-emerald-500/5 focus:bg-white border border-emerald-500/20 focus:border-emerald-500 text-emerald-700 text-[16px] font-bold rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 transition-all duration-200">
                            </div>
                        </div>

                        <!-- HIDDEN ONLINE PRICE FIELD -->
                        <div id="online-price-wrapper" class="hidden animate-[fadeIn_0.3s_ease-in-out]">
                            <label class="block text-[11px] font-bold text-blue-600 mb-2 uppercase tracking-wider">Harga Tiket Online / Live</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-blue-600 font-bold text-[14px]">Rp</span>
                                <input type="number" name="online_price" id="online_price" value="{{ old('online_price', $event->online_price) }}" min="0"
                                    class="w-full bg-blue-500/5 focus:bg-white border border-blue-500/20 focus:border-blue-500 text-blue-700 text-[16px] font-bold rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Kuota Maksimal (Tiket)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-indigo-600/70"><i class="bi bi-people-fill"></i></span>
                                <input type="number" name="quota" id="quota" value="{{ old('quota', $event->quota) }}" required min="1"
                                    class="w-full bg-indigo-500/5 focus:bg-white border border-indigo-500/20 focus:border-indigo-500 text-indigo-700 text-[16px] font-bold rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-b from-white to-primary/5 border border-hairline rounded-[24px] shadow-level-1 p-6 space-y-4">
                        <h2 class="text-[16px] font-bold text-brand-dark flex items-center gap-2">
                            <i class="bi bi-image text-primary"></i> Poster Promosi
                        </h2>

                        <div class="relative group aspect-[4/5] w-full max-w-[220px] mx-auto rounded-2xl bg-canvas-soft border-2 border-dashed border-primary/20 overflow-hidden flex items-center justify-center shadow-inner">

                            <!-- Placeholder: Sembunyikan jika gambar sudah ada -->
                            <div class="text-center p-4 transition-opacity duration-200 {{ $event->image ? 'hidden' : '' }}" id="placeholder-box">
                                <i class="bi bi-cloud-arrow-up text-[36px] text-primary block mb-1 animate-pulse"></i>
                                <span class="text-primary text-[12px] font-bold block">Unggah Baru</span>
                                <span class="text-ink-mute text-[10px] block mt-0.5">Rasio Potret (4:5)</span>
                            </div>

                            <!-- Menampilkan gambar lama jika ada -->
                            <img id="badge-preview" src="{{ $event->image ? asset('storage/' . $event->image) : '' }}" class="w-full h-full object-cover {{ $event->image ? '' : 'hidden' }} transition-transform duration-300 group-hover:scale-105">

                            <div id="hover-overlay" class="absolute inset-0 bg-brand-dark/60 opacity-0 group-hover:opacity-100 transition-opacity hidden items-center justify-center {{ $event->image ? '!flex' : '' }}">
                                <span class="text-white text-[11px] font-semibold bg-primary px-3 py-1.5 rounded-full shadow-md"><i class="bi bi-arrow-repeat mr-1"></i> Ganti Poster</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] text-ink-mute block mb-2 text-center">Biarkan kosong jika tidak ingin mengubah poster</span>
                            <input type="file" name="image" id="badge-input" accept="image/*"
                                class="w-full text-xs text-ink-mute file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[11px] file:font-bold file:bg-primary file:text-white hover:file:bg-primary-press transition-all cursor-pointer border border-hairline rounded-lg p-1.5 bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTION BAR BAWAH -->
            <div class="mt-8 bg-brand-dark border border-white/10 rounded-[24px] p-6 shadow-level-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-[13px] text-white/70 font-medium flex items-center gap-1.5">
                    <i class="bi bi-info-circle-fill text-primary-subdued"></i> Pastikan untuk memeriksa ulang data sebelum menyimpan perubahan.
                </span>
                <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                    <a href="{{ route('admin.events.index') }}" class="text-[14px] text-white/70 hover:text-white font-bold px-5 py-3 transition-colors rounded-full hover:bg-white/5 text-center w-full sm:w-auto">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-primary-press text-white px-8 py-3.5 rounded-full text-[14px] font-bold transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        <i class="bi bi-save-fill"></i> Simpan Perubahan Event
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
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
