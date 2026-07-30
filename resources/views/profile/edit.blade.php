<!DOCTYPE html>
<html lang="id" class="light"> <!-- Default awal adalah mode terang -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - ARTIX ID</title>
    <link rel="icon" href="{{ asset('main_logo.png') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Exo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Konfigurasi Tailwind untuk Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class', // Wajib untuk mengaktifkan toggle manual
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'exo': ['"Exo 2"', 'sans-serif'],
                    },
                    colors: {
                        'artix-blue': '#0066FF',
                        'artix-navy': '#041B4A',
                        'artix-orange': '#FF7A00',
                        'artix-red': '#FF3B30',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Exo 2', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        ::-webkit-scrollbar { width: 6px; }
        html.light ::-webkit-scrollbar { background: #F1F5F9; }
        html.light ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        html.dark ::-webkit-scrollbar { background: #020C1F; }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(0,102,255,0.4); border-radius: 3px; }

        /* ── MEMAKSA FORM BAWAAN LARAVEL MENGIKUTI DESAIN ARTIX ID ── */

        /* Memperbaiki Input Teks & Password */
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100% !important;
            background-color: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            color: #0F172A !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            border-radius: 0.75rem !important; /* 12px */
            padding: 0.75rem 1rem !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }

        /* Input saat Mode Gelap */
        html.dark input[type="text"], html.dark input[type="email"], html.dark input[type="password"] {
            background-color: #020C1F !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #FFFFFF !important;
        }

        /* Input saat Fokus (Diklik) */
        input:focus {
            outline: none !important;
            border-color: #0066FF !important;
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1) !important;
        }

        /* Teks Label & Paragraf Bawaan Laravel */
        .text-gray-900, .text-gray-800 { color: #0F172A !important; font-family: 'Montserrat', sans-serif !important; }
        html.dark .text-gray-900, html.dark .text-gray-800 { color: #FFFFFF !important; }
        .text-gray-600, .text-sm.text-gray-600 { color: #64748B !important; font-family: 'Exo 2', sans-serif !important; }
        html.dark .text-gray-600, html.dark .text-sm.text-gray-600 { color: rgba(255, 255, 255, 0.6) !important; }

        /* Tombol Simpan (Save) Bawaan Laravel */
        button[type="submit"].bg-gray-800 {
            background: linear-gradient(135deg, #0066FF, #00C2FF) !important;
            color: white !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 700 !important;
            font-family: 'Montserrat', sans-serif !important;
            text-transform: none !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 102, 255, 0.2) !important;
            transition: all 0.2s ease !important;
        }
        button[type="submit"].bg-gray-800:hover { transform: translateY(-1px) !important; box-shadow: 0 10px 15px -3px rgba(0, 102, 255, 0.3) !important; }

        /* Tombol Hapus Bawaan Laravel */
        button[type="submit"].bg-red-600, .bg-red-600 {
            background: linear-gradient(135deg, #FF3B30, #dc2626) !important;
            border-radius: 0.75rem !important;
            font-family: 'Montserrat', sans-serif !important;
            text-transform: none !important;
            border: none !important;
        }

        /* Menghapus Shadow Box Bawaan Laravel agar mengikuti desain Card ARTIX */
        .bg-white.shadow.sm\:rounded-lg {
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 dark:bg-[#041B4A] dark:text-white min-h-screen">

    <!-- ── NAVBAR ── -->
    <nav class="bg-white/90 dark:bg-[#041B4A]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/10 fixed top-0 inset-x-0 z-50">
        <div class="max-w-4xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center shrink-0">
                <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID" class="h-8 block dark:hidden">
                <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID" class="h-8 hidden dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="text-sm font-bold text-slate-500 hover:text-[#0066FF] dark:text-white/60 dark:hover:text-white transition-colors flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
                <!-- Toggle Dark Mode -->
                <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-slate-200 hover:text-[#0066FF] dark:bg-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none shadow-inner">
                    <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- ── KONTEN UTAMA ── -->
    <main class="max-w-4xl mx-auto px-6 pt-32 pb-16">

        <!-- Header Halaman -->
        <div class="mb-10 text-center md:text-left">
            <h2 class="font-black text-3xl md:text-4xl font-montserrat text-slate-900 dark:text-white mb-2">
                Pengaturan Akun
            </h2>
            <p class="text-base font-medium text-slate-500 dark:text-white/60">
                Kelola informasi identitas pribadi dan keamanan kata sandi Anda di sini.
            </p>
        </div>

        <div class="space-y-8">

            <!-- ── KARTU 0: RIWAYAT PESANAN (BARU DITAMBAHKAN) ── -->
            

            <!-- KARTU 1: INFORMASI PRIBADI -->
            <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] p-6 md:p-8 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#0066FF]"></div>

                <div class="border-b border-slate-100 dark:border-white/10 pb-4 mb-6 flex items-center gap-3">
                    <div class="bg-blue-50 dark:bg-[#0066FF20] p-2 rounded-xl text-[#0066FF]">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-black text-xl font-montserrat text-slate-800 dark:text-white">Informasi Pribadi</h3>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- KARTU 2: KEAMANAN PASSWORD -->
            <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] p-6 md:p-8 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#FF7A00]"></div>

                <div class="border-b border-slate-100 dark:border-white/10 pb-4 mb-6 flex items-center gap-3">
                    <div class="bg-orange-50 dark:bg-[#FF7A0020] p-2 rounded-xl text-[#FF7A00]">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-black text-xl font-montserrat text-slate-800 dark:text-white">Keamanan Kata Sandi</h3>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- KARTU 3: HAPUS AKUN -->
            <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-[24px] p-6 md:p-8 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#FF3B30]"></div>

                <div class="border-b border-slate-100 dark:border-white/10 pb-4 mb-6 flex items-center gap-3">
                    <div class="bg-red-50 dark:bg-[#FF3B3020] p-2 rounded-xl text-[#FF3B30]">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-black text-xl font-montserrat text-slate-800 dark:text-white">Hapus Akun Permanen</h3>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </main>

    <!-- Script Dark Mode & Icons -->
    <script>
        lucide.createIcons();

        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            const iconName = isDark ? 'sun' : 'moon';
            themeIcon.setAttribute('data-lucide', iconName);
            lucide.createIcons();
        });
    </script>
</body>
</html>
