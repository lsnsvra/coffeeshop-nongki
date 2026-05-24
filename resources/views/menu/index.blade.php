@extends('layouts.app')

@section('title', 'Menu Kopi — NONGKI')

@push('styles')
<style>
    /* Hero Banner */
    .menu-hero {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        min-height: 200px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .menu-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80') center/cover no-repeat;
        filter: brightness(0.4) saturate(0.7);
    }

    .menu-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(15,12,7,0.9) 30%, transparent);
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 400;
        color: var(--cream);
        margin-bottom: 0.25rem;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold-light);
    }

    .hero-sub {
        font-size: 0.8rem;
        color: var(--cream-dim);
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 0.4rem 1rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--cream-dim);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-pill:hover {
        border-color: var(--gold);
        color: var(--cream);
    }

    .filter-pill.active {
        background: var(--gold);
        border-color: var(--gold);
        color: var(--dark);
        font-weight: 600;
    }

    .sort-select {
        padding: 0.4rem 0.8rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--cream-dim);
        font-size: 0.75rem;
        outline: none;
        cursor: pointer;
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1rem;
    }

    .menu-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        border-color: var(--gold);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .menu-img-wrap {
        position: relative;
        height: 160px;
        overflow: hidden;
        background: var(--dark-3);
    }

    .menu-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .menu-card:hover .menu-img {
        transform: scale(1.05);
    }

    .menu-img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,12,7,0.6) 0%, transparent 50%);
        pointer-events: none;
    }

    .menu-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }

    .badge-hot { background: rgba(224,82,82,0.9); color: white; }
    .badge-new { background: var(--gold); color: var(--dark); }
    .badge-fav { background: rgba(82,183,136,0.9); color: white; }

    .menu-fav {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        width: 28px;
        height: 28px;
        background: rgba(15,12,7,0.6);
        backdrop-filter: blur(4px);
        border-radius: 50%;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-muted-c);
    }

    .menu-fav:hover, .menu-fav.liked {
        color: #e05252;
        border-color: #e05252;
    }

    .menu-fav svg { width: 14px; height: 14px; }

    .menu-price-overlay {
        position: absolute;
        bottom: 8px;
        left: 8px;
        z-index: 2;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--gold);
        background: rgba(0,0,0,0.5);
        padding: 2px 8px;
        border-radius: 20px;
    }

    .menu-body { padding: 0.75rem; }

    .menu-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--cream);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-desc {
        font-size: 0.7rem;
        color: var(--cream-dim);
        line-height: 1.4;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 32px;
    }

    .menu-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .menu-rating {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: 0.7rem;
        color: var(--gold);
    }

    .menu-rating svg { width: 12px; height: 12px; fill: var(--gold); }
    .menu-rating span { color: var(--text-muted-c); }

    .btn-add {
        width: 28px;
        height: 28px;
        background: var(--gold);
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--dark);
    }

    .btn-add svg { width: 14px; height: 14px; }

    .btn-add:hover:not(:disabled) {
        background: var(--gold-light);
        transform: scale(1.05);
    }

    .btn-add:disabled {
        opacity: 0.8;
        cursor: not-allowed;
    }

    @media (max-width: 600px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .sort-select { width: 100%; }
        .menu-img-wrap { height: 120px; }
        .menu-name { font-size: 0.8rem; }
        .menu-desc { font-size: 0.65rem; -webkit-line-clamp: 1; }
    }

    @media (max-width: 400px) {
        .menu-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <div class="menu-hero">
        <div class="hero-content">
            <h1 class="hero-title">Pilih kopi<br><em>favoritmu.</em></h1>
            <p class="hero-sub">Menu segar tersedia setiap hari</p>
        </div>
    </div>

    @section('search_bar')
    <div class="header-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" placeholder="Cari menu, pesanan...">
    </div>
    @endsection

    <div class="filter-bar">
        <button class="filter-pill active" onclick="filterMenu('semua', this)">Semua</button>
        <button class="filter-pill" onclick="filterMenu('kopi', this)">Kopi</button>
        <button class="filter-pill" onclick="filterMenu('non-kopi', this)">Non-Kopi</button>
        <button class="filter-pill" onclick="filterMenu('makanan', this)">Makanan</button>
        <div>
            <select class="sort-select" id="sortSelect">
                <option value="default">Terpopuler</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
                <option value="name_asc">Nama A-Z</option>
            </select>
        </div>
    </div>

    <div class="menu-grid" id="menuGrid">
        @foreach($products as $product)
        @php
            $kategori = 'kopi';
            $nonKopi  = ['Matcha Latte', 'Chocolate Drink', 'Chocolate Avocado', 'Manggo Smoothie'];
            $makanan  = ['French Fries', 'Baked Macaroni', 'Chicken Katsu Curry', 'Enoki Crispy', 'Noodles'];

            if (in_array($product->NamaKopi, $nonKopi)) {
                $kategori = 'non-kopi';
            } elseif (in_array($product->NamaKopi, $makanan)) {
                $kategori = 'makanan';
            }
        @endphp

        <div class="menu-card"
             data-cat="{{ $kategori }}"
             data-id="{{ $product->ProductID ?? $product->id ?? $loop->iteration }}"
             data-name="{{ $product->NamaKopi }}"
             data-price="{{ $product->Harga }}">

            <div class="menu-img-wrap">
                <img class="menu-img"
                     src="{{ asset('images/products/' . $product->image) }}"
                     alt="{{ $product->NamaKopi }}"
                     loading="lazy"
                     onerror="this.src='https://placehold.co/400x200?text=' + encodeURIComponent('{{ $product->NamaKopi }}')">

                <button class="menu-fav"
                        onclick="handleFavClick(this, {{ $product->ProductID ?? $product->id ?? $loop->iteration }}, '{{ addslashes($product->NamaKopi) }}', {{ $product->Harga }}, '{{ asset('images/products/' . $product->image) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>

                <span class="menu-price-overlay">Rp {{ number_format($product->Harga, 0, ',', '.') }}</span>
            </div>

            <div class="menu-body">
                <div class="menu-name">{{ $product->NamaKopi }}</div>

                @php
                    $desc  = 'Menu spesial dari NONGKI yang disajikan segar setiap hari.';
                    $rating = '4.6';
                    $count  = rand(80, 250);
                    $nama_lower = strtolower($product->NamaKopi);

                    if (str_contains($nama_lower, 'americano'))                          { $desc = 'Double shot espresso dengan hot water. Simple, kuat, sempurna.'; $rating = '4.6'; }
                    elseif (str_contains($nama_lower, 'aren'))                           { $desc = 'Kopi susu dengan gula aren, manis dan creamy.'; $rating = '4.7'; }
                    elseif (str_contains($nama_lower, 'pandan'))                         { $desc = 'Kopi susu dengan aroma pandan yang harum.'; $rating = '4.6'; }
                    elseif (str_contains($nama_lower, 'hazelnut') || str_contains($nama_lower, 'halzenut')) { $desc = 'Kopi dengan sentuhan rasa hazelnut yang khas.'; $rating = '4.8'; }
                    elseif (str_contains($nama_lower, 'macchiato') || str_contains($nama_lower, 'machiatto')) { $desc = 'Espresso dengan busa susu yang lembut.'; $rating = '4.7'; }
                    elseif (str_contains($nama_lower, 'vanilla'))                        { $desc = 'Cappuccino klasik dengan sentuhan vanilla dan foam tebal.'; $rating = '4.8'; }
                    elseif (str_contains($nama_lower, 'matcha'))                         { $desc = 'Matcha premium Jepang dengan oat milk yang creamy.'; $rating = '4.9'; }
                    elseif (str_contains($nama_lower, 'chocolate avocado'))              { $desc = 'Perpaduan coklat dan alpukat yang creamy.'; $rating = '4.5'; }
                    elseif (str_contains($nama_lower, 'chocolate'))                      { $desc = 'Minuman coklat hangat yang nikmat.'; $rating = '4.6'; }
                    elseif (str_contains($nama_lower, 'manggo') || str_contains($nama_lower, 'mango')) { $desc = 'Smoothie mangga segar dengan potongan buah asli.'; $rating = '4.7'; }
                    elseif (str_contains($nama_lower, 'macaroni'))                       { $desc = 'Macaroni panggang dengan keju leleh.'; $rating = '4.6'; }
                    elseif (str_contains($nama_lower, 'katsu'))                          { $desc = 'Chicken katsu dengan saus kari Jepang.'; $rating = '4.8'; }
                    elseif (str_contains($nama_lower, 'enoki'))                          { $desc = 'Jamur enoki goreng crispy.'; $rating = '4.5'; }
                    elseif (str_contains($nama_lower, 'fries'))                          { $desc = 'Kentang goreng crispy dengan saus pilihan.'; $rating = '4.6'; }
                    elseif (str_contains($nama_lower, 'noodle'))                         { $desc = 'Mie goreng spesial dengan topping.'; $rating = '4.5'; }
                @endphp

                <div class="menu-desc">{{ $desc }}</div>

                <div class="menu-footer">
                    <button class="btn-add"
                            onclick="addToCart(
                                {{ $product->ProductID ?? $product->id ?? $loop->iteration }},
                                '{{ addslashes($product->NamaKopi) }}',
                                {{ $product->Harga }},
                                '{{ asset('images/products/' . $product->image) }}',
                                this
                            )">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </button>

                    <div class="menu-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $rating }} <span>({{ $count }})</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
<script>
    // =====================================================================
    // CART KEY — pakai window.CART_ITEMS_KEY & CART_STORAGE_KEY
    // yang sudah di-inject oleh layouts/app.blade.php per user
    // =====================================================================
    const MENU_CART_KEY       = window.CART_ITEMS_KEY   || 'cart_items_u0';
    const MENU_CART_COUNT_KEY = window.CART_STORAGE_KEY || 'cart_count_u0';

    // =====================================================================
    // FAVORIT KEY — per user, ikuti pola cart dari layouts/app.blade.php
    // window.CART_USER_ID sudah di-inject per user yang login
    // =====================================================================
    const MENU_FAV_USER_ID = window.CART_USER_ID || 0;
    const MENU_FAV_KEY     = 'favorites_u' + MENU_FAV_USER_ID;

    // ========== ADD TO CART ==========
    function addToCart(id, name, price, img, btn) {
        if (btn.disabled) return;
        btn.disabled = true;

        let cart = JSON.parse(localStorage.getItem(MENU_CART_KEY)) || [];

        const index = cart.findIndex(item => item.id == id);
        if (index !== -1) {
            cart[index].quantity += 1;
        } else {
            cart.push({ id, name, price, img, quantity: 1 });
        }

        localStorage.setItem(MENU_CART_KEY, JSON.stringify(cart));

        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        localStorage.setItem(MENU_CART_COUNT_KEY, totalItems);

        if (typeof updateBadges === 'function') {
            updateBadges(totalItems);
        } else {
            const hb = document.getElementById('cartBadgeHeader');
            const sb = document.getElementById('cartBadgeSidebar');
            if (hb) { hb.textContent = totalItems; hb.style.display = totalItems > 0 ? 'flex' : 'none'; }
            if (sb) { sb.textContent = totalItems; sb.style.display = totalItems > 0 ? 'inline-block' : 'none'; }
        }

        btn.style.transform = 'scale(0.85)';
        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
        btn.style.background = '#52b788';
        setTimeout(() => {
            btn.style.transform  = '';
            btn.style.background = '';
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
            btn.disabled = false;
        }, 1200);
    }

    // ========== FAVORIT (per user) ==========
    function getFavorites() {
        try { return JSON.parse(localStorage.getItem(MENU_FAV_KEY) || '[]'); }
        catch(e) { return []; }
    }

    function saveFavorites(favs) {
        localStorage.setItem(MENU_FAV_KEY, JSON.stringify(favs));
    }

    function isFavorite(id) {
        return getFavorites().some(item => item.id == id);
    }

    function toggleFavorite(id, name, price, img) {
        let favs = getFavorites();
        const index = favs.findIndex(item => item.id == id);
        if (index === -1) {
            favs.push({ id, name, price, img });
        } else {
            favs.splice(index, 1);
        }
        saveFavorites(favs);
    }

    function handleFavClick(btn, id, name, price, img) {
        btn.classList.toggle('liked');
        const svg = btn.querySelector('svg');
        svg.style.fill = btn.classList.contains('liked') ? 'currentColor' : 'none';
        toggleFavorite(id, name, price, img);
    }

    // ========== FILTER ==========
    function filterMenu(cat, btn) {
        document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.menu-card').forEach(card => {
            card.style.display = (cat === 'semua' || card.dataset.cat === cat) ? '' : 'none';
        });
    }

    // ========== SORTING ==========
    document.getElementById('sortSelect')?.addEventListener('change', function () {
        const sortValue = this.value;
        const grid  = document.getElementById('menuGrid');
        const cards = Array.from(document.querySelectorAll('.menu-card'));
        if (sortValue === 'default') return;
        cards.sort((a, b) => {
            if (sortValue === 'name_asc')    return a.dataset.name.localeCompare(b.dataset.name);
            if (sortValue === 'price_asc')   return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            if (sortValue === 'price_desc')  return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            return 0;
        });
        cards.forEach(card => grid.appendChild(card));
    });

    // ========== INIT ==========
    document.addEventListener('DOMContentLoaded', function () {
        let totalItems = parseInt(localStorage.getItem(MENU_CART_COUNT_KEY)) || 0;
        if (typeof updateBadges === 'function') {
            updateBadges(totalItems);
        } else {
            const hb = document.getElementById('cartBadgeHeader');
            const sb = document.getElementById('cartBadgeSidebar');
            if (hb) { hb.textContent = totalItems; hb.style.display = totalItems > 0 ? 'flex' : 'none'; }
            if (sb) { sb.textContent = totalItems; sb.style.display = totalItems > 0 ? 'inline-block' : 'none'; }
        }

        // Init ikon favorit berdasarkan key per user
        document.querySelectorAll('.menu-card').forEach(card => {
            const favBtn = card.querySelector('.menu-fav');
            if (favBtn && isFavorite(card.dataset.id)) {
                favBtn.classList.add('liked');
                const svg = favBtn.querySelector('svg');
                if (svg) svg.style.fill = 'currentColor';
            }
        });
    });
</script>
@endpush