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

    .filter-bar .ms-auto {
        margin-left: auto;
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

    /* Menu Grid - Ukuran lebih kecil */
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
        left: 8px;
        z-index: 2;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }

    .badge-hot {
        background: rgba(224,82,82,0.9);
        color: white;
    }

    .badge-new {
        background: var(--gold);
        color: var(--dark);
    }

    .badge-fav {
        background: rgba(82,183,136,0.9);
        color: white;
    }

    .menu-fav {
        position: absolute;
        top: 8px;
        right: 8px;
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

    .menu-fav:hover {
        color: #e05252;
        border-color: #e05252;
    }

    .menu-fav.liked {
        color: #e05252;
        border-color: #e05252;
    }

    .menu-fav svg {
        width: 14px;
        height: 14px;
    }

    .menu-price-overlay {
        position: absolute;
        bottom: 8px;
        left: 8px;
        z-index: 2;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--gold);
        background: rgba(0,0,0,0.5);
        padding: 2px 8px;
        border-radius: 20px;
    }

    .menu-body {
        padding: 0.75rem;
    }

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

    .menu-rating svg {
        width: 12px;
        height: 12px;
        fill: var(--gold);
    }

    .menu-rating span {
        color: var(--text-muted-c);
    }

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

    .btn-add svg {
        width: 14px;
        height: 14px;
    }

    .btn-add:hover {
        background: var(--gold-light);
        transform: scale(1.05);
    }

    @media (max-width: 600px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .filter-bar .ms-auto {
            width: 100%;
        }
        .sort-select {
            width: 100%;
        }
        .menu-img-wrap {
            height: 120px;
        }
        .menu-name {
            font-size: 0.8rem;
        }
        .menu-desc {
            font-size: 0.65rem;
            -webkit-line-clamp: 1;
        }
    }

    @media (max-width: 400px) {
        .menu-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero -->
    <div class="menu-hero">
        <div class="hero-content">
            <h1 class="hero-title">Pilih kopi<br><em>favoritmu.</em></h1>
            <p class="hero-sub">Menu segar tersedia setiap hari</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <button class="filter-pill active" onclick="filterMenu('semua', this)">Semua</button>
        <button class="filter-pill" onclick="filterMenu('kopi', this)">Kopi</button>
        <button class="filter-pill" onclick="filterMenu('non-kopi', this)">Non-Kopi</button>
        <button class="filter-pill" onclick="filterMenu('makanan', this)">Makanan</button>

        <div class="ms-auto">
            <select class="sort-select" id="sortSelect">
                <option value="default">Terpopuler</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
                <option value="name_asc">Nama A-Z</option>
            </select>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid" id="menuGrid">
        @php
        // Daftar menu lengkap dengan path gambar yang dipastikan ada (Caramel Latte dihapus)
        $menus = [
            // KOPI
            ['id'=>1, 'name'=>'Americano','cat'=>'kopi','desc'=>'Double shot espresso dengan hot water. Simple, kuat, sempurna.','price'=>28000,'price_str'=>'Rp 28.000','rating'=>4.6,'count'=>198,'badge'=>null,'img'=>'images/products/americano.jpeg'],
            ['id'=>2, 'name'=>'Coffee Milk Aren Sugar','cat'=>'kopi','desc'=>'Kopi susu dengan gula aren, manis dan creamy.','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.7,'count'=>215,'badge'=>null,'img'=>'images/products/coffe_milk_aren_sugar.jpeg'],
            ['id'=>3, 'name'=>'Coffee Milk Pandan','cat'=>'kopi','desc'=>'Kopi susu dengan aroma pandan yang harum.','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.6,'count'=>178,'badge'=>'new','img'=>'images/products/coffe_milk_pandan.jpeg'],
            ['id'=>4, 'name'=>'Hazelnut Coffee','cat'=>'kopi','desc'=>'Kopi dengan sentuhan rasa hazelnut yang khas.','price'=>40000,'price_str'=>'Rp 40.000','rating'=>4.8,'count'=>234,'badge'=>null,'img'=>'images/products/halzenutt_coffe.jpeg'],
            ['id'=>5, 'name'=>'Machiatto','cat'=>'kopi','desc'=>'Espresso dengan busa susu yang lembut.','price'=>38000,'price_str'=>'Rp 38.000','rating'=>4.7,'count'=>156,'badge'=>null,'img'=>'images/products/machiatto.jpeg'],
            ['id'=>6, 'name'=>'Vanilla Latte','cat'=>'kopi','desc'=>'Cappuccino klasik dengan sentuhan vanilla dan foam tebal.','price'=>38000,'price_str'=>'Rp 38.000','rating'=>4.8,'count'=>156,'badge'=>null,'img'=>'images/products/vanilla_latte.jpeg'],
            
            // NON KOPI
            ['id'=>7, 'name'=>'Matcha Latte','cat'=>'non-kopi','desc'=>'Matcha premium Jepang dengan oat milk yang creamy.','price'=>45000,'price_str'=>'Rp 45.000','rating'=>4.9,'count'=>241,'badge'=>'fav','img'=>'images/products/matcha_latte.jpeg'],
            ['id'=>8, 'name'=>'Chocolate Avocado','cat'=>'non-kopi','desc'=>'Perpaduan coklat dan alpukat yang creamy.','price'=>40000,'price_str'=>'Rp 40.000','rating'=>4.5,'count'=>89,'badge'=>'new','img'=>'images/products/chocolate_avocado.jpeg'],
            ['id'=>9, 'name'=>'Chocolate Drink','cat'=>'non-kopi','desc'=>'Minuman coklat hangat yang nikmat.','price'=>30000,'price_str'=>'Rp 30.000','rating'=>4.6,'count'=>112,'badge'=>null,'img'=>'images/products/chocolate.jpeg'],
            ['id'=>10, 'name'=>'Mango Smoothie','cat'=>'non-kopi','desc'=>'Smoothie mangga segar dengan potongan buah asli.','price'=>35000,'price_str'=>'Rp 35.000','rating'=>4.7,'count'=>98,'badge'=>null,'img'=>'images/products/manggo_smoothie.jpeg'],
            
            // MAKANAN
            ['id'=>11, 'name'=>'Baked Macaroni','cat'=>'makanan','desc'=>'Macaroni panggang dengan keju leleh.','price'=>32000,'price_str'=>'Rp 32.000','rating'=>4.6,'count'=>145,'badge'=>null,'img'=>'images/products/baked_macaroni.jpeg'],
            ['id'=>12, 'name'=>'Chicken Katsu Curry','cat'=>'makanan','desc'=>'Chicken katsu dengan saus kari Jepang.','price'=>45000,'price_str'=>'Rp 45.000','rating'=>4.8,'count'=>167,'badge'=>'hot','img'=>'images/products/chicken_katsu_curry.jpeg'],
            ['id'=>13, 'name'=>'Enoki Crispy','cat'=>'makanan','desc'=>'Jamur enoki goreng crispy.','price'=>25000,'price_str'=>'Rp 25.000','rating'=>4.5,'count'=>89,'badge'=>null,'img'=>'images/products/enoki_crispy.jpeg'],
            ['id'=>14, 'name'=>'French Fries','cat'=>'makanan','desc'=>'Kentang goreng crispy dengan saus pilihan.','price'=>22000,'price_str'=>'Rp 22.000','rating'=>4.6,'count'=>234,'badge'=>null,'img'=>'images/products/french_fries.jpeg'],
            ['id'=>15, 'name'=>'Noodles','cat'=>'makanan','desc'=>'Mie goreng spesial dengan topping.','price'=>28000,'price_str'=>'Rp 28.000','rating'=>4.5,'count'=>98,'badge'=>null,'img'=>'images/products/noodles.jpeg'],
        ];
        @endphp

        @foreach($menus as $menu)
        <div class="menu-card" data-cat="{{ $menu['cat'] }}" data-id="{{ $menu['id'] }}" data-name="{{ $menu['name'] }}" data-price="{{ $menu['price'] }}" data-img="{{ asset($menu['img']) }}">
            <div class="menu-img-wrap">
                <img class="menu-img" src="{{ asset($menu['img']) }}" alt="{{ $menu['name'] }}" loading="lazy" 
                     onerror="this.src='https://placehold.co/400x200?text=' + encodeURIComponent('{{ $menu['name'] }}')">

                @if($menu['badge'])
                <span class="menu-badge badge-{{ $menu['badge'] }}">
                    {{ $menu['badge'] === 'hot' ? '🔥 Hot' : ($menu['badge'] === 'new' ? '✨ Baru' : '⭐ Favorit') }}
                </span>
                @endif

                <button class="menu-fav" onclick="handleFavClick(this, {{ $menu['id'] }}, '{{ addslashes($menu['name']) }}', {{ $menu['price'] }}, '{{ asset($menu['img']) }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <span class="menu-price-overlay">{{ $menu['price_str'] }}</span>
            </div>

            <div class="menu-body">
                <div class="menu-name">{{ $menu['name'] }}</div>
                <div class="menu-desc">{{ $menu['desc'] }}</div>
                <div class="menu-footer">
                    <div class="menu-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $menu['rating'] }}
                        <span>({{ $menu['count'] }})</span>
                    </div>
                    <button class="btn-add" onclick="addToCart({{ $menu['id'] }}, '{{ addslashes($menu['name']) }}', {{ $menu['price'] }}, '{{ asset($menu['img']) }}', this)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
<script>
    // ========== FUNGSI FAVORIT ==========
    function getFavorites() {
        let favs = localStorage.getItem('favorites');
        return favs ? JSON.parse(favs) : [];
    }

    function saveFavorites(favs) {
        localStorage.setItem('favorites', JSON.stringify(favs));
    }

    function isFavorite(id) {
        let favs = getFavorites();
        return favs.some(item => item.id == id);
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
        return favs.length;
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
            if (cat === 'semua' || card.dataset.cat === cat) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // ========== SORTING ==========
    document.getElementById('sortSelect')?.addEventListener('change', function() {
        const sortValue = this.value;
        const grid = document.getElementById('menuGrid');
        const cards = Array.from(document.querySelectorAll('.menu-card'));
        if (sortValue === 'default') return;
        cards.sort((a, b) => {
            if (sortValue === 'name_asc') return a.dataset.name.localeCompare(b.dataset.name);
            if (sortValue === 'price_asc') return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            if (sortValue === 'price_desc') return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            return 0;
        });
        cards.forEach(card => grid.appendChild(card));
    });

    // ========== ADD TO CART ==========
    function addToCart(id, name, price, img, btn) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const index = cart.findIndex(item => item.id == id);
        if (index !== -1) {
            cart[index].quantity += 1;
        } else {
            cart.push({ id, name, price, img, quantity: 1 });
        }
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
        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
        btn.style.background = '#52b788';
        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
        }, 1200);
    }

    // ========== INISIALISASI IKON FAVORIT ==========
    function initFavoriteIcons() {
        document.querySelectorAll('.menu-card').forEach(card => {
            const id = card.dataset.id;
            const favBtn = card.querySelector('.menu-fav');
            if (favBtn && isFavorite(id)) {
                favBtn.classList.add('liked');
                const svg = favBtn.querySelector('svg');
                if (svg) svg.style.fill = 'currentColor';
            }
        });
    }

    // ========== INISIALISASI BADGE KERANJANG ==========
    document.addEventListener('DOMContentLoaded', function() {
        let totalItems = parseInt(localStorage.getItem('cartCount')) || 0;
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
        initFavoriteIcons();
    });
</script>
@endpush