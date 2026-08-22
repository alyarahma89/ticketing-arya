@extends('layouts.main')

@section('title', 'Pengajuan Sponsor - ' . $sponsorship->name . ' | ARTIX ID')

@section('content')

    <div class="max-w-5xl mx-auto px-6 pt-32 pb-16">
        <div class="text-center mb-10">
            <h1 class="font-black text-3xl md:text-4xl font-montserrat mb-3 dark:text-white">Formulir Pengajuan Kemitraan</h1>
            <p class="text-slate-500 font-medium dark:text-white/60">Lengkapi data perusahaan Anda untuk mengajukan kontrak sponsorship resmi.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- KOLOM KIRI: RINGKASAN PAKET -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] p-6 shadow-sm sticky top-28">
                    <div class="text-[10px] font-bold tracking-widest text-[#0066FF] uppercase mb-2">Ringkasan Paket</div>
                    <h3 class="font-black text-xl font-montserrat mb-1">{{ $sponsorship->name }}</h3>
                    <p class="text-sm font-medium text-slate-500 dark:text-white/50 border-b border-slate-100 dark:border-white/10 pb-4 mb-4">
                        Event: <span class="font-bold text-slate-800 dark:text-white">{{ $sponsorship->event->name }}</span>
                    </p>

                    <div class="mb-4">
                        <span class="block text-xs font-medium text-slate-400 dark:text-white/40 mb-1">Nilai Investasi:</span>
                        <span class="font-black text-2xl text-[#FF7A00]">Rp {{ number_format($sponsorship->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="bg-blue-50 dark:bg-[#0066FF15] rounded-xl p-4">
                        <p class="text-[11px] font-bold text-[#0066FF] dark:text-[#00C2FF] uppercase mb-2">Benefit Anda:</p>
                        <ul class="space-y-2">
                            @php $benefits = array_slice(explode(',', $sponsorship->benefits), 0, 3); @endphp
                            @foreach($benefits as $benefit)
                                @if(trim($benefit) != '')
                                <li class="flex items-start gap-2 text-xs font-medium text-slate-700 dark:text-white/70">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5"></i>
                                    <span>{{ trim($benefit) }}</span>
                                </li>
                                @endif
                            @endforeach
                            <li class="text-[10px] font-bold text-[#0066FF] italic mt-1">Dan benefit lainnya...</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: FORMULIR ISIAN -->
            <div class="w-full lg:w-2/3">
                <form action="{{ route('sponsorship.submit', $sponsorship->id) }}" method="POST" class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] p-8 shadow-sm">
                    @csrf

                    <h2 class="font-black text-lg font-montserrat mb-6 flex items-center gap-2 border-b border-slate-100 dark:border-white/10 pb-4">
                        <i data-lucide="building-2" class="w-5 h-5 text-[#0066FF]"></i> Data Perusahaan
                    </h2>

                    <div class="space-y-5">
                        <!-- Nama Perusahaan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">Nama Brand / Perusahaan</label>
                            <input type="text" name="company_name" required placeholder="Contoh: PT. Teknologi Nusantara" class="w-full bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">Email Resmi</label>
                                <input type="email" name="company_email" required placeholder="contact@perusahaan.com" class="w-full bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
                            </div>
                            <!-- Telepon -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="company_phone" required placeholder="081234567890" class="w-full bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
                            </div>
                        </div>

                        <!-- Pesan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">Pesan untuk Penyelenggara (Opsional)</label>
                            <textarea name="message" rows="4" placeholder="Tuliskan harapan kemitraan, tujuan promosi, atau catatan khusus lainnya..." class="w-full bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-white/10">
                        <button type="submit" class="w-full py-4 rounded-xl text-sm font-bold text-white shadow-lg transition-all hover:scale-[1.02] hover:shadow-xl flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                            Kirim Pengajuan Sekarang <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                        <p class="text-[10px] text-center text-slate-400 mt-3">Dengan mengirim form ini, Anda menyetujui EO untuk menghubungi kontak yang tertera.</p>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
