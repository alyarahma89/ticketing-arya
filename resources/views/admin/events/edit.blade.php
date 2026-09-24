@extends('layouts.admin')

@section('title', 'Edit Event')

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
                    <h1 class="text-3xl font-black tracking-tight font-montserrat text-slate-900 mb-2 flex items-center gap-3">
                        Modifikasi Data Acara
                        <span class="text-[12px] font-bold font-exo text-[#0066FF] bg-blue-50 px-3 py-1 border border-blue-200 rounded-lg shadow-sm">
                            ID: #{{ $event->id }}
                        </span>
                    </h1>
                    <p class="text-[14px] text-slate-500 font-medium max-w-xl">Perbarui informasi event, harga tiket, kuota, atau poster promosi di bawah ini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── MAIN FORM AREA ── -->
    <div class="flex-1 max-w-6xl w-full mx-auto pb-10 px-6 relative z-20">

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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">

                <!-- ── KOLOM KIRI (Detail Utama Event) ── -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-8 space-y-6 relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

                        <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                            <div class="p-1.5 bg-blue-50 text-[#0066FF] rounded-lg"><i data-lucide="file-text" class="w-5 h-5"></i></div>
                            Informasi Dasar Event
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Nama Resmi Event</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="type" class="w-5 h-5"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required placeholder="Contoh: Ticks Music Festival 2026"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Kategori / Klaster</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="layout-grid" class="w-5 h-5"></i></span>
                                    <select name="category_id" required class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 appearance-none cursor-pointer">
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

                        <!-- ── PILIHAN CHECKBOX TIPE EVENT ── -->
                        @php
                            $isOffline = old('is_offline', ($event->location || $event->price > 0 || $event->ticketPackages->count() > 0) ? 1 : 0);
                            $isOnline = old('is_online', ($event->youtube_link || $event->online_price > 0) ? 1 : 0);

                            if($isOffline == 0 && $isOnline == 0) $isOffline = 1;
                        @endphp
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-3 uppercase tracking-widest">Tipe Penyelenggaraan (Pilih salah satu atau keduanya)</label>
                            <div class="flex flex-col sm:flex-row gap-4 p-4 border border-slate-200 rounded-[12px] bg-slate-50/50">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" id="check_offline" name="is_offline" value="1" class="w-5 h-5 text-[#0066FF] rounded border-slate-300 focus:ring-[#0066FF]" {{ $isOffline ? 'checked' : '' }}>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-[#0066FF] transition-colors">Offline (Di Tempat)</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" id="check_online" name="is_online" value="1" class="w-5 h-5 text-[#FF3B30] rounded border-slate-300 focus:ring-[#FF3B30]" {{ $isOnline ? 'checked' : '' }}>
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
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" placeholder="Contoh: Gelora Bung Karno, Jakarta"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Deskripsi Lengkap Acara</label>
                            <textarea name="description" id="description" rows="5" required placeholder="Jelaskan detail acara, rundown, syarat dan ketentuan tiket..."
                                class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-medium rounded-[12px] px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:text-slate-400">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- LINK YOUTUBE ONLINE -->
                        <div id="online-options" class="transition-all duration-300">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest flex items-center gap-1.5"><i data-lucide="youtube" class="w-4 h-4"></i> Link Livestream YouTube</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30]/60"><i data-lucide="link" class="w-5 h-5"></i></span>
                                <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $event->youtube_link) }}" placeholder="https://youtube.com/live/..."
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200 placeholder:font-medium placeholder:text-red-300">
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block">*Kolom ini muncul karena Anda mencentang opsi penyelenggaraan Online.</span>
                        </div>

                        <!-- KODE RAHASIA PANITIA -->
                        <div class="border-t border-slate-100 pt-6 mt-6">
                            <label class="block text-[11px] font-bold text-[#A100FF] mb-2 uppercase tracking-widest flex items-center gap-1.5">
                                <i data-lucide="key" class="w-4 h-4"></i> Kode Rahasia Rekrutmen Panitia
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-purple-400"><i data-lucide="lock" class="w-5 h-5"></i></span>
                                <input type="text" name="secret_code" value="{{ old('secret_code', $event->secret_code) }}" placeholder="Contoh: PANITIA_TICKS_2026"
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
                        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#FF7A00] to-[#FF3B30]"></div>

                        <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                            <div class="p-1.5 bg-orange-50 text-[#FF7A00] rounded-lg"><i data-lucide="ticket" class="w-5 h-5"></i></div>
                            Tiket & Kapasitas
                        </h2>

                        <!-- ── AREA PAKET TIKET OFFLINE (DINAMIS - EDIT MODE) ── -->
                        <div id="offline-packages-wrapper" class="transition-all duration-300">
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kategori Tiket Offline</label>
                                <button type="button" id="btn-add-package" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#0066FF] text-white text-[10px] font-bold uppercase tracking-wider rounded-lg hover:bg-blue-700 transition-all shadow-md">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Tambah
                                </button>
                            </div>

                            <div id="packages-container" class="space-y-3">
                                @forelse($event->ticketPackages as $index => $package)
                                    <div class="package-row flex flex-col gap-3 p-4 border border-slate-200 bg-slate-50 rounded-xl relative group transition-all duration-300">
                                        <!-- Hidden ID supaya sistem tau ini data lama yang diupdate -->
                                        <input type="hidden" name="packages[{{ $index }}][id]" value="{{ $package->id }}">

                                        <!-- Tombol Hapus (Hanya muncul jika paket lebih dari 1) -->
                                        @if($index > 0)
                                        <button type="button" class="btn-remove-package absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full shadow-md hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100 z-10">
                                            <i data-lucide="x" class="w-3 h-3"></i>
                                        </button>
                                        @endif

                                        <div class="w-full">
                                            <label class="block text-[10px] font-bold text-slate-400 mb-1">NAMA PAKET</label>
                                            <input type="text" name="packages[{{ $index }}][name]" value="{{ old('packages.'.$index.'.name', $package->name) }}" required placeholder="Contoh: Reguler / VIP" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                        </div>
                                        <div class="w-full">
                                            <label class="block text-[10px] font-bold text-slate-400 mb-1">FASILITAS / DESKRIPSI PAKET (OPSIONAL)</label>
                                            <input type="text" name="packages[{{ $index }}][description]" value="{{ old('packages.'.$index.'.description', $package->description) }}" placeholder="Contoh: Free Drink, Baris Depan, Akses Eksklusif" class="w-full text-xs font-semibold border border-slate-300 rounded-lg px-3 py-2 focus:border-[#0066FF] focus:outline-none">
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-400 mb-1">HARGA (RP)</label>
                                                <input type="number" name="packages[{{ $index }}][price]" value="{{ old('packages.'.$index.'.price', $package->price) }}" required min="0" placeholder="0" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-400 mb-1">KUOTA PAKET</label>
                                                <input type="number" name="packages[{{ $index }}][quota]" value="{{ old('packages.'.$index.'.quota', $package->quota) }}" required min="1" placeholder="50" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Jika database lama dan event ini belum punya paket tiket sama sekali -->
                                    <div class="package-row flex flex-col gap-3 p-4 border border-slate-200 bg-slate-50 rounded-xl relative group transition-all duration-300">
                                        <div class="w-full">
                                            <label class="block text-[10px] font-bold text-slate-400 mb-1">NAMA PAKET</label>
                                            <input type="text" name="packages[0][name]" value="{{ old('packages.0.name', 'Reguler') }}" required placeholder="Contoh: Reguler / VIP" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                        </div>
                                        <div class="w-full">
                                            <label class="block text-[10px] font-bold text-slate-400 mb-1">FASILITAS / DESKRIPSI PAKET (OPSIONAL)</label>
                                            <input type="text" name="packages[0][description]" value="" placeholder="Contoh: Free Drink, Baris Depan, Akses Eksklusif" class="w-full text-xs font-semibold border border-slate-300 rounded-lg px-3 py-2 focus:border-[#0066FF] focus:outline-none">
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-400 mb-1">HARGA (RP)</label>
                                                <input type="number" name="packages[0][price]" value="{{ old('packages.0.price', $event->price ?? 0) }}" required min="0" placeholder="0" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-400 mb-1">KUOTA PAKET</label>
                                                <input type="number" name="packages[0][quota]" value="{{ old('packages.0.quota', $event->quota ?? 50) }}" required min="1" placeholder="50" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- HARGA ONLINE -->
                        <div id="online-price-wrapper" class="transition-all duration-300 border-t border-slate-100 pt-4 mt-4">
                            <label class="block text-[11px] font-bold text-[#FF3B30] mb-2 uppercase tracking-widest">Harga Tiket Online (Livestream)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#FF3B30] font-black text-sm">Rp</span>
                                <input type="number" name="online_price" id="online_price" value="{{ old('online_price', $event->online_price) }}" min="0" placeholder="0"
                                    class="w-full bg-red-50 focus:bg-white border border-red-200 focus:border-[#FF3B30] text-[#FF3B30] text-lg font-black rounded-[12px] pl-12 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#FF3B30]/10 transition-all duration-200">
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-4 mt-4">
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Total Kapasitas Event Keseluruhan</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="users" class="w-5 h-5"></i></span>
                                <input type="number" name="quota" id="quota" value="{{ old('quota', $event->quota) }}" required min="1" placeholder="Contoh: 500"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 mt-2 block">
                                *Isi dengan kapasitas maksimal gedung/acara.
                            </span>
                        </div>
                    </div>

                    <!-- ── POSTER PROMOSI ── -->
                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                        <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                            <div class="p-1.5 bg-purple-50 text-[#A100FF] rounded-lg"><i data-lucide="image" class="w-4 h-4"></i></div>
                            Poster Promosi <span class="text-[11px] font-medium text-slate-400 font-exo">(Opsional)</span>
                        </h2>

                        <div class="relative group aspect-[4/5] w-full max-w-[220px] mx-auto rounded-2xl bg-slate-50 border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center shadow-inner transition-colors hover:border-[#0066FF]/50">
                            @if($event->image)
                                <img id="badge-preview" src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div id="hover-overlay" class="absolute inset-0 bg-[#041B4A]/70 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <span class="text-white text-xs font-bold bg-[#0066FF] px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Ganti Poster</span>
                                </div>
                                <div class="text-center p-4 transition-opacity duration-200 hidden" id="placeholder-box">
                                    <i data-lucide="upload-cloud" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <span class="text-[#0066FF] text-xs font-bold block">Unggah Poster</span>
                                    <span class="text-slate-400 text-[10px] font-medium block mt-1">Rasio Potret (4:5)</span>
                                </div>
                            @else
                                <div class="text-center p-4 transition-opacity duration-200" id="placeholder-box">
                                    <i data-lucide="upload-cloud" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                                    <span class="text-[#0066FF] text-xs font-bold block">Unggah Poster</span>
                                    <span class="text-slate-400 text-[10px] font-medium block mt-1">Rasio Potret (4:5)</span>
                                </div>
                                <img id="badge-preview" class="w-full h-full object-cover hidden transition-transform duration-300 group-hover:scale-105">
                                <div id="hover-overlay" class="absolute inset-0 bg-[#041B4A]/70 opacity-0 group-hover:opacity-100 transition-opacity hidden items-center justify-center backdrop-blur-sm">
                                    <span class="text-white text-xs font-bold bg-[#0066FF] px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3 h-3"></i> Ganti Poster</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <input type="file" name="image" id="badge-input" accept="image/*"
                                class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                            <p class="text-[10px] text-slate-400 font-medium mt-2 text-center">Biarkan kosong jika tidak ingin mengubah poster.</p>
                        </div>
                    </div>

                    <!-- ── KOTAK GALERI FOTO EVENT ── -->
                    <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-black text-slate-800 font-montserrat flex items-center gap-2.5">
                                <div class="p-1.5 bg-blue-50 text-[#0066FF] rounded-lg"><i data-lucide="images" class="w-4 h-4"></i></div>
                                Galeri Tambahan
                            </h2>
                            @if($event->galleries && $event->galleries->count() > 0)
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-[#0066FF]" id="gallery-count-badge">
                                    {{ $event->galleries->count() }} Foto
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] font-medium text-slate-500 mb-2 leading-relaxed">
                            Kelola foto galeri yang sudah ada atau unggah foto tambahan untuk carousel di halaman detail acara.
                        </p>

                        <!-- Foto Galeri Yang Sudah Ada -->
                        @if($event->galleries && $event->galleries->count() > 0)
                            <div class="space-y-2" id="existing-galleries-section">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Foto Tersimpan (Klik 🗑️ untuk hapus)</label>
                                <div class="grid grid-cols-3 gap-2.5" id="existing-galleries-container">
                                    @foreach($event->galleries as $gallery)
                                        <div class="aspect-square rounded-xl overflow-hidden border border-slate-200 shadow-sm relative group bg-slate-100 transition-all duration-300" id="gallery-item-{{ $gallery->id }}">
                                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                            
                                            <!-- Overlay Tombol Hapus -->
                                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 backdrop-blur-[2px]">
                                                <button type="button" onclick="deleteExistingGallery({{ $gallery->id }}, '{{ route('admin.events.gallery.destroy', $gallery->id) }}')" 
                                                    class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white shadow-lg transition-transform hover:scale-110 active:scale-95" 
                                                    title="Hapus Foto Galeri Ini">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Container Preview Foto Baru Yang Dipilih -->
                        <div class="space-y-2">
                            <div id="new-gallery-preview-container" class="grid grid-cols-3 gap-2.5 mb-2 empty:hidden"></div>
                        </div>

                        <!-- Input File Upload Baru -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">+ Tambah Foto Galeri Baru</label>
                            <input type="file" name="galleries[]" id="gallery-input" accept="image/*" multiple
                                class="w-full text-xs text-slate-500 font-medium file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0066FF] hover:file:bg-[#0066FF] hover:file:text-white transition-all cursor-pointer border border-slate-200 rounded-[12px] p-1.5 bg-slate-50">
                            <p class="text-[10px] text-slate-400 font-medium mt-1.5">Bisa pilih beberapa foto sekaligus (Format JPG, PNG maks 2MB).</p>
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
                    <button type="submit" id="btn-submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        Simpan Perubahan <i data-lucide="save" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

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
            }
        });
    }

    // --- SCRIPT 2: Preview Galeri Foto Baru ---
    const galleryInput = document.getElementById('gallery-input');
    const newGalleryPreviewContainer = document.getElementById('new-gallery-preview-container');

    if(galleryInput) {
        galleryInput.addEventListener('change', function() {
            newGalleryPreviewContainer.innerHTML = '';
            const files = this.files;

            if(files && files.length > 0) {
                newGalleryPreviewContainer.classList.remove('empty:hidden');
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.addEventListener('load', function() {
                        const imgBox = document.createElement('div');
                        imgBox.className = 'aspect-square rounded-xl overflow-hidden border border-blue-300 shadow-sm relative group bg-slate-100';
                        const img = document.createElement('img');
                        img.src = this.result;
                        img.className = 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-110';
                        imgBox.appendChild(img);
                        newGalleryPreviewContainer.appendChild(imgBox);
                    });
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // --- SCRIPT 3: Hapus Foto Galeri yang Sudah Ada via AJAX ---
    async function deleteExistingGallery(galleryId, deleteUrl) {
        if(!confirm('Apakah Anda yakin ingin menghapus foto galeri ini? Foto akan langsung dihapus dari sistem.')) {
            return;
        }

        try {
            const response = await fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            if(data.success) {
                const item = document.getElementById(`gallery-item-${galleryId}`);
                if(item) {
                    item.style.transform = 'scale(0.8)';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.remove();
                        const remaining = document.querySelectorAll('#existing-galleries-container > div');
                        const badge = document.getElementById('gallery-count-badge');
                        if(badge) {
                            badge.innerText = `${remaining.length} Foto`;
                        }
                    }, 250);
                }
            } else {
                alert(data.message || 'Gagal menghapus foto galeri.');
            }
        } catch(err) {
            window.location.reload();
        }
    }

    // --- SCRIPT 4: LOGIKA CHECKBOX TIPE EVENT & PAKET DINAMIS ---
    const checkOffline = document.getElementById('check_offline');
    const checkOnline = document.getElementById('check_online');
    const offlineVenueWrapper = document.getElementById('offline-venue-wrapper');
    const offlinePackagesWrapper = document.getElementById('offline-packages-wrapper');
    const onlineLinkWrapper = document.getElementById('online-options');
    const onlinePriceWrapper = document.getElementById('online-price-wrapper');
    const btnSubmit = document.getElementById('btn-submit');
    const errorMsg = document.getElementById('type-error-msg');

    // Fitur Tambah Paket Dinamis (Mulai dari index terakhir yang ada di database)
    let packageIndex = {{ $event->ticketPackages->count() > 0 ? $event->ticketPackages->count() : 1 }};
    const btnAddPackage = document.getElementById('btn-add-package');
    const packagesContainer = document.getElementById('packages-container');

    if(btnAddPackage) {
        btnAddPackage.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'package-row flex flex-col gap-3 p-4 border border-slate-200 bg-slate-50 rounded-xl relative group transition-all duration-300';
            newRow.innerHTML = `
                <button type="button" class="btn-remove-package absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full shadow-md hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100 z-10">
                    <i data-lucide="x" class="w-3 h-3"></i>
                </button>
                <div class="w-full">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1">NAMA PAKET</label>
                    <input type="text" name="packages[${packageIndex}][name]" required placeholder="Contoh: VVIP" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                </div>
                <div class="w-full">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1">FASILITAS / DESKRIPSI PAKET (OPSIONAL)</label>
                    <input type="text" name="packages[${packageIndex}][description]" placeholder="Contoh: Free Drink, Baris Depan, Akses Eksklusif" class="w-full text-xs font-semibold border border-slate-300 rounded-lg px-3 py-2 focus:border-[#0066FF] focus:outline-none">
                </div>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-slate-400 mb-1">HARGA (RP)</label>
                        <input type="number" name="packages[${packageIndex}][price]" required min="0" placeholder="0" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-slate-400 mb-1">KUOTA PAKET</label>
                        <input type="number" name="packages[${packageIndex}][quota]" required min="1" placeholder="50" class="w-full text-sm font-bold border border-slate-300 rounded-lg px-3 py-2.5 focus:border-[#0066FF] focus:outline-none">
                    </div>
                </div>
            `;
            packagesContainer.appendChild(newRow);
            lucide.createIcons();
            packageIndex++;
        });

        // Fitur Hapus Paket Dinamis
        packagesContainer.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-package');
            if(btnRemove) {
                btnRemove.closest('.package-row').remove();
            }
        });
    }

    // Logika Sembunyikan Form jika Checkbox tidak dicentang
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

        const packageInputs = offlinePackagesWrapper.querySelectorAll('input');
        if (checkOffline.checked) {
            offlineVenueWrapper.classList.remove('hidden');
            offlinePackagesWrapper.classList.remove('hidden');
            document.getElementById('location').required = true;
            packageInputs.forEach(input => input.disabled = false);
        } else {
            offlineVenueWrapper.classList.add('hidden');
            offlinePackagesWrapper.classList.add('hidden');
            document.getElementById('location').required = false;
            packageInputs.forEach(input => input.disabled = true);
        }

        if (checkOnline.checked) {
            onlineLinkWrapper.classList.remove('hidden');
            onlinePriceWrapper.classList.remove('hidden');
            document.getElementById('youtube_link').required = true;
        } else {
            onlineLinkWrapper.classList.add('hidden');
            onlinePriceWrapper.classList.add('hidden');
            document.getElementById('youtube_link').required = false;
        }
    }

    checkOffline.addEventListener('change', toggleEventTypes);
    checkOnline.addEventListener('change', toggleEventTypes);
    toggleEventTypes();
</script>
@endpush
