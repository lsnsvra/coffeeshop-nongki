<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
   public function index(Request $request)
    {
        // 1. Filter Tanggal (Default: Awal bulan ini s/d hari ini)
        $start = $request->get('start', date('Y-m-01'));
        $end = $request->get('end', date('Y-m-d'));

        // SINKRON TOTAL: Diubah menggunakan CreatedDate karena created_at bernilai NULL di DB
        $totalOmzet = DB::table('orders')
            ->where('StatusOrder', 'paid')
            ->where('Status', 1)
            ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->sum('TotalHarga'); 
            
        $jumlahTransaksi = DB::table('orders')
            ->where('StatusOrder', 'paid')
            ->where('Status', 1)
            ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->count();
            
        $rataRata = $jumlahTransaksi > 0 ? $totalOmzet / $jumlahTransaksi : 0;

        // SINKRON TOTAL: Filter produk terlaris disesuaikan ke kolom CreatedDate
        $terlaris = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->where('orders.StatusOrder', 'paid')
            ->where('orders.Status', 1)
            ->whereBetween('orders.CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->select('products.NamaKopi', DB::raw('SUM(order_details.Qty) as total_terjual'))
            ->groupBy('products.NamaKopi')
            ->orderBy('total_terjual', 'desc')
            ->first();

        // Data Transaksi Terakhir diurutkan berdasarkan CreatedDate terbaru
        $transaksiTerakhir = DB::table('orders')
            ->where('Status', 1)
            ->orderBy('CreatedDate', 'desc')
            ->limit(10)
            ->get();

        return view('admin.laporan', compact(
            'totalOmzet', 
            'jumlahTransaksi', 
            'rataRata', 
            'terlaris', 
            'transaksiTerakhir',
            'start',
            'end'
        ));
    }
}