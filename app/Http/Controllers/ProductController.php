<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('menu.index', compact('products'));
    }

    public function home()
    {
        $featuredProducts = Product::limit(8)->get();
        return view('home', compact('featuredProducts'));
    }
}