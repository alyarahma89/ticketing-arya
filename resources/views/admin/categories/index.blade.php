<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori (Mode Back-End)</title>
</head>
<body>

    <h1>Manajemen Kategori Event</h1>

    <!-- Menampilkan Pesan Sukses atau Error -->
    @if(session('success'))
        <div style="color: green; font-weight: bold; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; font-weight: bold; margin-bottom: 15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    <!-- FORM TAMBAH KATEGORI (METHOD POST) -->
    <h2>Tambah Kategori Baru</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <label for="name">Nama Kategori:</label>
        <input type="text" name="name" id="name" required placeholder="Contoh: KONSER MUSIK">
        <button type="submit">Simpan Kategori</button>
    </form>

    <hr>

    <!-- TABEL DAFTAR KATEGORI -->
    <h2>Daftar Kategori Tersedia</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 800px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 50px;">ID</th>
                <th>Nama Kategori</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td style="text-align: center;">{{ $category->id }}</td>
                    <td>
                        <!-- FORM EDIT KATEGORI LANGSUNG (METHOD PUT) -->
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" style="display: flex; gap: 10px;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" required style="width: 100%;">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td style="text-align: center;">
                        <!-- FORM HAPUS KATEGORI (METHOD DELETE) -->
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')" style="color: red;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: gray;">Data kategori masih kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <!-- Navigasi Kembali -->
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali ke Dashboard</a>

</body>
</html>
