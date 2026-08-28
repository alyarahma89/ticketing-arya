<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan - Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Exo+2:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Exo 2', sans-serif; }
        .text-gradient-blue { background: linear-gradient(135deg,#0066FF,#00C2FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 flex flex-col min-h-screen">

    <!-- Navbar Sederhana -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 py-4">
        <div class="max-w-4xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-slate-600 hover:text-[#0066FF] transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Beranda
            </a>
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID" class="h-8 w-auto object-contain block dark:hidden">
                <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID" class="h-8 w-auto object-contain hidden dark:block">
            </a>
        </div>
    </nav>

    <!-- Konten Dokumen -->
    <main class="flex-grow py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-200">
                <h1 class="font-montserrat font-black text-3xl md:text-4xl mb-2 text-gradient-blue">Syarat & Ketentuan</h1>
                <p class="text-sm text-slate-500 mb-8 border-b pb-4">Pembaruan Terakhir: {{ date('d F Y') }}</p>

                <div class="space-y-6 text-slate-700 leading-relaxed">
                    <h3 class="font-bold text-xl text-slate-900">1. Ketentuan Umum</h3>
                    <p>Dengan mengakses dan menggunakan layanan ARTIX ID, Anda menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Sistem kami bertindak sebagai perantara antara penyelenggara acara (Event Organizer) dan pembeli tiket.</p>

                    <h3 class="font-bold text-xl text-slate-900 mt-6">2. Pembelian Tiket</h3>
                    <p>Semua tiket yang dibeli melalui platform ARTIX ID adalah sah. Pembeli wajib membawa identitas asli yang sesuai dengan nama pada E-Ticket saat melakukan registrasi ulang di lokasi acara.</p>

                    <h3 class="font-bold text-xl text-slate-900 mt-6">3. Tanggung Jawab Penyelenggara</h3>
                    <p>ARTIX ID tidak bertanggung jawab atas isi, kualitas, atau perubahan jadwal dari acara yang diselenggarakan. Segala bentuk keluhan terkait pelaksanaan acara merupakan tanggung jawab penuh pihak penyelenggara acara (Mitra/EO).</p>

                    <!-- Tambahkan teks legalitas lainnya sesuai kebutuhan mitramu di sini -->
                </div>
            </div>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
