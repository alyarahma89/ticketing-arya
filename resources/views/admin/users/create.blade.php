<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna Baru - ARTIX ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        syne: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        primary: '#696FC7',
                        'primary-deep': '#3D365C',
                        'primary-press': '#7C4585',
                        'primary-soft': '#C95792',
                        'primary-subdued': '#F8B55F',
                        'brand-dark': '#1c1e54',
                        ink: '#0d253d',
                        'ink-secondary': '#273951',
                        'ink-mute': '#64748d',
                        canvas: '#ffffff',
                        'canvas-soft': '#f0f4f8',
                        hairline: '#e3e8ee',
                        ruby: '#ea2261',
                    },
                    boxShadow: {
                        'level-1': '0 4px 20px rgba(28, 30, 84, 0.04), 0 1px 3px rgba(28, 30, 84, 0.02)',
                        'level-2': '0 20px 40px rgba(28, 30, 84, 0.08), 0 1px 10px rgba(28, 30, 84, 0.03)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-canvas-soft text-ink font-sans antialiased min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="h-20 bg-brand-dark border-b border-white/10 flex items-center justify-between px-8 sticky top-0 z-50 shadow-md">
        <div class="flex items-center w-1/4">
            <a href="{{ route('admin.users.index') }}" class="text-white/70 hover:text-white flex items-center gap-2 text-[14px] font-semibold transition-all duration-200 group">
                <span class="transform group-hover:-translate-x-1 transition-transform">&larr;</span> Kembali
            </a>
        </div>

        <div class="flex items-center justify-center gap-1.5 w-2/4">
            <span class="font-syne font-extrabold text-[22px] tracking-tight text-white block">ARTIX</span>
            <span class="font-syne font-extrabold text-[22px] tracking-tight text-primary-subdued block">ID</span>
        </div>

        <div class="flex items-center justify-end w-1/4">
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full border border-white/10">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-[11px] font-bold text-white tracking-wide uppercase">User Creator</span>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <div class="bg-gradient-to-r from-brand-dark via-primary-deep to-primary text-white py-12 px-8 shadow-inner">
        <div class="max-w-4xl w-full mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="text-primary-subdued font-bold text-xs uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full border border-white/10">Manajemen Akses</span>
                <h1 class="text-[36px] font-bold tracking-tight font-syne mt-2">Tambah Pengguna Baru</h1>
                <p class="text-[14px] text-white/70 font-light mt-1">Daftarkan akun pengguna baru, tetapkan kredensial login, dan tentukan hak akses sistem.</p>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-[28px] opacity-20 font-syne font-black tracking-wider">ARTIX ID ACCOUNTS</span>
            </div>
        </div>
    </div>

    <!-- MAIN FORM AREA -->
    <main class="flex-1 max-w-4xl w-full mx-auto py-10 px-6 -mt-8">

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="bg-ruby/10 border border-ruby/20 text-ruby p-4 rounded-xl mb-6 text-[14px] flex gap-3 items-start shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill text-[18px] mt-0.5"></i>
                    <div>
                        <span class="font-bold block mb-1">Gagal menambahkan pengguna:</span>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- CARD FORM -->
            <div class="bg-white border border-hairline rounded-[24px] shadow-level-1 p-8 space-y-6 relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-primary to-primary-soft"></div>

                <h2 class="text-[18px] font-bold text-brand-dark border-b border-hairline pb-3 flex items-center gap-2">
                    <i class="bi bi-person-vcard text-primary"></i> Data Kredensial Pengguna
                </h2>

                <div class="space-y-6">
                    <!-- Field: Nama Lengkap -->
                    <div>
                        <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                                class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Field: Email -->
                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="budi@example.com"
                                    class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">
                            </div>
                        </div>

                        <!-- Field: Role -->
                        <div>
                            <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Hak Akses (Role)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-person-badge"></i></span>
                                <select name="role" id="role" required class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran Pengguna --</option>
                                    <option value="panitia" {{ old('role') == 'panitia' ? 'selected' : '' }}>Panitia (Scan Tiket)</option>
                                    <option value="eo" {{ old('role') == 'eo' ? 'selected' : '' }}>Event Organizer (EO)</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Platform)</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pelanggan Biasa</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-ink-mute/50"><i class="bi bi-chevron-down text-xs"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field: Password -->
                    <div>
                        <label class="block text-[11px] font-bold text-ink-secondary mb-2 uppercase tracking-wider">Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-primary/60"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                                class="w-full bg-canvas-soft focus:bg-white border border-hairline text-ink text-[15px] font-semibold rounded-xl pl-11 pr-12 py-3.5 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">

                            <!-- Ikon Mata -->
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-ink-mute hover:text-primary transition-colors focus:outline-none">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <span class="text-[11px] text-ink-mute mt-1.5 block flex items-center gap-1">
                            <i class="bi bi-info-circle text-primary"></i> Password harus terdiri dari kombinasi huruf dan angka.
                        </span>
                    </div>

                </div>
            </div>

            <!-- ACTION BAR BAWAH -->
            <div class="mt-8 bg-brand-dark border border-white/10 rounded-[24px] p-6 shadow-level-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-[13px] text-white/70 font-medium flex items-center gap-1.5">
                    <i class="bi bi-shield-check text-emerald-400"></i> Pastikan untuk memberikan role yang sesuai dengan wewenang.
                </span>
                <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                    <a href="{{ route('admin.users.index') }}" class="text-[14px] text-white/70 hover:text-white font-bold px-5 py-3 transition-colors rounded-full hover:bg-white/5 text-center w-full sm:w-auto">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-primary-press text-white px-8 py-3.5 rounded-full text-[14px] font-bold transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        <i class="bi bi-person-plus-fill"></i> Simpan Pengguna
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- SCRIPT UNTUK LOGIKA IKON MATA -->
    <script>
        const togglePasswordBtn = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePasswordBtn.addEventListener('click', function () {
            // Cek apakah tipenya 'password' atau 'text'
            const isPassword = passwordInput.getAttribute('type') === 'password';

            // Ubah tipe input
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            // Ubah kelas ikon Bootstrap (bi-eye menjadi bi-eye-slash)
            if (isPassword) {
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>
