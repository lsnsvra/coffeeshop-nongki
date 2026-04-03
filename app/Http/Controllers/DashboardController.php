<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $ordersToday = Order::today()->count();
        $revenueToday = Payment::completed()->today()->sum('Jumlah'); // ganti 'amount' jadi 'Jumlah'
        $activeProducts = Product::where('Stok', '>', 0)->count();
        $pendingOrders = Order::pending()->count();

        // Recent orders (latest 5)
        $recentOrders = Order::with(['user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top products (by assuming we track via order details later; for now random/popular)
        $topProducts = Product::orderByRaw('RAND()') // TODO: replace with real sales_count
            ->limit(5)
            ->get(['NamaKopi', 'Stok']);

        return view('dashboard.index', compact(
            'ordersToday',
            'revenueToday', 
            'activeProducts',
            'pendingOrders',
            'recentOrders',
            'topProducts'
        ));
    }
}