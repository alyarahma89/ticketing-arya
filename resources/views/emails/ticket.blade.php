<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket Resmi {{ $transaction->order_id }} - ARTIX ID</title>

    <style>
        /* Pengaturan Dasar Email & Dokumen PDF */
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #F8FAFC;
            margin: 0;
            padding: 20px 10px;
            color: #0F172A;
        }

        /* ── KERANGKA UTAMA BOARDING PASS TIKET ── */
        .ticket-wrapper {
            width: 100%;
            max-width: 780px;
            margin: 0 auto 15px auto;
            border: 2px solid #CBD5E1;
            border-radius: 16px;
            border-collapse: collapse;
            overflow: hidden;
            background-color: #FFFFFF;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            page-break-inside: avoid;
        }

        /* ── HEADER TIKET (Navy Gelap ARTIX) ── */
        .header-row td {
            background-color: #041B4A;
            color: #FFFFFF;
            padding: 10px 20px;
            vertical-align: middle;
        }
        .header-left {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #00C2FF;
            text-transform: uppercase;
        }
        .header-right {
            text-align: right;
            border-left: 2px dashed #1E3A8A;
            padding-left: 15px;
        }
        .header-logo-img {
            height: 26px;
            max-width: 130px;
            vertical-align: middle;
        }

        /* ── BADAN TIKET (Dua Kolom: Utama & Sobekan) ── */
        .body-row td {
            padding: 0;
            vertical-align: top;
        }
        .body-left {
            width: 72%;
            background-color: #FFFFFF;
            padding: 18px;
        }
        .body-right {
            width: 28%;
            background-color: #F8FAFC;
            border-left: 3px dashed #CBD5E1;
            padding: 16px 12px;
            text-align: center;
            vertical-align: top;
        }

        /* ── HERO BANNER EVENT DI DALAM TIKET ── */
        .event-hero-box {
            background-color: #041B4A;
            color: #FFFFFF;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }
        .category-badge {
            background-color: rgba(0, 194, 255, 0.25);
            color: #00C2FF;
            font-size: 8.5px;
            font-weight: 900;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .event-title {
            font-size: 16px;
            font-weight: 900;
            color: #FFFFFF;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            line-height: 1.25;
        }

        /* ── KOTAK PAKET TIKET & FASILITAS (HIGHLIGHT) ── */
        .package-box {
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 12px;
        }

        /* ── TABEL INFORMASI PESANAN ── */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .info-grid td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .lbl {
            font-size: 8.5px;
            font-weight: 800;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 2px;
        }
        .val {
            font-size: 11.5px;
            font-weight: 700;
            color: #0F172A;
            display: block;
        }

        /* ── AREA SOBEKAN / QR CODE (KANAN) ── */
        .stub-logo-img {
            height: 28px;
            max-width: 100px;
            margin: 0 auto 6px auto;
            display: block;
        }
        .stub-title {
            font-size: 13px;
            font-weight: 900;
            color: #0F172A;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .stub-subtitle {
            font-size: 8.5px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .package-pill {
            font-size: 8.5px;
            font-weight: 900;
            color: #FFFFFF;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .qr-card {
            background-color: #FFFFFF;
            padding: 6px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .ticket-code-badge {
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.2px;
            color: #041B4A;
            background-color: #E2E8F0;
            padding: 4px 6px;
            border-radius: 6px;
            display: block;
            margin-top: 2px;
        }

        /* ── SYARAT DAN KETENTUAN TIKET ── */
        .terms-box {
            width: 100%;
            max-width: 780px;
            margin: 0 auto 20px auto;
            padding: 7px 12px;
            font-size: 8px;
            color: #64748B;
            line-height: 1.35;
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
        }

        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
            page-break-after: auto;
        }
    </style>
</head>
<body>

    @foreach($transaction->tickets as $index => $ticket)

    @php
        // Palet warna resmi ARTIX ID
        $artixPalette = ['#0066FF', '#FF7A00', '#A100FF', '#FF3B30', '#00C2FF'];
        $themeColor = $artixPalette[$transaction->event_id % count($artixPalette)];
        $isOnlineTicket = (strtolower($transaction->ticket_type) === 'online' || stripos($transaction->ticket_type, 'livestream') !== false || stripos($transaction->ticket_type, 'online') !== false);

        // Pencarian detail paket tiket
        $matchedPackage = null;
        if ($transaction->ticketPackage) {
            $matchedPackage = $transaction->ticketPackage;
        } elseif ($transaction->event && $transaction->event->ticketPackages) {
            $matchedPackage = $transaction->event->ticketPackages->where('name', $transaction->ticket_type)->first();
        }

        if ($matchedPackage) {
            $packageName = $matchedPackage->name;
            $packageDesc = $matchedPackage->description;
        } elseif ($isOnlineTicket) {
            $packageName = 'AKSES VIRTUAL (LIVESTREAM)';
            $packageDesc = 'Saksikan siaran langsung via tautan resmi YouTube';
        } elseif (strtolower($transaction->ticket_type) === 'offline' || empty($transaction->ticket_type)) {
            $packageName = 'TIKET REGULER (OFFLINE)';
            $packageDesc = 'Akses standar masuk ke area venue acara';
        } else {
            $packageName = strtoupper($transaction->ticket_type);
            $packageDesc = null;
        }

        // Gambar Logo Resmi ARTIX
        $logoPutihPath = public_path('logo_putih.png');
        $mainLogoPath = public_path('main_logo.png');
    @endphp

    <div class="page-break">
        <!-- ── TABEL UTAMA BOARDING PASS TIKET ── -->
        <table class="ticket-wrapper" cellpadding="0" cellspacing="0">
            <!-- 1. HEADER BAR -->
            <tr class="header-row">
                <td class="header-left">
                    OFFICIAL E-TICKET | ARTIX ID
                </td>
                <td class="header-right">
                    @if(file_exists($logoPutihPath))
                        <img src="{{ $logoPutihPath }}" alt="ARTIX ID" class="header-logo-img">
                    @else
                        <span style="font-size: 15px; font-weight: 900; color: #FFFFFF;">ARTIX<span style="color: #00C2FF;">.ID</span></span>
                    @endif
                </td>
            </tr>

            <!-- 2. ISI TIKET -->
            <tr class="body-row">
                <!-- ── KOLOM KIRI (72%): DETAIL UTAMA ACARA & PAKET ── -->
                <td class="body-left">

                    <!-- HERO BANNER EVENT -->
                    <div class="event-hero-box">
                        <span class="category-badge">
                            {{ $transaction->event->category->name ?? 'EVENT RESMI' }}
                        </span>
                        <h1 class="event-title">{{ $transaction->event->name }}</h1>

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width: 55%; padding: 0; vertical-align: top;">
                                    <span class="lbl" style="color: #00C2FF;">WAKTU PELAKSANAAN</span>
                                    <span class="val" style="color: #FFFFFF; font-size: 11.5px;">
                                        {{ date('d M Y', strtotime($transaction->event->event_date)) }} | {{ date('H:i', strtotime($transaction->event->event_date)) }} WIB
                                    </span>
                                </td>
                                <td style="width: 45%; padding: 0; vertical-align: top;">
                                    <span class="lbl" style="color: #00C2FF;">{{ $isOnlineTicket ? 'FORMAT ACARA' : 'LOKASI VENUE' }}</span>
                                    <span class="val" style="color: #FFFFFF; font-size: 11px; line-height: 1.3;">
                                        {{ $isOnlineTicket ? 'Online via YouTube Livestream' : ($transaction->event->location ?? 'Venue Belum Ditentukan') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- KOTAK PAKET TIKET & FASILITAS (BERSIH & JELAS) -->
                    <div class="package-box" style="border-left: 6px solid {{ $themeColor }};">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align: middle; padding: 0;">
                                    <span class="lbl">KATEGORI & PAKET TIKET</span>
                                    <span style="font-size: 15px; font-weight: 900; color: {{ $themeColor }}; text-transform: uppercase; display: block; margin-top: 1px;">
                                        {{ $packageName }}
                                    </span>
                                    @if($packageDesc)
                                        <span style="font-size: 10px; font-weight: 600; color: #475569; display: block; margin-top: 3px; line-height: 1.3;">
                                            <strong style="color: #0F172A;">Fasilitas / Benefit:</strong> {{ $packageDesc }}
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right; vertical-align: middle; width: 30%; padding: 0;">
                                    <span class="lbl">STATUS TIKET</span>
                                    <span style="font-size: 9.5px; font-weight: 900; background-color: #DCFCE7; color: #15803D; padding: 3px 8px; border-radius: 20px; display: inline-block; margin-top: 2px;">
                                        LUNAS (VALID)
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if($isOnlineTicket && !empty($transaction->event->youtube_link))
                    <!-- KOTAK LINK LIVESTREAM YOUTUBE (BEBAS DARI TANDA TANYA EMOJI) -->
                    <div style="background-color: #FEF2F2; border: 1.5px solid #FCA5A5; border-left: 6px solid #EF4444; border-radius: 10px; padding: 10px 12px; margin-bottom: 12px; text-align: center;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align: middle; width: 14px; padding-right: 6px;">
                                    <div style="width: 8px; height: 8px; background-color: #DC2626; border-radius: 50%;"></div>
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <span style="font-size: 9px; font-weight: 900; color: #DC2626; text-transform: uppercase; letter-spacing: 0.5px; display: block;">
                                        LINK RESMI LIVESTREAM YOUTUBE
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <a href="{{ $transaction->event->youtube_link }}" target="_blank" style="display: inline-block; background-color: #DC2626; color: #FFFFFF; font-weight: 800; font-size: 10.5px; text-decoration: none; padding: 6px 14px; border-radius: 6px; margin: 5px 0;">
                            KLIK DI SINI UNTUK NONTON SIARAN
                        </a>
                        <span style="font-size: 9.5px; color: #991B1B; font-weight: bold; word-break: break-all; display: block;">
                            {{ $transaction->event->youtube_link }}
                        </span>
                    </div>
                    @endif

                    <!-- TABEL METADATA PEMESAN & TRANSAKSI -->
                    <table class="info-grid">
                        <tr>
                            <td style="width: 40%; border-right: 1px solid #E2E8F0;">
                                <span class="lbl">Nama Pemesan (Guest)</span>
                                <span class="val" style="font-size: 12px;">{{ strtoupper($transaction->user->name ?? 'GUEST') }}</span>
                            </td>
                            <td style="width: 32%; padding-left: 10px; border-right: 1px solid #E2E8F0;">
                                <span class="lbl">Order ID Transaksi</span>
                                <span class="val" style="color: #0066FF;">#{{ $transaction->order_id }}</span>
                            </td>
                            <td style="width: 28%; padding-left: 10px;">
                                <span class="lbl">Total Harga</span>
                                <span class="val" style="color: #0F172A;">
                                    {{ $transaction->total_amount == 0 ? 'GRATIS' : 'Rp ' . number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </table>

                </td>

                <!-- ── KOLOM KANAN (28%): SOBEKAN TIKET & QR CODE SCANNER ── -->
                <td class="body-right">
                    <!-- Logo ARTIX ID di Atas Sobekan -->
                    @if(file_exists($mainLogoPath))
                        <img src="{{ $mainLogoPath }}" alt="ARTIX ID" class="stub-logo-img">
                    @else
                        <div style="font-size: 12px; font-weight: 900; color: #0066FF; margin-bottom: 6px;">ARTIX ID</div>
                    @endif

                    <div class="stub-title">E-TICKET</div>
                    <div class="stub-subtitle">Tiket {{ $index + 1 }} dari {{ $transaction->quantity }}</div>

                    <!-- Badge Kategori Mini -->
                    <span class="package-pill" style="background-color: {{ $themeColor }};">
                        {{ strtoupper($packageName) }}
                    </span>

                    <!-- QR CODE (UNIVERSAL EMAIL + DOMPDF COMPATIBLE) -->
                    <div class="qr-card">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $ticket->ticket_code }}&color=041B4A&bgcolor=ffffff" alt="QR Code" width="100" height="100" style="display: block; margin: 0 auto;">
                    </div>

                    <!-- Kode Unik Tiket -->
                    <span class="ticket-code-badge">
                        {{ $ticket->ticket_code }}
                    </span>

                    <div style="margin-top: 10px; padding-top: 6px; border-top: 1px dashed #CBD5E1;">
                        <p style="font-size: 8px; font-weight: 700; color: #64748B; margin: 0; line-height: 1.3;">
                            @if($isOnlineTicket)
                                Akses Siaran<br>Langsung Online
                            @else
                                Tunjukkan QR Code ini<br>di Gerbang Masuk Event
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- SYARAT & KETENTUAN PENGGUNAAN TIKET -->
        <div class="terms-box">
            <strong style="color: #0F172A;">KETENTUAN TIKET RESMI:</strong> 
            1. Tiket ini merupakan tanda bukti masuk sah yang diterbitkan oleh ARTIX ID. 
            2. Satu (1) QR Code hanya berlaku untuk 1 (satu) kali scan masuk (1 Tiket = 1 Orang). 
            3. Dilarang menyebarluaskan QR Code kepada pihak lain. 
            4. Tunjukkan tiket ini dalam bentuk cetak atau layar HP saat registrasi di pintu masuk.
        </div>
    </div>

    @endforeach

</body>
</html>
