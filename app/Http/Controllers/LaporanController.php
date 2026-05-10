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

        // 2. Ringkasan Stats (Omzet & Jumlah Transaksi)
        // Kita pakai 'TotalHarga' karena 'TotalBayar' tidak ada di tabel orders kamu
        $totalOmzet = DB::table('orders')
            ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->sum('TotalHarga'); 
            
        $jumlahTransaksi = DB::table('orders')
            ->whereBetween('CreatedDate', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->count();
            
        $rataRata = $jumlahTransaksi > 0 ? $totalOmzet / $jumlahTransaksi : 0;

        // 3. Produk Terlaris (Join tabel order_details dan products)
        // Menggunakan 'NamaKopi' dan 'Qty' sesuai struktur HeidiSQL kamu
        $terlaris = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->select('products.NamaKopi', DB::raw('SUM(order_details.Qty) as total_terjual'))
            ->groupBy('products.NamaKopi')
            ->orderBy('total_terjual', 'desc')
            ->first();

        // 4. Data Transaksi Terakhir (Limit 10 untuk tabel riwayat)
        $transaksiTerakhir = DB::table('orders')
            ->orderBy('CreatedDate', 'desc')
            ->limit(10)
            ->get();

        // 5. Kirim data ke View admin/laporan.blade.php
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