@extends('layouts.main')

@section('title', 'Proposal Sponsorship - ' . $event->name . ' | Ticks ID')

@section('content')

    <!-- ── HERO SECTION: DETAIL EVENT ── -->
    <section class="relative pt-32 pb-16 overflow-hidden bg-white dark:bg-transparent transition-colors border-b border-slate-200 dark:border-white/10">
        <div class="absolute inset-0 pointer-events-none hidden dark:block" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, #0A2A6E 0%, transparent 70%); z-index: 0;"></div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest border mb-6 bg-purple-50 border-purple-200 text-purple-700 dark:bg-[#A100FF18] dark:border-[#A100FF45] dark:text-[#c5a3ff]">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i> PROPOSAL SPONSORSHIP
            </div>

            <h1 class="font-black text-4xl md:text-5xl leading-tight font-montserrat text-slate-900 dark:text-white mb-6">
                {{ $event->name }}
            </h1>

            <p class="text-base md:text-lg max-w-2xl mx-auto leading-relaxed font-medium text-slate-600 dark:text-white/60 mb-8">
                {{ $event->description }}
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4 text-sm font-bold">
                <div class="flex items-center gap-2 bg-slate-100 text-slate-700 dark:bg-white/10 dark:text-white px-5 py-2.5 rounded-full">
                    <i data-lucide="calendar" class="w-4 h-4 text-orange-500"></i> {{ date('d F Y', strtotime($event->event_date)) }}
                </div>
                <div class="flex items-center gap-2 bg-slate-100 text-slate-700 dark:bg-white/10 dark:text-white px-5 py-2.5 rounded-full">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i> {{ $event->location }}
                </div>
            </div>
        </div>
    </section>

    <!-- ── KATALOG PAKET SPONSOR EVENT INI ── -->
    <section class="py-16 flex-grow transition-colors bg-[#F8FAFC] dark:bg-[#020C1F]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between mb-10">
                <h2 class="font-black text-2xl font-montserrat text-slate-900 dark:text-white">Pilihan Paket Kemitraan</h2>
                <span class="text-xs font-bold bg-blue-50 text-[#0066FF] px-3 py-1.5 rounded-lg border border-blue-100 dark:bg-[#0066FF22] dark:border-[#0066FF55] dark:text-[#00C2FF]">
                    {{ count($event->sponsorships) }} Paket Tersedia
                </span>
            </div>

            @if(count($event->sponsorships) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($event->sponsorships as $sponsor)
                    <div class="group p-5 rounded-3xl border shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl flex flex-col bg-white border-slate-200 dark:bg-white/5 dark:border-white/10 dark:hover:border-[#A100FF55] dark:hover:shadow-[0_8px_40px_rgba(161,0,255,0.25)]">

                        <!-- Header Kartu -->
                        <div class="flex items-start gap-4 mb-6 pb-6 border-b border-slate-100 dark:border-white/10">
                            <!-- Gambar Badge (Bisa Logo EO atau Gambar Paket) -->
                            <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-[#0A1A3A] flex items-center justify-center border border-slate-200 dark:border-white/10">
                                @if($sponsor->image)
                                    <img src="{{ asset('storage/' . $sponsor->image) }}" 
                                         onerror="this.onerror=null;this.parentElement.innerHTML='<i data-lucide=\'shield\' class=\'w-8 h-8 text-slate-300 dark:text-white/20\'></i>';lucide.createIcons();" 
                                         class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="shield" class="w-8 h-8 text-slate-300 dark:text-white/20"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-black text-lg leading-tight font-montserrat text-slate-900 dark:text-white mb-1.5">{{ $sponsor->name }}</h3>
                                <p class="text-lg font-black text-[#FF7A00] dark:text-[#FFB000]">
                                    Rp {{ number_format($sponsor->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Daftar Benefit (Full List) -->
                        <div class="flex-grow mb-8">
                            <p class="text-[11px] font-bold text-slate-400 dark:text-white/40 uppercase tracking-widest mb-4">Benefit Eksklusif:</p>
                            <ul class="space-y-3">
                                @php
                                    $benefits = explode(',', $sponsor->benefits);
                                @endphp

                                @foreach($benefits as $benefit)
                                    @if(trim($benefit) != '')
                                    <li class="flex items-start gap-2.5 text-[14px] font-medium text-slate-600 dark:text-white/70">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 shrink-0"></i>
                                        <span class="leading-snug">{{ trim($benefit) }}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- Tombol CTA & Kuota -->
                        <div class="mt-auto">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-500 dark:text-white/50 flex items-center gap-1.5">
                                    <i data-lucide="users" class="w-4 h-4"></i> {{ $sponsor->quota }} Slot Tersedia
                                </span>
                            </div>
                            <a href="{{ route('sponsorship.apply', $sponsor->id) }}" class="w-full block text-center py-3.5 rounded-xl text-sm font-bold text-white shadow-md transition-all hover:scale-[1.02] hover:shadow-xl" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                                Sepakati & Ajukan Sponsor
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State Jika Event Belum Menambahkan Sponsor -->
                <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 dark:bg-white/5 dark:border-white/10 shadow-sm max-w-3xl mx-auto">
                    <i data-lucide="folder-x" class="w-20 h-20 text-slate-300 dark:text-white/20 mx-auto mb-5"></i>
                    <h3 class="text-2xl font-black text-slate-800 font-montserrat mb-3 dark:text-white">Proposal Belum Tersedia</h3>
                    <p class="text-base text-slate-500 font-medium dark:text-white/60 mb-6">Penyelenggara acara ini belum merilis paket kemitraan ke dalam sistem marketplace.</p>
                    <a href="{{ url('/') }}#packages" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 dark:border-white/20 dark:text-white dark:hover:bg-white/10 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Lihat Event Lainnya
                    </a>
                </div>
            @endif

        </div>
    </section>

@endsection
