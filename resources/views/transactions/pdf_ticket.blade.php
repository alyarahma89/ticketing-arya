<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket {{ $transaction->order_id }} | ARTIX ID</title>
    <style>
        /* Pengaturan Dasar Halaman */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 30px 20px;
        }

        /* ── KERANGKA UTAMA BOARDING PASS ── */
        .ticket-wrapper {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #CBD5E1;
            border-radius: 16px;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
            background-color: #ffffff;
        }

        /* ── BAGIAN HEADER (Navy Gelap Premium) ── */
        .header-row td {
            background-color: #041B4A; /* Warna Navy ARTIX ID */
            color: #ffffff;
            padding: 15px 25px;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }
        .header-left {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #00C2FF; /* Aksen biru muda */
        }
        .header-right {
            text-align: right;
            border-left: 2px dashed #1E3A8A;
        }
        .brand-logo {
            height: 28px; /* Ukuran proporsional untuk logo */
            vertical-align: middle;
        }

        /* ── BAGIAN ISI (Putih) ── */
        .body-row td {
            padding: 25px;
            vertical-align: top;
        }
        .body-left {
            width: 70%;
            background-color: #ffffff;
            border-bottom-left-radius: 14px;
        }

        /* ── EFEK SOBEKAN TIKET (Kanan) ── */
        .body-right {
            width: 30%;
            background-color: #F8FAFC;
            border-left: 3px dashed #CBD5E1; /* Garis sobekan lebih tebal */
            text-align: center;
            border-bottom-right-radius: 14px;
        }

        /* ── TIPOGRAFI TEKS ── */
        .lbl {
            display: block;
            font-size: 10px;
            color: #64748B;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .val {
            display: block;
            font-size: 15px;
            color: #020C1F;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .val-large {
            display: block;
            font-size: 26px;
            color: #0066FF;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        /* ── AREA QR CODE ── */
        .qr-wrapper {
            background: #ffffff;
            padding: 12px;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            display: inline-block;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .ticket-code-text {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #0066FF;
            letter-spacing: 2px;
            background-color: #E6F0FF;
            padding: 5px;
            border-radius: 4px;
            margin-top: 5px;
        }

        /* ── SYARAT & KETENTUAN BAWAH TIKET ── */
        .terms-wrapper {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px 15px;
            font-size: 9px;
            color: #64748B;
            line-height: 1.4;
            text-align: justify;
        }
    </style>
</head>
<body>

    <!-- MENGULANG CETAKAN TIKET SEBANYAK JUMLAH YANG DIBELI -->
    @foreach($transaction->tickets as $index => $ticket)

    <!-- Tabel Pembungkus Utama -->
    <table class="ticket-wrapper">

        <!-- BARIS 1: HEADER -->
        <tr class="header-row">
            <td class="header-left">
                OFFICIAL E-TICKET
            </td>
            <td class="header-right">
                <!-- Memanggil Logo dari folder public -->
                <img src="{{ public_path('main_logo.png') }}" alt="ARTIX ID" class="brand-logo">
            </td>
        </tr>

        <!-- BARIS 2: ISI TIKET -->
        <tr class="body-row">

            <!-- KOLOM KIRI: Detail Utama -->
            <td class="body-left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3">
                            <span class="lbl">Nama Event</span>
                            <span class="val-large">{{ $transaction->event->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="45%">
                            <span class="lbl">Nama Pemesan (Guest)</span>
                            <span class="val">{{ strtoupper($transaction->user->name) }}</span>
                        </td>
                        <td width="25%">
                            <span class="lbl">Tanggal</span>
                            <span class="val">{{ date('d M Y', strtotime($transaction->event->event_date)) }}</span>
                        </td>
                        <td width="30%">
                            <span class="lbl">Waktu</span>
                            <span class="val">{{ date('H:i', strtotime($transaction->event->event_date)) }} WIB</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span class="lbl">Lokasi / Venue</span>
                            <span class="val" style="margin-bottom: 0;">{{ $transaction->event->location ?? 'Lokasi Belum Ditentukan' }}</span>
                        </td>
                        <td>
                            <span class="lbl">Order ID</span>
                            <span class="val" style="color: #FF7A00; margin-bottom: 0;">#{{ $transaction->order_id }}</span>
                        </td>
                    </tr>
                </table>
            </td>

            <!-- KOLOM KANAN: Sobekan Tiket & QR Code -->
            <td class="body-right">
                <span class="lbl">Tiket Ke</span>
                <span class="val" style="font-size: 18px; color: #FF7A00;">{{ $index + 1 }} <span style="font-size: 12px; color: #64748B;">dari {{ $transaction->quantity }}</span></span>

                <span class="lbl">Kategori</span>
                <span class="val" style="font-size: 14px;">{{ strtoupper($transaction->event->category->name ?? 'UMUM') }}</span>

                <!-- Target QR Code -->
                <div class="qr-wrapper">
                    <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(110)->generate($ticket->ticket_code)) }}" alt="QR Code" width="110" height="110">
                </div>

                <!-- Teks kode unik -->
                <span class="ticket-code-text">
                    {{ $ticket->ticket_code }}
                </span>

                <span style="display: block; font-size: 9px; color: #94A3B8; margin-top: 8px; font-weight: bold;">
                    SCAN DI GERBANG MASUK
                </span>
            </td>

        </tr>
    </table>

    <!-- SYARAT DAN KETENTUAN -->
    <div class="terms-wrapper">
        <strong>PENTING:</strong> 1. Tiket yang sudah dibeli bersifat Non-Refundable (tidak dapat diuangkan kembali). 2. Pengunjung wajib menunjukkan E-Ticket (QR Code) ini saat registrasi di lokasi acara. 3. Satu (1) QR Code hanya berlaku untuk 1 (satu) kali akses masuk (1 Tiket = 1 Orang). 4. Pihak penyelenggara berhak menolak pengunjung yang terbukti memalsukan atau menggandakan tiket ini.
    </div>

    <!-- ── KODE SAKTI PEMOTONG HALAMAN ── -->
    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif

    @endforeach

</body>
</html>
