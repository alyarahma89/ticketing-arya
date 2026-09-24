<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>E-Ticket Resmi {{ $transaction->order_id }} - Ticks ID</title>
</head>
<body style="margin: 0; padding: 20px 10px; background-color: #0F172A; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <div style="max-width: 720px; margin: 0 auto;">

        @foreach($transaction->tickets as $index => $ticket)

        @php
            // Palet warna resmi Ticks ID
            $artixPalette = ['#0066FF', '#FF7A00', '#A100FF', '#FF3B30', '#00C2FF'];
            $themeColor = $artixPalette[$transaction->event_id % count($artixPalette)];
            $isOnlineTicket = (strtolower($transaction->ticket_type) === 'online' || stripos($transaction->ticket_type, 'livestream') !== false || stripos($transaction->ticket_type, 'online') !== false);

            // Detail Paket Tiket
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
        @endphp

        <!-- ── TABEL BOARDING PASS TIKET ── -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #FFFFFF; border: 2px solid #CBD5E1; border-radius: 16px; overflow: hidden; margin-bottom: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            
            <!-- 1. HEADER BAR -->
            <tr>
                <td colspan="2" style="background-color: #041B4A; padding: 12px 20px; border-bottom: 2px solid #0066FF;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td align="left" style="vertical-align: middle;">
                                <span style="font-size: 11px; font-weight: 900; letter-spacing: 2px; color: #00C2FF; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                    OFFICIAL E-TICKET | TICKS ID
                                </span>
                            </td>
                            <td align="right" style="vertical-align: middle;">
                                <table cellpadding="0" cellspacing="0" border="0" align="right" style="border-collapse: collapse;">
                                    <tr>
                                        <td style="background-color: #0066FF; color: #FFFFFF; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 5px; letter-spacing: 1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">TICKS</td>
                                        <td style="color: #00C2FF; font-size: 12px; font-weight: 900; padding-left: 4px; letter-spacing: 1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">.ID</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- 2. ISI TIKET: KOLOM KIRI (UTAMA) & KOLOM KANAN (SOBEKAN) -->
            <tr>
                <!-- KOLOM KIRI (70%): Detail Acara & Paket -->
                <td width="70%" style="background-color: #FFFFFF; padding: 18px 18px 14px 18px; vertical-align: top;">
                    
                    <!-- HERO BANNER EVENT -->
                    <div style="background-color: #041B4A; border-radius: 12px; padding: 14px 16px; margin-bottom: 12px; color: #FFFFFF;">
                        <span style="background-color: rgba(0, 194, 255, 0.25); color: #00C2FF; font-size: 8.5px; font-weight: 900; padding: 2px 7px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 6px;">
                            {{ $transaction->event->category->name ?? 'EVENT RESMI' }}
                        </span>
                        
                        <h1 style="font-size: 17px; font-weight: 900; color: #FFFFFF; text-transform: uppercase; margin: 0 0 10px 0; line-height: 1.25; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                            {{ $transaction->event->name }}
                        </h1>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="55%" style="vertical-align: top; padding: 0;">
                                    <span style="font-size: 8.5px; font-weight: 800; color: #00C2FF; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px;">WAKTU PELAKSANAAN</span>
                                    <span style="font-size: 11.5px; font-weight: bold; color: #FFFFFF; display: block; line-height: 1.25;">
                                        {{ date('d M Y', strtotime($transaction->event->event_date)) }} | {{ date('H:i', strtotime($transaction->event->event_date)) }} WIB
                                    </span>
                                </td>
                                <td width="45%" style="vertical-align: top; padding: 0;">
                                    <span style="font-size: 8.5px; font-weight: 800; color: #00C2FF; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px;">{{ $isOnlineTicket ? 'FORMAT ACARA' : 'LOKASI VENUE' }}</span>
                                    <span style="font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; line-height: 1.25;">
                                        {{ $isOnlineTicket ? 'Online via Livestream' : ($transaction->event->location ?? 'Venue Acara') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- KOTAK DETAIL PAKET TIKET -->
                    <div style="background-color: #F8FAFC; border: 1.5px solid #E2E8F0; border-left: 6px solid {{ $themeColor }}; border-radius: 10px; padding: 10px 14px; margin-bottom: 12px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="vertical-align: middle; padding: 0;">
                                    <span style="font-size: 8.5px; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; display: block;">KATEGORI & PAKET TIKET</span>
                                    <span style="font-size: 15px; font-weight: 900; color: {{ $themeColor }}; text-transform: uppercase; display: block; margin-top: 1px;">
                                        {{ $packageName }}
                                    </span>
                                    @if($packageDesc)
                                        <span style="font-size: 10px; font-weight: 600; color: #475569; display: block; margin-top: 3px; line-height: 1.3;">
                                            <strong style="color: #0F172A;">Fasilitas / Benefit:</strong> {{ $packageDesc }}
                                        </span>
                                    @endif
                                </td>
                                <td align="right" style="vertical-align: middle; width: 30%; padding: 0;">
                                    <span style="font-size: 8.5px; font-weight: 800; color: #64748B; text-transform: uppercase; display: block; margin-bottom: 2px;">STATUS TIKET</span>
                                    <span style="font-size: 9.5px; font-weight: 900; background-color: #DCFCE7; color: #15803D; padding: 3px 8px; border-radius: 20px; display: inline-block;">
                                        LUNAS (VALID)
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if($isOnlineTicket && !empty($transaction->event->youtube_link))
                    <!-- LINK LIVESTREAM -->
                    <div style="background-color: #FEF2F2; border: 1.5px solid #FCA5A5; border-left: 6px solid #EF4444; border-radius: 10px; padding: 10px 12px; margin-bottom: 12px; text-align: center;">
                        <span style="font-size: 9px; font-weight: 900; color: #DC2626; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">
                            LINK RESMI LIVESTREAM YOUTUBE
                        </span>
                        <a href="{{ $transaction->event->youtube_link }}" target="_blank" style="display: inline-block; background-color: #DC2626; color: #FFFFFF; font-weight: 800; font-size: 11px; text-decoration: none; padding: 7px 16px; border-radius: 6px; margin: 4px 0;">
                            KLIK UNTUK NONTON SIARAN
                        </a>
                        <span style="font-size: 9.5px; color: #991B1B; font-weight: bold; word-break: break-all; display: block; margin-top: 4px;">
                            {{ $transaction->event->youtube_link }}
                        </span>
                    </div>
                    @endif

                    <!-- TABEL INFORMASI PESANAN -->
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top: 1px solid #E2E8F0; padding-top: 8px; margin-top: 6px;">
                        <tr>
                            <td width="40%" style="vertical-align: top; padding: 4px 6px 4px 0; border-right: 1px solid #E2E8F0;">
                                <span style="font-size: 8.5px; font-weight: 800; color: #64748B; text-transform: uppercase; display: block; margin-bottom: 2px;">NAMA PEMESAN</span>
                                <span style="font-size: 12px; font-weight: 800; color: #0F172A; display: block;">{{ strtoupper($transaction->user->name ?? 'GUEST') }}</span>
                            </td>
                            <td width="35%" style="vertical-align: top; padding: 4px 6px 4px 10px; border-right: 1px solid #E2E8F0;">
                                <span style="font-size: 8.5px; font-weight: 800; color: #64748B; text-transform: uppercase; display: block; margin-bottom: 2px;">ORDER ID</span>
                                <span style="font-size: 11.5px; font-weight: 800; color: #0066FF; display: block;">#{{ $transaction->order_id }}</span>
                            </td>
                            <td width="25%" style="vertical-align: top; padding: 4px 0 4px 10px;">
                                <span style="font-size: 8.5px; font-weight: 800; color: #64748B; text-transform: uppercase; display: block; margin-bottom: 2px;">TOTAL HARGA</span>
                                <span style="font-size: 11.5px; font-weight: 800; color: #0F172A; display: block;">
                                    {{ $transaction->total_amount == 0 ? 'GRATIS' : 'Rp ' . number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </table>

                </td>

                <!-- KOLOM KANAN (30%): SOBEKAN TIKET & QR CODE SCANNER (HIGH CONTRAST & EMAIL PROOF) -->
                <td width="30%" style="background-color: #F8FAFC; border-left: 2px dashed #94A3B8; padding: 18px 12px; text-align: center; vertical-align: top;">
                    
                    <!-- BRANDING KECIL DI STUB -->
                    <div style="font-size: 12px; font-weight: 900; color: #0066FF; letter-spacing: 1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin-bottom: 2px;">
                        TICKS ID
                    </div>
                    
                    <div style="font-size: 13px; font-weight: 900; color: #041B4A; letter-spacing: 1px; margin-bottom: 1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        E-TICKET
                    </div>
                    
                    <div style="font-size: 9px; font-weight: 700; color: #64748B; text-transform: uppercase; margin-bottom: 8px;">
                        Tiket {{ $index + 1 }} dari {{ $transaction->quantity }}
                    </div>

                    <!-- BADGE KATEGORI MINI -->
                    <div style="margin-bottom: 8px;">
                        <span style="font-size: 8.5px; font-weight: 900; color: #FFFFFF; background-color: {{ $themeColor }}; padding: 3px 8px; border-radius: 6px; display: inline-block; text-transform: uppercase;">
                            {{ strtoupper($packageName) }}
                        </span>
                    </div>

                    <!-- KOTAK QR CODE DENGAN BACKGROUND PUTIH SOLID (TIDAK AKAN HILANG DI GMAIL DARK MODE) -->
                    <div style="background-color: #FFFFFF !important; padding: 8px; border: 2px solid #CBD5E1; border-radius: 12px; display: inline-block; margin: 0 auto 6px auto; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ $ticket->ticket_code }}&color=041B4A&bgcolor=ffffff" 
                             alt="QR Code Tiket" 
                             width="110" 
                             height="110" 
                             style="display: block; width: 110px; height: 110px; margin: 0 auto; background-color: #FFFFFF; border: 0;">
                    </div>

                    <!-- KODE TIKET UNIK -->
                    <div style="background-color: #041B4A; color: #FFFFFF; font-family: Consolas, 'Courier New', monospace; font-size: 11px; font-weight: 900; letter-spacing: 1.5px; padding: 5px 8px; border-radius: 6px; display: inline-block; margin-top: 4px; border: 1px solid #1E293B;">
                        {{ $ticket->ticket_code }}
                    </div>

                    <!-- PETUNJUK CHECK-IN -->
                    <div style="margin-top: 10px; padding-top: 8px; border-top: 1px dashed #CBD5E1;">
                        <p style="font-size: 8.5px; font-weight: 700; color: #475569; margin: 0; line-height: 1.35; text-align: center;">
                            @if($isOnlineTicket)
                                Akses Siaran<br>Langsung Online
                            @else
                                Tunjukkan QR Code ini<br>di Pintu Masuk Event
                            @endif
                        </p>
                    </div>

                </td>
            </tr>
        </table>

        <!-- 3. SYARAT & KETENTUAN PENGGUNAAN TIKET -->
        <div style="background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 24px; font-size: 8.5px; color: #64748B; line-height: 1.45;">
            <strong style="color: #0F172A; text-transform: uppercase;">Ketentuan Tiket Resmi:</strong><br>
            1. Tiket ini merupakan tanda bukti masuk sah yang diterbitkan resmi oleh Ticks ID.<br>
            2. Satu (1) QR Code hanya berlaku untuk 1 (satu) kali scan masuk (1 Tiket = 1 Orang).<br>
            3. Dilarang menggandakan atau menyebarluaskan gambar QR Code tiket ini kepada pihak lain.<br>
            4. Tunjukkan tiket ini dalam bentuk cetak atau langsung melalui layar HP saat registrasi di venue acara.
        </div>

        @endforeach

    </div>

</body>
</html>
