<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
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

        // 2. Filter Role (Admin vs EO)
        // Logika ini sudah sangat benar! Admin akan melewatkan filter ini.
        if ($user->role === 'eo') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // 3. Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // 4. Ambil data yang sudah difilter
        $reports = $query->latest()->get();

        // ==========================================
        // FITUR EXPORT (EXCEL & PDF)
        // ==========================================
        if ($request->has('export')) {

            // 1. Logika Jika Export EXCEL
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

            // 2. Logika Jika Export PDF
            if ($request->export === 'pdf') {
                $pdf = Pdf::loadView('admin.reports.pdf', compact('reports'));

                // Mengubah nama file menjadi ARTIX_ID
                return $pdf->download('Laporan_Pendapatan_ARTIX_ID_' . date('Y-m-d') . '.pdf');
            }
        }

        // ==========================================
        // PERSIAPAN DATA GRAFIK (CHART.JS)
        // ==========================================
        $chartDataRaw = $reports->groupBy(function($item) {
            return Carbon::parse($item->created_at)->format('d M Y');
        })->map(function($row) {
            return $row->sum('total_amount');
        });

        $chartLabels = $chartDataRaw->keys()->toArray();
        $chartValues = $chartDataRaw->values()->toArray();

        // 5. Hitung Ringkasan (Total Uang dan Total Tiket)
        $totalPendapatan = $reports->sum('total_amount');
        $totalTiket = $reports->sum('quantity');

        // 6. Kirim ke tampilan (View)
        return view('admin.reports.index', compact('reports', 'totalPendapatan', 'totalTiket', 'chartLabels', 'chartValues'));
    }
}
