<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Daftar Akun | Ticks ID</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

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

        /* Animasi transisi form panitia */
        #staff_section {
            transition: max-height 0.5s ease-in-out, opacity 0.4s ease-in-out, margin 0.3s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            margin-top: 0;
        }
        #staff_section.show {
            max-height: 400px; /* Diperbesar agar muat dropdown */
            opacity: 1;
            margin-top: 1.25rem;
        }
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

    <!-- ── NAVIGASI ATAS ── -->
    <div class="relative z-20 w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] dark:text-white/60 dark:hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Beranda
        </a>
        <button id="theme-toggle" class="p-2.5 rounded-full text-slate-500 bg-white border border-slate-200 shadow-sm hover:text-[#0066FF] dark:bg-white/10 dark:border-white/10 dark:text-white/70 dark:hover:text-white transition-all focus:outline-none">
            <i id="theme-icon" data-lucide="moon" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- ── KONTEN DAFTAR ── -->
    <div class="flex-1 flex items-center justify-center p-6 relative z-10 py-10">
        <div class="w-full max-w-lg rounded-[24px] border shadow-2xl relative overflow-hidden transition-colors duration-300 bg-white border-slate-200 dark:bg-[#041B4A]/80 dark:border-[#1E2A4D] dark:backdrop-blur-xl">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0066FF] to-[#00C2FF]"></div>

            <div class="p-8 sm:p-10">
                <!-- Header Logo & Teks -->
                <div class="text-center mb-6">
                    <div class="flex justify-center mb-6">
                        <!-- Logo Ticks ID -->
                        <img src="{{ asset('logoticksid.png') }}" alt="Ticks ID Logo" class="h-16 w-auto object-contain block dark:hidden">
                        <img src="{{ asset('logo_putih_ticks.png') }}" alt="Ticks ID Logo" class="h-16 w-auto object-contain hidden dark:block">
                    </div>
                    <h3 class="text-2xl font-black font-montserrat text-slate-900 dark:text-white tracking-tight mb-2">Selamat Datang!</h3>
                    <p class="text-sm font-medium text-slate-500 dark:text-white/50">Silakan isi formulir di bawah untuk bergabung dengan Ticks ID.</p>
                </div>

                <!-- ── KOTAK NOTIFIKASI ERROR (PENTING) ── -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-[12px] text-sm text-red-600 dark:text-red-400 font-medium flex items-start gap-3 shadow-sm">
                        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- PILIH JENIS AKUN -->
                    <div class="mb-6">
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-3">Pilih Jenis Akun</label>
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <input type="radio" name="account_type" id="type_user" value="user" class="peer hidden" checked onchange="toggleRole()">
                                <label for="type_user" class="block w-full text-center py-3 px-3 rounded-[12px] border text-sm font-bold cursor-pointer transition-all shadow-sm
                                       bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100
                                       peer-checked:bg-[#0066FF] peer-checked:text-white peer-checked:border-[#0066FF] peer-checked:shadow-md
                                       dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white/50 dark:hover:bg-[#0F1730]/80
                                       dark:peer-checked:bg-[#0066FF] dark:peer-checked:text-white dark:peer-checked:border-[#0066FF]">
                                    Pelanggan
                                </label>
                            </div>
                            <div class="flex-1">
                                <input type="radio" name="account_type" id="type_staff" value="staff" class="peer hidden" onchange="toggleRole()">
                                <label for="type_staff" class="block w-full text-center py-3 px-3 rounded-[12px] border text-sm font-bold cursor-pointer transition-all shadow-sm
                                       bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100
                                       peer-checked:bg-[#0066FF] peer-checked:text-white peer-checked:border-[#0066FF] peer-checked:shadow-md
                                       dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white/50 dark:hover:bg-[#0F1730]/80
                                       dark:peer-checked:bg-[#0066FF] dark:peer-checked:text-white dark:peer-checked:border-[#0066FF]">
                                    Panitia / EO
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input Nama -->
                    <div class="mb-5">
                        <label for="name" class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-2.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-white/40">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Masukkan nama lengkap Anda"
                                   class="w-full pl-11 pr-4 py-3.5 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                          bg-slate-50 border-slate-200 text-slate-900 focus:border-[#0066FF] focus:bg-white focus:ring-4 focus:ring-[#0066FF]/10
                                          dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF] dark:focus:bg-[#0F1730] dark:focus:ring-[#0066FF]/20">
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-2.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-white/40">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="contoh@email.com"
                                   class="w-full pl-11 pr-4 py-3.5 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                          bg-slate-50 border-slate-200 text-slate-900 focus:border-[#0066FF] focus:bg-white focus:ring-4 focus:ring-[#0066FF]/10
                                          dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF] dark:focus:bg-[#0F1730] dark:focus:ring-[#0066FF]/20">
                        </div>
                    </div>

                    <!-- Grup Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-2">
                        <!-- Input Password -->
                        <div>
                            <label for="password" class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-2.5">Kata Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-white/40">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                </div>
                                <input id="password" type="password" name="password" required
                                       placeholder="Contoh: ArT1x_@2026!"
                                       class="w-full pl-11 pr-10 py-3.5 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                              bg-slate-50 border-slate-200 text-slate-900 focus:border-[#0066FF] focus:bg-white focus:ring-4 focus:ring-[#0066FF]/10
                                              dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF] dark:focus:bg-[#0F1730] dark:focus:ring-[#0066FF]/20">
                                <button type="button" onclick="togglePassword('password', 'icon-pwd')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-white/40 dark:hover:text-white focus:outline-none p-1 transition-colors">
                                    <i id="icon-pwd" data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-2.5">Ulangi Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-white/40">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                       placeholder="Ulangi kata sandi"
                                       class="w-full pl-11 pr-10 py-3.5 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                              bg-slate-50 border-slate-200 text-slate-900 focus:border-[#0066FF] focus:bg-white focus:ring-4 focus:ring-[#0066FF]/10
                                              dark:bg-[#0F1730] dark:border-[#1E2A4D] dark:text-white dark:focus:border-[#0066FF] dark:focus:bg-[#0F1730] dark:focus:ring-[#0066FF]/20">
                                <button type="button" onclick="togglePassword('password_confirmation', 'icon-pwd-confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-white/40 dark:hover:text-white focus:outline-none p-1 transition-colors">
                                    <i id="icon-pwd-confirm" data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Syarat Password Keamanan Tinggi -->
                    <p class="text-[10px] text-slate-500 dark:text-white/50 mt-2 mb-4 leading-relaxed font-medium">
                        *Minimal 8 karakter, wajib mengandung huruf (Besar & kecil), angka, dan simbol (@, #, $, dll).
                    </p>

                    <!-- ── BAGIAN KHUSUS PANITIA (Animasi Expand) ── -->
                    <div id="staff_section">
                        <div class="p-5 rounded-[12px] border border-dashed transition-colors bg-blue-50/50 border-blue-200 dark:bg-[#0066FF]/10 dark:border-[#0066FF]/40">

                            <!-- Dropdown Jabatan / Peran -->
                            <div class="mb-4">
                                <label for="role_type" class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-blue-600 dark:text-[#00C2FF] mb-2.5">
                                    <i data-lucide="badge-check" class="w-4 h-4"></i>
                                    Peran / Jabatan
                                </label>
                                <select id="role_type" name="role_type"
                                        class="w-full px-4 py-3 rounded-[12px] border text-sm font-bold focus:outline-none transition-all appearance-none cursor-pointer
                                               bg-white border-blue-200 text-slate-900 focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10
                                               dark:bg-[#0F1730] dark:border-[#0066FF]/40 dark:text-white dark:focus:border-[#00C2FF] dark:focus:ring-[#00C2FF]/20">
                                    <option value="" disabled selected>Pilih peran Anda di Event ini</option>
                                    <option value="eo">Penyelenggara Inti (EO / Admin Event)</option>
                                    <option value="panitia_tiket">Petugas Scanner Tiket (Check-In)</option>
                                    <option value="panitia_lapangan">Staff Lapangan / Keamanan</option>
                                </select>
                            </div>

                            <!-- Input Kode Rahasia -->
                            <div>
                                <label for="secret_code" class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-blue-600 dark:text-[#00C2FF] mb-2.5">
                                    <i data-lucide="key" class="w-4 h-4"></i>
                                    Kode Akses Event
                                </label>
                                <input id="secret_code" type="text" name="secret_code" value="{{ old('secret_code') }}"
                                       placeholder="Minta kode akses pada pembuat Event"
                                       class="w-full px-4 py-3 rounded-[12px] border text-sm font-bold focus:outline-none transition-all placeholder:font-medium placeholder:text-slate-400 dark:placeholder:text-white/30
                                              bg-white border-blue-200 text-slate-900 focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10
                                              dark:bg-[#0F1730] dark:border-[#0066FF]/40 dark:text-white dark:focus:border-[#00C2FF] dark:focus:ring-[#00C2FF]/20">
                                <p class="text-[11px] text-slate-500 dark:text-white/50 mt-2.5 leading-relaxed font-medium">
                                    *Kode ini akan mengaitkan akun Anda secara otomatis dengan Event terkait.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR BAGIAN KHUSUS PANITIA -->

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-[#0066FF] hover:bg-blue-700 text-white font-bold font-montserrat text-sm py-4 rounded-[12px] shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-200 mt-6 mb-6 border border-[#0066FF]">
                        Daftar Akun Baru <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </button>

                    <!-- Link Login -->
                    <div class="text-center border-t border-slate-200 dark:border-white/10 pt-6">
                        <span class="text-sm font-medium text-slate-500 dark:text-white/50">Sudah punya akun? </span>
                        <a href="{{ route('login') }}" class="text-sm font-bold text-[#0066FF] dark:text-[#00C2FF] hover:underline transition-colors">
                            Masuk di Sini
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Fungsionalitas -->
    <script>
        lucide.createIcons();

        // ── LOGIKA DARK MODE TOGGLE ──
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        function toggleTheme() {
            const isDark = html.classList.toggle('dark');
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            lucide.createIcons();
        }
        if(themeToggle) themeToggle.addEventListener('click', toggleTheme);

        // ── FUNGSI TOGGLE PASSWORD ──
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = "password";
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // ── FUNGSI TOGGLE FORM KODE PANITIA ──
        function toggleRole() {
            const isStaff = document.getElementById('type_staff').checked;
            const staffSection = document.getElementById('staff_section');
            const secretCodeInput = document.getElementById('secret_code');
            const roleTypeInput = document.getElementById('role_type');

            if (isStaff) {
                staffSection.classList.add('show');
                secretCodeInput.setAttribute('required', 'required');
                roleTypeInput.setAttribute('required', 'required');
            } else {
                staffSection.classList.remove('show');
                secretCodeInput.removeAttribute('required');
                roleTypeInput.removeAttribute('required');
                secretCodeInput.value = '';
                roleTypeInput.value = '';
            }
        }

        window.onload = function() {
            toggleRole();
        };
    </script>
</body>
</html>
