<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Tambah Event Baru')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')

    <!-- ── HERO SECTION (Clean UI) ── -->
    <div class="pt-10 pb-6 px-8 relative">
        <div class="max-w-6xl w-full mx-auto relative z-10">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] transition-colors group mb-6 w-max">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Daftar Event
            </a>

            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <span class="text-[#0066FF] font-bold text-xs uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100 inline-block mb-3">Manajemen Acara</span>
                    <h1 class="text-3xl font-black tracking-tight font-montserrat text-slate-900 mb-2">Tambah Event Baru</h1>
                    <p class="text-[14px] text-slate-500 font-medium max-w-xl">Publikasikan informasi event, atur ketersediaan tiket, dan kelola rincian acara secara real-time ke dalam ekosistem ARTIX.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── MAIN FORM AREA ── -->
    <div class="flex-1 max-w-6xl w-full mx-auto pb-10 px-6 relative z-20">

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-5 rounded-2xl mb-6 text-sm flex gap-3 items-start shadow-sm font-medium">
                    <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5 text-red-500"></i>
                    <div>
                        <span class="font-bold block mb-1 text-red-700">Gagal menerbitkan event:</span>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">

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
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Artix Music Festival 2026"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kategori / Klaster</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="layout-grid" class="w-5 h-5"></i></span>
                                    <select name="category_id" required class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 appearance-none cursor-pointer">
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                                        class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 cursor-text">
                                </div>
                            </div>
                        </div>

                        <!-- ── PILIHAN CHECKBOX TIPE EVENT ── -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-3 uppercase tracking-widest">Tipe Penyelenggaraan (Pilih salah satu atau keduanya)</label>
                            <div class="flex flex-col sm:flex-row gap-4 p-4 border border-slate-200 rounded-[12px] bg-slate-50/50">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" id="check_offline" name="is_offline" value="1" class="w-5 h-5 text-[#0066FF] rounded border-slate-300 focus:ring-[#0066FF]" checked>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-[#0066FF] transition-colors">Offline (Di Tempat)</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" id="check_online" name="is_online" value="1" class="w-5 h-5 text-[#FF3B30] rounded border-slate-300 focus:ring-[#FF3B30]">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-[#FF3B30] transition-colors">Online (Livestreaming)</span>
                                </label>
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block" id="type-error-msg" style="display:none; color:#FF3B30;">*Anda harus memilih minimal satu tipe penyelenggaraan.</span>
                        </div>

                        <!-- LOKASI OFFLINE -->
                        <div id="offline-venue-wrapper" class="transition-all duration-300">
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Lokasi / Venue</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="map-pin" class="w-5 h-5"></i></span>
                                <input type="text" name="location" id="location" value="{{ old('location') }}" required placeholder="Contoh: Gelora Bung Karno, Jakarta"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- DESKRIPSI -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Deskripsi Lengkap Acara</label>
                            <textarea name="description" id="description" rows="5" required placeholder="Jelaskan detail acara, rundown, syarat dan ketentuan tiket..."
                                class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-medium rounded-[12px] px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:text-slate-400">{{ old('description') }}</textarea>
                        </div>

                        <!-- LINK YOUTUBE ONLINE -->
                        <div id="online-options" class="hidden transition-all duration-300">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest flex items-center gap-1.5"><i data-lucide="youtube" class="w-4 h-4"></i> Link Livestream YouTube</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30]/60"><i data-lucide="link" class="w-5 h-5"></i></span>
                                <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link') }}" placeholder="https://youtube.com/live/..."
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200 placeholder:font-medium placeholder:text-red-300">
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block">*Kolom ini muncul karena Anda mencentang opsi penyelenggaraan Online.</span>
                        </div>

                        <!-- ── FIELD BARU: KODE RAHASIA PANITIA ── -->
                        <div class="border-t border-slate-100 pt-6 mt-6">
                            <label class="block text-[11px] font-bold text-[#A100FF] mb-2 uppercase tracking-widest flex items-center gap-1.5">
                                <i data-lucide="key" class="w-4 h-4"></i> Kode Rahasia Rekrutmen Panitia
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-purple-400"><i data-lucide="lock" class="w-5 h-5"></i></span>
                                <input type="text" name="secret_code" value="{{ old('secret_code') }}" placeholder="Contoh: PANITIA_ARTIX_2026"
                                    class="w-full bg-purple-50 focus:bg-white border border-purple-200 focus:border-[#A100FF] text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#A100FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-purple-300">
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block leading-relaxed">
                                *Opsional. Berikan kode unik ini kepada calon panitia/staff Anda agar mereka bisa mendaftar secara mandiri dan otomatis terhubung sebagai panitia di event ini.
                            </span>
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

                        <!-- HARGA OFFLINE -->
                        <div id="offline-price-wrapper" class="transition-all duration-300">
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Harga Tiket Offline</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#0066FF] font-black text-sm">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', 0) }}" required min="0" placeholder="0"
                                    class="w-full bg-blue-50 focus:bg-white border border-blue-200 focus:border-[#0066FF] text-[#0066FF] text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200">
                            </div>
                        </div>

                        <!-- HARGA ONLINE -->
                        <div id="online-price-wrapper" class="hidden transition-all duration-300">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest">Harga Tiket Online</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30] font-black text-sm">Rp</span>
                                <input type="number" name="online_price" id="online_price" value="{{ old('online_price', 0) }}" min="0" placeholder="0"
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-[#FF3B30] text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kuota Maksimal (Tiket)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="users" class="w-5 h-5"></i></span>
                                <input type="number" name="quota" id="quota" value="{{ old('quota') }}" required min="1" placeholder="Contoh: 500"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                        <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                            <div class="p-1.5 bg-purple-50 text-[#A100FF] rounded-lg"><i data-lucide="image" class="w-4 h-4"></i></div>
                            Poster Promosi <span class="text-[11px] font-medium text-slate-400 font-exo">(Opsional)</span>
                        </h2>

                        <div class="relative group aspect-[4/5] w-full max-w-[220px] mx-auto rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center shadow-inner transition-colors hover:border-[#0066FF]/50">
                            <div class="text-center p-4 transition-opacity duration-200" id="placeholder-box">
                                <i data-lucide="upload-cloud" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                <span class="text-[#0066FF] text-xs font-bold block">Unggah Poster</span>
                                <span class="text-slate-400 text-[10px] font-medium block mt-1">Rasio Potret (4:5)</span>
                            </div>
                            <img id="badge-preview" class="w-full h-full object-cover hidden transition-transform duration-300 group-hover:scale-105">
                            <div id="hover-overlay" class="absolute inset-0 bg-[#041B4A]/70 opacity-0 group-hover:opacity-100 transition-opacity hidden items-center justify-center backdrop-blur-sm">
                                <span class="text-white text-xs font-bold bg-[#0066FF] px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Ganti Poster</span>
                            </div>
                        </div>

                        <div>
                            <input type="file" name="image" id="badge-input" accept="image/*"
                                class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                        </div>
                    </div>

                    <!-- KOTAK TAMBAHAN: GALERI FOTO -->
                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                        <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                            <div class="p-1.5 bg-blue-50 text-[#0066FF] rounded-lg"><i data-lucide="images" class="w-4 h-4"></i></div>
                            Galeri Tambahan
                        </h2>
                        <p class="text-[11px] font-medium text-slate-500 mb-2 leading-relaxed">
                            Unggah beberapa foto sekaligus untuk ditampilkan sebagai carousel di halaman detail.
                        </p>

                        <div id="gallery-preview-container" class="grid grid-cols-3 gap-3 mb-2 empty:hidden">
                        </div>

                        <div>
                            <input type="file" name="galleries[]" id="gallery-input" accept="image/*" multiple
                                class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── ACTION BAR BAWAH ── -->
            <div class="mt-8 bg-white border border-slate-200 rounded-[24px] p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-40">
                <span class="text-[13px] text-slate-500 font-medium flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-[#0066FF]"></i> Pastikan semua informasi acara sudah valid sebelum diterbitkan.
                </span>
                <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                    <a href="{{ route('admin.events.index') }}" class="text-sm text-slate-500 hover:text-slate-800 font-bold px-6 py-3.5 transition-colors rounded-[12px] hover:bg-slate-100 border border-transparent w-full sm:w-auto text-center">Batal</a>
                    <button type="submit" id="btn-submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        Publikasikan Event <i data-lucide="rocket" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

<!-- ── MEMASUKKAN SCRIPT KHUSUS HALAMAN INI ── -->
@push('scripts')
<script>
    // --- SCRIPT 1: Preview Poster ---
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

    // --- SCRIPT 2: Preview Galeri Foto ---
    const galleryInput = document.getElementById('gallery-input');
    const galleryPreviewContainer = document.getElementById('gallery-preview-container');

    if(galleryInput) {
        galleryInput.addEventListener('change', function() {
            galleryPreviewContainer.innerHTML = '';
            const files = this.files;

            if(files && files.length > 0) {
                galleryPreviewContainer.classList.remove('empty:hidden');
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.addEventListener('load', function() {
                        const imgBox = document.createElement('div');
                        imgBox.className = 'aspect-square rounded-xl overflow-hidden border border-slate-200 shadow-sm relative group';
                        const img = document.createElement('img');
                        img.src = this.result;
                        img.className = 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-110';
                        imgBox.appendChild(img);
                        galleryPreviewContainer.appendChild(imgBox);
                    });
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // --- SCRIPT 3: LOGIKA CHECKBOX TIPE EVENT ---
    const checkOffline = document.getElementById('check_offline');
    const checkOnline = document.getElementById('check_online');
    const offlineVenueWrapper = document.getElementById('offline-venue-wrapper');
    const offlinePriceWrapper = document.getElementById('offline-price-wrapper');
    const onlineLinkWrapper = document.getElementById('online-options');
    const onlinePriceWrapper = document.getElementById('online-price-wrapper');
    const btnSubmit = document.getElementById('btn-submit');
    const errorMsg = document.getElementById('type-error-msg');

    function toggleEventTypes() {
        if (!checkOffline.checked && !checkOnline.checked) {
            errorMsg.style.display = 'block';
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            errorMsg.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        if (checkOffline.checked) {
            offlineVenueWrapper.classList.remove('hidden');
            offlinePriceWrapper.classList.remove('hidden');
            document.getElementById('location').required = true;
            document.getElementById('price').required = true;
        } else {
            offlineVenueWrapper.classList.add('hidden');
            offlinePriceWrapper.classList.add('hidden');
            document.getElementById('location').required = false;
            document.getElementById('location').value = '';
            document.getElementById('price').required = false;
            document.getElementById('price').value = 0;
        }

        if (checkOnline.checked) {
            onlineLinkWrapper.classList.remove('hidden');
            onlinePriceWrapper.classList.remove('hidden');
            document.getElementById('youtube_link').required = true;
            document.getElementById('online_price').required = true;
        } else {
            onlineLinkWrapper.classList.add('hidden');
            onlinePriceWrapper.classList.add('hidden');
            document.getElementById('youtube_link').required = false;
            document.getElementById('youtube_link').value = '';
            document.getElementById('online_price').required = false;
            document.getElementById('online_price').value = 0;
        }
    }

    checkOffline.addEventListener('change', toggleEventTypes);
    checkOnline.addEventListener('change', toggleEventTypes);
    toggleEventTypes();
</script>
@endpush
