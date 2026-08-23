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
// use App\Http\Controllers\EOEventController; // <-- TELAH DIHAPUS (Tidak Dipakai Lagi)
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\HomeController;


// =========================================================
// RUTE PUBLIK (TIDAK PERLU LOGIN)
// =========================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore/events', [HomeController::class, 'exploreEvents'])->name('explore.events');
Route::get('/explore/sponsorships', [HomeController::class, 'exploreSponsorships'])->name('explore.sponsorships');

Route::get('/event/{id}', function ($id) {
    $event = Event::findOrFail($id);
    return view('events.show', compact('event'));
});

Route::view('/syarat-ketentuan', 'pages.terms')->name('terms');
Route::view('/kebijakan-refund', 'pages.refund')->name('refund');

Route::get('/events/category/{id}', [App\Http\Controllers\AdminEventController::class, 'byCategory'])->name('events.byCategory');
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

    // Pengajuan Sponsor
    Route::get('/sponsorship/{id}/apply', [App\Http\Controllers\SponsorshipController::class, 'apply'])->name('sponsorship.apply');
    Route::post('/sponsorship/{id}/apply', [App\Http\Controllers\SponsorshipController::class, 'submitApplication'])->name('sponsorship.submit');

    // Rute untuk memproses pengajuan refund dari sisi pelanggan (Jika masih dipakai)
    Route::post('/transaksi/{id}/refund', [\App\Http\Controllers\CheckoutController::class, 'requestRefund'])->name('transaction.refund');
});


// =========================================================
// RUTE SCANNER (KHUSUS PANITIA, EO, & ADMIN)
// =========================================================
Route::middleware(['auth', 'role:admin,eo,panitia'])->group(function () {
    Route::get('/scanner', [CheckInController::class, 'index']);
    Route::post('/check-in-process', [CheckInController::class, 'process']);
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

    // Manajemen Transaksi & Refund
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    // --- BARIS BARU UNTUK PROSES REFUND OLEH ADMIN/EO ---
    Route::post('/transactions/{id}/refund', [AdminTransactionController::class, 'processRefund'])->name('refund.process');

    // Manajemen Sponsorship
    Route::get('/sponsorships', [SponsorshipController::class, 'index'])->name('sponsorships.index');
    Route::get('/sponsorships/create', [SponsorshipController::class, 'create'])->name('sponsorships.create');
    Route::post('/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');
    Route::get('/sponsorships/{id}/edit', [SponsorshipController::class, 'edit'])->name('sponsorships.edit');
    Route::put('/sponsorships/{id}', [SponsorshipController::class, 'update'])->name('sponsorships.update');
    Route::delete('/sponsorships/{id}', [SponsorshipController::class, 'destroy'])->name('sponsorships.destroy');

    Route::get('/sponsorship-requests', [SponsorshipController::class, 'requests'])->name('sponsorship_requests.index');
    Route::put('/sponsorship-requests/{id}/status', [SponsorshipController::class, 'updateStatus'])->name('sponsorship_requests.update');

    // CRUD Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Laporan Keuangan
    Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports.index');

    // ROUTE REFUND LAMA TELAH DIHAPUS DARI SINI
});


// =========================================================
// RUTE KELOLA PENGGUNA (SANGAT RAHASIA - KHUSUS ADMIN)
// =========================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});


// Rute khusus untuk Panitia
Route::middleware(['auth'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'index'])->name('dashboard');
    Route::get('/scanner', [PanitiaController::class, 'scanner'])->name('scanner');

    // Rute untuk memproses hasil scan QR Code via AJAX
    Route::post('/scanner/process', [\App\Http\Controllers\PanitiaController::class, 'processScan'])->name('scanner.process');
});


// =========================================================
// RUTE KHUSUS EVENT ORGANIZER (EO)
// =========================================================
Route::middleware(['auth', 'role:eo'])->prefix('eo')->group(function () {
    // KITA ARAHKAN DASHBOARD EO KE CONTROLLER BARU
    Route::get('/dashboard', [AdminEventController::class, 'dashboard'])->name('eo.dashboard');
});


// =========================================================
// INTEGRASI PAYMENT GATEWAY MIDTRANS
// =========================================================
Route::post('/midtrans-callback', [CheckoutController::class, 'callback']);
Route::get('/midtrans/finish', [CheckoutController::class, 'finish'])->name('midtrans.finish');

// =========================================================
// RUTE DEBUGGING SEMENTARA (Hapus jika email sudah lancar)
// =========================================================
Route::get('/test-email/{id}', function($id) {
    // Cari data transaksi berdasarkan ID
    $transaction = \App\Models\Transaction::with(['event', 'user', 'tickets'])->findOrFail($id);
    
    // Paksa kirim email
    \Illuminate\Support\Facades\Mail::to($transaction->user->email)->send(new \App\Mail\TicketMail($transaction));
    
    // Pesan sukses jika tidak ada error
    return "Sukses Kirim Email untuk Transaksi #" . $transaction->order_id . "! Silakan cek inbox/spam.";
});

require __DIR__.'/auth.php';
