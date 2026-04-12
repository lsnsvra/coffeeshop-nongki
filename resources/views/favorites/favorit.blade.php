@extends('layouts.app')

@section('title', 'Menu Favorit — NONGKI')

@push('styles')
<style>
    .favorite-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1rem;
    }
    .fav-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .fav-card:hover {
        transform: translateY(-3px);
        border-color: var(--gold);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .fav-img-wrap {
        position: relative;
        height: 160px;
        overflow: hidden;
        background: var(--dark-3);
    }
    .fav-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .fav-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: var(--gold);
        color: #000;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    .fav-body {
        padding: 0.75rem;
    }
    .fav-name {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fav-price {
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }
    .fav-footer {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
    }
    .remove-fav, .add-to-cart {
        flex: 1;
        text-align: center;
        padding: 6px 0;
        border-radius: 8px;
        font-size: 0.7rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .remove-fav {
        background: none;
        border: 1px solid var(--border);
        color: var(--text-muted-c);
    }
    .remove-fav:hover {
        border-color: var(--red);
        color: var(--red);
    }
    .add-to-cart {
        background: var(--gold);
        border: none;
        color: #000;
        font-weight: 600;
    }
    .add-to-cart:hover {
        background: var(--gold-light);
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
    }
    .page-breadcrumb a {
        color: var(--gold);
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title" style="font-family:'Cormorant Garamond',serif; font-size: 2rem;">Menu Favorit</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a> &raquo; <span>Favorit</span>
        </div>
    </div>
</div>

<div id="favoriteGrid" class="favorite-grid"></div>
<div id="emptyState" class="empty-state" style="display: none;">
    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
    </svg>
    <h3>Belum ada favorit</h3>
    <p>Klik ikon hati pada menu untuk menambah favorit.</p>
    <a href="{{ route('menu.index') }}" class="btn-gold" style="display: inline-block; margin-top: 1rem;">Lihat Menu</a>
</div>
@endsection

@push('scripts')
<script>
    function getFavorites() {
        return JSON.parse(localStorage.getItem('favorites') || '[]');
    }

    function saveFavorites(favs) {
        localStorage.setItem('favorites', JSON.stringify(favs));
    }

    function renderFavorites() {
        const favs = getFavorites();
        const container = document.getElementById('favoriteGrid');
        const emptyState = document.getElementById('emptyState');
        if (favs.length === 0) {
            container.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }
        container.style.display = 'grid';
        emptyState.style.display = 'none';
        container.innerHTML = favs.map(item => `
            <div class="fav-card" data-id="${item.id}">
                <div class="fav-img-wrap">
                    <img class="fav-img" src="${item.img}" alt="${item.name}" onerror="this.src='https://placehold.co/400x200?text=No+Image'">
                    <div class="fav-badge">❤️ Favorit</div>
                </div>
                <div class="fav-body">
                    <div class="fav-name">${item.name}</div>
                    <div class="fav-price">Rp ${item.price.toLocaleString()}</div>
                    <div class="fav-footer">
                        <button class="remove-fav" onclick="removeFavorite(${item.id})">Hapus</button>
                        <button class="add-to-cart" onclick="addToCartFromFav(${item.id}, '${item.name}', ${item.price}, '${item.img}', this)">+ Keranjang</button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function removeFavorite(id) {
        let favs = getFavorites();
        favs = favs.filter(item => item.id != id);
        saveFavorites(favs);
        renderFavorites();
        // Update ikon hati di menu jika halaman menu terbuka (opsional)
        if (typeof window.updateHeartIcons === 'function') window.updateHeartIcons();
    }

    function addToCartFromFav(id, name, price, img, btn) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const index = cart.findIndex(item => item.id == id);
        if (index !== -1) cart[index].quantity += 1;
        else cart.push({ id, name, price, img, quantity: 1 });
        localStorage.setItem('cart', JSON.stringify(cart));
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        localStorage.setItem('cartCount', totalItems);
        // Update badge
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
        // Efek visual
        btn.style.transform = 'scale(0.85)';
        btn.innerHTML = '✓';
        btn.style.background = '#52b788';
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
            btn.innerHTML = '+ Keranjang';
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', renderFavorites);
</script>
@endpush