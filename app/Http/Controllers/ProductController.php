<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Tampilkan Data
    public function index()
    {
        $products = Product::where('IsDeleted', 0)->orderBy('ProductID', 'DESC')->get();
        return view('admin.menu', compact('products'));
    }

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'NamaKopi' => 'required',
            'Harga' => 'required|numeric',
            'Category' => 'required',
            'Image' => 'image|mimes:jpeg,png,jpg|max:2048' // Validasi gambar
        ]);

        $imageName = null;
        if ($request->hasFile('Image')) {
            $imageName = time().'.'.$request->Image->extension();  
            $request->Image->move(public_path('images/products'), $imageName);
        }

        \App\Models\Product::create([
            'NamaKopi' => $request->NamaKopi,
            'Harga' => $request->Harga,
            'Category' => $request->Category,
            'Ukuran'   => 0, // Tambahkan ini agar database tidak protes
            'Stok'     => 0,
            'Image' => $imageName, // Simpan nama file ke database
            'IsDeleted' => 0,
            'Status' => 1
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // 3. Hapus Data (Soft Delete)
    public function destroy($id)
    {
        $product = Product::where('ProductID', $id)->firstOrFail();
        $product->update(['IsDeleted' => 1]);

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}