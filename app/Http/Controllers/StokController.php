<?php

namespace App\Http\Controllers;

use App\Models\Material; // 👈 SEKARANG KITA PAKE TABEL MATERIAL
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel materials yang belum dihapus
        $Stok = Material::where('IsDeleted', 0)->get(); 
        $Products = Product::where('IsDeleted', 0)->get(); 

        return view('admin.stok', compact('Stok', 'Products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok_sekarang' => 'required|numeric',
            'satuan' => 'required',
        ]);

        // Jembatan: Form FE -> Database BE
        Material::create([
            'NamaMaterial' => $request->nama_bahan,
            'Stock' => $request->stok_sekarang,
            'Unit' => $request->satuan,
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => Carbon::now(),
            'LastUpdatedDate' => Carbon::now(),
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
        ]);
        
        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan ke Gudang!');
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        
        $material->update([
            'NamaMaterial' => $request->nama_bahan,
            'Stock' => $request->stok_sekarang,
            'Unit' => $request->satuan,
            'LastUpdatedDate' => Carbon::now(),
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
        ]);
        
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        // Hapus pura-pura (Soft Delete) biar resep yang udah pake bahan ini nggak error
        $material->update(['IsDeleted' => 1]); 
        
        return redirect()->back()->with('success', 'Bahan berhasil dihapus dari Gudang!');
    }
}