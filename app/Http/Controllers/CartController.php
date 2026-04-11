<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    //tampilkan cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.keranjang', compact('cart'));
    }
     
    // Tambah ke cart
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart =session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id]= [
                "name" => $product->name,
                "price"=> $product->price,
                'qty'=> 1
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Produk ditambhakna ke keranjang');
    }
}
