<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * 1. REDIRECT DASHBOARD CERDAS
     * Menangani rute umum /dashboard agar melempar user ke rute yang tepat sesuai role.
     */
    public function redirectBasedOnRole()
    {
        // Ambil role user login, ubah ke huruf kecil
        $role = strtolower(auth()->user()->role ?? 'customer'); 

        if (in_array($role, ['admin', 'manager'])) {
            // Jika Admin atau Manager, lempar ke rute admin.dashboard
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'kasir') {
            // Jika Kasir, lempar ke rute /kasir/pos
            return redirect()->route('kasir.pos');
        }

        // Jika Pelanggan (Customer) biasa, jalankan method customerDashboard
        return $this->customerDashboard();
    }

    /**
     * 2. HALAMAN DASHBOARD CUSTOMER / USER UTAMA
     * Mengambil data produk aktif lalu menampilkannya ke dashboard index customer.
     */
    private function customerDashboard()
    {
        // Ambil produk yang tidak dihapus (IsDeleted = 0) dan berstatus aktif (Status = 1)
        // Ini dilakukan untuk menyuplai variabel $products yang diminta oleh view kamu
        $products = DB::table('products')
            ->where('IsDeleted', 0)
            ->where('Status', 1)
            ->get();

        // Mengirimkan variabel $products ke folder dashboard file index.blade.php
        return view('dashboard.index', compact('products'));
    }

    /**
     * 3. HALAMAN UTAMA DASHBOARD ADMIN / INDEX
     * Menampilkan data statistik kofisyop asli milikmu untuk Admin.
     */
   public function index()
{
    // Gunakan tanggal hari ini secara paksa
    $hariIni = Carbon::now()->toDateString(); 

    // 2. Query Statistik Hari Ini
    $queryStat = DB::table('orders')
        ->whereDate('TanggalOrder', $hariIni) // Tetap memfilter berdasarkan hari ini
        ->whereRaw("(LOWER(StatusOrder) = 'paid' OR LOWER(StatusOrder) = 'settlement')")
        ->where('Status', 1);

    $revenueToday = $queryStat->sum('TotalHarga');
    $ordersToday = $queryStat->count();

        // 3. Hitung Menu Aktif
        $activeProducts = DB::table('products')->where('Status', 1)->count();

        // 4. Hitung Pesanan Pending
        $pendingOrders = DB::table('orders')
            ->whereRaw("LOWER(StatusOrder) = 'pending'")
            ->where('Status', 1)
            ->count();

        // 5. Query Riwayat Terbaru (Terbaru di atas / Urutkan DESC berdasarkan TanggalOrder)
        $recentOrders = DB::table('orders')
            ->leftJoin('users', 'orders.UserID', '=', 'users.UserID')
            ->where('orders.Status', 1)
            ->select('orders.*', 'users.Nama as nama_user')
            ->orderBy('orders.TanggalOrder', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'ordersToday', 'revenueToday', 'activeProducts', 
            'pendingOrders', 'recentOrders', 'hariIni'
        ));
    }
}