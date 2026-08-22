<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Sponsorship;
use App\Models\Category;

class HomeController extends Controller
{
    // ====================================================
    // FUNGSI 1: Halaman Utama (Beranda)
    // ====================================================
    public function index(Request $request)
    {
        // PERBAIKAN: Hanya ambil event yang tanggalnya hari ini atau di masa depan
        $query = Event::whereDate('event_date', '>=', now()->toDateString());

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function ($subQuery) use ($searchTerm) {
                      $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Hanya ambil 6 data terbaru untuk etalase Beranda
        $events = $query->latest()->take(6)->get();

        // Untuk Sponsorship di beranda, kita juga bisa memfilter agar hanya menampilkan dari event yang belum lewat
        $sponsorships = Sponsorship::whereHas('event', function($q) {
            $q->whereDate('event_date', '>=', now()->toDateString());
        })->latest()->get();

        // ── BARIS BARU: Mengambil data kategori dari Otak (Controller) ──
        $categories = Category::all();

        // ── UPDATE: Tambahkan 'categories' ke dalam compact ──
        return view('events.index', compact('events', 'sponsorships', 'categories'));
    }

    // ====================================================
    // FUNGSI 2: Halaman Katalog Semua Event
    // ====================================================
    public function exploreEvents(Request $request)
    {
        // PERBAIKAN: Hanya ambil event yang tanggalnya hari ini atau di masa depan
        $query = Event::whereDate('event_date', '>=', now()->toDateString());

        // Fitur Pencarian berdasarkan nama event atau nama kategori
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function($subQuery) use ($searchTerm) {
                      $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Fitur Filter berdasarkan ID Kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Fitur Filter berdasarkan Lokasi
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Gunakan paginate(12) agar data dibagi menjadi 12 kartu per halaman
        $events = $query->latest()->paginate(12);

        // Ambil semua kategori untuk ditampilkan di tombol filter
        $categories = Category::all();

        return view('explore.events', compact('events', 'categories'));
    }

    // ====================================================
    // FUNGSI 3: Halaman Katalog Semua Sponsorship
    // ====================================================
    public function exploreSponsorships(Request $request)
    {
        // PERBAIKAN: Hanya ambil event yang belum lewat untuk halaman sponsorship
        $query = Event::whereDate('event_date', '>=', now()->toDateString());

        // Fitur Pencarian berdasarkan nama event atau kategori untuk sponsorship
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function($subQuery) use ($searchTerm) {
                      $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Fitur Filter Lokasi
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Sama seperti event, gunakan paginate agar rapi
        $events = $query->latest()->paginate(12);

        return view('explore.sponsorships', compact('events'));
    }
}
