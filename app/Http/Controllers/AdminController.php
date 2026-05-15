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
        
        $user->update([
            'Role' => $request->Role,
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'LastUpdatedDate' => now(),
        ]);

        // Setelah ubah role
        return redirect()->back()->with('success', 'Hak akses berhasil diperbarui.');
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

        // Setelah toggle status
        return redirect()->back()->with('success', 'Status akun berhasil diubah.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Setelah hapus user
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
}