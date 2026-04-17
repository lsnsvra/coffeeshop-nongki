@extends('layouts.kasir')

@section('title', 'Menu — NONGKI Kasir')

@section('content')
{{-- Sisi Kiri: Daftar Menu --}}
<div class="pos-left">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 24px; margin: 0;">
            <i class="fa-solid fa-mug-saucer" style="color: var(--gold); margin-right: 10px;"></i>Menu NONGKI
        </h3>
        <div style="display: flex; gap: 8px;">
            <button class="category-btn active" data-cat="all" style="background: var(--gold); color: #000; border: none; padding: 6px 16px; border-radius: 20px; font-weight: 600; cursor: pointer;">Semua</button>
            <button class="category-btn" data-cat="kopi" style="background: transparent; border: 1px solid var(--border); color: var(--cream-dim); padding: 6px 16px; border-radius: 20px; cursor: pointer;">Kopi</button>
            <button class="category-btn" data-cat="non-kopi" style="background: transparent; border: 1px solid var(--border); color: var(--cream-dim); padding: 6px 16px; border-radius: 20px; cursor: pointer;">Non-Kopi</button>
            <button class="category-btn" data-cat="makanan" style="background: transparent; border: 1px solid var(--border); color: var(--cream-dim); padding: 6px 16px; border-radius: 20px; cursor: pointer;">Makanan</button>
        </div>
    </div>

    {{-- Data Menu (diambil dari array PHP) --}}
    @php
        $menus = [
            // KOPI
            ['id'=>1, 'name'=>'Americano','cat'=>'kopi','price'=>28000,'img'=>'images/products/americano.jpeg'],
            ['id'=>2, 'name'=>'Coffee Milk Aren Sugar','cat'=>'kopi','price'=>35000,'img'=>'images/products/coffe_milk_aren_sugar.jpeg'],
            ['id'=>3, 'name'=>'Coffee Milk Pandan','cat'=>'kopi','price'=>35000,'img'=>'images/products/coffe_milk_pandan.jpeg'],
            ['id'=>4, 'name'=>'Hazelnut Coffee','cat'=>'kopi','price'=>40000,'img'=>'images/products/halzenutt_coffe.jpeg'],
            ['id'=>5, 'name'=>'Machiatto','cat'=>'kopi','price'=>38000,'img'=>'images/products/machiatto.jpeg'],
            ['id'=>6, 'name'=>'Vanilla Latte','cat'=>'kopi','price'=>38000,'img'=>'images/products/vanilla_latte.jpeg'],
            // NON KOPI
            ['id'=>7, 'name'=>'Matcha Latte','cat'=>'non-kopi','price'=>45000,'img'=>'images/products/matcha_latte.jpeg'],
            ['id'=>8, 'name'=>'Chocolate Avocado','cat'=>'non-kopi','price'=>40000,'img'=>'images/products/chocolate_avocado.jpeg'],
            ['id'=>9, 'name'=>'Chocolate Drink','cat'=>'non-kopi','price'=>30000,'img'=>'images/products/chocolate.jpeg'],
            ['id'=>10, 'name'=>'Mango Smoothie','cat'=>'non-kopi','price'=>35000,'img'=>'images/products/manggo_smoothie.jpeg'],
            // MAKANAN
            ['id'=>11, 'name'=>'Baked Macaroni','cat'=>'makanan','price'=>32000,'img'=>'images/products/baked_macaroni.jpeg'],
            ['id'=>12, 'name'=>'Chicken Katsu Curry','cat'=>'makanan','price'=>45000,'img'=>'images/products/chicken_katsu_curry.jpeg'],
            ['id'=>13, 'name'=>'Enoki Crispy','cat'=>'makanan','price'=>25000,'img'=>'images/products/enoki_crispy.jpeg'],
            ['id'=>14, 'name'=>'French Fries','cat'=>'makanan','price'=>22000,'img'=>'images/products/french_fries.jpeg'],
            ['id'=>15, 'name'=>'Noodles','cat'=>'makanan','price'=>28000,'img'=>'images/products/noodles.jpeg'],
        ];
    @endphp

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;" id="menuGrid">
        @foreach($menus as $menu)
        <div class="menu-item" data-category="{{ $menu['cat'] }}" style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; transition: all 0.2s; cursor: pointer;" onclick="addToCart('{{ $menu['name'] }}', {{ $menu['price'] }})">
            <div style="height: 120px; background-image: url('{{ asset($menu['img']) }}'); background-size: cover; background-position: center;"></div>
            <div style="padding: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <div style="font-weight: 600; margin-bottom: 4px;">{{ $menu['name'] }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ ucfirst($menu['cat']) }}</div>
                    </div>
                    <div style="color: var(--gold); font-weight: 700;">Rp {{ number_format($menu['price'], 0, ',', '.') }}</div>
                </div>
                <button style="margin-top: 12px; width: 100%; background: transparent; border: 1px solid var(--border); color: var(--cream-dim); padding: 6px; border-radius: 8px; font-size: 13px; transition: all 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='#000'; this.style.borderColor='var(--gold)'" onmouseout="this.style.background='transparent'; this.style.color='var(--cream-dim)'; this.style.borderColor='var(--border)'">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Sisi Kanan: Keranjang (sama dengan POS) --}}
<div class="pos-right">
    <h3 style="font-family: 'Cormorant Garamond', serif; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-basket-shopping" style="color: var(--gold);"></i> Pesanan Saat Ini
    </h3>
    <div id="cart-items" style="flex:1; overflow-y: auto; margin-bottom: 16px;">
        <p style="color: var(--text-muted); text-align: center; padding: 20px;">Belum ada item</p>
    </div>
    <div style="border-top: 1px solid var(--border); padding-top: 16px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <span>Total</span>
            <span id="cart-total" style="color: var(--gold); font-weight: 700;">Rp 0</span>
        </div>
        <button style="width:100%; background: var(--gold); color:#000; border:none; padding:14px; border-radius:8px; font-weight:700; cursor: pointer;" onclick="processOrder()">
            <i class="fa-solid fa-check"></i> Proses Pesanan
        </button>
    </div>
</div>

<script>
    // Data cart (global, sinkron dengan fungsi di layout)
    let cart = [];

    // Fungsi menambah item ke keranjang
    function addToCart(name, price) {
        cart.push({ name, price });
        renderCart();
        // Animasi kecil (opsional)
        const btn = event.target.closest('.menu-item');
        if(btn) {
            btn.style.transform = 'scale(0.98)';
            setTimeout(() => btn.style.transform = 'scale(1)', 100);
        }
    }

    // Render keranjang
    function renderCart() {
        let html = '';
        let total = 0;
        if (cart.length === 0) {
            html = '<p style="color: var(--text-muted); text-align: center; padding: 20px;">Belum ada item</p>';
        } else {
            cart.forEach((item, index) => {
                total += item.price;
                html += `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border);">
                        <div>
                            <div style="font-weight: 500;">${item.name}</div>
                            <div style="font-size: 12px; color: var(--gold);">Rp ${item.price.toLocaleString('id-ID')}</div>
                        </div>
                        <button onclick="removeFromCart(${index})" style="background: none; border: none; color: #e05252; cursor: pointer; font-size: 14px;">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                `;
            });
        }
        document.getElementById('cart-items').innerHTML = html;
        document.getElementById('cart-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Hapus item dari keranjang
    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // Proses pesanan (dummy)
    function processOrder() {
        if (cart.length === 0) {
            alert('Keranjang masih kosong.');
            return;
        }
        alert('Pesanan berhasil diproses! (Simulasi)');
        cart = [];
        renderCart();
    }

    // Filter kategori (client-side)
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cat = this.dataset.cat;
            
            // Update active button
            document.querySelectorAll('.category-btn').forEach(b => {
                b.style.background = 'transparent';
                b.style.color = 'var(--cream-dim)';
                b.style.border = '1px solid var(--border)';
            });
            this.style.background = 'var(--gold)';
            this.style.color = '#000';
            this.style.border = 'none';

            // Filter items
            document.querySelectorAll('.menu-item').forEach(item => {
                if (cat === 'all' || item.dataset.category === cat) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Inisialisasi
    renderCart();
</script>

<style>
    .menu-item:hover {
        border-color: var(--gold) !important;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    .category-btn.active {
        background: var(--gold) !important;
        color: #000 !important;
        border: none !important;
    }
</style>
@endsection