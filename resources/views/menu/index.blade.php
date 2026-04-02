@extends('layouts.app')

@section('title', 'Menu Kopi — NONGKI')

@push('styles')
<style>
    /* Hero Banner */
    .menu-hero {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        min-height: 250px;
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-end;
        padding: 2rem;
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
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 400;
        color: var(--cream);
        margin-bottom: 0.5rem;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold-light);
    }

    .hero-sub {
        font-size: 0.9rem;
        color: var(--cream-dim);
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 0.5rem 1.25rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 40px;
        font-size: 0.85rem;
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
        padding: 0.5rem 1rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--cream-dim);
        font-size: 0.85rem;
        outline: none;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: var(--gold);
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .menu-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold);
        box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    }

    .menu-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
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
        background: linear-gradient(to top, rgba(15,12,7,0.7) 0%, transparent 60%);
    }

    .menu-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
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
        top: 12px;
        right: 12px;
        z-index: 2;
        width: 32px;
        height: 32px;
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

    .menu-price-overlay {
        position: absolute;
        bottom: 12px;
        left: 12px;
        z-index: 2;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gold-light);
    }

    .menu-body {
        padding: 1rem;
    }

    .menu-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--cream);
        margin-bottom: 0.5rem;
    }

    .menu-desc {
        font-size: 0.8rem;
        color: var(--cream-dim);
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .menu-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .menu-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.8rem;
        color: var(--gold);
    }

    .menu-rating svg {
        width: 14px;
        height: 14px;
        fill: var(--gold);
    }

    .menu-rating span {
        color: var(--text-muted-c);
    }

    .btn-add {
        width: 34px;
        height: 34px;
        background: var(--gold);
        border: none;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--dark);
    }

    .btn-add:hover {
        background: var(--gold-light);
        transform: scale(1.05);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem;
        color: var(--text-muted-c);
    }

    @media (max-width: 600px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .filter-bar .ms-auto {
            width: 100%;
        }
        .sort-select {
            width: 100%;
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
            <p class="hero-sub">50+ menu segar tersedia setiap hari</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <button class="filter-pill active" onclick="filterMenu('semua', this)">Semua</button>
        <button class="filter-pill" onclick="filterMenu('espresso', this)">Espresso</button>
        <button class="filter-pill" onclick="filterMenu('susu', this)">Kopi Susu</button>
        <button class="filter-pill" onclick="filterMenu('cold', this)">Cold Brew</button>
        <button class="filter-pill" onclick="filterMenu('non', this)">Non-Kopi</button>
        <button class="filter-pill" onclick="filterMenu('makanan', this)">Makanan</button>

        <div class="ms-auto">
            <select class="sort-select">
                <option>Terpopuler</option>
                <option>Harga Terendah</option>
                <option>Harga Tertinggi</option>
                <option>Terbaru</option>
            </select>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid" id="menuGrid">
       
        @foreach($products as $menu)
        <div class="menu-card" data-cat="">
            <div class="menu-img-wrap">
                <img class="menu-img" src="{{ asset('images/products/' . $menu->image) }}" alt="{{ $menu->NamaKopi }}" loading="lazy">

                    @if($menu->Harga >= 20000)
                        <span class="menu-badge badge-hot">🔥 Hot</span>
                    @else
                        <span class="menu-badge badge-new">✨ Baru</span>
                    @endif

                <button class="menu-fav" onclick="toggleFav(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <span class="menu-price-overlay">Rp {{ number_format($menu->Harga) }}</span>
            </div>

            <div class="menu-body">
                <div class="menu-name">{{ $menu->NamaKopi }}</div>
                <div class="menu-desc">Menu enak & fresh</div>
                <div class="menu-footer">

                    {{-- rating sementara dihapus--}}

                    <button class="btn-add" onclick="addToCart(this, '{{ addslashes($menu->NamaKopi) }}')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
<script>
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

    function toggleFav(btn) {
        btn.classList.toggle('liked');
        const svg = btn.querySelector('svg');
        svg.style.fill = btn.classList.contains('liked') ? 'currentColor' : 'none';
    }

    function addToCart(btn, name) {
        btn.style.transform = 'scale(0.85)';
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
        btn.style.background = '#52b788';

        setTimeout(() => {
            btn.style.transform = '';
            btn.style.background = '';
            btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
        }, 1200);
    }
</script>
@endpush