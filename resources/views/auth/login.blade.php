<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun | ARTIX ID</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Pola grid halus untuk latar belakang gelap */
        .bg-grid-dark {
            background-size: 24px 24px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }
    </style>
</head>
<!-- Menerapkan background gradasi gelap seperti header panitia -->
<body class="bg-gradient-to-br from-[#0B1A30] via-[#102A4C] to-[#0084FF] flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- Grid Pattern -->
    <div class="absolute inset-0 bg-grid-dark opacity-40 z-0"></div>

    <!-- Ambient Glow Sorotan di Belakang Card untuk menambah kedalaman -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-[#0084FF] rounded-full blur-[100px] opacity-30 z-0 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#00D2FF] rounded-full blur-[100px] opacity-20 z-0 pointer-events-none"></div>

    <div class="flex-1 flex items-center justify-center p-4 relative z-10">

        <!-- Frame Gradient Border untuk Card -->
        <div class="w-full max-w-md p-[2px] rounded-3xl bg-gradient-to-b from-white/40 via-white/10 to-transparent shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all">

            <!-- Card Login (Glassmorphism Putih agar menonjol di background gelap) -->
            <div class="bg-white/95 backdrop-blur-xl rounded-[22px] p-8 sm:p-10 relative overflow-hidden shadow-inner">

                <!-- Hiasan Sinar Atas Card -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0084FF] via-[#00D2FF] to-[#0084FF]"></div>

                <!-- Header Logo & Teks -->
                <div class="text-center mb-8">
                    <!-- Logo Box -->
                    <div class="w-14 h-14 bg-gradient-to-br from-[#0084FF] to-[#0055FF] text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-extrabold shadow-lg shadow-blue-500/40">
                        T
                    </div>
                    <h3 class="text-2xl font-extrabold text-[#0B1A30] tracking-tight mb-2">Selamat Datang Kembali!</h3>
                    <p class="text-sm text-gray-500">Silakan masuk untuk melanjutkan pemesanan tiket event Anda.</p>
                </div>

                <!-- Notifikasi Session -->
                @if (session('status'))
                    <div class="bg-blue-50 text-blue-600 border border-blue-100 p-3 rounded-xl text-sm font-medium mb-6 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Input Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-bold text-[#0B1A30] mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="contoh: user@gmail.com"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('email') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">

                        @error('email')
                            <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-bold text-[#0B1A30]">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#0084FF] hover:text-[#0055FF] transition-colors">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('password') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">

                        @error('password')
                            <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6 flex items-center gap-2">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#0084FF] border-gray-300 rounded focus:ring-[#0084FF] cursor-pointer">
                        <label for="remember_me" class="text-sm text-gray-500 select-none cursor-pointer">
                            Ingat akun saya di perangkat ini
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-[#0084FF] to-[#0055FF] hover:from-[#0070E0] hover:to-[#0040DD] text-white font-bold text-base py-3.5 rounded-xl shadow-[0_10px_25px_rgba(0,132,255,0.3)] hover:shadow-[0_15px_30px_rgba(0,132,255,0.4)] hover:-translate-y-0.5 transition-all duration-200 mb-6">
                        Masuk Ke Akun Saya
                    </button>

                    <!-- Link Register -->
                    <div class="text-center">
                        <span class="text-sm text-gray-500">Belum punya akun? </span>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-[#0084FF] hover:text-[#0055FF] transition-colors">
                            Daftar Sekarang
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
