<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// PASTIKAN EXTENDS CONTROLLER ADA
class ProductController extends Controller 
{
    public function index()
    {
        // Filter agar produk yang sudah dihapus (soft delete) tidak muncul
        $products = Product::where('IsDeleted', 0)->get();
        return view('menu.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Kategori' => 'required',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = new Product();
        $product->NamaProduk = $request->NamaProduk;
        $product->Kategori = $request->Kategori;
        $product->Harga = $request->Harga;
        $product->IsDeleted = 0; // Default produk aktif
        $product->Status = 1;

        if ($request->hasFile('Gambar')) {
            $product->Gambar = $request->file('Gambar')->store('products', 'public');
        }

        // ========== 4 CREATE AUDIT TRAIL ==========
        $product->CreatedBy = Auth::user()->Nama; 
        $product->CreatedDate = now();
        $product->LastUpdatedBy = Auth::user()->Nama;
        $product->LastUpdatedDate = now();

        $product->save();

        return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Kategori' => 'required'
        ]);

        $product = Product::findOrFail($id);
        $product->NamaProduk = $request->NamaProduk;
        $product->Kategori = $request->Kategori;
        $product->Harga = $request->Harga;

        if ($request->hasFile('Gambar')) {
            // Hapus gambar lama jika ada upload baru
            if ($product->Gambar) {
                Storage::disk('public')->delete($product->Gambar);
            }
            $product->Gambar = $request->file('Gambar')->store('products', 'public');
        }

        // ========== 4 UPDATE AUDIT TRAIL ==========
        $product->LastUpdatedBy = Auth::user()->Nama;
        $product->LastUpdatedDate = now();

        $product->save();

        return redirect()->back()->with('success', 'Produk Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        // Gunakan Soft Delete agar data tidak benar-benar hilang dari HeidiSQL
        $product = Product::findOrFail($id);
        $product->IsDeleted = 1;
        $product->LastUpdatedBy = Auth::user()->Nama;
        $product->LastUpdatedDate = now();
        $product->save();

        return redirect()->back()->with('success', 'Produk Berhasil Dihapus!');
    }
}