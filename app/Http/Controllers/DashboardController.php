<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();

        // 1. Penjualan hari ini — gunakan TanggalOrder & StatusOrder
        $revenueToday = DB::table('orders')
            ->whereDate('TanggalOrder', $hariIni)
            ->where('StatusOrder', 'Selesai')
            ->where('IsDeleted', 0)
            ->sum('TotalHarga');

        // 2. Total transaksi hari ini
        $ordersToday = DB::table('orders')
            ->whereDate('TanggalOrder', $hariIni)
            ->where('StatusOrder', 'Selesai')
            ->where('IsDeleted', 0)
            ->count();

        // 3. Menu aktif
        $activeProducts = DB::table('products')
            ->where('Stok', '>', 0)
            ->where('IsDeleted', 0)
            ->count();

        // 4. Pesanan pending
        $pendingOrders = DB::table('orders')
            ->where('StatusOrder', 'Pending')
            ->where('IsDeleted', 0)
            ->count();

        // 5. Riwayat pesanan terbaru
        $recentOrders = DB::table('orders')
            ->where('IsDeleted', 0)
            ->orderBy('TanggalOrder', 'desc')
            ->limit(10)
            ->get();

        // 6. Top produk terlaris hari ini
        $topProducts = DB::table('order_details')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->whereDate('orders.TanggalOrder', $hariIni)
            ->where('orders.StatusOrder', 'Selesai')
            ->where('order_details.IsDeleted', 0)
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
            'topProducts'
        ));
    }
}