<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Event; // Pastikan ini ditambahkan di atas
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Siapkan query dasar: Ambil transaksi yang SUDAH DIBAYAR saja
        $query = Transaction::with(['user', 'event'])->whereIn('payment_status', ['paid', 'success', 'settlement']);

        // ==========================================
        // DATA EVENT AKTIF & TIDAK AKTIF
        // ==========================================
        $eventQuery = \App\Models\Event::query();

        if ($user->role === 'eo') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            $eventQuery->where('user_id', $user->id);
        }

        $now = Carbon::now();
        $activeEventsCount = (clone $eventQuery)->where('event_date', '>=', $now)->count();
        $inactiveEventsCount = (clone $eventQuery)->where('event_date', '<', $now)->count();

        // 2. Filter Tanggal Transaksi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $reports = $query->latest()->get();

        // 3. Hitung Ringkasan (Total Uang dan Total Tiket)
        $totalPendapatan = $reports->sum('total_amount');
        $totalTiket = $reports->sum('quantity');

        // 4. PERSIAPAN DATA GRAFIK & EVENT POPULER
        $chartDataRaw = $reports->groupBy(function($item) {
            return Carbon::parse($item->created_at)->format('d M Y');
        })->map(function($row) {
            return $row->sum('total_amount');
        });

        $chartLabels = $chartDataRaw->keys()->toArray();
        $chartValues = $chartDataRaw->values()->toArray();

        $popularEventsList = $reports->groupBy(function($item) {
            return $item->event->name ?? 'Event Terhapus';
        })->map(function($group) {
            return $group->sum('quantity');
        })->sortByDesc(function($count) {
            return $count;
        })->take(5);

        $popularEventLabels = $popularEventsList->keys()->toArray();
        $popularEventValues = $popularEventsList->values()->toArray();

        // ==========================================
        // FITUR EXPORT (EXCEL & PDF) - Dipindah ke bawah agar semua data terhitung
        // ==========================================
        if ($request->has('export')) {
            if ($request->export === 'excel') {
                $fileName = 'laporan_pendapatan_' . date('Y-m-d') . '.csv';
                $headers = [
                    "Content-type"        => "text/csv",
                    "Content-Disposition" => "attachment; filename=$fileName",
                    "Pragma"              => "no-cache",
                    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                    "Expires"             => "0"
                ];

                $callback = function() use($reports) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Tanggal', 'Nama Event', 'Jumlah Tiket', 'Total Pendapatan (Rp)']);
                    foreach ($reports as $report) {
                        fputcsv($file, [
                            $report->created_at->format('d M Y, H:i'),
                            $report->event->name ?? 'Event Terhapus',
                            $report->quantity,
                            $report->total_amount
                        ]);
                    }
                    fclose($file);
                };
                return response()->stream($callback, 200, $headers);
            }

            if ($request->export === 'pdf') {
                // Semua variabel baru dikirim ke PDF
                $pdf = Pdf::loadView('admin.reports.pdf', compact(
                    'reports', 'totalPendapatan', 'totalTiket',
                    'activeEventsCount', 'inactiveEventsCount', 'popularEventsList'
                ));
                return $pdf->download('Laporan_Pendapatan_ARTIX_ID_' . date('Y-m-d') . '.pdf');
            }
        }

        // 5. Kirim ke tampilan web (View)
        return view('admin.reports.index', compact(
            'reports', 'totalPendapatan', 'totalTiket',
            'chartLabels', 'chartValues',
            'activeEventsCount', 'inactiveEventsCount',
            'popularEventLabels', 'popularEventValues'
        ));
    }
}
