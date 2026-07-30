<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <style>
        /* Mengimpor font jika PDF engine mendukung (misal: mPDF atau wkhtmltopdf) */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Exo+2:wght@400;600;700&display=swap');

        /* Setel Font Default dan Ukuran Kertas */
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
            border-bottom: 3px solid #0066FF; /* Garis Artix Blue */
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-logo {
            width: 30%;
            text-align: left;
            vertical-align: middle;
        }
        .header-logo img {
            max-height: 45px; /* Sesuaikan tinggi logo */
        }
        .header-text {
            width: 70%;
            text-align: right;
            vertical-align: middle;
        }
        .header-text h1 {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 900;
            color: #041B4A; /* Deep Navy */
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-text p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #64748b;
        }
        .text-blue { color: #0066FF; font-weight: 700; }

        /* --- BAGIAN TABEL DATA --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e2e8f0;
            padding: 12px 10px;
        }
        .data-table th {
            background-color: #041B4A; /* Deep Navy */
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
            letter-spacing: 0.5px;
        }
        /* Efek Zebra (Belang-belang) untuk baris tabel */
        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Baris Total di Bawah Tabel */
        .data-table tfoot th, .data-table tfoot td {
            background-color: #0066FF; /* Artix Blue */
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid #0066FF;
        }

        /* --- KELAS UTILITAS --- */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* --- BAGIAN CATATAN KAKI (FOOTER) --- */
        /* Posisi fixed bottom memastikan footer muncul di setiap halaman PDF */
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
        .footer-table {
            width: 100%;
            border: none;
        }
        .footer-table td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>

    <!-- BAGIAN HEADER (KOP LAPORAN) MENGGUNAKAN TABEL -->
    <table class="header-table">
        <tr>
            <!-- Kolom Kiri: Logo -->
            <td class="header-logo">
                <!-- Penting: Gunakan public_path() agar library PDF bisa menemukan file gambar di server lokal -->
                <img src="{{ public_path('main_logo.png') }}" alt="ARTIX ID Logo">
            </td>

            <!-- Kolom Kanan: Informasi Laporan -->
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

    <!-- BAGIAN ISI (TABEL DATA) -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="20%">Tanggal Transaksi</th>
                <th width="40%">Nama Event</th>
                <th width="15%" class="text-center">Jml Tiket</th>
                <th width="25%" class="text-right">Total Pendapatan (Rp)</th>
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
        <!-- BAGIAN TOTAL KESELURUHAN DI BAWAH TABEL -->
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-center">{{ $totalTiket }}</td>
                <td class="text-right">Rp {{ number_format($totalUang, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- BAGIAN FOOTER -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="text-align: left;">
                    Dokumen resmi ini di-generate secara otomatis oleh Sistem <strong>ARTIX ID</strong>.
                </td>
                <td style="text-align: right;">
                    Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
