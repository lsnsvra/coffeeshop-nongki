<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function pengguna()
    {
        $users = User::all();
        return view('admin.pengguna', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $user->Role;
        
        $user->update([
            'Role' => $request->Role,
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'LastUpdatedDate' => now(),
        ]);

        return back()->with('success', "Role {$user->Nama} berhasil diubah dari {$oldRole} menjadi {$request->Role}!");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = (int)$user->Status === 1 ? 0 : 1;

        $user->update([
            'Status' => $newStatus,
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'LastUpdatedDate' => now(),
        ]);

        return back()->with('success', "Status {$user->Nama} berhasil diperbarui!");
    }

    // INI FUNGSI YANG TADI ERROR (MENGHAPUS USER)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $namaUser = $user->Nama;
        $user->delete();

        return back()->with('success', "Akun {$namaUser} berhasil dihapus dari sistem NONGKI.");
    }
}