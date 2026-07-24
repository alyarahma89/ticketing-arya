<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - TICKS ID</title>
    <style>
        /* Desain khusus untuk kertas PDF */
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1c1e54; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 22px; color: #1c1e54; }
        .header p { margin: 5px 0 0 0; color: #555; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; color: #1c1e54; text-transform: uppercase; font-size: 11px;}

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #777; font-style: italic; }
    </style>
</head>
<body>

    <!-- BAGIAN HEADER (KOP LAPORAN) -->
    <div class="header">
        <h1>TICKS ID - LAPORAN PENDAPATAN</h1>
        <p>
            Periode:
            {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'Awal' }}
            s/d
            {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Sekarang' }}
        </p>
        <p>Dicetak oleh: {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})</p>
    </div>

    <!-- BAGIAN ISI (TABEL) -->
    <table>
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="40%">Nama Event</th>
                <th width="15%" class="text-center">Jml Tiket</th>
                <th width="25%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalUang = 0;
                $totalTiket = 0;
            @endphp

            @forelse($reports as $report)
                @php
                    $totalUang += $report->total_amount;
                    $totalTiket += $report->quantity;
                @endphp
                <tr>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $report->event->name ?? 'Event Terhapus' }}</td>
                    <td class="text-center">{{ $report->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($report->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <!-- BAGIAN TOTAL KESELURUHAN DI BAWAH TABEL -->
        <tfoot>
            <tr>
                <td colspan="2" class="text-right font-bold">TOTAL KESELURUHAN</td>
                <td class="text-center font-bold">{{ $totalTiket }}</td>
                <td class="text-right font-bold">Rp {{ number_format($totalUang, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- BAGIAN FOOTER -->
    <div class="footer">
        Dokumen ini di-generate secara otomatis oleh Sistem TICKS ID pada {{ \Carbon\Carbon::now()->format('d F Y H:i') }} WIB.
    </div>

</body>
</html>
