<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | ARTIX ID</title>

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

        /* Animasi transisi form panitia */
        #staff_section {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #staff_section.show {
            max-height: 150px; /* Cukup untuk menampung form kode */
            opacity: 1;
            margin-bottom: 1.25rem; /* setara mb-5 */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#0B1A30] via-[#102A4C] to-[#0084FF] flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- Grid Pattern -->
    <div class="absolute inset-0 bg-grid-dark opacity-40 z-0"></div>

    <!-- Ambient Glow Sorotan di Belakang Card -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-[#0084FF] rounded-full blur-[100px] opacity-30 z-0 pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#00D2FF] rounded-full blur-[100px] opacity-20 z-0 pointer-events-none"></div>

    <div class="flex-1 flex items-center justify-center p-4 relative z-10 py-10">

        <!-- Frame Gradient Border untuk Card -->
        <div class="w-full max-w-lg p-[2px] rounded-3xl bg-gradient-to-b from-white/40 via-white/10 to-transparent shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all">

            <!-- Card Register (Glassmorphism) -->
            <div class="bg-white/95 backdrop-blur-xl rounded-[22px] p-8 sm:p-10 relative overflow-hidden shadow-inner">

                <!-- Hiasan Sinar Atas Card -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0084FF] via-[#00D2FF] to-[#0084FF]"></div>

                <!-- Header Logo & Teks -->
                <div class="text-center mb-8">
                    <!-- Logo Box -->
                    <div class="w-14 h-14 bg-gradient-to-br from-[#0084FF] to-[#0055FF] text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-extrabold shadow-lg shadow-blue-500/40">
                        T
                    </div>
                    <h3 class="text-2xl font-extrabold text-[#0B1A30] tracking-tight mb-2">Buat Akun Baru</h3>
                    <p class="text-sm text-gray-500">Daftar sekarang untuk mulai berburu tiket event seru.</p>
                </div>

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- PILIH JENIS AKUN (Styled Radio Buttons) -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#0B1A30] mb-3">Pilih Jenis Akun</label>
                        <div class="flex gap-3">
                            <!-- Tombol Pelanggan -->
                            <div class="flex-1">
                                <input type="radio" name="account_type" id="type_user" class="peer hidden" checked onchange="toggleRole()">
                                <label for="type_user" class="block w-full text-center py-2.5 px-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 font-bold text-sm cursor-pointer transition-all peer-checked:bg-[#0084FF] peer-checked:text-white peer-checked:border-[#0084FF] peer-checked:shadow-md hover:bg-gray-100">
                                    🎟️ Pelanggan
                                </label>
                            </div>

                            <!-- Tombol Panitia / EO -->
                            <div class="flex-1">
                                <input type="radio" name="account_type" id="type_staff" class="peer hidden" onchange="toggleRole()">
                                <label for="type_staff" class="block w-full text-center py-2.5 px-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 font-bold text-sm cursor-pointer transition-all peer-checked:bg-[#0084FF] peer-checked:text-white peer-checked:border-[#0084FF] peer-checked:shadow-md hover:bg-gray-100">
                                    💼 Panitia / EO
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input Nama -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-bold text-[#0B1A30] mb-2">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Masukkan nama lengkap Anda"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-bold text-[#0B1A30] mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="contoh: user@gmail.com"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('email') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-bold text-[#0B1A30] mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('password') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">

                            <!-- Toggle Button (Menggunakan SVG langsung) -->
                            <button type="button" onclick="togglePassword('password', 'icon-pwd')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none p-1">
                                <svg id="icon-pwd" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <!-- Eye Icon Default -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-sm font-bold text-[#0B1A30] mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   placeholder="Ulangi kata sandi Anda"
                                   class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 text-sm focus:bg-white focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none">

                            <button type="button" onclick="togglePassword('password_confirmation', 'icon-pwd-confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none p-1">
                                <svg id="icon-pwd-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- BAGIAN KODE RAHASIA PANITIA -->
                    <div id="staff_section">
                        <div class="p-4 rounded-xl border border-dashed border-[#0084FF]/40 bg-[#0084FF]/5">
                            <label for="secret_code" class="flex items-center gap-2 text-sm font-bold text-[#0B1A30] mb-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Kode Pendaftaran Khusus
                            </label>
                            <input id="secret_code" type="text" name="secret_code" value="{{ old('secret_code') }}"
                                   placeholder="Masukkan kode dari Admin"
                                   class="w-full px-4 py-2.5 rounded-lg border border-[#0084FF]/30 bg-white text-gray-800 text-sm focus:border-[#0084FF] focus:ring-4 focus:ring-[#0084FF]/10 transition-all outline-none @error('secret_code') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">
                            <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                                *Wajib diisi agar akun Anda diverifikasi sebagai Panitia atau EO untuk mengakses Dashboard Scanner.
                            </p>
                            @error('secret_code')
                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- AKHIR BAGIAN KODE RAHASIA -->

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-[#0084FF] to-[#0055FF] hover:from-[#0070E0] hover:to-[#0040DD] text-white font-bold text-base py-3.5 rounded-xl shadow-[0_10px_25px_rgba(0,132,255,0.3)] hover:shadow-[0_15px_30px_rgba(0,132,255,0.4)] hover:-translate-y-0.5 transition-all duration-200 mt-2 mb-6">
                        Daftar Akun Baru
                    </button>

                    <!-- Link Login -->
                    <div class="text-center">
                        <span class="text-sm text-gray-500">Sudah punya akun? </span>
                        <a href="{{ route('login') }}" class="text-sm font-bold text-[#0084FF] hover:text-[#0055FF] transition-colors">
                            Masuk di Sini
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Fungsionalitas -->
    <script>
        // Fungsi Toggle Visibility Password dengan perubahan ikon SVG
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            // SVG Path Mata Terbuka
            const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;

            // SVG Path Mata Tertutup (Eye Slash)
            const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>`;

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = eyeClosed;
            } else {
                input.type = "password";
                icon.innerHTML = eyeOpen;
            }
        }

        // Fungsi Animasi Menampilkan/Menyembunyikan Form Panitia
        function toggleRole() {
            const isStaff = document.getElementById('type_staff').checked;
            const staffSection = document.getElementById('staff_section');
            const secretCodeInput = document.getElementById('secret_code');

            if (isStaff) {
                staffSection.classList.add('show');
                secretCodeInput.setAttribute('required', 'required');
            } else {
                staffSection.classList.remove('show');
                secretCodeInput.removeAttribute('required');
                secretCodeInput.value = '';
            }
        }

        // Inisialisasi saat pertama kali dimuat
        window.onload = function() {
            toggleRole();
        };
    </script>
</body>
</html>
