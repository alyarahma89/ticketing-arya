<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Ticks ID</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Exo+2:wght@400;600;700&display=swap');

        body {
            font-family: 'Exo 2', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        /* --- BAGIAN KOP LAPORAN (HEADER) --- */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #0066FF;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-logo { width: 30%; text-align: left; vertical-align: middle; }
        .header-logo img { max-height: 45px; }
        .header-text { width: 70%; text-align: right; vertical-align: middle; }
        .header-text h1 {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 900;
            color: #041B4A;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-text p { margin: 5px 0 0 0; font-size: 11px; color: #64748b; }
        .text-blue { color: #0066FF; font-weight: 700; }

        /* --- KOTAK RINGKASAN (SUMMARY BOX) --- */
        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-box td {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: center;
            width: 25%;
        }
        .summary-box .title {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            letter-spacing: 0.5px;
        }
        .summary-box .value {
            font-size: 14px;
            font-weight: bold;
            color: #041B4A;
        }

        /* --- JUDUL BAGIAN --- */
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: bold;
            color: #041B4A;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
        }

        /* --- BAGIAN TABEL DATA --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e2e8f0;
            padding: 10px 8px;
        }
        .data-table th {
            background-color: #041B4A;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        .data-table tfoot th, .data-table tfoot td {
            background-color: #0066FF;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid #0066FF;
        }

        /* --- KELAS UTILITAS --- */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* --- BAGIAN CATATAN KAKI (FOOTER) --- */
        .footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 10px;
            color: #94a3b8;
        }
        .footer-table { width: 100%; border: none; }
        .footer-table td { border: none; padding: 0; }
    </style>
</head>
<body>

    <!-- KOP LAPORAN -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('logoticksid.png') }}" alt="Ticks ID Logo">
            </td>
            <td class="header-text">
                <h1>Laporan Keuangan <span style="color: #FF7A00;">Event</span></h1>
                <p>
                    Periode:
                    <span class="text-blue">{{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'Awal' }}</span>
                    s/d
                    <span class="text-blue">{{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Sekarang' }}</span>
                </p>
                <p>Dicetak oleh: <strong>{{ Auth::user()->name }}</strong> ({{ strtoupper(Auth::user()->role) }})</p>
            </td>
        </tr>
    </table>

    <!-- KOTAK RINGKASAN (BARU) -->
    <table class="summary-box">
        <tr>
            <td>
                <span class="title">Total Pendapatan</span>
                <span class="value" style="color: #0066FF;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="title">Tiket Terjual</span>
                <span class="value" style="color: #FF7A00;">{{ $totalTiket }} Pax</span>
            </td>
            <td>
                <span class="title">Event Aktif</span>
                <span class="value" style="color: #A100FF;">{{ $activeEventsCount }} Event</span>
            </td>
            <td>
                <span class="title">Event Selesai</span>
                <span class="value">{{ $inactiveEventsCount }} Event</span>
            </td>
        </tr>
    </table>

    <!-- TABEL TOP 5 EVENT POPULER (BARU) -->
    <div class="section-title">Top 5 Event Populer (Terlaris)</div>
    <table class="data-table" style="margin-bottom: 25px;">
        <thead>
            <tr>
                <th width="15%" class="text-center">Peringkat</th>
                <th width="65%">Nama Event</th>
                <th width="20%" class="text-center">Tiket Terjual</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @forelse($popularEventsList as $eventName => $ticketsCount)
                <tr>
                    <td class="text-center font-bold" style="color: #FF7A00;">#{{ $rank++ }}</td>
                    <td class="font-bold">{{ $eventName }}</td>
                    <td class="text-center">{{ $ticketsCount }} Tiket</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data event populer.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TABEL RINCIAN TRANSAKSI -->
    <div class="section-title">Rincian Transaksi Pendapatan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="20%">Tanggal Transaksi</th>
                <th width="40%">Nama Event</th>
                <th width="15%" class="text-center">Jml Tiket</th>
                <th width="25%" class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td class="font-bold">{{ $report->event->name ?? 'Event Terhapus' }}</td>
                    <td class="text-center">{{ $report->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($report->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding: 30px;">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-center">{{ $totalTiket }}</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="text-align: left;">
                    Dokumen resmi ini di-generate secara otomatis oleh Sistem <strong>Ticks ID</strong>.
                </td>
                <td style="text-align: right;">
                    Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
