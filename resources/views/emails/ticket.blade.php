<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket ARTIX ID</title>
    <!-- Tautan Google Fonts TELAH DIHAPUS agar aman di DomPDF -->
    <style>
        /* Pengaturan Dasar Email */
        body {
            font-family: Helvetica, Arial, sans-serif; /* Menggunakan font standar yang sangat aman */
            background-color: #F8FAFC;
            margin: 0;
            padding: 40px 20px;
        }
        /* Pembungkus utama tiket */
        .ticket-box {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background-color: #ffffff;
        }
        /* Layout menggunakan Tabel (Paling aman untuk semua aplikasi Email) */
        table { width: 100%; border-collapse: collapse; margin: 0; padding: 0; }
        td { padding: 0; vertical-align: top; }

        /* Area Kiri (Warna Tema) */
        .main-area {
            width: 70%;
            padding: 30px;
        }

        /* Area Dark Navy di Dalam Tiket Utama */
        .inner-navy-box {
            background-color: #041B4A; /* Warna Navy ARTIX */
            color: #ffffff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .event-title {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 26px;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0 0 20px 0;
            line-height: 1.2;
            color: #ffffff;
        }

        .label-text {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 4px 0;
        }

        .value-text {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        /* Area Sobekan Kanan (Stub) */
        .stub-area {
            background-color: #ffffff;
            width: 30%;
            text-align: center;
            border-left: 3px dashed #CBD5E1; /* Garis putus-putus */
            padding: 30px 20px;
        }

        /* Kunci untuk Cetak PDF / Multi-Halaman */
        .page-break { page-break-after: always; padding-bottom: 30px; }
        .page-break:last-child { page-break-after: auto; }
    </style>
</head>
<body>

    @foreach($transaction->tickets as $index => $ticket)

    @php
        // RUMUS WARNA DINAMIS: Palet Warna Resmi ARTIX ID
        // Berisi: Biru, Oranye, Ungu, Merah, Cyan
        $artixPalette = ['#0066FF', '#FF7A00', '#A100FF', '#FF3B30', '#00C2FF'];
        $themeColor = $artixPalette[$transaction->event_id % count($artixPalette)];
    @endphp

    <div class="page-break">
        <div class="ticket-box">
            <table>
                <tr>
                    <!-- ── BAGIAN KIRI (DETAIL UTAMA) ── -->
                    <td class="main-area" style="background-color: {{ $themeColor }};">

                        <!-- Kotak Informasi Event -->
                        <div class="inner-navy-box">
                            <h1 class="event-title">{{ $transaction->event->name }}</h1>

                            <table>
                                <tr>
                                    <td style="width: 70%;">
                                        <p class="label-text" style="color: #00C2FF;">Waktu Pelaksanaan</p>
                                        <p class="value-text" style="margin-bottom: 15px;">
                                            {{ date('d M Y', strtotime($transaction->event->event_date)) }} | {{ date('H:i', strtotime($transaction->event->event_date)) }} WIB
                                        </p>

                                        <p class="label-text" style="color: #00C2FF;">Lokasi Acara</p>
                                        <p class="value-text" style="font-size: 13px;">{{ $transaction->event->location }}</p>
                                    </td>
                                    <td style="width: 30%; text-align: right; vertical-align: middle;">
                                        <!-- QR Code Kecil di Kiri (Warna Navy di atas Putih agar mudah di-scan) -->
                                        <div style="background-color: #ffffff; padding: 6px; border-radius: 8px; display: inline-block;">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ $ticket->ticket_code }}&color=041B4A&bgcolor=ffffff" width="80" height="80" alt="QR Event" style="display: block;">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Data Transaksi Pengunjung -->
                        <table style="width: 100%; margin-top: 20px; color: #ffffff;">
                            <tr>
                                <td>
                                    <span class="label-text" style="color: rgba(255,255,255,0.7); display: block;">Pemesan</span>
                                    <span style="font-size: 16px; font-weight: 700; font-family: Helvetica, Arial, sans-serif;">{{ strtoupper($transaction->user->name ?? 'PENGUNJUNG') }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="label-text" style="color: rgba(255,255,255,0.7); display: block;">Kategori</span>
                                    <span style="font-size: 16px; font-weight: 700; font-family: Helvetica, Arial, sans-serif;">{{ strtoupper($transaction->event->category->name ?? 'REGULER') }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <span class="label-text" style="color: rgba(255,255,255,0.7); display: block;">Order ID</span>
                                    <span style="font-size: 16px; font-weight: 700; font-family: Helvetica, Arial, sans-serif;">#{{ $transaction->order_id }}</span>
                                </td>
                            </tr>
                        </table>

                    </td>

                    <!-- ── BAGIAN KANAN (SOBEKAN / TANDA MASUK) ── -->
                    <td class="stub-area">
                        <!-- Panggil Logo ARTIX -->
                        <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID" style="max-width: 100px; margin-bottom: 20px;">

                        <p style="font-family: Helvetica, Arial, sans-serif; font-weight: 900; font-size: 18px; margin: 0 0 5px 0; color: #0F172A;">E-TICKET</p>
                        <p style="font-size: 11px; font-weight: 700; color: #64748B; margin: 0 0 20px 0; text-transform: uppercase;">Tiket {{ $index + 1 }} dari {{ $transaction->quantity }}</p>

                        <!-- QR Code Besar Utama (Hitam Putih agar sensor alat scan cepat membaca) -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ $ticket->ticket_code }}&color=0F172A&bgcolor=ffffff" width="140" height="140" alt="QR Scan" style="display: block; margin: 0 auto;">

                        <p style="font-family: Helvetica, Arial, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 2px; color: #0F172A; margin: 15px 0 0;">
                            {{ $ticket->ticket_code }}
                        </p>

                        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #E2E8F0;">
                            <p style="font-size: 10px; font-weight: 700; color: #94A3B8; margin: 0;">
                                Tunjukkan QR Code ini<br>saat masuk area event.
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach

</body>
</html>
