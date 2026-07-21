<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event (Mode Back-End)</title>
</head>
<body>

    <h1>Manajemen Event</h1>

    <!-- Link Navigasi Dasar -->
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali ke Dashboard</a> |
    <a href="{{ route('admin.categories.index') }}">🏷️ Kelola Kategori</a> |
    <a href="{{ route('admin.events.create') }}">➕ Tambah Event Baru</a>
    <hr><br>

    <!-- Menampilkan Pesan Sukses Jika Ada -->
    @if(session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            Sukses: {{ session('success') }}
        </div>
    @endif

    <!-- TABEL DATA EVENT -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Event</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;">Lokasi</th>
                <th style="width: 15%;">Pelaksanaan</th>
                <th style="width: 15%;">Harga & Kuota</th>
                <th style="width: 10%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $index => $event)
            <tr>
                <!-- Nomor Urut -->
                <td style="text-align: center;">{{ $index + 1 }}</td>

                <!-- Nama Event & Status Poster -->
                <td>
                    <strong>{{ $event->name }}</strong><br>
                    <small style="color: gray;">
                        @if($event->image)
                            [Ada Poster]
                        @else
                            [Tidak Ada Poster]
                        @endif
                    </small>
                </td>

                <!-- PERBAIKAN: Memanggil spesifik ->name dari relasi category -->
                <td>
                    {{ $event->category->name ?? 'Tanpa Kategori' }}
                </td>

                <!-- Lokasi -->
                <td>{{ $event->location }}</td>

                <!-- Tanggal & Jam -->
                <td>
                    {{ date('d M Y', strtotime($event->event_date)) }}<br>
                    <small>{{ date('H:i', strtotime($event->event_date)) }} WIB</small>
                </td>

                <!-- Harga & Kuota -->
                <td>
                    @if($event->price == 0)
                        <span style="color: green; font-weight: bold;">Gratis</span>
                    @else
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    @endif
                    <br>
                    <small>Kuota: {{ $event->quota }}</small>
                </td>

                <!-- Tombol Aksi -->
                <td style="text-align: center;">
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.events.edit', $event->id) }}" style="text-decoration: none; color: blue;">Edit</a>

                    &nbsp;|&nbsp;

                    <!-- Form Hapus -->
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red; border: none; background: none; cursor: pointer; text-decoration: underline; padding: 0;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Tampilan Jika Data Kosong -->
            <tr>
                <td colspan="7" style="text-align: center; color: gray; padding: 30px;">
                    Belum ada data event.<br><br>
                    <a href="{{ route('admin.events.create') }}">Tambah Event Sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
