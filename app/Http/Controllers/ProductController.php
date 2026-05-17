<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


// PASTIKAN EXTENDS CONTROLLER ADA
class ProductController extends Controller 
{

    public function index() {
        $products = Product::where('IsDeleted', 0)->get();
        return view('admin.menu', compact('products'));
    }

    public function store(Request $request) {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        }

        Product::create([
            'NamaKopi' => $request->NamaKopi,
            'Category' => $request->Category, // Pakai Category
            'Harga' => $request->Harga,
            'Ukuran' => $request->Ukuran ?? 300,
            'Stok' => $request->Stok ?? 50,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'CreatedDate' => now(),
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'LastUpdatedDate' => now(),
            'image' => $imageName
        ]);

        return back()->with('success', 'Menu NONGKI berhasil ditambah!');
    }

    public function update(Request $request, $id) {
        $p = Product::findOrFail($id);
        $data = [
            'NamaKopi' => $request->NamaKopi,
            'Category' => $request->Category,
            'Harga' => $request->Harga,
            'LastUpdatedBy' => Auth::user()->Nama ?? Auth::user()->name,
            'LastUpdatedDate' => now(),
        ];

        if ($request->hasFile('image')) {
            if ($p->image) File::delete(public_path('images/products/'.$p->image));
            $imgName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imgName);
            $data['image'] = $imgName;
        }

        $p->update($data);
        return back()->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy($id) {
        // Soft delete: set IsDeleted jadi 1
        Product::where('ProductID', $id)->update(['IsDeleted' => 1]);
        return back()->with('success', 'Menu berhasil dihapus!');
=======
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
