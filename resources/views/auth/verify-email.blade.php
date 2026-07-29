<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Verifikasi Email | ARTIX ID</title>

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

    <!-- ── NAVIGASI ATAS (TEMA) ── -->
    <div class="relative z-20 w-full max-w-7xl mx-auto px-6 py-6 flex justify-end items-center">
        <!-- Tombol Toggle Tema -->
        <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-white border border-slate-200 shadow-sm hover:text-[#0066FF] dark:bg-white/10 dark:border-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none">
            <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- ── KONTEN VERIFIKASI EMAIL ── -->
    <div class="flex-1 flex items-center justify-center p-6 relative z-10 py-10">

        <!-- Card Container -->
        <div class="w-full max-w-[480px] rounded-[24px] border shadow-2xl relative overflow-hidden transition-colors duration-300 bg-white border-slate-200 dark:bg-[#041B4A]/80 dark:border-[#1E2A4D] dark:backdrop-blur-xl">

            <!-- Hiasan Garis Atas -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

            <div class="p-8 sm:p-10">
                <!-- Header Logo -->
                <div class="flex justify-center mb-8">
                    <!-- Logo Hitam untuk Mode Terang -->
                    <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID Logo" class="h-10 object-contain block dark:hidden">
                    <!-- Logo Putih untuk Mode Gelap -->
                    <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID Logo" class="h-10 object-contain hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.4));">
                </div>

                <!-- Teks Instruksi -->
                <div class="text-center mb-8">
                    <!-- Ikon Dekoratif -->
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5 bg-blue-50 text-[#0066FF] dark:bg-[#0066FF]/10 dark:text-[#00C2FF]">
                        <i data-lucide="mail-check" class="w-8 h-8"></i>
                    </div>

                    <h3 class="text-2xl font-black font-montserrat text-slate-900 dark:text-white tracking-tight mb-3">Periksa Email Anda</h3>
                    <p class="text-sm font-medium leading-relaxed text-slate-500 dark:text-white/60">
                        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan tautan baru.
                    </p>
                </div>

                <!-- Session Status Bawaan Laravel -->
                @if (session('status') == 'verification-link-sent')
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400 p-4 rounded-xl text-sm font-bold mb-8 text-center transition-colors shadow-sm">
                        Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                    </div>
                @endif

                <!-- Form Kirim Ulang Verifikasi -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-[#0066FF] hover:bg-blue-700 text-white font-bold font-montserrat text-sm py-4 rounded-[12px] shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-200 border border-[#0066FF]">
                        Kirim Ulang Tautan Verifikasi <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>

                <!-- Form Log Out -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center border-t border-slate-200 dark:border-white/10 pt-6">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-sm font-bold transition-colors text-slate-400 hover:text-red-500 dark:text-white/40 dark:hover:text-red-400 focus:outline-none group">
                        <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Keluar Akun (Log Out)
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Fungsionalitas -->
    <script>
        // Mengaktifkan Ikon Lucide
        lucide.createIcons();

        // ── LOGIKA DARK MODE TOGGLE ──
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        function toggleTheme() {
            const isDark = html.classList.toggle('dark');
            const iconName = isDark ? 'sun' : 'moon';
            themeIcon.setAttribute('data-lucide', iconName);
            lucide.createIcons();
        }
        if(themeToggle) themeToggle.addEventListener('click', toggleTheme);
    </script>
</body>
</html>
