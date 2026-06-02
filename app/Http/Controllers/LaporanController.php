<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input tanggal (jika kosong, default ke bulan berjalan)
        $start = $request->get('start', date('Y-m-01'));
        $end = $request->get('end', date('Y-m-d'));

        // 2. Definisikan status sukses yang sinkron dengan dashboard
        $statusSukses = ['paid', 'settlement', 'success'];

        // 3. Definisikan Base Query menggunakan kolom TanggalOrder agar sinkron dengan database & dashboard
        $orderQuery = DB::table('orders')
            ->whereBetween('orders.TanggalOrder', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->where('orders.Status', 1);

        // 4. Ringkasan Statistik
        $paidQuery = (clone $orderQuery)->whereIn(DB::raw('LOWER(StatusOrder)'), $statusSukses);
        $totalOmzet = $paidQuery->sum('TotalHarga');
        $jumlahTransaksi = $paidQuery->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalOmzet / $jumlahTransaksi : 0;

        // 5. Produk Terlaris
        $terlaris = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->whereIn(DB::raw('LOWER(orders.StatusOrder)'), $statusSukses)
            ->whereBetween('orders.TanggalOrder', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->where('orders.Status', 1)
            ->select('products.NamaKopi', DB::raw('SUM(order_details.Qty) as total_terjual'))
            ->groupBy('products.NamaKopi')
            ->orderBy('total_terjual', 'desc')
            ->first();

        // 6. Daftar Transaksi Terakhir (Terbaru ditarik ke ATAS menggunakan TanggalOrder DESC)
        $transaksiTerakhir = (clone $orderQuery)
            ->leftJoin('users', 'orders.UserID', '=', 'users.UserID')
            ->select('orders.*', 'users.Nama as nama_pembeli')
            ->orderBy('orders.TanggalOrder', 'desc')
            ->get();

        return view('admin.laporan', compact(
            'totalOmzet', 'jumlahTransaksi', 'rataRata', 'terlaris', 
            'transaksiTerakhir', 'start', 'end'
        ));
    }
}