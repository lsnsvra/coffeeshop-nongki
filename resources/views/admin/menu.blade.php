@extends('layouts.admin')

@section('title', 'Manajemen Menu — NONGKI')

@section('content')
<div class="page-header">
    <h1>Manajemen Menu</h1>
    <p>Kelola daftar menu kopi, non-kopi, dan makanan.</p>
</div>

{{-- Data Menu (sementara didefinisikan di sini) --}}
@php
    $menus = [
        // KOPI
        ['id'=>1, 'name'=>'Americano','cat'=>'kopi','price'=>28000,'price_str'=>'Rp 28.000','rating'=>4.6,'count'=>198,'img'=>'images/products/americano.jpeg'],
        ['id'=>2, 'name'=>'Coffee Milk Aren Sugar','cat'=>'kopi','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.7,'count'=>215,'img'=>'images/products/coffe_milk_aren_sugar.jpeg'],
        ['id'=>3, 'name'=>'Coffee Milk Pandan','cat'=>'kopi','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.6,'count'=>178,'img'=>'images/products/coffe_milk_pandan.jpeg'],
        ['id'=>4, 'name'=>'Hazelnut Coffee','cat'=>'kopi','price'=>40000,'price_str'=>'Rp 40.000','rating'=>4.8,'count'=>234,'img'=>'images/products/halzenutt_coffe.jpeg'],
        ['id'=>5, 'name'=>'Machiatto','cat'=>'kopi','price'=>38000,'price_str'=>'Rp 38.000','rating'=>4.7,'count'=>156,'img'=>'images/products/machiatto.jpeg'],
        ['id'=>6, 'name'=>'Vanilla Latte','cat'=>'kopi','price'=>38000,'price_str'=>'Rp 38.000','rating'=>4.8,'count'=>156,'img'=>'images/products/vanilla_latte.jpeg'],
        // NON KOPI
        ['id'=>7, 'name'=>'Matcha Latte','cat'=>'non-kopi','price'=>45000,'price_str'=>'Rp 45.000','rating'=>4.9,'count'=>241,'img'=>'images/products/matcha_latte.jpeg'],
        ['id'=>8, 'name'=>'Chocolate Avocado','cat'=>'non-kopi','price'=>40000,'price_str'=>'Rp 40.000','rating'=>4.5,'count'=>89,'img'=>'images/products/chocolate_avocado.jpeg'],
        ['id'=>9, 'name'=>'Chocolate Drink','cat'=>'non-kopi','price'=>30000,'price_str'=>'Rp 30.000','rating'=>4.6,'count'=>112,'img'=>'images/products/chocolate.jpeg'],
        ['id'=>10, 'name'=>'Mango Smoothie','cat'=>'non-kopi','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.7,'count'=>98,'img'=>'images/products/manggo_smoothie.jpeg'],
        // MAKANAN
        ['id'=>11, 'name'=>'Baked Macaroni','cat'=>'makanan','price'=>32000,'price_str'=>'Rp 32.000','rating'=>4.6,'count'=>145,'img'=>'images/products/baked_macaroni.jpeg'],
        ['id'=>12, 'name'=>'Chicken Katsu Curry','cat'=>'makanan','price'=>45000,'price_str'=>'Rp 45.000','rating'=>4.8,'count'=>167,'img'=>'images/products/chicken_katsu_curry.jpeg'],
        ['id'=>13, 'name'=>'Enoki Crispy','cat'=>'makanan','price'=>25000,'price_str'=>'Rp 25.000','rating'=>4.5,'count'=>89,'img'=>'images/products/enoki_crispy.jpeg'],
        ['id'=>14, 'name'=>'French Fries','cat'=>'makanan','price'=>22000,'price_str'=>'Rp 22.000','rating'=>4.6,'count'=>234,'img'=>'images/products/french_fries.jpeg'],
        ['id'=>15, 'name'=>'Noodles','cat'=>'makanan','price'=>28000,'price_str'=>'Rp 28.000','rating'=>4.5,'count'=>98,'img'=>'images/products/noodles.jpeg'],
    ];
@endphp

<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; color: var(--cream);">Daftar Menu</h3>
        <button style="background: var(--gold); color: #000; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">+ Tambah Menu</button>
    </div>

    <table style="width: 100%; border-collapse: collapse; color: var(--cream-dim); font-size: 14px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border); color: rgba(245,237,216,0.5); text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                <th style="padding: 12px 8px; text-align: left;">Gambar</th>
                <th style="padding: 12px 8px; text-align: left;">Nama</th>
                <th style="padding: 12px 8px; text-align: left;">Kategori</th>
                <th style="padding: 12px 8px; text-align: left;">Harga</th>
                <th style="padding: 12px 8px; text-align: left;">Rating</th>
                <th style="padding: 12px 8px; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 12px 8px;">
                    <img src="{{ asset($menu['img']) }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                </td>
                <td style="padding: 12px 8px; font-weight: 500;">{{ $menu['name'] }}</td>
                <td style="padding: 12px 8px;">
                    <span style="background: var(--gold-dim); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-size: 11px;">{{ ucfirst($menu['cat']) }}</span>
                </td>
                <td style="padding: 12px 8px; color: var(--gold); font-weight: 600;">{{ $menu['price_str'] }}</td>
                <td style="padding: 12px 8px;">⭐ {{ $menu['rating'] }} ({{ $menu['count'] }})</td>
                <td style="padding: 12px 8px;">
                    <a href="#" style="color: var(--gold); margin-right: 10px;"><i class="fa-solid fa-pen"></i></a>
                    <a href="#" style="color: #e05252;"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection