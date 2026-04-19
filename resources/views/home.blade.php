<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NONGKI Coffee - Kopi Terbaik untuk Harimu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.15);
            --dark: #0A0A0A;
            --dark-2: #111111;
            --dark-3: #1A1A1A;
            --cream: #F5EDD8;
            --cream-dim: rgba(245,237,216,0.7);
            --text-muted: rgba(245,237,216,0.5);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmerText {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .animate-up { animation: fadeInUp 0.8s ease forwards; }
        .animate-left { animation: fadeInLeft 0.8s ease forwards; }
        .animate-right { animation: fadeInRight 0.8s ease forwards; }
        .animate-zoom { animation: zoomIn 0.6s ease forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .delay-5 { animation-delay: 0.5s; opacity: 0; }

.shimmer-word {
    display: inline-block;
    font-style: normal;
    background: linear-gradient(90deg, 
        #C9A84C 0%, 
        #E8C96A 40%,
        #FFFFFF 50%,
        #E8C96A 60%,
        #C9A84C 100%);
    background-size: 200% 100%;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: shimmerText 2s ease-in-out infinite;
}

@keyframes shimmerText {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
        /* ========== HERO SECTION ========== */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover no-repeat;
            filter: brightness(0.35) saturate(0.8);
            z-index: 0;
            transform: scale(1.05);
            transition: transform 8s ease;
        }

        .hero:hover .hero-bg {
            transform: scale(1.1);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(10,10,10,0.4) 0%, rgba(10,10,10,0.85) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .logo {
            margin-bottom: 2rem;
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--gold-light);
            position: relative;
            display: inline-block;
        }

        .logo-text::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .since-badge {
            display: inline-block;
            padding: 6px 20px;
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 40px;
            font-size: 0.7rem;
            color: var(--gold-light);
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
            backdrop-filter: blur(4px);
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem, 7vw, 5rem);
            font-weight: 400;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold);
            position: relative;
            display: inline-block;
        }

        .hero-description {
            font-size: clamp(0.95rem, 2vw, 1.1rem);
            color: var(--cream-dim);
            max-width: 550px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark);
            padding: 12px 32px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(201,168,76,0.4);
            color: var(--dark);
        }

        .btn-secondary {
            border: 1px solid rgba(201,168,76,0.4);
            color: var(--cream);
            padding: 12px 32px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(201,168,76,0.05);
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(201,168,76,0.15);
            transform: translateY(-3px);
        }

        /* ========== FEATURES SECTION ========== */
        .features {
            padding: 6rem 2rem;
            background: linear-gradient(180deg, var(--dark) 0%, var(--dark-2) 100%);
            position: relative;
        }

        .section-title {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title span {
            color: var(--gold);
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            background: var(--gold);
            margin: 1rem auto 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            background: rgba(26,21,9,0.6);
            border: 1px solid rgba(201,168,76,0.1);
            border-radius: 24px;
            transition: all 0.4s ease;
            backdrop-filter: blur(8px);
        }

        .feature-card:hover {
            border-color: rgba(201,168,76,0.4);
            transform: translateY(-8px);
            background: rgba(26,21,9,0.8);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .feature-icon {
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

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-icon i {
            font-size: 28px;
            color: var(--gold);
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.85rem;
            color: var(--cream-dim);
            line-height: 1.6;
        }

        /* ========== MENU PREVIEW SECTION ========== */
        .menu-preview {
            padding: 6rem 2rem;
            background: var(--dark);
            position: relative;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.8rem;
            max-width: 1200px;
            margin: 2rem auto;
        }

        .menu-card {
            background: var(--dark-2);
            border: 1px solid rgba(201,168,76,0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            border-color: rgba(201,168,76,0.4);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .menu-img {
            height: 250px;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }

        .menu-card:hover .menu-img {
            transform: scale(1.05);
        }

        .menu-info {
            padding: 1.2rem;
        }

        .menu-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .menu-price {
            font-size: 0.9rem;
            color: var(--gold);
            font-weight: 600;
        }

        .btn-view-all {
            text-align: center;
            margin-top: 2rem;
        }

        .btn-view-all a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
            padding: 10px 24px;
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 40px;
            background: rgba(201,168,76,0.05);
        }

        .btn-view-all a:hover {
            gap: 14px;
            background: rgba(201,168,76,0.1);
            border-color: var(--gold);
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, var(--dark-2), var(--dark-3));
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
            animation: float 15s ease infinite;
        }

        .cta-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .cta-description {
            color: var(--cream-dim);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark);
            padding: 14px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(201,168,76,0.4);
            color: var(--dark);
        }

        /* ========== FOOTER ========== */
        .footer {
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(201,168,76,0.1);
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .features, .menu-preview, .cta-section {
                padding: 3rem 1rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn-primary, .btn-secondary {
                width: 220px;
                justify-content: center;
            }
            .section-title {
                font-size: 2rem;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .menu-grid {
                grid-template-columns: 1fr;
            }
            .footer-links {
                gap: 1rem;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1200px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="logo animate-zoom">
                <div class="logo-text">NONGKI</div>
            </div>
            <div class="since-badge animate-left delay-1">SINCE 2026</div>
            <h1 class="hero-title animate-up delay-2">
                Kopi terbaik<br>
                untuk <em class="shimmer-word">harimu</em>
            </h1>
            <p class="hero-description animate-up delay-3">
                Tempat terbaik untuk produktivitas atau sekadar menikmati aroma kopi pilihan di tengah kesibukanmu.
            </p>
            <div class="hero-buttons animate-up delay-4">
                <a href="{{ route('register') }}" class="btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="btn-secondary">
                    <i class="fas fa-user"></i>
                    Masuk Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Kenapa <span>NONGKI</span>?</h2>
        <div class="features-grid">
            <div class="feature-card animate-up delay-1">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="feature-title">50+ Menu Pilihan</h3>
                <p class="feature-desc">Dari espresso klasik hingga kreasi spesial, semua tersedia untuk menemani harimu.</p>
            </div>
            <div class="feature-card animate-up delay-2">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-title">Pesan Lebih Cepat</h3>
                <p class="feature-desc">Pesan online, ambil tanpa antri. Lebih praktis untuk harimu yang padat.</p>
            </div>
            <div class="feature-card animate-up delay-3">
                <div class="feature-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="feature-title">Simpan Favorit</h3>
                <p class="feature-desc">Simpan menu favoritmu dan lihat riwayat pesanan kapan saja.</p>
            </div>
        </div>
    </section>

    <!-- Menu Preview Section -->
<section class="menu-preview">
    <h2 class="section-title">Menu <span>Populer</span></h2>
    <div class="menu-grid">
        <div class="menu-card animate-zoom delay-1">
            <div class="menu-img" style="background-image: url('{{ asset('images/products/halzenutt_coffe.jpeg') }}');"></div>
            <div class="menu-info">
                <div class="menu-name">Hazelnut Coffee</div>
                <div class="menu-price">Rp 40.000</div>
            </div>
        </div>
        <div class="menu-card animate-zoom delay-2">
            <div class="menu-img" style="background-image: url('{{ asset('images/products/matcha_latte.jpeg') }}');"></div>
            <div class="menu-info">
                <div class="menu-name">Matcha Latte</div>
                <div class="menu-price">Rp 45.000</div>
            </div>
        </div>
        <div class="menu-card animate-zoom delay-3">
            <div class="menu-img" style="background-image: url('{{ asset('images/products/french_fries.jpeg') }}');"></div>
            <div class="menu-info">
                <div class="menu-name">French Fries</div>
                <div class="menu-price">Rp 22.000</div>
            </div>
        </div>
    </div>
</section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2 class="cta-title">Siap menikmati <span style="color: var(--gold);">kopi terbaik</span>?</h2>
        <p class="cta-description">Daftar sekarang dan dapatkan pengalaman memesan kopi yang lebih mudah.</p>
        <a href="{{ route('register') }}" class="btn-cta">
            <i class="fas fa-user-plus"></i>
            Daftar Sekarang
            <i class="fas fa-arrow-right"></i>
        </a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#">Privasi</a>
            <a href="#">Syarat</a>
            <a href="#">Bantuan</a>
            <a href="#">Tentang Kami</a>
        </div>
        <p>©️ 2026 NONGKI Coffee. Hak cipta dilindungi.</p>
    </footer>
</body>
</html>