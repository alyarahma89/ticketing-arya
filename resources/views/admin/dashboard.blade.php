<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Ikhtisar Platform')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')
    <!-- ── HEADER HALAMAN DENGAN FILTER TAHUN ── -->
    <div class="px-8 pt-8 pb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-1 font-montserrat tracking-tight">Ikhtisar Platform</h1>
            <p class="text-[14px] text-slate-500 font-medium">Ringkasan performa sistem secara keseluruhan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-4">

            <!-- FILTER TAHUN DINAMIS -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="m-0">
                <div class="flex items-center bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 transition-colors hover:border-[#0066FF]">
                    <label for="yearFilter" class="text-[13px] text-slate-500 font-medium mr-2">Periode:</label>
                    <select name="year" id="yearFilter" onchange="this.form.submit()" class="text-[13px] font-bold text-[#0066FF] bg-transparent border-none focus:ring-0 p-0 cursor-pointer outline-none w-24">
                        @for($i = 2024; $i <= 2030; $i++)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }} class="text-slate-800">
                                Tahun {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>

            <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-6 py-2.5 rounded-xl text-[14px] font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 shrink-0">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Event
            </a>
        </div>
    </div>

    <div class="px-8 pb-12">

        <!-- ALERT -->
        @if(Auth::user()->role === 'admin')
            <div class="mb-8 p-4 bg-blue-50 text-blue-700 rounded-xl border border-blue-200 flex items-center gap-3 font-medium shadow-sm">
                <i data-lucide="info" class="w-5 h-5 text-blue-500 shrink-0"></i>
                <span><strong>Halo Admin!</strong> Anda melihat data keseluruhan platform ARTIX ID.</span>
            </div>
        @else
            <div class="mb-8 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 flex items-center gap-3 font-medium shadow-sm">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 shrink-0"></i>
                <span><strong>Halo EO!</strong> Anda hanya melihat data statistik dari event milik Anda sendiri.</span>
            </div>
        @endif

        <!-- ── KARTU STATISTIK ── -->
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5 mb-8">
            <!-- Card 1: Omset -->
            <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1 h-full bg-artix-blue"></div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Omset Tiket</span>
                    <div class="bg-blue-50 text-artix-blue p-1.5 rounded-lg"><i data-lucide="banknote" class="w-4 h-4"></i></div>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-800 font-montserrat">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Card 2: Sponsor -->
            <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1 h-full bg-artix-purple"></div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Dana Sponsor</span>
                    <div class="bg-purple-50 text-artix-purple p-1.5 rounded-lg"><i data-lucide="handshake" class="w-4 h-4"></i></div>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-800 font-montserrat">Rp {{ number_format($pendapatanSponsor ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Card 3: Tiket -->
            <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1 h-full bg-artix-orange"></div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Tiket Terjual</span>
                    <div class="bg-orange-50 text-artix-orange p-1.5 rounded-lg"><i data-lucide="ticket" class="w-4 h-4"></i></div>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($tiketTerjual ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Lembar</span></span>
                </div>
            </div>

            <!-- Card 4: Event -->
            <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1 h-full bg-artix-red"></div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Total Event</span>
                    <div class="bg-red-50 text-artix-red p-1.5 rounded-lg"><i data-lucide="calendar-check" class="w-4 h-4"></i></div>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($eventAktif ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Acara</span></span>
                </div>
            </div>

            <!-- Card 5: Pengguna -->
            <div class="bg-white rounded-[20px] p-5 shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1 h-full bg-artix-cyan"></div>
                <div class="flex justify-between items-start">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Total Pengguna</span>
                    <div class="bg-cyan-50 text-artix-cyan p-1.5 rounded-lg"><i data-lucide="users" class="w-4 h-4"></i></div>
                </div>
                <div>
                    <span class="text-2xl font-black text-slate-800 font-montserrat">{{ number_format($totalPengguna ?? 0, 0, ',', '.') }} <span class="text-[13px] font-bold text-slate-400 font-exo">Akun</span></span>
                </div>
            </div>
        </div>

        <!-- ── BAGIAN GRAFIK ── -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart -->
            <div class="lg:col-span-2 bg-white rounded-[24px] p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-slate-800 font-montserrat">Statistik Keuangan Bulanan</h3>
                    <span class="text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-lg">Juta Rupiah</span>
                </div>
                <div class="relative w-full h-72">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart -->
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-slate-200 flex flex-col items-center">
                <h3 class="text-lg font-black text-slate-800 font-montserrat w-full text-left mb-6">Proporsi Kategori</h3>
                <div class="relative w-full h-64 flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

<!-- ── MEMASUKKAN SCRIPT KHUSUS HALAMAN INI ── -->
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ── Konfigurasi Chart Garis (Sales) ──
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            let salesDataValues = @json($salesData);

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: salesDataValues,
                        borderColor: '#0066FF',
                        backgroundColor: 'rgba(0, 102, 255, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0066FF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
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
                            titleFont: { family: 'Montserrat', size: 13 },
                            bodyFont: { family: 'Exo 2', size: 14 },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#64748b', font: { family: 'Exo 2' } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { color: '#64748b', font: { family: 'Exo 2' } },
                            grid: { display: false }
                        }
                    }
                }
            });

            // ── Konfigurasi Chart Donat (Kategori) ──
            const catCtx = document.getElementById('categoryChart').getContext('2d');
            let rawCategoryData = @json($categoryData);

            if (!rawCategoryData || Object.keys(rawCategoryData).length === 0) {
                rawCategoryData = {'Belum ada data': 1};
            }

            const catLabels = Object.keys(rawCategoryData);
            const catValues = Object.values(rawCategoryData);

            const bgColors = Object.keys(rawCategoryData)[0] === 'Belum ada data'
                             ? ['#e2e8f0']
                             : ['#0066FF', '#FF7A00', '#A100FF', '#FF3B30', '#00C2FF'];

            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catValues,
                        backgroundColor: bgColors,
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Exo 2', size: 12 },
                                color: '#475569',
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#041B4A',
                            bodyFont: { family: 'Montserrat', size: 13, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        });
    </script>
@endpush
