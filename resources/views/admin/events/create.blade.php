<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event Baru (Mode Back-End)</title>
</head>
<body>

    <h1>Tambah Event Baru</h1>

    <!-- Link Kembali -->
    <a href="{{ route('admin.events.index') }}">⬅ Kembali ke Daftar Event</a>
    <hr><br>

    <!-- Menampilkan Pesan Error Jika Ada -->
    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <strong>Gagal menerbitkan event:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM TAMBAH EVENT -->
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name"><strong>Nama Resmi Event:</strong></label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category-select"><strong>Kategori / Klaster:</strong></label><br>
            <select name="category_id" id="category-select" required style="width: 100%; max-width: 400px;">
                <option value="" disabled selected>Pilih Klaster Kategori</option>
                <!-- Menampilkan Kategori dari Database -->
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location"><strong>Lokasi / Venue:</strong></label><br>
            <input type="text" name="location" id="location" value="{{ old('location') }}" required style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="event_date"><strong>Waktu Pelaksanaan (Tanggal & Jam):</strong></label><br>
            <!-- Input datetime-local akan memunculkan kalender saat diklik -->
            <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="price"><strong>Harga Tiket Offline (Rp):</strong></label><br>
            <input type="number" name="price" id="price" value="{{ old('price', 0) }}" required min="0">
        </div>

        <!-- Disembunyikan secara default, hanya muncul untuk Kategori Hybrid -->
        <div id="online-price-wrapper" style="margin-bottom: 15px; display: none;">
            <label for="online_price" style="color: blue;"><strong>Harga Tiket Online / Live (Rp):</strong></label><br>
            <input type="number" name="online_price" id="online_price" value="{{ old('online_price', 0) }}" min="0">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="quota"><strong>Kuota Maksimal Tiket:</strong></label><br>
            <input type="number" name="quota" id="quota" value="{{ old('quota') }}" required min="1">
        </div>

        <!-- Disembunyikan secara default, hanya muncul untuk Kategori Hybrid -->
        <div id="online-options" style="margin-bottom: 15px; display: none;">
            <label for="youtube_link" style="color: red;"><strong>Link Livestream YouTube:</strong></label><br>
            <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link') }}" style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description"><strong>Deskripsi Lengkap Acara:</strong></label><br>
            <textarea name="description" id="description" rows="5" required style="width: 100%; max-width: 400px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 25px;">
            <label for="image"><strong>Poster Promosi (Opsional):</strong></label><br>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Publikasikan Event</button>
    </form>

    <script>
        // Logika Javascript untuk memunculkan kolom harga online & Youtube
        const categorySelect = document.getElementById('category-select');
        const onlineOptions = document.getElementById('online-options');
        const onlinePriceWrapper = document.getElementById('online-price-wrapper');

        // Daftar nama kategori yang memunculkan opsi Livestream
        const hybridCategories = ['LIVE CONCERT', 'WORKSHOP', 'STAND UP COMEDY'];

        function toggleOnlineFields() {
            if(categorySelect.selectedIndex >= 0) {
                // Ambil teks dari opsi yang dipilih
                const selectedText = categorySelect.options[categorySelect.selectedIndex].text.trim().toUpperCase();

                if (hybridCategories.includes(selectedText)) {
                    // Tampilkan kolom
                    onlineOptions.style.display = 'block';
                    onlinePriceWrapper.style.display = 'block';
                } else {
                    // Sembunyikan kolom
                    onlineOptions.style.display = 'none';
                    onlinePriceWrapper.style.display = 'none';
                    // Reset nilai inputan ke default
                    document.getElementById('youtube_link').value = '';
                    document.getElementById('online_price').value = 0;
                }
            }
        }

        // Jalankan pengecekan saat pertama kali halaman dimuat (berguna jika ada old() data)
        toggleOnlineFields();

        // Jalankan pengecekan setiap kali pilihan dropdown berubah
        categorySelect.addEventListener('change', toggleOnlineFields);
    </script>
</body>
</html>
