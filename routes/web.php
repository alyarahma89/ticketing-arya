<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\Sponsorship;
use App\Models\Transaction;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\SponsorshipController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\EOEventController;
use App\Http\Controllers\AdminReportController;


// =========================================================
// RUTE PUBLIK (TIDAK PERLU LOGIN)
// =========================================================
Route::get('/', function (Request $request) {
    $query = Event::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('category', 'like', '%' . $request->search . '%');
    }
    if ($request->has('location') && $request->location != '') {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    $events = $query->latest()->get();
    $sponsorships = Sponsorship::with('event')->latest()->get();

    return view('events.index', compact('events', 'sponsorships'));
});

Route::get('/event/{id}', function ($id) {
    $event = Event::findOrFail($id);
    return view('events.show', compact('event'));
});

// Testing Email (Boleh dibiarkan)
Route::get('/test-email-qr', function () {
    $transaction = Transaction::latest()->first();
    if (!$transaction) { return "Belum ada transaksi di database!"; }
    Mail::to('newwestthoseeyes@gmail.com')->send(new TicketMail($transaction));
    return "Email dengan QR Code dikirim!";
});
Route::get('/tes-langsung', function () { return view('emails.ticket'); });

// Route untuk menampilkan event berdasarkan kategori
Route::get('/events/category/{id}', [App\Http\Controllers\AdminEventController::class, 'byCategory'])->name('events.byCategory');
// Tambahkan rute ini untuk halaman detail sponsorship sebuah event
Route::get('/event/{id}/sponsorship', [App\Http\Controllers\AdminEventController::class, 'sponsorship'])->name('event.sponsorship');

// =========================================================
// RUTE PEMESANAN & PROFIL (SEMUA AKUN YANG LOGIN: USER, EO, ADMIN)
// =========================================================
Route::middleware('auth')->group(function () {
    Route::post('/checkout/{id}', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/transaction/{id}', [CheckoutController::class, 'show'])->name('transaction.show');
    Route::get('/history', [CheckoutController::class, 'history'])->name('transaction.history');
    Route::get('/download-ticket/{id}', [CheckoutController::class, 'downloadTicket'])->name('ticket.download');
    Route::get('/debug-paid/{id}', [CheckoutController::class, 'debugPaid']);

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // TAMBAHKAN DUA BARIS INI UNTUK PENGAJUAN SPONSOR
    Route::get('/sponsorship/{id}/apply', [App\Http\Controllers\SponsorshipController::class, 'apply'])->name('sponsorship.apply');
    Route::post('/sponsorship/{id}/apply', [App\Http\Controllers\SponsorshipController::class, 'submitApplication'])->name('sponsorship.submit');
});

// =========================================================
// RUTE SCANNER (KHUSUS PANITIA, EO, & ADMIN)
// =========================================================
Route::middleware(['auth', 'role:admin,eo,panitia'])->group(function () {
    Route::get('/scanner', [CheckInController::class, 'index']);
    Route::post('/check-in-process', [CheckInController::class, 'process']);
    // --- TAMBAHKAN DUA BARIS INI ---
    Route::get('/panitia/attendance', [PanitiaController::class, 'attendance'])->name('panitia.attendance');
    Route::get('/panitia/event-info', [PanitiaController::class, 'eventInfo'])->name('panitia.event_info');
});

// =========================================================
// RUTE DASHBOARD & MANAJEMEN EVENT (KHUSUS EO & ADMIN)
// =========================================================
Route::middleware(['auth', 'role:admin,eo'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [AdminEventController::class, 'dashboard'])->name('dashboard');

    // CRUD Event
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [AdminEventController::class, 'create'])->name('events.create');
    Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [AdminEventController::class, 'destroy'])->name('events.destroy');

    // Manajemen Transaksi
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

    Route::get('/sponsorships', [SponsorshipController::class, 'index'])->name('sponsorships.index');
    Route::get('/sponsorships/create', [SponsorshipController::class, 'create'])->name('sponsorships.create');
    Route::post('/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');

    // TAMBAHKAN 3 BARIS INI:
    Route::get('/sponsorships/{id}/edit', [SponsorshipController::class, 'edit'])->name('sponsorships.edit');
    Route::put('/sponsorships/{id}', [SponsorshipController::class, 'update'])->name('sponsorships.update');
    Route::delete('/sponsorships/{id}', [SponsorshipController::class, 'destroy'])->name('sponsorships.destroy');

    Route::get('/sponsorship-requests', [App\Http\Controllers\SponsorshipController::class, 'requests'])->name('sponsorship_requests.index');
    Route::put('/sponsorship-requests/{id}/status', [App\Http\Controllers\SponsorshipController::class, 'updateStatus'])->name('sponsorship_requests.update');

    // CRUD Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Rute untuk laporan keuangan
    Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports.index');
});

// =========================================================
// RUTE KELOLA PENGGUNA (SANGAT RAHASIA - KHUSUS ADMIN)
// =========================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Menampilkan daftar pengguna
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    // 2. Menampilkan formulir tambah pengguna (Ini yang tadi kurang)
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');

    // 3. Memproses penyimpanan data pengguna baru ke database (Ini juga penting)
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');

    // 4. Menghapus pengguna
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Rute khusus untuk Panitia
Route::middleware(['auth'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'index'])->name('dashboard');
    Route::get('/scanner', [PanitiaController::class, 'scanner'])->name('scanner');
});

// =========================================================
// RUTE KHUSUS EVENT ORGANIZER (EO)
// =========================================================
Route::middleware(['auth', 'role:eo'])->prefix('eo')->group(function () {
    Route::get('/dashboard', [EOEventController::class, 'dashboard'])->name('eo.dashboard');
});

// =========================================================
// INTEGRASI PAYMENT GATEWAY MIDTRANS
// =========================================================
Route::post('/midtrans-callback', [CheckoutController::class, 'callback']);
Route::get('/midtrans/finish', [CheckoutController::class, 'finish'])->name('midtrans.finish');

require __DIR__.'/auth.php';
