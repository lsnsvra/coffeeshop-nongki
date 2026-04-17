{{-- resources/views/kasir/pos.blade.php --}}
@extends('layouts.kasir')

@section('title', 'POS — NONGKI Kasir')

@section('content')
@php
    $menus = [
        // KOPI
        ['name'=>'Americano', 'price'=>28000, 'cat'=>'kopi'],
        ['name'=>'Coffee Milk Aren Sugar', 'price'=>35000, 'cat'=>'kopi'],
        ['name'=>'Coffee Milk Pandan', 'price'=>35000, 'cat'=>'kopi'],
        ['name'=>'Hazelnut Coffee', 'price'=>40000, 'cat'=>'kopi'],
        ['name'=>'Machiatto', 'price'=>38000, 'cat'=>'kopi'],
        ['name'=>'Vanilla Latte', 'price'=>38000, 'cat'=>'kopi'],
        // NON KOPI
        ['name'=>'Matcha Latte', 'price'=>45000, 'cat'=>'non-kopi'],
        ['name'=>'Chocolate Avocado', 'price'=>40000, 'cat'=>'non-kopi'],
        ['name'=>'Chocolate Drink', 'price'=>30000, 'cat'=>'non-kopi'],
        ['name'=>'Mango Smoothie', 'price'=>35000, 'cat'=>'non-kopi'],
        // MAKANAN
        ['name'=>'Baked Macaroni', 'price'=>32000, 'cat'=>'makanan'],
        ['name'=>'Chicken Katsu Curry', 'price'=>45000, 'cat'=>'makanan'],
        ['name'=>'Enoki Crispy', 'price'=>25000, 'cat'=>'makanan'],
        ['name'=>'French Fries', 'price'=>22000, 'cat'=>'makanan'],
        ['name'=>'Noodles', 'price'=>28000, 'cat'=>'makanan'],
    ];
@endphp

<div class="pos-left">
    <h3 style="font-family: 'Cormorant Garamond', serif; margin-bottom: 20px;">Menu Kopi & Makanan</h3>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
        @foreach($menus as $menu)
        <div class="menu-item" style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 12px; padding: 12px; cursor: pointer;" onclick="addToCart('{{ $menu['name'] }}', {{ $menu['price'] }})">
            <div style="font-weight: 600;">{{ $menu['name'] }}</div>
            <div style="color: var(--gold); font-size: 13px; margin-top: 6px;">Rp {{ number_format($menu['price'], 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>
</div>

<div class="pos-right">
    <h3 style="font-family: 'Cormorant Garamond', serif; margin-bottom: 16px;">Pesanan Saat Ini</h3>
    <div id="cart-items" style="flex:1; overflow-y: auto; margin-bottom: 16px;">
        <p style="color: var(--text-muted); text-align: center; padding: 20px;">Belum ada item</p>
    </div>
    <div style="border-top: 1px solid var(--border); padding-top: 16px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <span>Total</span>
            <span id="cart-total" style="color: var(--gold); font-weight: 700;">Rp 0</span>
        </div>
        <button style="width:100%; background: var(--gold); color:#000; border:none; padding:14px; border-radius:8px; font-weight:700;" onclick="processOrder()">Proses Pesanan</button>
    </div>
</div>

<script>
    let cart = [];
    function addToCart(name, price) {
        cart.push({ name, price });
        renderCart();
    }
    function renderCart() {
        let html = '';
        let total = 0;
        cart.forEach((item, i) => { 
            total += item.price; 
            html += `<div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border);">
                        <span>${item.name}</span>
                        <span>Rp ${item.price.toLocaleString()}</span>
                     </div>`; 
        });
        document.getElementById('cart-items').innerHTML = html || '<p style="color: var(--text-muted); text-align:center;">Belum ada item</p>';
        document.getElementById('cart-total').innerText = 'Rp ' + total.toLocaleString();
    }
    function processOrder() { 
        if(cart.length) { 
            alert('Pesanan diproses! Total: Rp ' + cart.reduce((sum, i) => sum + i.price, 0).toLocaleString()); 
            cart = []; 
            renderCart(); 
        } else { 
            alert('Keranjang kosong'); 
        } 
    }
</script>
@endsection