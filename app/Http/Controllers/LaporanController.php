<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ─── Query helper agar tidak duplikasi ───────────────────────────────────
    private function buildData(string $start, string $end): array
    {
        $statusSukses = ['paid', 'settlement', 'success'];

        $orderQuery = DB::table('orders')
            ->whereBetween('orders.TanggalOrder', [
                $start . ' 00:00:00',
                $end   . ' 23:59:59',
            ])
            ->where('orders.Status', 1);

        $paidQuery       = (clone $orderQuery)->whereIn(DB::raw('LOWER(StatusOrder)'), $statusSukses);
        $totalOmzet      = (float) $paidQuery->sum('TotalHarga');
        $jumlahTransaksi = (int)   $paidQuery->count();
        $rataRata        = $jumlahTransaksi > 0 ? $totalOmzet / $jumlahTransaksi : 0;

        $terlaris = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('orders',   'order_details.OrderID',   '=', 'orders.OrderID')
            ->whereIn(DB::raw('LOWER(orders.StatusOrder)'), $statusSukses)
            ->whereBetween('orders.TanggalOrder', [
                $start . ' 00:00:00',
                $end   . ' 23:59:59',
            ])
            ->where('orders.Status', 1)
            ->select('products.NamaKopi', DB::raw('SUM(order_details.Qty) as total_terjual'))
            ->groupBy('products.NamaKopi')
            ->orderByDesc('total_terjual')
            ->first();

        $transaksiTerakhir = (clone $orderQuery)
            ->leftJoin('users', 'orders.UserID', '=', 'users.UserID')
            ->select('orders.*', 'users.Nama as nama_pembeli')
            ->orderByDesc('orders.TanggalOrder')
            ->get();

        // Kelompokkan per tanggal (untuk PDF)
        $transaksiByDate = $transaksiTerakhir->groupBy(function ($t) {
            return Carbon::parse($t->TanggalOrder)->isoFormat('dddd, D MMMM Y');
        });

        return compact(
            'totalOmzet', 'jumlahTransaksi', 'rataRata',
            'terlaris', 'transaksiTerakhir', 'transaksiByDate',
            'start', 'end'
        );
    }

    // ─── Halaman web laporan ─────────────────────────────────────────────────
    public function index(Request $request)
    {
        $start = $request->get('start', date('Y-m-01'));
        $end   = $request->get('end',   date('Y-m-d'));

        return view('admin.laporan', $this->buildData($start, $end));
    }

    // ─── Export PDF ──────────────────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        // Terima baik 'start' maupun 'start_date' agar fleksibel
        $start = $request->get('start', $request->get('start_date', date('Y-m-01')));
        $end   = $request->get('end',   $request->get('end_date',   date('Y-m-d')));

        $data = $this->buildData($start, $end);

        $pdf = Pdf::loadView('admin.laporan-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'     => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi'             => 150,
            ]);

        $filename = 'laporan-nongki-' . $start . '-sd-' . $end . '.pdf';

        return $pdf->stream($filename);
    }
}