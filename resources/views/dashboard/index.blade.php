{{-- resources/views/dashboard.blade.php (atau home.blade.php) --}}
@extends('layouts.app')

@section('title', 'Beranda - NONGKI')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* Import font elegan khusus untuk judul Hero */
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* ========== ANIMATIONS & TIMING ========== */
    :root {
        --transition-smooth: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        --gold-glow: 0 0 20px rgba(201, 168, 76, 0.3);
    }

    @keyframes fadeUpSmooth {
        0% { opacity: 0; transform: translateY(30px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes floatGentle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .reveal { animation: fadeUpSmooth 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; } .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; } .delay-4 { animation-delay: 0.4s; }

    /* ========== 1. HERO SECTION (IMMERSIVE) ========== */
    .hero-premium {
        position: relative; height: 80vh; min-height: 500px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 30px; overflow: hidden; margin-bottom: 5rem;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }
    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover;
        transition: transform 10s ease; transform: scale(1.05); z-index: 1;
    }
    .hero-premium:hover .hero-bg { transform: scale(1.02); }
    .hero-overlay {
        position: absolute; inset: 0; z-index: 2;
        background: linear-gradient(180deg, rgba(15,14,12,0.3) 0%, rgba(15,14,12,0.95) 100%),
                    radial-gradient(circle at center, rgba(0,0,0,0) 0%, rgba(0,0,0,0.6) 100%);
    }
    
    .hero-content {
        position: relative; z-index: 3; text-align: center; max-width: 900px; padding: 0 2rem;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(201, 168, 76, 0.3);
        padding: 6px 18px; border-radius: 30px; backdrop-filter: blur(10px);
        color: var(--gold); font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase;
        margin-bottom: 1.5rem; font-weight: 700; box-shadow: var(--gold-glow);
    }
    
    /* DIKEMBALIKAN KE FONT ORIGINAL YANG ELEGAN */
    .hero-title {
        font-family: 'Cormorant Garamond', serif; /* Font dikembalikan */
        font-size: clamp(3.5rem, 7vw, 5.5rem); 
        line-height: 1.1; 
        color: #f0ece3;
        margin-bottom: 1rem; 
        text-shadow: 0 10px 30px rgba(0,0,0,0.8); 
        font-weight: 400; /* Dibuat lebih tipis elegan seperti desain awal */
    }
    .hero-title em {
        font-style: italic; color: var(--gold); position: relative;
        text-shadow: 0 0 20px rgba(201, 168, 76, 0.4);
    }
    
    .hero-desc {
        color: rgba(240, 236, 227, 0.7); font-size: 1.05rem; max-width: 600px;
        margin: 0 auto; line-height: 1.7;
    }
    .scroll-down {
        position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 3;
        color: var(--gold); font-size: 1.5rem; animation: floatGentle 2s infinite; opacity: 0.7;
    }

    /* ========== 2. FEATURES SECTION (GLASSMORPHISM) ========== */
    .section-header { text-align: center; margin-bottom: 4rem; }
    .section-subtitle {
        color: var(--gold); font-size: 0.75rem; letter-spacing: 3px;
        text-transform: uppercase; display: block; margin-bottom: 0.8rem; font-weight: 700;
    }
    .section-title {
        font-size: 2.2rem; color: #f0ece3; margin: 0; font-weight: 700; letter-spacing: -0.5px;
    }

    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 5rem; }
    .feature-card {
        background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px; padding: 2.5rem 2rem; text-align: center;
        transition: var(--transition-smooth); position: relative; overflow: hidden;
        backdrop-filter: blur(10px);
    }
    .feature-card::before {
        content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 60%);
        opacity: 0; transition: var(--transition-smooth); pointer-events: none;
    }
    .feature-card:hover {
        transform: translateY(-8px); border-color: rgba(201, 168, 76, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4), inset 0 0 20px rgba(201,168,76,0.05);
    }
    .feature-card:hover::before { opacity: 1; }
    
    .feature-icon {
        width: 70px; height: 70px; margin: 0 auto 1.5rem; border-radius: 50%;
        background: linear-gradient(135deg, rgba(201,168,76,0.1), rgba(201,168,76,0.02));
        border: 1px solid rgba(201, 168, 76, 0.2); display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; color: var(--gold); transition: var(--transition-smooth);
    }
    .feature-card:hover .feature-icon { transform: scale(1.1) rotate(5deg); background: var(--gold); color: #000; }
    
    .feature-title { color: #f0ece3; font-size: 1.15rem; font-weight: 700; margin-bottom: 0.8rem; }
    .feature-desc { color: rgba(240, 236, 227, 0.5); font-size: 0.85rem; line-height: 1.6; }

    /* ========== 3. MENU SECTION (COMPACT & PROPORTIONAL) ========== */
    .menu-grid { 
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; 
        max-width: 850px; margin: 0 auto 3rem auto; 
    }
    .menu-card {
        background: var(--dark-2); border-radius: 20px; padding: 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.03); transition: var(--transition-smooth);
        display: flex; flex-direction: column; position: relative;
    }
    .menu-card:hover {
        transform: translateY(-8px); border-color: rgba(201, 168, 76, 0.4);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4), 0 0 20px rgba(201,168,76,0.08);
    }
    
    .menu-img-wrap {
        height: 180px; 
        border-radius: 14px; overflow: hidden; position: relative;
        background: #111; 
    }
    .menu-img {
        width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease;
    }
    .menu-card:hover .menu-img { transform: scale(1.1); }
    .menu-img-overlay {
        position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
    }

    .menu-info { padding: 1rem 0.5rem 0.5rem; text-align: center; }
    .menu-name { font-size: 1.1rem; color: #f0ece3; margin-bottom: 0.3rem; font-weight: 700; }
    .menu-price { color: var(--gold); font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; }
    
    .btn-buy {
        width: 100%; padding: 0.7rem; border-radius: 10px; background: rgba(201, 168, 76, 0.1);
        border: 1px solid var(--gold); color: var(--gold); font-weight: 600; font-size: 0.8rem; cursor: pointer;
        transition: var(--transition-smooth); display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .menu-card:hover .btn-buy { background: var(--gold); color: #000; box-shadow: var(--gold-glow); }

    .view-all-wrap { text-align: center; margin-bottom: 5rem; }
    .btn-view-all {
        display: inline-flex; align-items: center; gap: 10px; padding: 0.9rem 2rem;
        background: transparent; border: 1px solid rgba(201, 168, 76, 0.4); border-radius: 30px;
        color: var(--gold); font-weight: 600; text-decoration: none; transition: var(--transition-smooth);
        font-size: 0.9rem;
    }
    .btn-view-all i { transition: transform 0.3s; }
    .btn-view-all:hover { background: rgba(201, 168, 76, 0.1); border-color: var(--gold); transform: translateY(-3px); }
    .btn-view-all:hover i { transform: translateX(5px); }

    /* ========== 4. STATS FLOATING PANEL ========== */
    .stats-panel {
        background: linear-gradient(135deg, rgba(26,24,20,0.9) 0%, rgba(15,14,12,0.95) 100%);
        border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 24px;
        padding: 3rem 2rem; display: flex; justify-content: space-around; flex-wrap: wrap; gap: 2rem;
        backdrop-filter: blur(20px); box-shadow: 0 25px 50px rgba(0,0,0,0.5); position: relative; overflow: hidden;
    }
    .stats-panel::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .stat-item { text-align: center; position: relative; z-index: 2; }
    .stat-num { font-size: 2.8rem; color: var(--gold); font-weight: 800; line-height: 1; margin-bottom: 0.5rem; letter-spacing: -1px; }
    .stat-label { color: rgba(240, 236, 227, 0.6); font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; }

    @media (max-width: 900px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); max-width: 600px; }
        .hero-title { font-size: 2.5rem; }
    }
    @media (max-width: 768px) {
        .menu-grid { grid-template-columns: 1fr; max-width: 300px; }
        .stats-panel { flex-direction: column; text-align: center; }
        .hero-premium { border-radius: 20px; min-height: 400px; height: auto; padding: 4rem 1rem; }
    }
</style>
@endpush

@section('content')
    <!-- 1. HERO SECTION (ULTRA PREMIUM) -->
    <section class="hero-premium">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge reveal">
                <i class="fas fa-gem"></i> NONGKI EXCLUSIVE
            </div>
            <!-- TEKS DAN FONT DIKEMBALIKAN KE BENTUK ORIGINAL -->
            <h1 class="hero-title reveal delay-1">
                Kopi terbaik<br>untuk <em>harimu</em>
            </h1>
            <p class="hero-desc reveal delay-2">
                Bukan sekadar kedai kopi biasa. Ini adalah ruang eksklusif tempat aroma biji kopi pilihan bertemu dengan kenyamanan tingkat tinggi untuk produktivitas Anda.
            </p>
        </div>
        <div class="scroll-down reveal delay-4">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- 2. FEATURES (WHY US) -->
    <section class="features-section">
        <div class="section-header reveal">
            <span class="section-subtitle">Nilai Tambah Kami</span>
            <h2 class="section-title">Kenapa Memilih NONGKI?</h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-card reveal delay-1">
                <div class="feature-icon"><i class="fas fa-coffee"></i></div>
                <h3 class="feature-title">50+ Menu Pilihan</h3>
                <p class="feature-desc">Mulai dari espresso klasik, manual brew, hingga signature mocktails yang diracik khusus oleh barista profesional kami.</p>
            </div>
            <div class="feature-card reveal delay-2">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <h3 class="feature-title">Pesanan Instan</h3>
                <p class="feature-desc">Lewati antrean. Pesan langsung dari meja Anda atau ambil pesanan takeaway tepat waktu tanpa membuang detik berharga.</p>
            </div>
            <div class="feature-card reveal delay-3">
                <div class="feature-icon"><i class="fas fa-bookmark"></i></div>
                <h3 class="feature-title">Koleksi Personal</h3>
                <p class="feature-desc">Sistem pintar kami menyimpan preferensi dan menu favorit Anda, membuat pemesanan ulang semudah satu klik.</p>
            </div>
        </div>
    </section>

    <!-- 3. MENU POPULER (COMPACT SIZE) -->
    <section class="menu-section">
        <div class="section-header reveal">
            <span class="section-subtitle">Top Terlaris</span>
            <h2 class="section-title">Menu Signature</h2>
        </div>

        <div class="menu-grid">
            <!-- Menu 1 -->
            <div class="menu-card reveal delay-1">
                <div class="menu-img-wrap">
                    <img src="{{ asset('images/products/americano.jpeg') }}" class="menu-img" alt="Americano">
                    <div class="menu-img-overlay"></div>
                </div>
                <div class="menu-info">
                    <h3 class="menu-name">Classic Americano</h3>
                    <div class="menu-price">Rp 28.000</div>
                    <button class="btn-buy" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-bag"></i> Pesan Sekarang
                    </button>
                </div>
            </div>

            <!-- Menu 2 -->
            <div class="menu-card reveal delay-2">
                <div class="menu-img-wrap">
                    <img src="{{ asset('images/products/coffe_milk_aren_sugar.jpeg') }}" class="menu-img" alt="Kopi Susu Aren">
                    <div class="menu-img-overlay"></div>
                </div>
                <div class="menu-info">
                    <h3 class="menu-name">Kopi Susu Gula Aren</h3>
                    <div class="menu-price">Rp 35.000</div>
                    <button class="btn-buy" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-bag"></i> Pesan Sekarang
                    </button>
                </div>
            </div>

            <!-- Menu 3 -->
            <div class="menu-card reveal delay-3">
                <div class="menu-img-wrap">
                    <img src="{{ asset('images/products/halzenutt_coffe.jpeg') }}" class="menu-img" alt="Hazelnut Coffee">
                    <div class="menu-img-overlay"></div>
                </div>
                <div class="menu-info">
                    <h3 class="menu-name">Premium Hazelnut</h3>
                    <div class="menu-price">Rp 40.000</div>
                    <button class="btn-buy" onclick="window.location.href='{{ route('menu.index') }}'">
                        <i class="fas fa-shopping-bag"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>

        <div class="view-all-wrap reveal delay-4">
            <a href="{{ route('menu.index') }}" class="btn-view-all">
                Jelajahi Semua Menu <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- 4. STATS PANEL (DASHBOARD WIDGET STYLE) -->
    <section class="stats-section reveal">
        <div class="stats-panel">
            <div class="stat-item">
                <div class="stat-num">50<span style="font-size: 1.8rem;">+</span></div>
                <div class="stat-label">Varian Menu</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">4.9</div>
                <div class="stat-label">Rating Pelanggan</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">10<span style="font-size: 1.8rem;">k+</span></div>
                <div class="stat-label">Pelanggan Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">24<span style="font-size: 1.8rem;">/7</span></div>
                <div class="stat-label">Pemesanan Web</div>
            </div>
        </div>
    </section>
@endsection