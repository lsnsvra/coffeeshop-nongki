<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan baris ini ada di paling atas!

class UserController extends Controller
{
   // 1. FUNGSI HALAMAN BERANDA/DASHBOARD PELANGGAN
    public function index()
    {
        // Pastikan nama tabelnya menggunakan huruf kecil 'products' ya, Lang!
        $products = DB::table('products')->where('Status', 1)->limit(3)->get();
        
        // 🔄 UBAH INI: Sesuaikan dengan letak file blade dashboard kamu
        return view('dashboard.index', compact('products')); 
        // 💡 Catatan: Kalau file kamu letaknya langsung di views/dashboard.blade.php (tanpa folder), ganti menjadi: return view('dashboard', compact('products'));
    }

    /// 2. FUNGSI HALAMAN DAFTAR SEMUA MENU
    public function semuaMenu()
    {
        $products = DB::table('products')->where('Status', 1)->get();
        
        // Diarahkan ke folder menu/index.blade.php sesuai struktur route kamu!
        return view('menu.index', compact('products')); 
    }
}
