<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
   public function index(Request $request)
{
    // Filter Tanggal
    $start = $request->get('start', date('Y-m-01'));
    $end = $request->get('end', date('Y-m-d'));

    // Ringkasan Stats
    // Ganti 'TotalBayar' jika nama kolom di tabel orders berbeda
    $totalOmzet = DB::table('orders')
        ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
        ->sum('TotalBayar');
        
    $jumlahTransaksi = DB::table('orders')
        ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
        ->count();
        
    $rataRata = $jumlahTransaksi > 0 ? $totalOmzet / $jumlahTransaksi : 0;

    // Produk Terlaris - Menggunakan ProductID dan Qty dari tabel order_details di gambar
    $terlaris = DB::table('order_details')
        ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
        ->select('products.NamaProduk', DB::raw('SUM(order_details.Qty) as total_terjual'))
        ->groupBy('products.NamaProduk')
        ->orderBy('total_terjual', 'desc')
        ->first();

    // Data Transaksi Terakhir
    $transaksiTerakhir = DB::table('orders')
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