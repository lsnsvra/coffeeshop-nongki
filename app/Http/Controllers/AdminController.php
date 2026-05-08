<?php

namespace App\Http\Controllers;

use App\Models\User; // Mengambil data user dari database
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pengguna()
    {
        // 1. Ambil semua data user
        $users = User::all();
        
        // 2. Hitung jumlah user untuk tampilan header
        $totalUsers = $users->count();

        // 3. Kirim ke view (Pastikan folder & nama filenya benar: admin/pengguna.blade.php)
        return view('admin.pengguna', compact('users', 'totalUsers'));
    }

    // Kamu bisa tambah fungsi laporan/stok di bawah sini nanti
}