<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna Baru (Mode Back-End)</title>
</head>
<body>

    <h1>Tambah Pengguna Baru</h1>

    <!-- Link Kembali -->
    <a href="{{ route('admin.users.index') }}">⬅ Batal dan Kembali ke Daftar Pengguna</a>
    <hr><br>

    <!-- Menampilkan Pesan Error Jika Ada Kesalahan Input -->
    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <strong>Gagal menambahkan pengguna:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM TAMBAH PENGGUNA -->
    <form action="{{ route('admin.users.store') }}" method="POST">
        <!-- Token Keamanan Wajib Laravel -->
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name"><strong>Nama Lengkap:</strong></label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; max-width: 400px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email"><strong>Alamat Email:</strong></label><br>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; max-width: 400px; padding: 5px;">
        </div>

        <!-- BAGIAN PASSWORD YANG DIPERBARUI -->
        <div style="margin-bottom: 15px;">
            <label for="password"><strong>Password Baru:</strong></label><br>

            <!-- Pembungkus untuk menempatkan ikon di dalam input -->
            <div style="position: relative; width: 100%; max-width: 400px;">
                <input type="password" name="password" id="password" required style="width: 100%; padding: 5px; padding-right: 40px; box-sizing: border-box;">

                <!-- Ikon Mata (Bisa di-klik) -->
                <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;">
                    👁️
                </span>
            </div>

            <small style="color: gray;">*Minimal 8 karakter</small>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="role"><strong>Hak Akses (Role):</strong></label><br>
            <select name="role" id="role" required style="width: 100%; max-width: 400px; padding: 5px;">
                <option value="" disabled selected>Pilih Peran Pengguna</option>
                <option value="panitia" {{ old('role') == 'panitia' ? 'selected' : '' }}>Panitia (Scan Tiket)</option>
                <option value="eo" {{ old('role') == 'eo' ? 'selected' : '' }}>Event Organizer (EO)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Platform)</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pelanggan Biasa</option>
            </select>
        </div>

        <div style="margin-top: 25px;">
            <button type="submit" style="padding: 10px 20px; cursor: pointer; background-color: blue; color: white; border: none;">Simpan Pengguna Baru</button>
        </div>
    </form>

    <!-- SCRIPT UNTUK LOGIKA IKON MATA -->
    <script>
        // Mengambil elemen HTML dari ID-nya
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        // Mendengarkan saat ikon mata diklik
        togglePassword.addEventListener('click', function () {

            // Cek apakah tipenya saat ini 'password'. Jika ya, ubah ke 'text'. Jika tidak, kembalikan ke 'password'.
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Mengubah bentuk ikon sebagai penanda visual
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>

</body>
</html>
