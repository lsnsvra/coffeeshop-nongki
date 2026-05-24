<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // AMBIL TANGGAL TRANSAKSI TERAKHIR DARI DATABASE
        // Biar kalau data database-nya data dump lama, dashboard-nya tetap mau nampil angkanya!
        $lastOrder = DB::table('orders')->orderBy('created_at', 'desc')->first();
        
        // Jika ada data di DB, pakai tanggal dari data terbaru itu. Kalau kosong baru pakai hari ini.
        $hariIni = $lastOrder ? Carbon::parse($lastOrder->created_at)->toDateString() : Carbon::now('Asia/Jakarta')->toDateString();

        // 1. Penjualan hari ini — SINKRON: Menggunakan tanggal dinamis & status 'paid'
        $revenueToday = DB::table('orders')
            ->whereDate('created_at', $hariIni)
            ->where('StatusOrder', 'paid')
            ->where('Status', 1)
            ->sum('TotalHarga');

        // 2. Total transaksi lunas hari ini
        $ordersToday = DB::table('orders')
            ->whereDate('created_at', $hariIni)
            ->where('StatusOrder', 'paid')
            ->where('Status', 1)
            ->count();

        // 3. Menu aktif
        $activeProducts = DB::table('products')
            ->where('Status', 1)
            ->count();

        // 4. Pesanan pending (huruf kecil 'pending' sesuai isi HeidiSQL)
        $pendingOrders = DB::table('orders')
            ->where('StatusOrder', 'pending')
            ->where('Status', 1)
            ->count();

        // 5. Riwayat pesanan terbaru
        $recentOrders = DB::table('orders')
            ->leftJoin('users', 'orders.UserID', '=', 'users.UserID') // H
            ->where('orders.Status', 1)
            ->select('orders.*', 'users.Nama as nama_user') //
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        // 6. Top produk terlaris hari ini
        $topProducts = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->whereDate('orders.created_at', $hariIni)
            ->where('orders.StatusOrder', 'paid')
            ->where('order_details.Status', 1)
            ->select('products.NamaKopi', DB::raw('SUM(order_details.Qty) as total_terjual'))
            ->groupBy('products.ProductID', 'products.NamaKopi')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'ordersToday',
            'revenueToday',
            'activeProducts',
            'pendingOrders',
            'recentOrders',
            'topProducts',
            'hariIni' // Kita oper juga ke view buat jaga-jaga kalau mau nampilin teks info tanggalnya
        ));
    }

    public function redirectBasedOnRole() 
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'kasir') {
        return redirect()->route('kasir.pos');
    }

    // Jika bukan admin/kasir, arahkan ke UserController index
    return app(\App\Http\Controllers\UserController::class)->index();
}
}
