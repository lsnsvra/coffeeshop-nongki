@extends('layouts.app')

@section('title', 'Keranjang Belanja — NONGKI')

@section('page_title', 'Keranjang Belanja')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Keranjang</li>   
@endsection

@section('page_actions')
    {{-- bisa ditambah tombol jika perlu --}}
@endsection


@push('styles')
<style>
    /* FIX LINK BIRU DI HALAMAN KERANJANG */
    #cartItemsContainer a,
    #summaryContainer a {
        color: var(--gold) !important;
        text-decoration: none !important;
        font-weight: 600;
    }

    #cartItemsContainer a:hover,
    #summaryContainer a:hover {
        color: #ffd36a !important;
        text-decoration: underline !important;
    }
</style>
@endpush


@section('content')
<div class="cart-layout" style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">
    <!-- Daftar Item Keranjang (dinamis) -->
    <div class="card-nongki" style="padding: 0;" id="cartItemsContainer">
        <div class="card-nongki-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); margin-bottom: 0;">
            <span>Item Pesanan</span>
            <button class="clear-btn" id="clearAllBtn" style="background: none; border: none; color: var(--red); font-size: 0.8rem; cursor: pointer;">Hapus Semua</button>
        </div>
        <div id="cartItemsList">
            <!-- item akan dimuat via JS -->
            <div style="text-align: center; padding: 2rem;">Memuat keranjang...</div>
        </div>
    </div>

    <!-- Ringkasan Pesanan (dinamis) -->
    <div class="card-nongki" style="position: sticky; top: 88px;" id="summaryContainer">
        <div class="card-nongki-header">Ringkasan Pesanan</div>
        <div id="summaryDetails">
            <!-- akan diisi JS -->
        </div>
        <div style="display: flex; gap: 0.5rem; margin: 1rem 0;">
            <input type="text" id="promoCode" placeholder="Kode promo..." style="flex: 1; background: var(--dark-3); border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; color: var(--cream);">
            <button class="btn-gold" id="applyPromoBtn" style="padding: 0.5rem 1rem;">Pakai</button>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <span style="font-weight: 600;">Total</span>
            <span style="font-size: 1.3rem; font-weight: 700; color: var(--gold);" id="grandTotal">Rp 0</span>
        </div>
        <button class="btn-gold" id="checkoutBtn" style="width: 100%; margin-top: 1rem;">Lanjut ke Pembayaran →</button>
        <a href="{{ route('menu.index') }}" style="display: block; text-align: center; margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted-c); text-decoration: none;">← Tambah Menu Lain</a>
    </div>
</div>
@endsection


@push('scripts')
<script>
    // Fungsi untuk mengambil cart dari localStorage
    function getCart() {
    let cart = localStorage.getItem('cart');
    cart = cart ? JSON.parse(cart) : [];

    // buang item rusak / kosong
    cart = cart.filter(item => item && item.id && item.name && item.price > 0 && item.quantity > 0);

    return cart;
}

    // Fungsi untuk menyimpan cart ke localStorage
    function saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));

        // Hitung total quantity dan simpan cartCount
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        localStorage.setItem('cartCount', totalItems);

        // Update badge di layout (jika ada fungsi global, panggil)
        if (typeof updateBadges === 'function') {
            updateBadges(totalItems);
        } else {
            // fallback: coba temukan badge dan update manual
            const headerBadge = document.getElementById('cartBadgeHeader');
            const sidebarBadge = document.getElementById('cartBadgeSidebar');

            if (headerBadge) {
                headerBadge.textContent = totalItems;
                headerBadge.style.display = totalItems > 0 ? 'flex' : 'none';
            }

            if (sidebarBadge) {
                sidebarBadge.textContent = totalItems;
                sidebarBadge.style.display = totalItems > 0 ? 'inline-block' : 'none';
            }
        }
    }

    // Render daftar item keranjang
    function renderCart() {
        const cart = getCart();
        const container = document.getElementById('cartItemsList');
        const summaryContainer = document.getElementById('summaryDetails');

        if (!cart.length) {
            container.innerHTML = `
                <div style="text-align: center; padding: 2rem;">
                    Keranjang kosong. 
                    <a href="{{ route('menu.index') }}">Mulai belanja</a>
                </div>
            `;
            summaryContainer.innerHTML = `<div style="text-align: center; padding: 1rem;">Belum ada item</div>`;
            document.getElementById('grandTotal').innerText = 'Rp 0';
            saveCart([]); // reset cartCount jadi 0 dan update badge
            return;
        }

        // Render item
        let itemsHtml = '';
        let subtotal = 0;

        cart.forEach((item) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            itemsHtml += `
                <div class="cart-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);" data-id="${item.id}">
                    <div style="width: 64px; height: 64px; background: var(--dark-3); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                        ${item.img ? `<img src="${item.img}" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">` : '☕'}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 500;">${escapeHtml(item.name)}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted-c);">${item.variant ? item.variant : 'Reguler'}</div>
                        <div style="font-weight: 600; color: var(--gold); margin-top: 4px;">${formatRupiah(item.price)}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0; background: var(--dark-3); border: 1px solid var(--border); border-radius: 10px;">
                        <button class="qty-btn" data-id="${item.id}" data-delta="-1" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">−</button>
                        <span style="width: 32px; text-align: center; border-left: 1px solid var(--border); border-right: 1px solid var(--border); line-height: 34px;">${item.quantity}</span>
                        <button class="qty-btn" data-id="${item.id}" data-delta="1" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">+</button>
                    </div>
                    <button class="remove-item-btn" data-id="${item.id}" style="width: 34px; height: 34px; background: none; border: 1px solid var(--border); border-radius: 8px; color: var(--text-dim); cursor: pointer;">🗑</button>
                </div>
            `;
        });

        container.innerHTML = itemsHtml;

        // Hitung pajak (10%) dan total
        const tax = Math.round(subtotal * 0.1);
        const total = subtotal + tax;
        const discount = 0;

        // Render ringkasan
        let summaryHtml = '';

        cart.forEach(item => {
            summaryHtml += `
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                    <span>${escapeHtml(item.name)} × ${item.quantity}</span>
                    <span>${formatRupiah(item.price * item.quantity)}</span>
                </div>
            `;
        });

        summaryHtml += `
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Subtotal</span>
                <span>${formatRupiah(subtotal)}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Diskon</span>
                <span style="color: var(--green);">- ${formatRupiah(discount)}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Pajak (10%)</span>
                <span>${formatRupiah(tax)}</span>
            </div>
        `;

        summaryContainer.innerHTML = summaryHtml;
        document.getElementById('grandTotal').innerText = formatRupiah(total);
    }

    // Helper format Rupiah
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    // Helper escape HTML
    function escapeHtml(str) {
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Event handling untuk perubahan quantity, hapus item, hapus semua
    function attachCartEvents() {
        document.getElementById('cartItemsList')?.addEventListener('click', (e) => {
            const btn = e.target.closest('.qty-btn');
            if (btn) {
                const id = parseInt(btn.dataset.id);
                const delta = parseInt(btn.dataset.delta);

                if (!isNaN(id) && !isNaN(delta)) {
                    updateItemQuantity(id, delta);
                }
            }

            const removeBtn = e.target.closest('.remove-item-btn');
            if (removeBtn) {
                const id = parseInt(removeBtn.dataset.id);

                if (!isNaN(id)) {
                    removeItem(id);
                }
            }
        });

        document.getElementById('clearAllBtn')?.addEventListener('click', () => {
            if (confirm('Hapus semua item dari keranjang?')) {
                saveCart([]);
                renderCart();
            }
        });
    }

    function updateItemQuantity(id, delta) {
        let cart = getCart();
        const index = cart.findIndex(item => item.id === id);

        if (index !== -1) {
            let newQty = cart[index].quantity + delta;

            if (newQty <= 0) {
                cart.splice(index, 1);
            } else {
                cart[index].quantity = newQty;
            }

            saveCart(cart);
            renderCart();
        }
    }

    function removeItem(id) {
        let cart = getCart();
        cart = cart.filter(item => item.id !== id);

        saveCart(cart);
        renderCart();
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
        attachCartEvents();

        document.getElementById('applyPromoBtn')?.addEventListener('click', () => {
            alert('Fitur promo akan segera hadir.');
        });

        document.getElementById('checkoutBtn')?.addEventListener('click', () => {
        if (getCart().length === 0) {
            alert('Keranjang kosong, silakan tambahkan menu terlebih dahulu.');
        } else {
            window.location.href = "{{ route('payment.index') }}";
        }
        });
    });
</script>
@endpush