@extends('layouts.app')

@section('title', 'Keranjang Belanja — NONGKI')

@section('page_title', 'Keranjang Belanja')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Keranjang</li>
@endsection

@push('styles')
<style>
    #cartItemsContainer a.btn-gold, #summaryContainer a.btn-gold {
        color: var(--dark) !important;
    }

    button:focus, button:active, button:focus-visible,
    .qty-btn:focus, .qty-btn:focus-visible,
    .remove-item-btn:focus, .clear-btn:focus, .btn-back-menu:focus {
        outline: none !important;
        box-shadow: none !important;
        -webkit-tap-highlight-color: transparent !important;
    }

    .remove-item-btn:active { transform: scale(0.85); }

    .qty-btn:active {
        background: rgba(0,0,0,0.3) !important;
        box-shadow: inset 0 3px 6px rgba(0,0,0,0.4) !important;
        color: #fff !important;
    }

    /* ===== TOMBOL KEMBALI ===== */
    .btn-back-menu {
        display: flex; align-items: center; justify-content: center; gap: 0.6rem;
        margin-top: 1.25rem; padding: 0.85rem; width: 100%;
        border-radius: 12px; color: var(--gold) !important;
        font-size: 0.95rem; font-weight: 600; text-decoration: none !important;
        background: transparent; border: 1px solid transparent; transition: all 0.3s ease;
    }
    .btn-back-menu:hover {
        color: var(--gold) !important;
        background: rgba(255,255,255,0.03);
        border-color: var(--border);
    }
    .btn-back-menu svg { transition: transform 0.3s ease; }
    .btn-back-menu:hover svg { transform: scale(1.15) rotate(-5deg); }

    /* ===== LAYOUT ===== */
    .cart-layout {
        display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;
    }
    .card-nongki {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        overflow: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
    }
    .card-nongki-header {
        padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);
        font-size: 1.1rem; font-weight: 600; color: var(--cream);
    }

    /* ===== CART ITEM ===== */
    .cart-item {
        display: flex; align-items: center; gap: 1.5rem;
        padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);
        transition: background 0.3s ease;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: var(--dark-3); }

    .cart-actions-left {
        display: flex; align-items: center; gap: 1rem;
        padding-right: 1.5rem; border-right: 1px dashed var(--border);
        flex-shrink: 0;
    }

    .remove-item-btn {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(224,82,82,0.1); color: #e05252;
        border: 1px solid transparent;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease; flex-shrink: 0;
    }
    .remove-item-btn:hover { background: #e05252; color: #fff; transform: scale(1.05); }

    /* ===== QTY CONTROL ===== */
    .qty-control {
        display: flex; align-items: center;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-mask-image: -webkit-radial-gradient(white, black);
        flex-shrink: 0;
    }
    .qty-control span {
        width: 36px; text-align: center;
        font-weight: 600; color: var(--cream);
        user-select: none;
    }
    .qty-btn {
        width: 34px; height: 34px;
        background: transparent; border: none;
        color: var(--gold); font-size: 1.2rem; cursor: pointer;
        transition: background 0.2s; line-height: 1;
    }
    .qty-btn:first-of-type { border-radius: 10px 0 0 10px !important; }
    .qty-btn:last-of-type  { border-radius: 0 10px 10px 0 !important; }
    .qty-btn:hover { background: rgba(255,211,106,0.15) !important; }

    /* ===== ITEM INFO ===== */
    .cart-item-img {
        width: 75px; height: 75px; border-radius: 12px; overflow: hidden;
        background: var(--dark-3); flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .cart-item-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .cart-item-info { flex: 1; min-width: 0; }
    .item-name  { font-size: 1.05rem; font-weight: 600; color: var(--cream); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .item-variant { font-size: 0.8rem; color: var(--text-muted-c); margin-top: 4px; }
    .item-price { font-size: 0.9rem; color: var(--gold); margin-top: 6px; font-weight: 500; }
    .item-total-price { font-size: 1.05rem; font-weight: 700; color: var(--cream); text-align: right; flex-shrink: 0; white-space: nowrap; }

    .clear-btn {
        display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem;
        background: rgba(224,82,82,0.1); color: #e05252;
        border: 1px solid transparent; border-radius: 8px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .clear-btn:hover { background: #e05252; color: white; }

    .promo-container { display: flex; gap: 0.75rem; margin: 1.5rem 0; }
    .promo-input {
        flex: 1; min-width: 0;
        background: var(--dark-3); border: 1px solid var(--border);
        border-radius: 10px; padding: 0.75rem 1rem; color: var(--cream);
        outline: none; transition: border-color 0.3s;
    }
    .promo-input:focus { border-color: var(--gold); }
    .btn-action-left { padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; flex-shrink: 0; }

    /* ===== MODAL ===== */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(10,10,10,0.75); backdrop-filter: blur(5px);
        display: flex; align-items: center; justify-content: center;
        z-index: 9999; opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 16px; padding: 2rem; width: 90%; max-width: 400px;
        text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.175,0.885,0.32,1.275);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: scale(1); }
    .modal-icon {
        width: 60px; height: 60px; margin: 0 auto 1.5rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-icon.warning { background: rgba(255,193,7,0.1);  color: #ffc107; }
    .modal-icon.info    { background: rgba(255,211,106,0.1); color: var(--gold); }
    .modal-icon.danger  { background: rgba(224,82,82,0.1);   color: #e05252; }
    .modal-title   { font-size: 1.25rem; font-weight: 600; color: var(--cream); margin-bottom: 0.5rem; }
    .modal-message { font-size: 0.95rem; color: var(--text-muted-c); margin-bottom: 2rem; line-height: 1.5; }
    .modal-actions { display: flex; gap: 1rem; justify-content: center; }

    .btn-modal-outline {
        background: transparent; border: 1px solid var(--border); color: var(--cream);
        padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600;
        cursor: pointer; transition: all 0.2s; flex: 1;
    }
    .btn-modal-outline:hover { background: var(--dark-3); border-color: var(--text-muted-c); }
    .btn-modal-solid {
        background: var(--gold); border: none; color: var(--dark);
        padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600;
        cursor: pointer; transition: all 0.2s; flex: 1;
    }
    .btn-modal-solid:hover { background: var(--gold-light); transform: translateY(-2px); }
    .btn-modal-danger { background: #e05252; color: #fff; }
    .btn-modal-danger:hover { background: #f26868; transform: translateY(-2px); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .cart-layout { grid-template-columns: 1fr; }
        #summaryContainer { position: static !important; }
        .cart-actions-left { padding-right: 1rem; gap: 0.5rem; }
    }
    @media (max-width: 576px) {
        .cart-item { gap: 0.6rem; padding: 0.85rem 0.75rem; }
        .cart-item-img { width: 52px; height: 52px; border-radius: 8px; }
        .item-name { font-size: 0.88rem; }
        .item-total-price { font-size: 0.88rem; }
        .cart-actions-left { padding-right: 0.6rem; gap: 0.4rem; border-right-style: dotted; }
        .qty-btn { width: 26px; height: 26px; font-size: 0.95rem; }
        .qty-control span { width: 24px; font-size: 0.85rem; }
        .remove-item-btn { width: 30px; height: 30px; }
        .remove-item-btn svg { width: 14px; height: 14px; }
    }
</style>
@endpush

@section('content')
<div class="cart-layout">

    <!-- DAFTAR ITEM -->
    <div class="card-nongki" style="padding:0;" id="cartItemsContainer">
        <div class="card-nongki-header" style="display:flex;justify-content:flex-start;align-items:center;gap:1rem;">
            <button class="clear-btn" id="clearAllBtn" style="display:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                </svg>
                Hapus Semua
            </button>
            <span style="margin-left:auto;color:var(--text-muted-c);font-size:0.9rem;">Daftar Pesanan Kamu</span>
        </div>
        <div id="cartItemsList">
            <div style="text-align:center;padding:4rem 2rem;">
                <span style="color:var(--gold);">Memuat keranjang...</span>
            </div>
        </div>
    </div>

    <!-- RINGKASAN -->
    <div class="card-nongki" style="position:sticky;top:88px;padding:1.5rem;" id="summaryContainer">
        <h3 style="font-size:1.2rem;font-weight:600;color:var(--cream);margin-bottom:1.5rem;">Ringkasan Pesanan</h3>
        <div id="summaryDetails"></div>

        <div class="promo-container">
            <button class="btn-gold btn-action-left" id="applyPromoBtn">Pakai</button>
            <input type="text" id="promoCode" class="promo-input" placeholder="Kode promo...">
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;padding-top:1.5rem;border-top:1px dashed var(--border);">
            <span style="font-weight:600;color:var(--cream);font-size:1.1rem;">Total Tagihan</span>
            <span style="font-size:1.5rem;font-weight:700;color:var(--gold);" id="grandTotal">Rp 0</span>
        </div>

        <button class="btn-gold" id="checkoutBtn"
                style="width:100%;margin-top:1.5rem;padding:1rem;border-radius:12px;font-size:1.05rem;display:flex;align-items:center;justify-content:center;gap:0.6rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="3" y="6" width="18" height="15" rx="2" ry="2"/><path d="M3 10h18"/><path d="M7 15h.01"/>
            </svg>
            Lanjut ke Pembayaran
        </button>

        <a href="{{ route('menu.index') }}" class="btn-back-menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                <line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>
            </svg>
            Tambah Menu Lain
        </a>
    </div>
</div>

<!-- MODAL -->
<div id="nongkiModal" class="nongki-modal-overlay">
    <div class="nongki-modal-box">
        <div id="nongkiModalIcon" class="modal-icon info"></div>
        <h3 id="nongkiModalTitle" class="modal-title">Info</h3>
        <p id="nongkiModalMessage" class="modal-message">Pesan</p>
        <div class="modal-actions" id="nongkiModalActions"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// =========================================================================
// AMBIL CART KEY DARI layouts/app.blade.php (sudah di-inject per user)
// Fallback ke 'cart_items_u0' kalau belum login
// =========================================================================
const CART_KEY       = window.CART_ITEMS_KEY   || 'cart_items_u0';
const CART_COUNT_KEY = window.CART_STORAGE_KEY || 'cart_count_u0';

// =========================================================================
// MODAL
// =========================================================================
const modalOverlay = document.getElementById('nongkiModal');
const modalIcon    = document.getElementById('nongkiModalIcon');
const modalTitle   = document.getElementById('nongkiModalTitle');
const modalMessage = document.getElementById('nongkiModalMessage');
const modalActions = document.getElementById('nongkiModalActions');

const ICONS = {
    info:    `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>`,
    warning: `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
    danger:  `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`
};

function closeModal() { modalOverlay.classList.remove('active'); }

function nongkiAlert(title, message, type = 'info') {
    modalIcon.className    = `modal-icon ${type}`;
    modalIcon.innerHTML    = ICONS[type] || ICONS.info;
    modalTitle.innerText   = title;
    modalMessage.innerText = message;
    modalActions.innerHTML = `<button class="btn-modal-solid" onclick="closeModal()">Mengerti</button>`;
    modalOverlay.classList.add('active');
}

function nongkiConfirm(title, message, onConfirm, type = 'danger') {
    modalIcon.className    = `modal-icon ${type}`;
    modalIcon.innerHTML    = ICONS[type] || ICONS.danger;
    modalTitle.innerText   = title;
    modalMessage.innerText = message;
    const cls = type === 'danger' ? 'btn-modal-solid btn-modal-danger' : 'btn-modal-solid';
    modalActions.innerHTML = `
        <button class="btn-modal-outline" onclick="closeModal()">Batal</button>
        <button id="modalConfirmBtn" class="${cls}">Ya, Lanjutkan</button>
    `;
    document.getElementById('modalConfirmBtn').onclick = () => { closeModal(); if (onConfirm) onConfirm(); };
    modalOverlay.classList.add('active');
}

// =========================================================================
// CART HELPERS
// id bisa string atau number — pakai == (loose) supaya tidak mismatch
// price dikonversi ke Number() supaya tidak gagal filter
// =========================================================================
function getCart() {
    let raw  = localStorage.getItem(CART_KEY);
    let cart = [];
    try { cart = raw ? JSON.parse(raw) : []; } catch(e) { cart = []; }

    // Normalisasi: pastikan id string, price number, quantity number
    return cart
        .map(item => ({
            ...item,
            id:       String(item.id),
            price:    Number(item.price),
            quantity: Number(item.quantity)
        }))
        .filter(item => item.id && item.name && item.price > 0 && item.quantity > 0);
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    localStorage.setItem(CART_COUNT_KEY, totalItems);

    // Update badge via fungsi global dari layouts/app.blade.php
    if (typeof updateBadges === 'function') {
        updateBadges(totalItems);
    } else {
        const hb = document.getElementById('cartBadgeHeader');
        const sb = document.getElementById('cartBadgeSidebar');
        if (hb) { hb.textContent = totalItems; hb.style.display = totalItems > 0 ? 'flex' : 'none'; }
        if (sb) { sb.textContent = totalItems; sb.style.display = totalItems > 0 ? 'inline-block' : 'none'; }
    }
}

// =========================================================================
// RENDER
// =========================================================================
function renderCart() {
    const cart         = getCart();
    const container    = document.getElementById('cartItemsList');
    const summaryEl    = document.getElementById('summaryDetails');
    const grandTotalEl = document.getElementById('grandTotal');
    const clearBtn     = document.getElementById('clearAllBtn');

    if (!cart.length) {
        container.innerHTML = `
            <div style="text-align:center;padding:5rem 2rem;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" style="margin-bottom:1rem;">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <h3 style="color:var(--cream);margin-bottom:0.5rem;">Keranjang Masih Kosong</h3>
                <p style="color:var(--text-muted-c);margin-bottom:1.5rem;">Pilih minuman dan makanan favoritmu dulu yuk!</p>
                <a href="{{ route('menu.index') }}" class="btn-gold" style="display:inline-block;padding:0.6rem 1.5rem;border-radius:20px;color:var(--dark);">Lihat Menu</a>
            </div>`;
        summaryEl.innerHTML    = `<div style="text-align:center;padding:2rem 0;color:var(--text-muted-c);">Belum ada item</div>`;
        grandTotalEl.innerText = 'Rp 0';
        if (clearBtn) clearBtn.style.display = 'none';
        saveCart([]);
        return;
    }

    if (clearBtn) clearBtn.style.display = 'flex';

    let html     = '';
    let subtotal = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        html += `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-actions-left">
                    <button class="remove-item-btn" data-id="${item.id}" title="Hapus">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                        </svg>
                    </button>
                    <div class="qty-control">
                        <button class="qty-btn" data-id="${item.id}" data-delta="-1">−</button>
                        <span>${item.quantity}</span>
                        <button class="qty-btn" data-id="${item.id}" data-delta="1">+</button>
                    </div>
                </div>
                <div class="cart-item-img">
                    ${item.img
                        ? `<img src="${escapeHtml(item.img)}" alt="${escapeHtml(item.name)}" onerror="this.parentElement.innerHTML='<span style=font-size:2rem>☕</span>'">`
                        : '<span style="font-size:2rem;">☕</span>'}
                </div>
                <div class="cart-item-info">
                    <div class="item-name">${escapeHtml(item.name)}</div>
                    <div class="item-variant">${item.variant ? escapeHtml(item.variant) : 'Reguler'}</div>
                    <div class="item-price">${formatRupiah(item.price)} <span style="color:var(--text-muted-c);font-size:0.8rem;">/ item</span></div>
                </div>
                <div class="item-total-price">${formatRupiah(itemTotal)}</div>
            </div>`;
    });

    container.innerHTML = html;

    const tax   = Math.round(subtotal * 0.1);
    const total = subtotal + tax;

    summaryEl.innerHTML = `
        <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
            <span>Subtotal Barang</span>
            <span style="color:var(--cream);font-weight:500;">${formatRupiah(subtotal)}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
            <span>Total Diskon</span>
            <span style="color:#52b788;font-weight:500;">- ${formatRupiah(0)}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
            <span>Pajak (10%)</span>
            <span style="color:var(--cream);font-weight:500;">${formatRupiah(tax)}</span>
        </div>`;

    grandTotalEl.innerText = formatRupiah(total);
}

// =========================================================================
// HELPERS
// =========================================================================
function formatRupiah(n) {
    return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(n);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

// =========================================================================
// AKSI QTY & HAPUS — bandingkan ID sebagai String (loose ==)
// =========================================================================
function updateItemQuantity(id, delta) {
    let cart = getCart();
    // String comparison — id dari dataset selalu string
    const idx = cart.findIndex(item => item.id == id);
    if (idx === -1) return;

    const newQty = cart[idx].quantity + delta;
    if (newQty <= 0) {
        nongkiConfirm(
            'Hapus Menu',
            `Hapus "${cart[idx].name}" dari keranjang?`,
            () => { cart.splice(idx, 1); saveCart(cart); renderCart(); },
            'warning'
        );
    } else {
        cart[idx].quantity = newQty;
        saveCart(cart);
        renderCart();
    }
}

function removeItem(id) {
    let cart = getCart();
    const idx = cart.findIndex(item => item.id == id);
    if (idx === -1) return;
    nongkiConfirm(
        'Hapus Menu',
        `Hapus "${cart[idx].name}" dari keranjang?`,
        () => { cart.splice(idx, 1); saveCart(cart); renderCart(); },
        'warning'
    );
}

// =========================================================================
// EVENT LISTENERS
// =========================================================================
function attachCartEvents() {
    document.getElementById('cartItemsList')?.addEventListener('click', e => {
        const qtyBtn = e.target.closest('.qty-btn');
        if (qtyBtn) {
            updateItemQuantity(qtyBtn.dataset.id, parseInt(qtyBtn.dataset.delta));
            return;
        }
        const rmBtn = e.target.closest('.remove-item-btn');
        if (rmBtn) removeItem(rmBtn.dataset.id);
    });

    document.getElementById('clearAllBtn')?.addEventListener('click', () => {
        nongkiConfirm(
            'Kosongkan Keranjang?',
            'Semua pesanan yang sudah kamu pilih akan dihapus. Yakin mau dilanjutkan?',
            () => { saveCart([]); renderCart(); },
            'danger'
        );
    });

    document.getElementById('applyPromoBtn')?.addEventListener('click', () => {
        const code = document.getElementById('promoCode').value.trim();
        if (!code) {
            nongkiAlert('Kode Promo Kosong', 'Silakan masukkan kode promo terlebih dahulu.', 'warning');
        } else {
            nongkiAlert('Promo Tidak Valid', `Kode promo "${code}" belum tersedia atau sudah kadaluarsa.`, 'info');
        }
    });

    document.getElementById('checkoutBtn')?.addEventListener('click', () => {
        if (getCart().length === 0) {
            nongkiAlert('Keranjang Kosong', 'Tambah menu kopi atau makanan dulu yuk!', 'info');
        } else {
            window.location.href = "{{ route('payment.index') }}";
        }
    });
}

// =========================================================================
// INIT
// =========================================================================
document.addEventListener('DOMContentLoaded', () => {
    renderCart();
    attachCartEvents();
});
</script>
@endpush
