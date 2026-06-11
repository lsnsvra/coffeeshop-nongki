<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Material; // ⚠️ PENTING: Kalo temen lu pakenya model 'Stok', ganti jadi 'use App\Models\Stok;'
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecipeController extends Controller
{
    /**
     * Nampilin halaman UI Resep yang udah lu buat (FE)
     */
    public function index($id)
    {
        // Ambil data menu (Product) sekalian sama bahan-bahannya (materials)
        $product = Product::with('materials')->findOrFail($id);

        // Ambil semua bahan baku dari gudang buat ditampilin di dropdown
        // Asumsi ada kolom 'IsDeleted', kalo nggak ada, hapus where('IsDeleted', 0) nya.
        $materials = Material::where('IsDeleted', 0)->get(); 

        return view('admin.resep', compact('product', 'materials'));
    }

    /**
     * Simpan bahan baku ke dalam resep menu (Pivot Table)
     */
    public function store(Request $request, $id)
{
    $request->validate([
        'MaterialID' => 'required',
        'QuantityNeeded' => 'required|numeric|min:0.1'
    ]);

    $product = Product::findOrFail($id);

    if ($product->materials()->where('menu_material.MaterialID', $request->MaterialID)->exists()) {
        return back()->with('error', 'Bahan baku ini sudah ada di komposisi resep!');
    }

    // Mengisi kolom pivot secara manual karena kita tidak memakai otomatisasi timestamps bawaan Laravel
    $product->materials()->attach($request->MaterialID, [
        'QuantityNeeded' => $request->QuantityNeeded,
        'CreatedDate' => Carbon::now(),
        'LastUpdatedDate' => Carbon::now()
    ]);

    return back()->with('success', 'Bahan berhasil ditambahkan ke resep!');
}

    /**
     * Hapus bahan baku dari resep
     */
    public function destroy($product_id, $material_id)
    {
        $product = Product::findOrFail($product_id);

        // Copot relasi bahan dari menu (hapus baris di pivot table)
        $product->materials()->detach($material_id);

        return back()->with('success', 'Bahan berhasil dihapus dari resep!');
    }
}