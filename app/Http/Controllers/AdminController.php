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

    public function toggleStatus($id) {
    $user = \App\Models\User::where('UserID', $id)->firstOrFail();
    $user->Status = (int)$user->Status === 1 ? 0 : 1;
    $user->save();
    return back()->with('success', 'Status updated!');
}

        public function updateRole(Request $request, $id) {
            $user = \App\Models\User::where('UserID', $id)->firstOrFail();
            $user->Role = $request->Role;
            $user->save();
            return back()->with('success', 'Role updated!');
        }

        public function destroy($id) {
            $user = \App\Models\User::where('UserID', $id)->firstOrFail();
            $user->delete();
            return back()->with('success', 'User deleted!');
        }
}