<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Scanner - ARTIX ID</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Pola grid halus untuk latar belakang */
        .bg-grid-light {
            background-size: 24px 24px;
            background-image:
                linear-gradient(to right, rgba(0, 132, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 132, 255, 0.05) 1px, transparent 1px);
        }

        /* Styling kustom untuk menimpa elemen bawaan library html5-qrcode */
        #reader {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 2px dashed rgba(0, 132, 255, 0.3) !important;
            background: rgba(0, 132, 255, 0.02);
            padding: 0;
        }
        #reader__scan_region { background: white; }
        #reader__scan_region img { object-fit: cover; }
        #reader__dashboard { padding: 15px; }
        #reader button {
            background: #0084FF;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin: 5px;
        }
        #reader button:hover { background: #006BB3; }
        #reader a { color: #0084FF; text-decoration: none; }
    </style>
</head>
<body class="bg-[#EEF4FB] bg-grid-light flex flex-col items-center justify-center min-h-screen p-4 relative overflow-x-hidden">

    <!-- Ambient Glow Sorotan di Belakang Card -->
    <div class="absolute w-[30rem] h-[30rem] bg-gradient-to-tr from-[#0084FF]/20 to-[#00D2FF]/20 rounded-full blur-3xl pointer-events-none top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-0"></div>

    <!-- Frame Gradient Border untuk Card -->
    <div class="relative z-10 w-full max-w-md p-[2px] rounded-3xl bg-gradient-to-b from-[#0084FF]/40 via-white to-transparent shadow-[0_20px_50px_rgba(0,132,255,0.15)] transition-all">

        <!-- Wrapper Utama (Glassmorphism) -->
        <div class="bg-white/95 backdrop-blur-xl rounded-[22px] overflow-hidden relative shadow-inner">

            <!-- Hiasan Sinar Atas Card -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0084FF] via-[#00D2FF] to-[#0084FF]"></div>

            <!-- Header Scanner -->
            <div class="px-6 pt-8 pb-4 text-center">
                <div class="w-12 h-12 bg-blue-50 text-[#0084FF] rounded-xl border border-blue-100/80 flex items-center justify-center mx-auto mb-3 text-2xl shadow-sm">
                    📷
                </div>
                <h1 class="text-2xl font-extrabold text-[#0B1A30] tracking-tight">SCANNER PANITIA</h1>
                <p class="text-sm text-gray-500 mt-1">Arahkan kamera ke QR Code tiket peserta</p>
            </div>

            <!-- Area Kamera & Pesan -->
            <div class="px-6 pb-8">
                <!-- Wrapper Kamera dengan Efek Glow saat Aktif -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#0084FF] to-[#00D2FF] rounded-[20px] blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                    <div id="reader" class="relative z-10 shadow-sm bg-white"></div>
                </div>

                <!-- Tempat memunculkan pesan sukses/error -->
                <div id="result-box" class="mt-5 p-4 rounded-xl hidden text-center font-semibold text-sm border shadow-sm transition-all duration-300 transform translate-y-2 opacity-0"></div>

                <!-- Tombol Kembali -->
                <div class="mt-8 text-center">
                    <a href="{{ route('panitia.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0084FF] transition-colors bg-gray-50 hover:bg-blue-50 py-2.5 px-5 rounded-full border border-gray-200 hover:border-blue-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Library Javascript HTML5-QRCode -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const resultBox = document.getElementById('result-box');
        let isScanning = false;

        // Fungsi pembantu untuk animasi result box
        function showResult(type, message) {
            resultBox.classList.remove('hidden', 'translate-y-2', 'opacity-0');

            if (type === 'loading') {
                resultBox.className = "mt-5 p-4 rounded-xl text-center font-semibold text-sm border shadow-sm transition-all duration-300 block bg-blue-50 text-blue-700 border-blue-200 animate-pulse";
                resultBox.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Mengecek tiket...
                    </div>`;
            } else if (type === 'success') {
                resultBox.className = "mt-5 p-4 rounded-xl text-center text-sm border shadow-sm transition-all duration-300 block bg-emerald-50 text-emerald-700 border-emerald-200";
                resultBox.innerHTML = `
                    <div class="font-bold text-base mb-1">✅ BERHASIL</div>
                    <div>${message}</div>`;
            } else {
                resultBox.className = "mt-5 p-4 rounded-xl text-center text-sm border shadow-sm transition-all duration-300 block bg-red-50 text-red-700 border-red-200";
                resultBox.innerHTML = `
                    <div class="font-bold text-base mb-1">❌ GAGAL</div>
                    <div>${message}</div>`;
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if(isScanning) return;
            isScanning = true;

            showResult('loading', '');

            fetch('/check-in-process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ order_id: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showResult('success', `${data.message}<br><span class="text-emerald-900 font-semibold mt-1 block">Peserta: ${data.participant_name}</span>`);
                } else {
                    showResult('error', data.message);
                }

                // Sembunyikan notifikasi setelah 3 detik
                setTimeout(() => {
                    isScanning = false;
                    resultBox.classList.add('translate-y-2', 'opacity-0');
                    setTimeout(() => resultBox.classList.add('hidden'), 300); // Tunggu animasi transisi selesai
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                showResult('error', 'Terjadi kesalahan sistem. Coba lagi.');
                isScanning = false;
            });
        }

        // Inisialisasi Kamera dengan UI yang lebih bersih
        let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: {width: 250, height: 250},
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
            showTorchButtonIfSupported: true
        });

        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
