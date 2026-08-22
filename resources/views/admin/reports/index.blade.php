<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Laporan Keuangan')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
    <!-- ── KONTEN LAPORAN ── -->
    <div class="px-8 pt-10 pb-12">

        <!-- Judul & Tombol Export -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Laporan Keuangan</h1>
                <p class="text-[14px] text-slate-500 font-medium">
                    @if(Auth::user()->role === 'eo') Ringkasan pendapatan dan performa event Anda. @else Ringkasan pendapatan dan performa seluruh event di platform. @endif
                </p>
            </div>

            <!-- TOMBOL EXPORT (Sembunyikan saat cetak) -->
            <div class="flex flex-wrap gap-3 no-print">
                <button type="submit" form="filterForm" name="export" value="pdf" class="bg-gradient-to-r from-red-500 to-[#FF3B30] text-white px-6 py-2.5 rounded-[12px] text-sm font-bold hover:shadow-lg hover:shadow-red-500/30 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Download PDF
                </button>
                <button type="submit" form="filterForm" name="export" value="excel" class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-2.5 rounded-[12px] text-sm font-bold hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Download Excel
                </button>
            </div>
        </div>

        <!-- ── FORM FILTER TANGGAL ── -->
        <div class="bg-white p-6 rounded-[24px] border border-slate-200 shadow-sm mb-6 no-print">
            <form id="filterForm" action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Dari Tanggal</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-[12px] text-[14px] font-bold text-slate-700 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Sampai Tanggal</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-[12px] text-[14px] font-bold text-slate-700 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-[#041B4A] hover:bg-slate-800 text-white px-6 py-2.5 rounded-[12px] text-sm font-bold transition-all shadow-md flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4"></i> Filter Data
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 hover:border-slate-300 px-6 py-2.5 rounded-[12px] text-sm font-bold transition-all flex items-center gap-2">
                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ── KARTU RINGKASAN (SUMMARY) 4 KOLOM ── -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <!-- 1. Total Pendapatan -->
            <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#0066FF]"></div>
                <div class="pl-2">
                    <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Total Pendapatan</p>
                    <h3 class="text-xl xl:text-2xl font-black text-slate-800 font-montserrat">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0066FF] shadow-inner border border-blue-100 shrink-0">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- 2. Total Tiket Terjual -->
            <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#FF7A00]"></div>
                <div class="pl-2">
                    <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Tiket Terjual</p>
                    <h3 class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($totalTiket, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 font-exo">Pax</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7A00] shadow-inner border border-orange-100 shrink-0">
                    <i data-lucide="ticket" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- 3. Event Aktif -->
            <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#A100FF]"></div>
                <div class="pl-2">
                    <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Event Aktif</p>
                    <h3 class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($activeEventsCount, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 font-exo">Event</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-[#A100FF] shadow-inner border border-purple-100 shrink-0">
                    <i data-lucide="radio" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- 4. Event Selesai -->
            <div class="bg-white p-6 rounded-[20px] border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-slate-400"></div>
                <div class="pl-2">
                    <p class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-1">Event Selesai</p>
                    <h3 class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($inactiveEventsCount, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400 font-exo">Event</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-500 shadow-inner border border-slate-200 shrink-0">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
            </div>

        </div>

        <!-- ── AREA GRAFIK (2 KOLOM) ── -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- GRAFIK 1: Pendapatan Harian -->
            <div class="lg:col-span-2 bg-white p-8 rounded-[24px] border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-black text-slate-800 font-montserrat flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-5 h-5 text-[#0066FF]"></i> Pendapatan Harian
                    </h2>
                    <span class="text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-lg">Rupiah (Rp)</span>
                </div>
                <div class="relative h-[320px] w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- GRAFIK 2: Top Event Populer -->
            <div class="lg:col-span-1 bg-white p-8 rounded-[24px] border border-slate-200 shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-black text-slate-800 font-montserrat flex items-center gap-2">
                        <i data-lucide="star" class="w-5 h-5 text-[#FF7A00]"></i> Top 5 Populer
                    </h2>
                </div>
                <div class="relative flex-1 w-full flex items-center justify-center min-h-[250px]">
                    @if(empty($popularEventLabels))
                        <div class="text-center text-slate-400">
                            <i data-lucide="bar-chart-2" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                            <p class="text-sm font-medium">Belum ada data penjualan.</p>
                        </div>
                    @else
                        <canvas id="popularEventChart"></canvas>
                    @endif
                </div>
            </div>

        </div>

        <!-- ── TABEL LAPORAN ── -->
        <div class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-base font-black text-slate-800 font-montserrat">Rincian Transaksi Event</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-widest font-montserrat">
                        <tr>
                            <th class="py-5 px-6">Tanggal Transaksi</th>
                            <th class="py-5 px-6">Nama Event</th>
                            <th class="py-5 px-6 text-center">Jml Tiket</th>
                            <th class="py-5 px-6 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-slate-700 divide-y divide-slate-100">
                        @forelse($reports as $report)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 text-slate-500 font-medium">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $report->event->name ?? 'Event Terhapus' }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="bg-slate-100 border border-slate-200 text-slate-700 font-bold px-3 py-1 rounded-lg text-xs">
                                    {{ $report->quantity }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-black text-slate-800 font-montserrat">Rp {{ number_format($report->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                        <i data-lucide="inbox" class="w-8 h-8"></i>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 mb-1 font-montserrat">Tidak Ada Data</h3>
                                    <p class="text-[14px] font-medium">Belum ada transaksi pendapatan pada rentang waktu ini.</p>
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
    <!-- Panggil Pustaka Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // GRAFIK 1: PENDAPATAN HARIAN (LINE CHART)
            // ==========================================
            const labels = @json($chartLabels ?? []);
            const dataValues = @json($chartValues ?? []);

            if(document.getElementById('revenueChart') && labels.length > 0) {
                const ctx = document.getElementById('revenueChart').getContext('2d');

                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(0, 102, 255, 0.4)');
                gradient.addColorStop(1, 'rgba(0, 102, 255, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: dataValues,
                            borderColor: '#0066FF',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0066FF',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#0066FF',
                            pointHoverBorderColor: '#ffffff',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#041B4A',
                                titleFont: { family: 'Montserrat', size: 13, weight: 'bold' },
                                bodyFont: { family: 'Exo 2', size: 14, weight: '600' },
                                padding: 12,
                                cornerRadius: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let value = context.parsed.y;
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: { color: '#f1f5f9', drawBorder: false },
                                ticks: {
                                    color: '#64748b',
                                    font: { family: 'Exo 2', weight: '600' },
                                    padding: 10,
                                    callback: function(value) {
                                        if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                        if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                        return 'Rp ' + value;
                                    }
                                }
                            },
                            x: {
                                border: { display: false },
                                grid: { display: false },
                                ticks: { color: '#64748b', font: { family: 'Exo 2', weight: '600' }, padding: 10 }
                            }
                        }
                    }
                });
            }

            // ==========================================
            // GRAFIK 2: TOP EVENT POPULER (DOUGHNUT CHART)
            // ==========================================
            const popularLabels = @json($popularEventLabels ?? []);
            const popularValues = @json($popularEventValues ?? []);

            if(document.getElementById('popularEventChart') && popularLabels.length > 0) {
                const popularCtx = document.getElementById('popularEventChart').getContext('2d');
                new Chart(popularCtx, {
                    type: 'doughnut',
                    data: {
                        labels: popularLabels,
                        datasets: [{
                            label: 'Tiket Terjual',
                            data: popularValues,
                            backgroundColor: ['#0066FF', '#00C2FF', '#FF7A00', '#FF3B30', '#A100FF'],
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 15, usePointStyle: true, pointStyle: 'circle', font: { family: 'Exo 2', size: 12, weight: '600' }, color: '#64748b' }
                            },
                            tooltip: {
                                backgroundColor: '#041B4A',
                                titleFont: { family: 'Montserrat', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Exo 2', size: 13, weight: '600' },
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        let value = context.parsed;
                                        return ' ' + value + ' Tiket';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
