<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Refund - ARTIX ID</title>
    <icon rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Exo+2:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Exo 2', sans-serif; }
        .text-gradient-orange { background: linear-gradient(135deg,#FF7A00,#FF3B30); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 flex flex-col min-h-screen">

    <!-- Navbar Sederhana -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 py-4">
        <div class="max-w-4xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-slate-600 hover:text-[#FF7A00] transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Beranda
            </a>
            <h1 class="font-montserrat font-black text-xl">ARTIX <span class="text-[#FF7A00]">ID</span></h1>
        </div>
    </nav>

    <!-- Konten Dokumen -->
    <main class="flex-grow py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-200">
                <h1 class="font-montserrat font-black text-3xl md:text-4xl mb-2 text-gradient-orange">Kebijakan Pengembalian Dana (Refund)</h1>
                <p class="text-sm text-slate-500 mb-8 border-b pb-4">Pembaruan Terakhir: {{ date('d F Y') }}</p>

                <div class="space-y-6 text-slate-700 leading-relaxed">
                    <h3 class="font-bold text-xl text-slate-900">1. Pembatalan Acara oleh Penyelenggara</h3>
                    <p>Apabila acara dibatalkan sepenuhnya oleh pihak penyelenggara (Event Organizer), pembeli tiket berhak mendapatkan pengembalian dana penuh (100%) tidak termasuk biaya admin layanan (*platform fee*). Proses pencairan dana akan dilakukan maksimal 14 hari kerja setelah pengumuman resmi.</p>

                    <h3 class="font-bold text-xl text-slate-900 mt-6">2. Penundaan Acara atau Perubahan Jadwal</h3>
                    <p>Jika terjadi penundaan atau perubahan jadwal acara, tiket yang sudah dibeli akan otomatis berlaku untuk tanggal yang baru. Apabila pembeli tidak dapat hadir pada tanggal yang baru, pembeli berhak mengajukan refund dalam batas waktu yang akan diumumkan oleh penyelenggara.</p>

                    <h3 class="font-bold text-xl text-slate-900 mt-6">3. Ketidakhadiran Pembeli (No-Show)</h3>
                    <p>Tiket yang sudah dibeli **TIDAK DAPAT** dikembalikan (Non-refundable) apabila pembeli batal hadir karena alasan pribadi, keterlambatan, atau kesalahan pembeli dalam membaca detail waktu dan lokasi acara.</p>
                </div>
            </div>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
