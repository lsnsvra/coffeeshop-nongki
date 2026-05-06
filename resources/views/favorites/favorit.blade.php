{{-- resources/views/favorit.blade.php --}}
@extends('layouts.app')

@section('title', 'Koleksi Favorit — NONGKI')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* 1. ANIMASI & LAYOUT DASAR */
    .favorite-container { max-width: 1200px; margin: 0 auto; animation: fadeIn 0.6s ease-out; padding-bottom: 3rem; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* 2. HEADER ELEGAN & MODERN */
    .page-header { margin-bottom: 3rem; position: relative; }
    
    /* Breadcrumb bentuk Pill/Kapsul Premium */
    .breadcrumb-modern {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(201, 168, 76, 0.1); 
        border: 1px solid rgba(201, 168, 76, 0.2);
        padding: 6px 16px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; 
        letter-spacing: 1px; margin-bottom: 1.2rem;
    }
    .breadcrumb-modern a { 
        color: var(--gold); text-decoration: none; display: flex; 
        align-items: center; gap: 6px; transition: all 0.3s ease; 
    }
    .breadcrumb-modern a:hover { color: var(--gold-light); transform: translateX(-2px); }
    .breadcrumb-modern .separator { color: rgba(240, 236, 227, 0.3); font-size: 0.7rem; }
    .breadcrumb-modern .current { color: #f0ece3; }
    
   /* Judul Modern Tanpa Font Jadul */
    .page-title { 
        font-size: 1.8rem; /* <-- Diubah dari 2.4rem ke 1.8rem */
        color: #f0ece3; 
        margin-bottom: 0.4rem; 
        font-weight: 800; 
        letter-spacing: -0.5px;
    }
    .page-subtitle {
        font-size: 0.95rem; color: rgba(240, 236, 227, 0.6); margin: 0;
    }

    /* 3. GRID SYSTEM - UKURAN DINORMALKAN */
    .favorite-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); /* Diperkecil dari 280px */
        gap: 1.5rem; /* Gap diperkecil sedikit agar lebih padat */
    }

    /* 4. CARD PREMIUM NONGKI */
    .fav-card {
        background: linear-gradient(145deg, var(--dark-2) 0%, rgba(20, 19, 17, 0.8) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 20px; /* Radius sedikit disesuaikan */
        overflow: hidden; display: flex; flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .fav-card:hover {
        transform: translateY(-8px); border-color: rgba(201, 168, 76, 0.4);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(201,168,76,0.15);
    }

    /* 5. IMAGE WRAPPER & HOVER EFFECT - UKURAN DINORMALKAN */
    .fav-img-wrap { position: relative; height: 180px; overflow: hidden; background: var(--dark-3); } /* Height dari 220px ke 180px */
    .fav-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.8) 100%); pointer-events: none;
    }
    .fav-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .fav-card:hover .fav-img { transform: scale(1.08); }

    /* 6. BADGE & TOMBOL HAPUS (MELAYANG) */
    .fav-badge {
        position: absolute; top: 12px; right: 12px; z-index: 2; /* Jarak top & right disesuaikan */
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #000; padding: 4px 12px; border-radius: 20px;
        font-size: 0.65rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3); display: flex; align-items: center; gap: 4px;
    }
    
    .btn-remove-fav {
        position: absolute; top: 12px; left: 12px; z-index: 2; /* Jarak top & left disesuaikan */
        width: 32px; height: 32px; border-radius: 50%; /* Diperkecil sedikit */
        background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1); color: #ff4d4d;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-remove-fav:hover { background: #ff4d4d; color: #fff; transform: scale(1.1) rotate(-5deg); border-color: #ff4d4d; }

    /* 7. BODY KONTEN - UKURAN DINORMALKAN */
    .fav-body { padding: 1.2rem; display: flex; flex-direction: column; flex-grow: 1; position: relative; } /* Padding dari 1.8rem ke 1.2rem */
    .fav-name { 
        font-family: 'Playfair Display', 'Cormorant Garamond', serif; 
        font-size: 1.2rem; font-weight: 700; color: #f0ece3; /* Font size dari 1.4rem ke 1.2rem */
        margin-bottom: 0.3rem; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .fav-price { color: var(--gold); font-weight: 700; font-size: 1rem; margin-bottom: 1.2rem; } /* Font size dari 1.15rem ke 1rem */

    /* 8. TOMBOL KERANJANG PREMIUM - UKURAN DINORMALKAN */
    .btn-add-cart {
        width: 100%; padding: 0.7rem; border-radius: 12px; margin-top: auto; /* Padding dari 0.9rem ke 0.7rem */
        background: rgba(201, 168, 76, 0.1); border: 1px solid var(--gold);
        color: var(--gold); font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        cursor: pointer; transition: all 0.3s ease;
    }
    .btn-add-cart:hover {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: #000; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(201,168,76,0.3);
    }

    /* 9. EMPTY STATE (LEBIH HIDUP) */
    .empty-state { text-align: center; padding: 5rem 2rem; }
    .empty-icon-wrap {
        width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
        display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 3rem;
    }
    .empty-state h3 { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #f0ece3; margin-bottom: 0.5rem; }
    .empty-state p { color: rgba(240, 236, 227, 0.6); margin-bottom: 2rem; font-size: 0.95rem; }
    .btn-explore {
        background: var(--gold); color: #000; padding: 0.9rem 2.5rem; border-radius: 30px;
        font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(201,168,76,0.2);
    }
    .btn-explore:hover { background: var(--gold-light); transform: translateY(-3px); box-shadow: 0 12px 25px rgba(201,168,76,0.35); }
</style>
@endpush

@section('content')
<div class="favorite-container">
    <!-- HEADER MODERN -->
    <div class="page-header">
        <div class="breadcrumb-modern">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right separator"></i>
            <span class="current">Favorit</span>
        </div>
        <h1 class="page-title">Koleksi Favorit</h1>
        <p class="page-subtitle">Kopi pilihan terbaik yang selalu pas di seleramu.</p>
    </div>

    <!-- TEMPAT GRID MUNCUL -->
    <div id="favoriteGrid" class="favorite-grid"></div>
    
    <!-- TAMPILAN KETIKA KOSONG -->
    <div id="emptyState" class="empty-state" style="display: none;">
        <div class="empty-icon-wrap">
            <i class="far fa-heart"></i>
        </div>
        <h3>Daftar Favorit Kosong</h3>
        <p>Anda belum menyimpan menu apapun. Temukan kopi favorit Anda dan simpan di sini!</p>
        <a href="{{ route('menu.index') }}" class="btn-explore">
            <i class="fas fa-coffee"></i> Jelajahi Menu
        </a>
    </div>
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
                    <img class="fav-img" src="${item.img}" alt="${item.name}" onerror="this.src='https://placehold.co/400x300/1a1814/c9a84c?text=NONGKI'">
                    <!-- POSISI TOMBOL DAN BADGE SUDAH DITUKAR DI HTML -->
                    <button class="btn-remove-fav" onclick="removeFavorite(${item.id})" title="Hapus dari Favorit">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="fav-badge"><i class="fas fa-heart"></i> Favorit</div>
                </div>
                <div class="fav-body">
                    <div class="fav-name">${item.name}</div>
                    <div class="fav-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                    
                    <button class="btn-add-cart" onclick="addToCartFromFav(${item.id}, '${item.name}', ${item.price}, '${item.img}', this)">
                        <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        `).join('');
    }

    function removeFavorite(id) {
        let favs = getFavorites();
        // Animasi fade out sebelum dihapus
        const card = document.querySelector(`.fav-card[data-id="${id}"]`);
        if(card) {
            card.style.transform = 'scale(0.9)';
            card.style.opacity = '0';
            setTimeout(() => {
                favs = favs.filter(item => item.id != id);
                saveFavorites(favs);
                renderFavorites();
                if (typeof window.updateHeartIcons === 'function') window.updateHeartIcons();
            }, 300);
        } else {
            favs = favs.filter(item => item.id != id);
            saveFavorites(favs);
            renderFavorites();
        }
    }

    function addToCartFromFav(id, name, price, img, btn) {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const index = cart.findIndex(item => item.id == id);
        if (index !== -1) cart[index].quantity += 1;
        else cart.push({ id, name, price, img, quantity: 1 });
        
        localStorage.setItem('cart', JSON.stringify(cart));
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        localStorage.setItem('cartCount', totalItems);
        
        // Update badge UI
        const headerBadge = document.getElementById('cartBadgeHeader');
        const sidebarBadge = document.getElementById('cartBadgeSidebar');
        if (headerBadge) { headerBadge.textContent = totalItems; headerBadge.style.display = 'flex'; }
        if (sidebarBadge) { sidebarBadge.textContent = totalItems; sidebarBadge.style.display = 'inline-block'; }
        
        // Efek Animasi Sukses pada Tombol
        const originalContent = btn.innerHTML;
        btn.style.transform = 'scale(0.95)';
        btn.innerHTML = '<i class="fas fa-check"></i> Berhasil Ditambah';
        btn.style.background = '#27ae60';
        btn.style.borderColor = '#27ae60';
        btn.style.color = '#fff';
        
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
            btn.style.borderColor = '';
            btn.style.color = '';
            btn.innerHTML = originalContent;
        }, 1500);
    }

    document.addEventListener('DOMContentLoaded', renderFavorites);
</script>
@endpush