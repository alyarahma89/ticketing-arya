<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event (Mode Back-End)</title>
</head>
<body>

    <h1>Edit Event: {{ $event->name }}</h1>

    <!-- Link Kembali -->
    <a href="{{ route('admin.events.index') }}">⬅ Batal dan Kembali</a>
    <hr><br>

    <!-- Menampilkan Pesan Error Jika Ada -->
    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <strong>Gagal memperbarui event:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM EDIT EVENT -->
    <!-- Mengarah ke fungsi update dan mengirimkan ID event -->
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Memaksa form menjadi metode PUT untuk proses update data -->
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="name"><strong>Nama Resmi Event:</strong></label><br>
            <!-- Menampilkan data lama sebagai value -->
            <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category-select"><strong>Kategori / Klaster:</strong></label><br>
            <select name="category_id" id="category-select" required style="width: 100%; max-width: 400px;">
                <option value="" disabled>Pilih Klaster Kategori</option>
                <!-- Menampilkan Kategori dari Database -->
                @foreach($categories as $category)
                    <!-- Mengecek apakah ID kategori ini sama dengan category_id milik event yang sedang diedit -->
                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location"><strong>Lokasi / Venue:</strong></label><br>
            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="event_date"><strong>Waktu Pelaksanaan (Tanggal & Jam):</strong></label><br>
            <!-- Mengubah format tanggal dari database menjadi format yang dibaca oleh input datetime-local HTML (YYYY-MM-DDThh:mm) -->
            <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date', date('Y-m-d\TH:i', strtotime($event->event_date))) }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="price"><strong>Harga Tiket Offline (Rp):</strong></label><br>
            <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" required min="0">
        </div>

        <!-- Disembunyikan secara default, hanya muncul untuk Kategori Hybrid melalui JavaScript -->
        <div id="online-price-wrapper" style="margin-bottom: 15px; display: none;">
            <label for="online_price" style="color: blue;"><strong>Harga Tiket Online / Live (Rp):</strong></label><br>
            <input type="number" name="online_price" id="online_price" value="{{ old('online_price', $event->online_price) }}" min="0">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="quota"><strong>Kuota Maksimal Tiket:</strong></label><br>
            <input type="number" name="quota" id="quota" value="{{ old('quota', $event->quota) }}" required min="1">
        </div>

        <!-- Disembunyikan secara default, hanya muncul untuk Kategori Hybrid melalui JavaScript -->
        <div id="online-options" style="margin-bottom: 15px; display: none;">
            <label for="youtube_link" style="color: red;"><strong>Link Livestream YouTube:</strong></label><br>
            <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $event->youtube_link) }}" style="width: 100%; max-width: 400px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description"><strong>Deskripsi Lengkap Acara:</strong></label><br>
            <textarea name="description" id="description" rows="5" required style="width: 100%; max-width: 400px;">{{ old('description', $event->description) }}</textarea>
        </div>

        <div style="margin-bottom: 25px;">
            <label for="image"><strong>Poster Promosi:</strong></label><br>

            <!-- Menampilkan gambar lama jika ada -->
            @if($event->image)
                <div style="margin-bottom: 10px;">
                    <small>Poster saat ini:</small><br>
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Poster Event" style="max-width: 200px; border: 1px solid #ccc;">
                </div>
            @endif

            <small style="color: gray;">(Biarkan kosong jika tidak ingin mengubah poster)</small><br>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Simpan Perubahan Event</button>
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
                    // Kita tidak mereset nilai saat Edit, agar data lama tidak hilang secara tidak sengaja sebelum disimpan
                }
            }
        }

        // Jalankan pengecekan saat pertama kali halaman dimuat (untuk menyesuaikan tampilan dengan data lama)
        toggleOnlineFields();

        // Jalankan pengecekan setiap kali pilihan dropdown berubah
        categorySelect.addEventListener('change', toggleOnlineFields);
    </script>
</body>
</html>
