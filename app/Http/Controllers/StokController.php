<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Menampilkan daftar stok
    public function index()
    {
        $Stok = Stok::all(); 
        return view('admin.stok', compact('Stok'));
    }

    // Menyimpan bahan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok_sekarang' => 'required|numeric',
            'stok_maksimal' => 'required|numeric',
            'satuan' => 'required',
            'supplier' => 'required',
        ]);

        Stok::create($request->all());
        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan!');
    }

    // Update data stok
    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);
        $stok->update($request->all());
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    // Hapus bahan
    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();
        return redirect()->back()->with('success', 'Bahan berhasil dihapus!');
    }
}