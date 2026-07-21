<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | TICKS ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #696FC7;
            --primary-deep: #3D365C;
            --primary-press: #7C4585;
            --primary-soft: #C95792;
            --brand-dark-900: #1c1e54;
            --ink: #0d253d;
            --ink-secondary: #273951;
            --ink-mute: #64748d;
            --on-primary: #ffffff;
            --canvas: #ffffff;
            --hairline: #e3e8ee;
            --hairline-input: #a8c3de;
            --rounded-xl: 16px;
            --rounded-pill: 9999px;
            --shadow-level-2: 0 8px 24px rgba(0, 55, 112, 0.08), 0 2px 6px rgba(0, 55, 112, 0.04);
            --font-sans: 'Inter', 'SF Pro Display', system-ui, -apple-system, sans-serif;
        }

        body { font-family: var(--font-sans); }

        .gradient-mesh {
            background: radial-gradient(ellipse at 20% 30%, rgba(253, 244, 227, 0.8) 0%, rgba(255, 209, 165, 0.6) 25%, rgba(197, 163, 255, 0.5) 55%, rgba(105, 111, 199, 0.55) 75%, rgba(234, 34, 97, 0.35) 100%);
        }

        .card-stripi {
            background: var(--canvas);
            border-radius: var(--rounded-xl);
            border: 1px solid var(--hairline);
            box-shadow: var(--shadow-level-2);
        }

        .btn-primary-pill {
            background: var(--primary);
            color: var(--on-primary);
            padding: 12px 24px;
            border-radius: var(--rounded-pill);
            font-weight: 600;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary-pill:hover {
            background: var(--primary-press);
            transform: translateY(-2px);
            color: white;
        }

        .form-control {
            border: 1px solid var(--hairline-input) !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
        }

        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(105, 111, 199, 0.1) !important;
        }

        /* Styling Khusus Tombol Pilih Akun */
        .btn-check:checked + .btn-outline-secondary {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .btn-outline-secondary {
            border-color: var(--hairline-input);
            color: var(--ink-secondary);
        }

        /* Animasi Transisi Halus */
        #staff_section {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body>

<div class="gradient-mesh min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="card-stripi p-4 p-md-5" style="max-width: 450px; width: 100%;">

        <div class="text-center mb-4">
            <span class="fs-1 d-block mb-2">✨</span>
            <h3 class="fw-bold m-0" style="color: var(--brand-dark-900); font-size: 24px;">Buat Akun Baru</h3>
            <p class="text-muted small mt-2">Daftar sekarang untuk mulai berburu tiket event seru di Medan.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- AWAL BAGIAN PILIH JENIS AKUN -->
            <div class="mb-4">
                <label class="form-label small fw-bold" style="color: var(--ink-secondary);">Pilih Jenis Akun</label>
                <div class="d-flex gap-2">
                    <!-- Tombol Pelanggan -->
                    <input type="radio" class="btn-check" name="account_type" id="type_user" autocomplete="off" checked onchange="toggleRole()">
                    <label class="btn btn-outline-secondary flex-fill fw-bold rounded-3 py-2" for="type_user">
                        🎟️ Pelanggan
                    </label>

                    <!-- Tombol Panitia / EO -->
                    <input type="radio" class="btn-check" name="account_type" id="type_staff" autocomplete="off" onchange="toggleRole()">
                    <label class="btn btn-outline-secondary flex-fill fw-bold rounded-3 py-2" for="type_staff">
                        💼 Panitia / EO
                    </label>
                </div>
            </div>
            <!-- AKHIR BAGIAN PILIH JENIS AKUN -->

            <div class="mb-3">
                <label for="name" class="form-label small fw-bold" style="color: var(--ink-secondary);">Nama Lengkap</label>
                <input id="name" type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap Anda">
                @error('name')
                    <div class="invalid-feedback small fw-semibold">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label small fw-bold" style="color: var(--ink-secondary);">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control shadow-sm @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required placeholder="contoh: anakmedan@gmail.com">
                @error('email')
                    <div class="invalid-feedback small fw-semibold">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-bold" style="color: var(--ink-secondary);">Kata Sandi</label>
                <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control shadow-sm @error('password') is-invalid @enderror"
                           required placeholder="Minimal 8 karakter">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'icon1')" style="border-color: var(--hairline-input);">
                        <i id="icon1" class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block small fw-semibold mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label small fw-bold" style="color: var(--ink-secondary);">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control shadow-sm"
                           required placeholder="Ulangi kata sandi Anda">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'icon2')" style="border-color: var(--hairline-input);">
                        <i id="icon2" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- AWAL BAGIAN KODE RAHASIA (DISEMBUNYIKAN SECARA DEFAULT) -->
            <div id="staff_section" style="display: none;">
                <div class="mb-4 p-3 rounded" style="background-color: rgba(105, 111, 199, 0.05); border: 1px dashed var(--primary-soft);">
                    <label for="secret_code" class="form-label small fw-bold" style="color: var(--ink-secondary);">
                        <i class="bi bi-key-fill text-warning me-1"></i> Kode Pendaftaran Khusus
                    </label>
                    <input id="secret_code" type="text" name="secret_code" class="form-control shadow-sm @error('secret_code') is-invalid @enderror"
                           value="{{ old('secret_code') }}" placeholder="Masukkan kode yang diberikan Admin">
                    <div class="form-text mt-1" style="font-size: 11px; color: var(--ink-mute);">
                        *Wajib diisi agar akun Anda diverifikasi sebagai Panitia atau EO.
                    </div>
                    @error('secret_code')
                        <div class="invalid-feedback small fw-semibold">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- AKHIR BAGIAN KODE RAHASIA -->

            <button type="submit" class="btn-primary-pill w-100 mb-3 shadow-sm mt-2">
                Daftar Akun Baru
            </button>

            <div class="text-center mt-4">
                <span class="text-secondary small">Sudah punya akun? </span>
                <a href="{{ route('login') }}" class="small fw-bold text-decoration-none" style="color: var(--primary-soft);">
                    Masuk di Sini
                </a>
            </div>
        </form>

    </div>
</div>

<script>
    // Fungsi untuk menampilkan/menyembunyikan password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }

    // Fungsi cerdas untuk menampilkan form Panitia
    function toggleRole() {
        const isStaff = document.getElementById('type_staff').checked;
        const staffSection = document.getElementById('staff_section');
        const secretCodeInput = document.getElementById('secret_code');

        if (isStaff) {
            // Tampilkan kotak kode khusus dan buat wajib diisi
            staffSection.style.display = 'block';
            secretCodeInput.setAttribute('required', 'required');
        } else {
            // Sembunyikan, hapus wajib isi, dan bersihkan teksnya agar tidak error
            staffSection.style.display = 'none';
            secretCodeInput.removeAttribute('required');
            secretCodeInput.value = '';
        }
    }

    // Jalankan fungsi saat halaman pertama kali dimuat (jaga-jaga jika ada error validasi)
    window.onload = function() {
        toggleRole();
    };
</script>
</body>
</html>
