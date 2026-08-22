<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Data Transaksi')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')

    <!-- ── HEADER HALAMAN DENGAN PENCARIAN & EXPORT ── -->
    <div class="px-8 pt-10 pb-6 flex flex-col xl:flex-row xl:items-end justify-between gap-6">

        <!-- Bagian Kiri: Judul -->
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Data Transaksi & Kelola Refund</h1>
            <p class="text-[14px] text-slate-500 font-medium">Pantau seluruh riwayat pembelian, status pembayaran, dan proses pengembalian dana.</p>
        </div>

        <!-- Bagian Kanan: Pencarian & Export -->
        <div class="flex flex-col sm:flex-row sm:flex-wrap items-center justify-start xl:justify-end gap-3 no-print w-full xl:w-auto">

            <!-- FORM PENCARIAN -->
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex items-center gap-2 m-0 w-full sm:w-auto">
                <div class="relative w-full sm:w-64 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID, Pembeli, Event..."
                           class="w-full bg-white pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:border-[#0066FF] focus:ring-2 focus:ring-[#0066FF]/20 transition-all shadow-sm">
                </div>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0">
                    Cari
                </button>
                <!-- Tombol Reset -->
                @if(request('search'))
                    <a href="{{ route('admin.transactions.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 p-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center justify-center shrink-0" title="Reset Pencarian">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Export CSV -->
            <button onclick="exportTableToCSV('data_transaksi_artix.csv')" class="bg-white border border-slate-200 text-slate-600 hover:text-[#0066FF] hover:border-[#0066FF] hover:bg-blue-50 px-6 py-2.5 rounded-[12px] text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-2 shrink-0 w-full sm:w-auto">
                <i data-lucide="download" class="w-4 h-4"></i> Export (CSV)
            </button>

        </div>
    </div>

    <div class="px-8 pb-12 relative z-10 flex-1">

        <!-- NOTIFIKASI PESAN SUKSES / ERROR -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                <span class="text-[14px]">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-medium">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                <span class="text-[14px]">{{ session('error') }}</span>
            </div>
        @endif

        <!-- ── TABEL DATA TRANSAKSI ── -->
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="transactionTable">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-widest text-slate-500 font-bold font-montserrat">
                            <th class="px-6 py-5 w-[15%]">Order ID / Waktu</th>
                            <th class="px-6 py-5 w-[20%]">Pembeli</th>
                            <th class="px-6 py-5 w-[20%]">Event</th>
                            <th class="px-6 py-5 w-[10%] text-center">Jml Tiket</th>
                            <th class="px-6 py-5 w-[15%] text-right">Total (Rp)</th>
                            <th class="px-6 py-5 w-[10%] text-center">Status</th>
                            <th class="px-6 py-5 w-[10%] text-center sticky right-0 bg-slate-50 z-10 shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.05)] border-l border-slate-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700">

                        @forelse($transactions as $trx)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-[#0066FF] text-[13px] mb-1.5 flex items-center gap-1.5">
                                    <i data-lucide="hash" class="w-3.5 h-3.5"></i>{{ $trx->order_id ?? $trx->id }}
                                </div>
                                <div class="text-[12px] text-slate-500 font-medium flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $trx->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-[14px] mb-1 truncate max-w-[180px]">
                                    {{ $trx->user->name ?? 'User Terhapus' }}
                                </div>
                                <div class="text-[12px] text-slate-500 font-medium flex items-center gap-1.5 truncate max-w-[180px]">
                                    <i data-lucide="mail" class="w-3.5 h-3.5"></i> {{ $trx->user->email ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-slate-100 border border-slate-200 text-slate-700 text-[12px] px-3 py-1.5 rounded-lg font-bold truncate max-w-[180px]">
                                    {{ $trx->event->name ?? 'Event Terhapus' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-slate-800 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">{{ $trx->quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-black text-slate-800 font-montserrat">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(in_array($trx->payment_status, ['paid', 'success', 'settlement']))
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Lunas
                                    </span>
                                @elseif($trx->payment_status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i> Pending
                                    </span>
                                @elseif($trx->payment_status == 'refund_requested')
                                    <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-600 border border-orange-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                        <i data-lucide="refresh-ccw" class="w-3.5 h-3.5"></i> Minta Refund
                                    </span>
                                @elseif($trx->payment_status == 'refunded')
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 border border-slate-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Dikembalikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 text-[11px] px-2.5 py-1.5 rounded-md font-bold uppercase tracking-wider">
                                        <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Gagal
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center sticky right-0 bg-white z-10 shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.05)] border-l border-slate-50">
                                @if(in_array($trx->payment_status, ['paid', 'success', 'settlement']))
                                    <form action="{{ route('admin.refund.process', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan tiket ini? Tiket akan hangus dan masuk ke antrean Refund.');">
                                        @csrf
                                        <button type="submit" title="Batalkan Tiket" class="bg-orange-50 hover:bg-orange-500 text-orange-600 hover:text-white border border-orange-200 hover:border-orange-500 px-3 py-2 rounded-xl font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-1.5 mx-auto">
                                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Batalkan
                                        </button>
                                    </form>
                                @elseif($trx->payment_status === 'refund_processing' || $trx->payment_status === 'refund_requested')
                                    <form action="{{ route('admin.refund.process', $trx->id) }}" method="POST" onsubmit="return confirm('PENTING: Pastikan Anda sudah mentransfer uang ke rekening pembeli sebelum menekan OK!');">
                                        @csrf
                                        <button type="submit" title="Tandai Selesai" class="bg-[#0066FF] hover:bg-blue-700 text-white px-3 py-2 rounded-xl font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-1.5 mx-auto">
                                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Selesai
                                        </button>
                                    </form>
                                @elseif($trx->payment_status === 'refunded')
                                    <span class="text-slate-400 font-bold text-[10px] bg-slate-100 border border-slate-200 px-2.5 py-1.5 rounded-lg inline-block whitespace-nowrap">Telah di-Refund</span>
                                @else
                                    <span class="text-slate-300 font-bold">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        @if(request('search'))
                                            <i data-lucide="search-x" class="w-8 h-8"></i>
                                        @else
                                            <i data-lucide="inbox" class="w-8 h-8"></i>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">
                                        {{ request('search') ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Transaksi' }}
                                    </h3>
                                    <p class="text-slate-500 text-[14px] font-medium">
                                        {{ request('search') ? 'Tidak ada transaksi yang cocok dengan kata kunci tersebut.' : 'Saat ini belum ada pengguna yang melakukan pembelian tiket.' }}
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

<!-- ── MEMASUKKAN SCRIPT KHUSUS HALAMAN INI ── -->
@push('scripts')
<script>
    // FUNGSI EXPORT KE CSV
    function exportTableToCSV(filename) {
        let csv = [];
        let table = document.getElementById("transactionTable");
        let rows = table.querySelectorAll("tr");

        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");

            // Mengurangi 1 dari cols.length agar kolom terakhir (Aksi) tidak ikut di-export
            let columnCount = (i === 0) ? cols.length - 1 : cols.length - 1;

            for (let j = 0; j < columnCount; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }

        let csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
        let downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endpush
