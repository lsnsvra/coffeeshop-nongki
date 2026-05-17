<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Product;

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
    }
    

}
