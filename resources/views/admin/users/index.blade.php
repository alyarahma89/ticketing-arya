<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna (Mode Back-End)</title>
</head>
<body>

    <h1>Database Pengguna</h1>

    <!-- Link Navigasi Dasar -->
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali ke Dashboard</a> |
    <a href="{{ route('admin.users.create') }}">➕ Tambah Pengguna Baru (Panitia/EO)</a>
    <hr><br>

    <!-- Menampilkan Pesan Sukses -->
    @if(session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            Sukses: {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan Pesan Error -->
    @if(session('error'))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            Gagal: {{ session('error') }}
        </div>
    @endif

    <p>Total Akun Terdaftar: <strong>{{ count($users) }}</strong></p>

    <!-- TABEL DATA PENGGUNA -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Profil Pengguna</th>
                <th style="width: 30%;">Alamat Email</th>
                <th style="width: 15%;">Hak Akses (Role)</th>
                <th style="width: 20%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <!-- Nomor Urut -->
                <td style="text-align: center;">{{ $index + 1 }}</td>

                <!-- Nama dan ID -->
                <td>
                    <strong>{{ $user->name }}</strong><br>
                    <small style="color: gray;">ID: #USR-{{ $user->id }}</small>
                </td>

                <!-- Email -->
                <td>{{ $user->email }}</td>

                <!-- Role -->
                <td>
                    <!-- Mengubah tampilan teks berdasarkan role -->
                    @if($user->role == 'admin')
                        <span style="color: blue; font-weight: bold;">ADMIN</span>
                    @elseif($user->role == 'panitia')
                        <span style="color: orange; font-weight: bold;">PANITIA</span>
                    @elseif($user->role == 'eo')
                        <span style="color: purple; font-weight: bold;">EVENT ORGANIZER</span>
                    @else
                        <span style="color: gray;">PELANGGAN</span>
                    @endif
                </td>

                <!-- Aksi (Hapus Akun) -->
                <td style="text-align: center;">
                    <!-- Mencegah admin menghapus akunnya sendiri yang sedang dipakai login -->
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Peringatan: Menghapus akun akan menghilangkan semua data transaksi pengguna ini. Yakin ingin menghapus permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: red; border: none; background: none; cursor: pointer; text-decoration: underline; padding: 0;">
                                Hapus Akun
                            </button>
                        </form>
                    @else
                        <span style="color: green; font-weight: bold;">[Akun Anda]</span>
                    @endif
                </td>
            </tr>
            @empty
            <!-- Tampilan Jika Data Kosong -->
            <tr>
                <td colspan="5" style="text-align: center; color: gray; padding: 30px;">
                    Belum ada data pengguna lainnya.<br><br>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
