<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Lupa Kata Sandi | ARTIX ID</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Konfigurasi Tailwind untuk Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'exo': ['"Exo 2"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Exo 2', sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Animasi Bola Cahaya (Orb) */
        @keyframes orb1 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.15) translate(30px, -20px); }
        }
        @keyframes orb2 {
            0%, 100% { transform: scale(1) translate(0,0); }
            50% { transform: scale(1.1) translate(-25px, 15px); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        html.light ::-webkit-scrollbar { background: #F1F5F9; }
        html.light ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        html.dark ::-webkit-scrollbar { background: #020C1F; }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white flex flex-col min-h-screen relative transition-colors duration-300">

    <!-- ── BACKGROUND ANIMATION & GRID ── -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <!-- Latar Gelap Khusus Dark Mode -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_90%_70%_at_50%_-10%,#0A2A6E_0%,#041B4A_65%)] hidden dark:block"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-40 dark:opacity-100" style="background-image: linear-gradient(var(--tw-gradient-stops)), linear-gradient(90deg, var(--tw-gradient-stops)); --tw-gradient-from: #CBD5E1; --tw-gradient-to: transparent; --tw-gradient-stops: var(--tw-gradient-from) 1px, var(--tw-gradient-to) 1px; background-size: 56px 56px; dark:--tw-gradient-from: rgba(0,102,255,0.07);"></div>

        <!-- Orbs -->
        <div class="absolute rounded-full opacity-20 dark:opacity-15" style="width: 500px; height: 500px; top: -10%; left: -10%; background: #0066FF; filter: blur(120px); animation: orb1 8s ease-in-out infinite;"></div>
        <div class="absolute rounded-full opacity-15 dark:opacity-10" style="width: 400px; height: 400px; bottom: -10%; right: -5%; background: #A100FF; filter: blur(100px); animation: orb2 10s ease-in-out infinite 2s;"></div>
    </div>

    <!-- ── NAVIGASI ATAS (KEMBALI & TEMA) ── -->
    <div class="relative z-20 w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
        <!-- Tombol Kembali ke Login -->
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] dark:text-white/60 dark:hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Masuk
        </a>

        <!-- Tombol Toggle Tema -->
        <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-white border border-slate-200 shadow-sm hover:text-[#0066FF] dark:bg-white/10 dark:border-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none">
            <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- ── KONTEN LUPA SANDI ── -->
    <div class="flex-1 flex items-center justify-center p-6 relative z-10">

        <!-- Card Container -->
        <div class="w-full max-w-[420px] rounded-[24px] border shadow-2xl relative overflow-hidden transition-colors duration-300 bg-white border-slate-200 dark:bg-[#041B4A]/80 dark:border-[#1E2A4D] dark:backdrop-blur-xl">

            <!-- Hiasan Garis Atas -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

            <div class="p-8 sm:p-10">
                <!-- Header Logo & Teks -->
                <div class="text-center mb-6">
                    <div class="flex justify-center mb-6">
                        <!-- Logo Hitam untuk Mode Terang -->
                        <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID Logo" class="h-10 object-contain block dark:hidden">
                        <!-- Logo Putih untuk Mode Gelap -->
                        <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID Logo" class="h-10 object-contain hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.4));">
                    </div>
                    <h3 class="text-2xl font-black font-montserrat text-slate-900 dark:text-white tracking-tight mb-3">Lupa Kata Sandi?</h3>
                    <p class="text-sm font-medium leading-relaxed text-slate-500 dark:text-white/50">
                        Tidak masalah. Cukup beri tahu kami alamat email Anda, dan kami akan mengirimkan tautan untuk membuat kata sandi baru.
                    </p>
                </div>

                <!-- Session Status Bawaan Laravel -->
                @if (session('status'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400 p-3.5 rounded-xl text-sm font-bold mb-6 text-center transition-colors">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Lupa Sandi -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Input Email -->
                    <div class="mb-8">
                        <label for="email" class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-2.5">Alamat Email Terdaftar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-white/40">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="contoh@email.com"
                                   class="w-full pl-11 pr-4 py-3.5 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                          bg-slate-50 border-slate-200 text-slate-900 focus:border-[#0066FF] focus:bg-white focus:ring-4 focus:ring-[#0066FF]/10
                                          dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF] dark:focus:bg-[#0F1730] dark:focus:ring-[#0066FF]/20
                                          @error('email') border-red-500 focus:border-red-500 focus:ring-red-100 dark:border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="text-red-500 dark:text-red-400 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-[#0066FF] hover:bg-blue-700 text-white font-bold font-montserrat text-sm py-4 rounded-[12px] shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-200 border border-[#0066FF]">
                        Kirim Tautan Reset Sandi <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Kalkulasi & Interaksi -->
    <script>
        // Mengaktifkan Ikon Lucide
        lucide.createIcons();

        // ── LOGIKA DARK MODE TOGGLE ──
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        function toggleTheme() {
            // Membalikkan class 'dark' pada HTML
            const isDark = html.classList.toggle('dark');

            // Ubah ikon sesuai tema
            const iconName = isDark ? 'sun' : 'moon';
            themeIcon.setAttribute('data-lucide', iconName);

            // Render ulang ikon
            lucide.createIcons();
        }

        // Pasang event ke tombol toggle
        if(themeToggle) themeToggle.addEventListener('click', toggleTheme);
    </script>
</body>
</html>
