@extends('layouts.app')

@section('title', 'NONGKI Coffee - Kopi Terbaik untuk Harimu')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 4rem 2rem;
        overflow: hidden;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover no-repeat;
        filter: brightness(0.35) saturate(0.8);
        z-index: 0;
        transform: scale(1.05);
        transition: transform 8s ease;
    }

    .hero-section:hover .hero-bg {
        transform: scale(1.1);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(15,12,7,0.7) 0%, rgba(15,12,7,0.85) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(201,168,76,0.15);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 40px;
        font-size: 0.8rem;
        color: var(--gold-light);
        margin-bottom: 1.5rem;
        backdrop-filter: blur(8px);
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.8rem, 6vw, 5rem);
        font-weight: 400;
        color: var(--cream);
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold);
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.2rem);
        color: var(--cream-dim);
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--dark);
        padding: 12px 32px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(201,168,76,0.4);
        color: var(--dark);
    }

    .btn-hero-secondary {
        border: 1px solid var(--border);
        color: var(--cream);
        padding: 12px 32px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-hero-secondary:hover {
        border-color: var(--gold);
        color: var(--gold);
        background: rgba(201,168,76,0.1);
    }

    /* Features Section */
    .features-section {
        padding: 5rem 2rem;
        background: var(--dark-2);
    }

    .section-title {
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        font-weight: 400;
        color: var(--cream);
        margin-bottom: 3rem;
    }

    .section-title span {
        color: var(--gold);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold);
        box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: rgba(201,168,76,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .feature-icon svg {
        width: 32px;
        height: 32px;
        color: var(--gold);
    }

    .feature-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--cream);
        margin-bottom: 0.75rem;
    }

    .feature-desc {
        font-size: 0.9rem;
        color: var(--cream-dim);
        line-height: 1.6;
    }

    /* Menu Preview */
    .menu-preview {
        padding: 5rem 2rem;
        background: var(--dark);
    }

    .menu-grid-preview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto 2rem;
    }

    .menu-preview-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .menu-preview-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold);
    }

    .menu-preview-img {
        height: 180px;
        background-size: cover;
        background-position: center;
    }

    .menu-preview-content {
        padding: 1rem;
    }

    .menu-preview-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--cream);
        margin-bottom: 0.25rem;
    }

    .menu-preview-price {
        font-size: 0.9rem;
        color: var(--gold);
        font-weight: 500;
    }

    .btn-view-all {
        text-align: center;
        margin-top: 1rem;
    }

    .btn-view-all a {
        color: var(--gold);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view-all a:hover {
        gap: 12px;
    }

    @media (max-width: 768px) {
        .features-section, .menu-preview {
            padding: 3rem 1rem;
        }
        .section-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">✨ Since 2026</div>
            <h1 class="hero-title">
                Kopi terbaik<br>
                untuk <em>harimu</em>
            </h1>
            <p class="hero-subtitle">
                Tempat terbaik untuk produktivitas atau sekadar menikmati aroma kopi pilihan di tengah kesibukanmu.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('menu.index') }}" class="btn-hero-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5h2V5h-2v3zm-2 5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4V5h12v8z"/></svg>
                    Lihat Menu
                </a>
                @guest
                    <a href="{{ route('login') }}" class="btn-hero-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Masuk Akun
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Kenapa <span>NONGKI</span>?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5h2V5h-2v3zm-2 5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4V5h12v8z"/></svg>
                    </div>
                    <h3 class="feature-title">50+ Menu Pilihan</h3>
                    <p class="feature-desc">Dari espresso klasik hingga kreasi spesial, semua tersedia untuk menemani harimu.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="feature-title">Pesan Lebih Cepat</h3>
                    <p class="feature-desc">Pesan online, ambil tanpa antri. Lebih praktis untuk harimu yang padat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </div>
                    <h3 class="feature-title">Simpan Favorit</h3>
                    <p class="feature-desc">Simpan menu favoritmu dan lihat riwayat pesanan kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Preview -->
    <section class="menu-preview">
        <div class="container">
            <h2 class="section-title">Menu <span>Populer</span></h2>
            <div class="menu-grid-preview">
                <div class="menu-preview-card">
                    <div class="menu-preview-img" style="background-image: url('https://images.unsplash.com/photo-1541167760496-1628856ab772?w=400&q=80');"></div>
                    <div class="menu-preview-content">
                        <div class="menu-preview-name">Caramel Latte</div>
                        <div class="menu-preview-price">Rp 42.000</div>
                    </div>
                </div>
                <div class="menu-preview-card">
                    <div class="menu-preview-img" style="background-image: url('https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&q=80');"></div>
                    <div class="menu-preview-content">
                        <div class="menu-preview-name">Cold Brew Classic</div>
                        <div class="menu-preview-price">Rp 38.000</div>
                    </div>
                </div>
                <div class="menu-preview-card">
                    <div class="menu-preview-img" style="background-image: url('https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?w=400&q=80');"></div>
                    <div class="menu-preview-content">
                        <div class="menu-preview-name">Matcha Oat Latte</div>
                        <div class="menu-preview-price">Rp 45.000</div>
                    </div>
                </div>
                <div class="menu-preview-card">
                    <div class="menu-preview-img" style="background-image: url('https://images.unsplash.com/photo-1610889556528-9a770e32642f?w=400&q=80');"></div>
                    <div class="menu-preview-content">
                        <div class="menu-preview-name">Americano</div>
                        <div class="menu-preview-price">Rp 28.000</div>
                    </div>
                </div>
            </div>
            <div class="btn-view-all">
                <a href="{{ route('menu.index') }}">
                    Lihat Semua Menu
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </section>
@endsection