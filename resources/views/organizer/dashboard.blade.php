<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard EO | TICKS ID</title>

    <!-- Memanggil Bootstrap 5 dan Ikon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #696FC7;
            --bg-canvas: #f8f9fa;
            --text-dark: #1c1e54;
            --text-muted: #64748d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-canvas);
        }

        /* Desain Kartu Statistik yang Modern */
        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e3e8ee;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
</head>
<body>

<!-- Navbar Sederhana Khusus EO -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#" style="color: var(--text-dark);">
            <i class="bi bi-stars text-warning"></i> TICKS ID <span class="badge bg-primary ms-2">EO Panel</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">Halo, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Keluar</button>
            </form>
        </div>
    </div>
</nav>

<!-- Konten Utama Dashboard -->
<div class="container py-5">

    <div class="mb-5">
        <h3 class="fw-bold" style="color: var(--text-dark);">Ringkasan Performa Event</h3>
        <p class="text-muted">Pantau penjualan tiket dan acara aktifmu di sini.</p>
    </div>

    <!-- 1. Baris Kartu Statistik -->
    <div class="row g-4 mb-5">

        <!-- Kartu 1: Total Event -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-medium" style="color: var(--text-muted);">Event Aktif</p>
                        <h2 class="fw-bold mb-0" style="color: var(--text-dark);">{{ $eventAktif }}</h2>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Tiket Terjual -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-medium" style="color: var(--text-muted);">Tiket Terjual</p>
                        <h2 class="fw-bold mb-0" style="color: var(--text-dark);">{{ $tiketTerjual }}</h2>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Total Pendapatan -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 fw-medium" style="color: var(--text-muted);">Total Pendapatan</p>
                        <h2 class="fw-bold mb-0" style="color: var(--text-dark);">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 2. Bagian Tabel Event Terakhir -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="color: var(--text-dark);">Event Terakhirmu</h5>
            <button class="btn btn-sm btn-primary rounded-pill px-3">+ Buat Event Baru</button>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-muted fw-medium py-3">Nama Event</th>
                            <th scope="col" class="text-muted fw-medium py-3">Tanggal</th>
                            <th scope="col" class="text-muted fw-medium py-3">Lokasi</th>
                            <th scope="col" class="text-muted fw-medium py-3">Sisa Kuota</th>
                            <th scope="col" class="text-muted fw-medium py-3 text-end">Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Melakukan perulangan untuk menampilkan data event dari database -->
                        @forelse ($activeEvents as $event)
                        <tr>
                            <td class="fw-semibold" style="color: var(--text-dark);">{{ $event->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">{{ $event->quota }} Tiket</span>
                            </td>
                            <td class="text-end fw-medium">{{ number_format($event->price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <!-- Pesan jika EO belum membuat event sama sekali -->
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Kamu belum membuat event apa pun. Yuk, mulai buat event pertamamu!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
