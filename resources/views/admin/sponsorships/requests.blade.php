<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Daftar Pengajuan Sponsor')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
<div class="p-8">
    <!-- ── HEADER HALAMAN DENGAN PENCARIAN ── -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 font-montserrat tracking-tight mb-2">Pengajuan Kemitraan Masuk</h1>
            <p class="text-[14px] text-slate-500 font-medium">Tinjau, terima, atau tolak penawaran kerja sama dari berbagai perusahaan untuk event Anda.</p>
        </div>

        <!-- Kotak Pencarian -->
        <div class="flex items-center gap-3 no-print">
            <form method="GET" action="{{ route('admin.sponsorship_requests.index') }}" class="flex items-center gap-2 m-0">
                <div class="relative w-full sm:w-64 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama perusahaan/event..."
                           class="w-full bg-white pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm">
                </div>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.sponsorship_requests.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 p-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0" title="Reset Pencarian">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>
        </div>
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

                        <!-- ── KOLOM STATUS ── -->
                        <td class="px-6 py-4 text-center">
                            @if($req->status === 'pending')
                                <span class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Menunggu</span>
                            @elseif($req->status === 'approved')
                                @if($req->payment_status === 'unpaid')
                                    <span class="bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Belum Lunas</span>
                                @else
                                    <span class="bg-blue-50 text-[#0066FF] border border-blue-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Lunas</span>
                                @endif
                            @else
                                <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                            @endif
                        </td>

                        <!-- ── KOLOM AKSI LANJUTAN ── -->
                        <td class="px-6 py-4 text-center">
                            @if($req->status === 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima kemitraan ini?');">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2 rounded-xl transition-all shadow-sm hover:shadow-md" title="Terima Pengajuan">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak kemitraan ini?');">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-xl transition-all shadow-sm hover:shadow-md" title="Tolak Pengajuan">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif($req->status === 'approved')
                                <div class="flex flex-col gap-2 items-center justify-center w-full">
                                    @php
                                        $wa_number = preg_replace('/^0/', '62', $req->company_phone);
                                        $wa_text = "Halo tim {$req->company_name}, pengajuan sponsor Anda untuk event {$req->sponsorship->event->name} telah kami terima. Mari diskusikan detail kontrak dan pembayarannya.";
                                    @endphp
                                    <a href="https://wa.me/{{ $wa_number }}?text={{ urlencode($wa_text) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-500 hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md">
                                        <i data-lucide="message-circle" class="w-4 h-4"></i> Chat WA
                                    </a>

                                    @if($req->payment_status === 'unpaid')
                                        <form action="{{ route('admin.sponsorship_requests.update', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menandai sponsor ini sudah Lunas?');" class="w-full">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="payment_status" value="paid">
                                            <button type="submit" class="w-full bg-[#0066FF] hover:bg-blue-700 text-white px-3 py-2 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                                <i data-lucide="banknote" class="w-4 h-4"></i> Tandai Lunas
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-slate-400 font-bold bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">- Selesai -</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mb-4 border border-slate-100">
                                    @if(request('search'))
                                        <i data-lucide="search-x" class="w-8 h-8"></i>
                                    @else
                                        <i data-lucide="inbox" class="w-8 h-8"></i>
                                    @endif
                                </div>
                                <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">
                                    {{ request('search') ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Pengajuan' }}
                                </h3>
                                <p class="text-slate-500 text-[14px] font-medium">
                                    {{ request('search') ? 'Tidak ada perusahaan yang cocok dengan kata kunci tersebut.' : 'Belum ada perusahaan yang mengajukan kemitraan untuk event Anda.' }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
