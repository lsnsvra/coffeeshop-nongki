{{-- resources/views/favorit.blade.php --}}
@extends('layouts.app')

@section('title', 'Koleksi Favorit — NONGKI')

@push('styles')
<style>
    /* 1. ANIMASI & LAYOUT DASAR */
    .favorite-container {
        max-width: 1200px; margin: 0 auto;
        animation: fadeIn 0.6s ease-out; padding-bottom: 3rem;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* 2. HEADER */
    .page-header { margin-bottom: 3rem; position: relative; }

    .breadcrumb-modern {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(201,168,76,0.1);
        border: 1px solid rgba(201,168,76,0.2);
        padding: 6px 16px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.2rem;
    }
    .breadcrumb-modern a {
        color: var(--gold); text-decoration: none;
        display: flex; align-items: center; gap: 6px; transition: all 0.3s ease;
    }
    .breadcrumb-modern a:hover { color: var(--gold-light); transform: translateX(-2px); }
    .breadcrumb-modern .separator { color: rgba(240,236,227,0.3); font-size: 0.7rem; }
    .breadcrumb-modern .current { color: #f0ece3; }

    .page-title {
        font-size: 1.8rem; color: #f0ece3;
        margin-bottom: 0.4rem; font-weight: 800; letter-spacing: -0.5px;
    }
    .page-subtitle { font-size: 0.95rem; color: rgba(240,236,227,0.6); margin: 0; }

    /* 3. GRID */
    .favorite-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    /* 4. CARD */
    .fav-card {
        background: linear-gradient(145deg, var(--dark-2) 0%, rgba(20,19,17,0.8) 100%);
        border: 1px solid rgba(255,255,255,0.05); border-radius: 20px;
        overflow: hidden; display: flex; flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175,0.885,0.32,1.275);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .fav-card:hover {
        transform: translateY(-8px); border-color: rgba(201,168,76,0.4);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(201,168,76,0.15);
    }

    /* 5. IMAGE */
    .fav-img-wrap { position: relative; height: 180px; overflow: hidden; background: var(--dark-3); }
    .fav-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.8) 100%);
        pointer-events: none;
    }
    .fav-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; display: block; }
    .fav-card:hover .fav-img { transform: scale(1.08); }

    .fav-img-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; background: var(--dark-3); color: var(--gold);
    }

    /* 6. BADGE & TOMBOL HAPUS */
    .fav-badge {
        position: absolute; top: 12px; right: 12px; z-index: 2;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #000; padding: 4px 12px; border-radius: 20px;
        font-size: 0.65rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        display: flex; align-items: center; gap: 5px;
    }
    .fav-badge svg { width: 10px; height: 10px; fill: #000; flex-shrink: 0; }

    .btn-remove-fav {
        position: absolute; top: 12px; left: 12px; z-index: 2;
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(0,0,0,0.45); backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12); color: #ff4d4d;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2); padding: 0;
    }
    .btn-remove-fav:hover {
        background: #ff4d4d; color: #fff;
        transform: scale(1.1) rotate(-5deg); border-color: #ff4d4d;
    }
    .btn-remove-fav svg { width: 14px; height: 14px; stroke: currentColor; fill: none; flex-shrink: 0; }

    /* 7. BODY KONTEN */
    .fav-body { padding: 1.2rem; display: flex; flex-direction: column; flex-grow: 1; }
    .fav-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem; font-weight: 700; color: #f0ece3;
        margin-bottom: 0.3rem; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .fav-price { color: var(--gold); font-weight: 700; font-size: 1rem; margin-bottom: 1.2rem; }

    /* 8. TOMBOL KERANJANG */
    .btn-add-cart {
        width: 100%; padding: 0.7rem; border-radius: 12px; margin-top: auto;
        background: rgba(201,168,76,0.1); border: 1px solid var(--gold);
        color: var(--gold); font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        cursor: pointer; transition: all 0.3s ease;
    }
    .btn-add-cart svg { width: 15px; height: 15px; stroke: currentColor; fill: none; flex-shrink: 0; }
    .btn-add-cart:hover {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #000; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(201,168,76,0.3);
    }
    .btn-add-cart:hover svg { stroke: #000; }

    /* 9. EMPTY STATE */
    .empty-state { text-align: center; padding: 5rem 2rem; }
    .empty-icon-wrap {
        width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
        display: flex; align-items: center; justify-content: center;
    }
    .empty-icon-wrap svg { width: 48px; height: 48px; stroke: var(--gold); fill: none; stroke-width: 1.5; }
    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem; color: #f0ece3; margin-bottom: 0.5rem;
    }
    .empty-state p { color: rgba(240,236,227,0.6); margin-bottom: 2rem; font-size: 0.95rem; }
    .btn-explore {
        background: var(--gold); color: #000; padding: 0.9rem 2.5rem; border-radius: 30px;
        font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(201,168,76,0.2);
    }
    .btn-explore svg { width: 16px; height: 16px; fill: #000; flex-shrink: 0; }
    .btn-explore:hover {
        background: var(--gold-light); color: #000;
        transform: translateY(-3px); box-shadow: 0 12px 25px rgba(201,168,76,0.35);
    }

    /* 10. RESPONSIVE */
    @media (max-width: 600px) {
        .favorite-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .fav-img-wrap { height: 130px; }
        .fav-name { font-size: 1rem; }
        .fav-body { padding: 0.85rem; }
    }
    @media (max-width: 380px) {
        .favorite-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="favorite-container">
    <!-- HEADER -->
    <div class="page-header">
        <div class="breadcrumb-modern">
            <a href="{{ route('home') }}">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Beranda
            </a>
            <svg class="separator" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="rgba(240,236,227,0.3)" stroke-width="2.5">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
            <span class="current">Favorit</span>
        </div>
        <h1 class="page-title">Koleksi Favorit</h1>
        <p class="page-subtitle">Kopi pilihan terbaik yang selalu pas di seleramu.</p>
    </div>

    <!-- GRID FAVORIT -->
    <div id="favoriteGrid" class="favorite-grid"></div>

    <!-- EMPTY STATE -->
    <div id="emptyState" class="empty-state" style="display:none;">
        <div class="empty-icon-wrap">
            <svg viewBox="0 0 24 24">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </div>
        <h3>Daftar Favorit Kosong</h3>
        <p>Anda belum menyimpan menu apapun. Temukan kopi favorit Anda dan simpan di sini!</p>
        <a href="{{ route('menu.index') }}" class="btn-explore">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
            </svg>
            Jelajahi Menu
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// =====================================================================
// KEY FAVORIT — per user, ikuti pola CART dari layouts/app.blade.php
// window.CART_USER_ID sudah di-inject per user yang login
// Sinkron dengan menu.blade.php: 'favorites_u{id}'
// =====================================================================
const FAV_USER_ID        = window.CART_USER_ID     || 0;
const FAV_KEY            = 'favorites_u' + FAV_USER_ID;       // ← per user, sama dengan menu.blade.php
const FAV_CART_KEY       = window.CART_ITEMS_KEY   || 'cart_items_u0';
const FAV_CART_COUNT_KEY = window.CART_STORAGE_KEY || 'cart_count_u0';

// =====================================================================
// BACA / SIMPAN FAVORIT (per user)
// =====================================================================
function getFavorites() {
    try { return JSON.parse(localStorage.getItem(FAV_KEY) || '[]'); }
    catch(e) { return []; }
}

function saveFavorites(favs) {
    localStorage.setItem(FAV_KEY, JSON.stringify(favs));
}

// =====================================================================
// RENDER GRID
// =====================================================================
function renderFavorites() {
    const favs      = getFavorites();
    const container = document.getElementById('favoriteGrid');
    const empty     = document.getElementById('emptyState');

    if (favs.length === 0) {
        container.style.display = 'none';
        empty.style.display     = 'block';
        return;
    }

    container.style.display = 'grid';
    empty.style.display     = 'none';

    container.innerHTML = favs.map(item => {
        const price = Number(item.price) || 0;
        const id    = String(item.id);

        const imgHtml = item.img
            ? `<img class="fav-img"
                    src="${escapeHtml(item.img)}"
                    alt="${escapeHtml(item.name)}"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
               <div class="fav-img-placeholder" style="display:none;">☕</div>`
            : `<div class="fav-img-placeholder">☕</div>`;

        return `
            <div class="fav-card" data-id="${id}">
                <div class="fav-img-wrap">
                    ${imgHtml}

                    <button class="btn-remove-fav" data-id="${id}" title="Hapus dari Favorit">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </button>

                    <div class="fav-badge">
                        <svg viewBox="0 0 24 24">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        Favorit
                    </div>
                </div>

                <div class="fav-body">
                    <div class="fav-name">${escapeHtml(item.name)}</div>
                    <div class="fav-price">Rp ${price.toLocaleString('id-ID')}</div>
                    <button class="btn-add-cart"
                            data-id="${id}"
                            data-name="${escapeHtml(item.name)}"
                            data-price="${price}"
                            data-img="${escapeHtml(item.img || '')}">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>`;
    }).join('');
}

// =====================================================================
// HAPUS FAVORIT
// =====================================================================
function removeFavorite(id) {
    const card = document.querySelector(`.fav-card[data-id="${id}"]`);
    const doRemove = () => {
        let favs = getFavorites().filter(item => String(item.id) != String(id));
        saveFavorites(favs);
        renderFavorites();
    };

    if (card) {
        card.style.transition = 'transform 0.25s ease, opacity 0.25s ease';
        card.style.transform  = 'scale(0.88)';
        card.style.opacity    = '0';
        setTimeout(doRemove, 270);
    } else {
        doRemove();
    }
}

// =====================================================================
// TAMBAH KE KERANJANG DARI FAVORIT (pakai key per user)
// =====================================================================
function addToCartFromFav(id, name, price, img, btn) {
    let raw  = localStorage.getItem(FAV_CART_KEY);
    let cart = [];
    try { cart = raw ? JSON.parse(raw) : []; } catch(e) { cart = []; }

    cart = cart.map(item => ({
        ...item,
        id:       String(item.id),
        price:    Number(item.price),
        quantity: Number(item.quantity)
    }));

    const idx = cart.findIndex(item => item.id == String(id));
    if (idx !== -1) {
        cart[idx].quantity += 1;
    } else {
        cart.push({ id: String(id), name, price: Number(price), img, quantity: 1 });
    }

    localStorage.setItem(FAV_CART_KEY, JSON.stringify(cart));
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    localStorage.setItem(FAV_CART_COUNT_KEY, totalItems);

    if (typeof updateBadges === 'function') {
        updateBadges(totalItems);
    } else {
        const hb = document.getElementById('cartBadgeHeader');
        const sb = document.getElementById('cartBadgeSidebar');
        if (hb) { hb.textContent = totalItems; hb.style.display = 'flex'; }
        if (sb) { sb.textContent = totalItems; sb.style.display = 'inline-block'; }
    }

    const originalHtml = btn.innerHTML;
    btn.innerHTML = `
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        Berhasil Ditambah`;
    btn.style.background  = 'linear-gradient(135deg,#27ae60,#2ecc71)';
    btn.style.borderColor = '#27ae60';
    btn.style.color       = '#fff';

    setTimeout(() => {
        btn.innerHTML         = originalHtml;
        btn.style.background  = '';
        btn.style.borderColor = '';
        btn.style.color       = '';
    }, 1500);
}

// =====================================================================
// HELPER
// =====================================================================
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m =>
        ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])
    );
}

// =====================================================================
// EVENT DELEGATION
// =====================================================================
document.addEventListener('DOMContentLoaded', () => {
    renderFavorites();

    document.getElementById('favoriteGrid').addEventListener('click', e => {
        const removeBtn = e.target.closest('.btn-remove-fav');
        if (removeBtn) { removeFavorite(removeBtn.dataset.id); return; }

        const cartBtn = e.target.closest('.btn-add-cart');
        if (cartBtn) {
            addToCartFromFav(
                cartBtn.dataset.id,
                cartBtn.dataset.name,
                cartBtn.dataset.price,
                cartBtn.dataset.img,
                cartBtn
            );
        }
    });
});
</script>
@endpush