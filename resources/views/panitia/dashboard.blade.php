<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panitia - TICKS ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar Atas -->
    <div class="bg-[#1c1e54] text-white p-5 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold tracking-tight">TICKS ID <span class="text-[#F8B55F]">Panitia</span></h1>
            <p class="text-sm text-white/70">Selamat bertugas, {{ Auth::user()->name ?? 'Panitia' }}!</p>
        </div>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                Logout
            </button>
        </form>
    </div>

    <!-- Konten Utama -->
    <div class="flex-1 p-6 flex flex-col items-center justify-center">

        <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">
                📷
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Scan Tiket</h2>
            <p class="text-gray-500 text-sm mb-8">Buka kamera untuk melakukan check-in tiket peserta secara otomatis.</p>

            <!-- Tombol Menuju Scanner -->
            <a href="{{ route('panitia.scanner') }}" class="block w-full bg-[#1c1e54] hover:bg-[#3D365C] text-white font-semibold text-lg py-4 rounded-xl shadow-md transition-all">
                Buka Scanner Sekarang
            </a>
        </div>

    </div>

</body>
</html>
