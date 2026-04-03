@extends('layouts.app')

@section('title', 'Keranjang Belanja — NONGKI')

@section('page_title', 'Keranjang Belanja')
@section('breadcrumb')
    <a href="{{ route('home') }}">Beranda</a> · Keranjang
@endsection

@push('styles')
<style>
    .cart-table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted-c);
        border-bottom: 1px solid var(--border);
        padding: 0.75rem 0;
    }
    .cart-table td {
        padding: 1rem 0;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    .cart-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
    }
    .cart-item-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .cart-item-price {
        font-size: 0.85rem;
        color: var(--text-muted-c);
    }
    .quantity-input {
        width: 70px;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--cream);
        padding: 0.4rem 0.5rem;
        text-align: center;
    }
    .cart-summary {
        background: var(--dark-2);
        border-radius: 14px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    .cart-total {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--gold);
    }
    .empty-cart {
        text-align: center;
        padding: 3rem;
    }
</style>
@endpush

@section('content')
<div class="row" id="cart-container">
    <div class="col-lg-8">
        <div class="card-nongki">
            <div id="cart-items-list">
                <!-- Isi keranjang akan diisi oleh JavaScript -->
                <div class="empty-cart text-center">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mb-3"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <p>Keranjang belanja masih kosong</p>
                    <a href="{{ route('menu.index') }}" class="btn-gold mt-2">Mulai Belanja</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="cart-summary" id="cart-summary">
            <!-- Ringkasan akan diisi JavaScript -->
            <h5 class="mb-3" style="font-family:'Cormorant Garamond';">Ringkasan Belanja</h5>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Total Item</span>
                <span id="total-items">0</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <hr class="border-secondary">
            <div class="d-flex justify-content-between mb-4">
                <strong>Total</strong>
                <strong id="total" class="cart-total">Rp 0</strong>
            </div>
            <a href="{{ route('checkout') }}" class="btn-gold w-100 text-center" id="checkout-btn">Lanjut ke Checkout</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk memuat dan menampilkan keranjang dari localStorage
    function loadCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cart-items-list');
        const totalItemsSpan = document.getElementById('total-items');
        const subtotalSpan = document.getElementById('subtotal');
        const totalSpan = document.getElementById('total');

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart text-center">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mb-3"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <p>Keranjang belanja masih kosong</p>
                    <a href="{{ route('menu.index') }}" class="btn-gold mt-2">Mulai Belanja</a>
                </div>
            `;
            totalItemsSpan.innerText = '0';
            subtotalSpan.innerText = 'Rp 0';
            totalSpan.innerText = 'Rp 0';
            document.getElementById('checkout-btn').style.opacity = '0.5';
            document.getElementById('checkout-btn').style.pointerEvents = 'none';
            return;
        }

        document.getElementById('checkout-btn').style.opacity = '';
        document.getElementById('checkout-btn').style.pointerEvents = '';

        let html = `
            <div class="table-responsive">
                <table class="cart-table w-100">
                    <thead>
                        <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th></th></tr>
                    </thead>
                    <tbody>
        `;

        let totalItems = 0;
        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.quantity;
            totalItems += item.quantity;
            subtotal += itemSubtotal;

            html += `
                <tr data-id="${item.id}">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="${item.img}" class="cart-item-img" alt="${item.name}">
                            <div>
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                    </td>
                    <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                    <td>
                        <input type="number" class="quantity-input" value="${item.quantity}" min="1" onchange="updateQuantity(${index}, this.value)">
                    </td>
                    <td>Rp ${itemSubtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `</tbody></table></div>`;
        container.innerHTML = html;

        totalItemsSpan.innerText = totalItems;
        subtotalSpan.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        totalSpan.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    // Fungsi untuk update jumlah item
    window.updateQuantity = function(index, newQty) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (newQty < 1) newQty = 1;
        cart[index].quantity = parseInt(newQty);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart(); // reload tampilan
        updateCartBadge(); // update badge di header
    }

    // Fungsi untuk hapus item
    window.removeItem = function(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
        updateCartBadge();
    }

    // Update badge di header (jumlah item)
    function updateCartBadge() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
        const badge = document.querySelector('.header-badge');
        if (badge) {
            if (totalQty > 0) {
                badge.style.display = 'inline-block';
                badge.innerText = totalQty > 9 ? '9+' : totalQty;
            } else {
                badge.style.display = 'none';
            }
        }
    }

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
        updateCartBadge();
    });
</script>
@endpush