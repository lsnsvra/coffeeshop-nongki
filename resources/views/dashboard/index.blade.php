@extends('layouts.app')

@section('title', 'Beranda - NONGKI Coffee')

@push('styles')
<style>
    /* ========== ANIMATIONS ========== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(40px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }

    @keyframes slowZoom {
        from { transform: scale(1); }
        to { transform: scale(1.08); }
    }

    .animate-up { animation: fadeInUp 0.8s ease forwards; }
    .animate-left { animation: fadeInLeft 0.8s ease forwards; }
    .animate-right { animation: fadeInRight 0.8s ease forwards; }
    .animate-zoom { animation: zoomIn 0.6s ease forwards; }
    .animate-float { animation: float 4s ease-in-out infinite; }
    .delay-1 { animation-delay: 0.1s; opacity: 0; }
    .delay-2 { animation-delay: 0.2s; opacity: 0; }
    .delay-3 { animation-delay: 0.3s; opacity: 0; }
    .delay-4 { animation-delay: 0.4s; opacity: 0; }
    .delay-5 { animation-delay: 0.5s; opacity: 0; }

    /* Hero Section Premium */
    .hero-premium {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem;
    overflow: hidden;
    border-radius: 16px 16px  16px;   
}

.hero-premium-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover no-repeat;
    z-index: 0;
    animation: slowZoom 12s ease-out forwards;
    border-radius: 16px 16px 16px;   
}

    .hero-premium-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(10,10,10,0.3) 0%, rgba(10,10,10,0.85) 100%);
        z-index: 1;
    }

    .hero-premium-content {
        position: relative;
        z-index: 2;
        max-width: 900px;
        margin: 0 auto;
    }

    .greeting-text {
        font-size: 1rem;
        color: var(--gold);
        letter-spacing: 3px;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    .hero-premium-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.5rem, 7vw, 5rem);
        font-weight: 400;
        line-height: 1.2;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--cream) 0%, var(--gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-premium-title em {
        font-style: italic;
        -webkit-text-fill-color: var(--gold);
        background: none;
    }

    .hero-premium-description {
        font-size: clamp(0.95rem, 2vw, 1.1rem);
        color: var(--cream-dim);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.8;
    }

    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        animation: float 2s ease-in-out infinite;
    }

    .scroll-indicator a {
        color: var(--cream-dim);
        font-size: 1.5rem;
        transition: color 0.3s;
    }

    .scroll-indicator a:hover {
        color: var(--gold);
    }

    /* Features Section Premium */
    .features-premium {
        padding: 6rem 2rem;
        background: linear-gradient(180deg, var(--dark) 0%, var(--dark-2) 100%);
        position: relative;
    }

    .section-badge {
        display: inline-block;
        padding: 4px 16px;
        background: rgba(201,168,76,0.12);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 40px;
        font-size: 0.7rem;
        color: var(--gold);
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }

    .section-title-premium {
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.8rem;
        font-weight: 400;
        margin-bottom: 3rem;
        position: relative;
    }

    .section-title-premium span {
        color: var(--gold);
    }

    .section-title-premium::after {
        content: '';
        display: block;
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), transparent);
        margin: 1rem auto 0;
    }

    .features-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card-premium {
        text-align: center;
        padding: 2rem;
        background: rgba(26,21,9,0.6);
        border: 1px solid rgba(201,168,76,0.1);
        border-radius: 24px;
        transition: all 0.4s ease;
        backdrop-filter: blur(8px);
        position: relative;
        overflow: hidden;
    }

    .feature-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(201,168,76,0.05), transparent);
        transition: left 0.6s ease;
    }

    .feature-card-premium:hover::before {
        left: 100%;
    }

    .feature-card-premium:hover {
        border-color: rgba(201,168,76,0.4);
        transform: translateY(-8px);
        background: rgba(26,21,9,0.8);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .feature-icon-premium {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--gold-dim), rgba(201,168,76,0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        transition: transform 0.3s ease;
    }

    .feature-card-premium:hover .feature-icon-premium {
        transform: scale(1.1);
    }

    .feature-icon-premium i {
        font-size: 28px;
        color: var(--gold);
    }

    .feature-title-premium {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .feature-desc-premium {
        font-size: 0.85rem;
        color: var(--cream-dim);
        line-height: 1.6;
    }

    /* Menu Section Premium - HANYA 3 MENU */
    .menu-premium {
        padding: 6rem 2rem;
        background: var(--dark);
        position: relative;
    }

    .menu-grid-premium {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        max-width: 1000px;
        margin: 3rem auto;
    }

    .menu-card-premium {
        background: var(--dark-2);
        border: 1px solid rgba(201,168,76,0.1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
    }

    .menu-card-premium:hover {
        transform: translateY(-10px);
        border-color: rgba(201,168,76,0.4);
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    }

    .menu-img-premium {
        height: 220px;
        background-size: cover;
        background-position: center;
        transition: transform 0.6s ease;
        position: relative;
    }

    .menu-card-premium:hover .menu-img-premium {
        transform: scale(1.05);
    }

    .menu-info-premium {
        padding: 1.2rem;
        text-align: center;
    }

    .menu-name-premium {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .menu-price-premium {
        font-size: 1rem;
        color: var(--gold);
        font-weight: 600;
    }

    .menu-order-btn {
        margin-top: 1rem;
        padding: 8px 20px;
        background: transparent;
        border: 1px solid var(--gold);
        border-radius: 40px;
        color: var(--gold);
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    .menu-order-btn:hover {
        background: var(--gold);
        color: var(--dark);
    }

    .btn-view-all-premium {
        text-align: center;
        margin-top: 2rem;
    }

    .btn-view-all-premium a {
        color: var(--gold);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 40px;
        background: rgba(201,168,76,0.05);
        transition: all 0.3s;
    }

    .btn-view-all-premium a:hover {
        gap: 14px;
        background: rgba(201,168,76,0.1);
        border-color: var(--gold);
    }

    /* Stats Section */
    .stats-premium {
        padding: 4rem 2rem;
        background: linear-gradient(135deg, var(--dark-2), var(--dark-3));
        text-align: center;
    }

    .stats-grid {
        display: flex;
        justify-content: center;
        gap: 4rem;
        flex-wrap: wrap;
        max-width: 800px;
        margin: 0 auto;
    }

    .stat-item-premium {
        text-align: center;
    }

    .stat-number-premium {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gold);
    }

    .stat-label-premium {
        font-size: 0.8rem;
        color: var(--text-muted);
        letter-spacing: 1px;
    }

    @media (max-width: 768px) {
        .features-premium, .menu-premium, .stats-premium {
            padding: 3rem 1rem;
        }
        .menu-grid-premium {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .stats-grid {
            gap: 2rem;
        }
        .section-title-premium {
            font-size: 2rem;
        }
        .hero-premium {
            min-height: 70vh;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section Premium -->
    <section class="hero-premium">
        <div class="hero-premium-bg"></div>
        <div class="hero-premium-overlay"></div>
        <div class="hero-premium-content">
            <div class="greeting-text animate-up delay-1">
                <i class="fas fa-crown"></i> WELCOME BACK
            </div>
            <h1 class="hero-premium-title animate-up delay-2">
                Kopi terbaik<br>
                untuk <em>harimu</em>
            </h1>
            <p class="hero-premium-description animate-up delay-3">
                Tempat terbaik untuk produktivitas atau sekadar menikmati aroma kopi pilihan di tengah kesibukanmu.
            </p>
        </div>
        <div class="scroll-indicator animate-float">
            <a href="#features">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Features Section Premium -->
    <section class="features-premium" id="features">
        <div style="text-align: center;">
            <span class="section-badge animate-up delay-1">WHY US</span>
            <h2 class="section-title-premium animate-up delay-2">Kenapa <span>NONGKI</span>?</h2>
        </div>
        <div class="features-grid-premium">
            <div class="feature-card-premium animate-up delay-1">
                <div class="feature-icon-premium">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="feature-title-premium">50+ Menu Pilihan</h3>
                <p class="feature-desc-premium">Dari espresso klasik hingga kreasi spesial, semua tersedia untuk menemani harimu.</p>
            </div>
            <div class="feature-card-premium animate-up delay-2">
                <div class="feature-icon-premium">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title-premium">Pesan Lebih Cepat</h3>
                <p class="feature-desc-premium">Pesan online, ambil tanpa antri. Lebih praktis untuk harimu yang padat.</p>
            </div>
            <div class="feature-card-premium animate-up delay-3">
                <div class="feature-icon-premium">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="feature-title-premium">Simpan Favorit</h3>
                <p class="feature-desc-premium">Simpan menu favoritmu dan lihat riwayat pesanan kapan saja.</p>
            </div>
        </div>
    </section>

    <!-- Menu Populer Section Premium - HANYA 3 MENU TERATAS -->
    <section class="menu-premium">
        <div style="text-align: center;">
            <span class="section-badge animate-up delay-1">BEST SELLER</span>
            <h2 class="section-title-premium animate-up delay-2">Menu <span>Populer</span></h2>
            <p style="color: var(--text-muted); margin-top: -1rem;" class="animate-up delay-3">Pilihan favorit pelanggan kami</p>
        </div>
        <div class="menu-grid-premium">
            <!-- Menu 1: Americano -->
            <div class="menu-card-premium animate-zoom delay-1">
                <div class="menu-img-premium" style="background-image: url('{{ asset('images/products/americano.jpeg') }}');"></div>
                <div class="menu-info-premium">
                    <div class="menu-name-premium">Americano</div>
                    <div class="menu-price-premium">Rp 28.000</div>
                    <button class="menu-order-btn" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
            <!-- Menu 2: Coffee Milk Aren Sugar -->
            <div class="menu-card-premium animate-zoom delay-2">
                <div class="menu-img-premium" style="background-image: url('{{ asset('images/products/coffe_milk_aren_sugar.jpeg') }}');"></div>
                <div class="menu-info-premium">
                    <div class="menu-name-premium">Coffee Milk Aren Sugar</div>
                    <div class="menu-price-premium">Rp 35.000</div>
                    <button class="menu-order-btn" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
            <!-- Menu 3: Hazelnut Coffee -->
            <div class="menu-card-premium animate-zoom delay-3">
                <div class="menu-img-premium" style="background-image: url('{{ asset('images/products/halzenutt_coffe.jpeg') }}');"></div>
                <div class="menu-info-premium">
                    <div class="menu-name-premium">Hazelnut Coffee</div>
                    <div class="menu-price-premium">Rp 40.000</div>
                    <button class="menu-order-btn" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
        <div class="btn-view-all-premium animate-up delay-4">
            <a href="{{ route('menu.index') }}">
                Lihat Semua Menu
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-premium">
        <div class="stats-grid">
            <div class="stat-item-premium animate-up delay-1">
                <div class="stat-number-premium">50+</div>
                <div class="stat-label-premium">MENU VARIAN</div>
            </div>
            <div class="stat-item-premium animate-up delay-2">
                <div class="stat-number-premium">4.9</div>
                <div class="stat-label-premium">CUSTOMER RATING</div>
            </div>
            <div class="stat-item-premium animate-up delay-3">
                <div class="stat-number-premium">10K+</div>
                <div class="stat-label-premium">HAPPY CUSTOMERS</div>
            </div>
        </div>
    </section>
@endsection