<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{

    // ==========================================
    // FUNGSI MENAMPILKAN DAFTAR SPONSORSHIP (DENGAN PENCARIAN & FILTER)
    // ==========================================
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Siapkan query dasar dengan relasi event
        $query = \App\Models\Sponsorship::with('event');

        // 2. Batasi khusus EO (Hanya lihat paket sponsor dari event miliknya)
        if ($user->role === 'eo') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. MESIN PENCARI (Berdasarkan Nama Paket atau Nama Event)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('event', function($eq) use ($search) {
                      $eq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // 4. MESIN FILTER STATUS (Berdasarkan Event Aktif vs Selesai)
        if ($request->has('status') && $request->status != '') {
            $sekarang = \Carbon\Carbon::now(); // Waktu saat ini

            if ($request->status === 'active') {
                // Tampilkan paket yang event-nya masih di masa depan
                $query->whereHas('event', function($eq) use ($sekarang) {
                    $eq->where('event_date', '>=', $sekarang);
                });
            } elseif ($request->status === 'inactive') {
                // Tampilkan paket yang event-nya sudah berlalu
                $query->whereHas('event', function($eq) use ($sekarang) {
                    $eq->where('event_date', '<', $sekarang);
                });
            }
        }

        // 5. Eksekusi query (Urutkan dari yang terbaru)
        $sponsorships = $query->latest()->get();

        return view('admin.sponsorships.index', compact('sponsorships'));
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM TAMBAH (CREATE)
    // ==========================================
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'eo') {
            // Jika EO, hanya tampilkan event miliknya di pilihan dropdown
            $events = Event::where('user_id', $user->id)->get();
        } else {
            $events = Event::all();
        }

        return view('admin.sponsorships.create', compact('events'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN DATA BARU (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'benefits' => 'required|string',
            'quota'    => 'required|integer|min:1',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // PENGAMANAN EKSTRA UNTUK EO
        if ($user->role === 'eo') {
            $eventMilikEO = Event::where('id', $request->event_id)->where('user_id', $user->id)->first();
            // Jika EO mencoba memasukkan ID event orang lain, sistem akan menolak
            if (!$eventMilikEO) {
                return back()->with('error', 'Akses ditolak! Anda hanya dapat menambah sponsor untuk event Anda sendiri.');
            }
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sponsors', 'public');
        }

        Sponsorship::create($validated);

        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil ditambahkan!');
    }

    // ==========================================
    // FUNGSI MENAMPILKAN FORM EDIT (EDIT)
    // ==========================================
    public function edit($id)
    {
        $sponsor = Sponsorship::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'eo') {
            // Cegah EO mengedit sponsor milik event orang lain
            if ($sponsor->event->user_id !== $user->id) {
                return redirect()->route('admin.sponsorships.index')->with('error', 'Akses ditolak! Ini bukan paket sponsor Anda.');
            }
            // Hanya tampilkan event miliknya di dropdown
            $events = Event::where('user_id', $user->id)->get();
        } else {
            $events = Event::all();
        }

        return view('admin.sponsorships.edit', compact('sponsor', 'events'));
    }

    // ==========================================
    // FUNGSI MENYIMPAN PERUBAHAN (UPDATE)
    // ==========================================
    public function update(Request $request, $id)
    {
        $sponsor = Sponsorship::findOrFail($id);
        $user = Auth::user();

        // Cegah EO mengupdate sponsor milik event orang lain
        if ($user->role === 'eo' && $sponsor->event->user_id !== $user->id) {
            return redirect()->route('admin.sponsorships.index')->with('error', 'Akses ditolak!');
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'benefits' => 'required|string',
            'quota'    => 'required|integer|min:1',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cegah EO memindahkan sponsor ini ke event milik orang lain
        if ($user->role === 'eo') {
            $eventMilikEO = Event::where('id', $request->event_id)->where('user_id', $user->id)->first();
            if (!$eventMilikEO) {
                return back()->with('error', 'Akses ditolak! Event tujuan tidak valid.');
            }
        }

        if ($request->hasFile('image')) {
            if ($sponsor->image && \Storage::disk('public')->exists($sponsor->image)) {
                \Storage::disk('public')->delete($sponsor->image);
            }
            $validated['image'] = $request->file('image')->store('sponsors', 'public');
        }

        $sponsor->update($validated);

        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil diperbarui!');
    }

    // ==========================================
    // FUNGSI MENGHAPUS SPONSOR (DESTROY)
    // ==========================================
    public function destroy($id)
    {
        $sponsor = Sponsorship::findOrFail($id);
        $user = Auth::user();

        // Cegah EO menghapus sponsor milik event orang lain
        if ($user->role === 'eo' && $sponsor->event->user_id !== $user->id) {
            return redirect()->route('admin.sponsorships.index')->with('error', 'Akses ditolak!');
        }

        if ($sponsor->image && \Storage::disk('public')->exists($sponsor->image)) {
            \Storage::disk('public')->delete($sponsor->image);
        }

        $sponsor->delete();

        return redirect()->route('admin.sponsorships.index')->with('success', 'Paket Sponsor berhasil dihapus!');
    }

    // ==========================================
    // FUNGSI UNTUK MENAMPILKAN FORMULIR PENGAJUAN (PUBLIK)
    // ==========================================
    public function apply($id)
    {
        $sponsorship = \App\Models\Sponsorship::with('event')->findOrFail($id);
        return view('sponsorship-apply', compact('sponsorship'));
    }

    // ==========================================
    // FUNGSI UNTUK MENYIMPAN DATA PENGAJUAN (PUBLIK)
    // ==========================================
    public function submitApplication(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        \App\Models\SponsorshipTransaction::create([
            'sponsorship_id' => $id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect('/')->with('success', 'Pengajuan sponsorship berhasil dikirim! Silakan tunggu EO menghubungi Anda.');
    }


    // ==========================================
    // FUNGSI MENAMPILKAN PENGAJUAN SPONSOR MASUK (DENGAN PENCARIAN)
    // ==========================================
    public function requests(Request $request)
    {
        $user = Auth::user();

        // 1. Siapkan query dasar
        // Asumsi nama Modelnya adalah SponsorshipTransaction atau SponsorshipRequest, sesuaikan jika berbeda.
        $query = \App\Models\SponsorshipTransaction::with(['sponsorship.event']);

        // 2. Batasi khusus EO (Hanya lihat pengajuan untuk event miliknya)
        if ($user->role === 'eo') {
            $query->whereHas('sponsorship.event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. MESIN PENCARI (Berdasarkan Nama Perusahaan, Email, atau Nama Event)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('company_email', 'like', '%' . $search . '%')
                  ->orWhereHas('sponsorship.event', function($eq) use ($search) {
                      $eq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // 4. Eksekusi query (Urutkan dari yang terbaru)
        $requests = $query->latest()->get();

        return view('admin.sponsorships.requests', compact('requests'));
    }

    // ==========================================
    // FUNGSI UNTUK MENGUBAH STATUS ATAU PEMBAYARAN PENGAJUAN
    // ==========================================
    public function updateStatus(Request $request, $id)
    {
        $transaction = \App\Models\SponsorshipTransaction::findOrFail($id);
        $user = Auth::user();

        // Keamanan ekstra: Cegah EO merubah status pengajuan event orang lain
        if ($user->role === 'eo' && $transaction->sponsorship->event->user_id !== $user->id) {
            return back()->with('error', 'Akses ditolak!');
        }

        if ($request->has('status')) {
            $request->validate(['status' => 'required|in:pending,approved,rejected']);
            $transaction->update(['status' => $request->status]);
        }

        if ($request->has('payment_status')) {
            $request->validate(['payment_status' => 'required|in:unpaid,paid']);
            $transaction->update(['payment_status' => $request->payment_status]);
        }

        return back()->with('success', 'Data pengajuan sponsor berhasil diperbarui!');
    }
}
