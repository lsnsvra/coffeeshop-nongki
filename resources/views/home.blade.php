<!DOCTYPE html>
<html lang="id" data-theme="dark">
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

        /* ========== DARK MODE (default) ========== */
        :root,
        [data-theme="dark"] {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.15);

            --bg-primary: #0A0A0A;
            --bg-secondary: #111111;
            --bg-tertiary: #1A1A1A;
            --bg-card: rgba(26,21,9,0.6);
            --bg-card-hover: rgba(26,21,9,0.8);

            --text-primary: #F5EDD8;
            --text-dim: rgba(245,237,216,0.7);
            --text-muted: rgba(245,237,216,0.5);

            --border-subtle: rgba(201,168,76,0.1);
            --border-hover: rgba(201,168,76,0.4);

            --hero-overlay: radial-gradient(circle at center, rgba(10,10,10,0.4) 0%, rgba(10,10,10,0.85) 100%);
            --hero-brightness: brightness(0.35) saturate(0.8);

            --footer-bg: transparent;
            --footer-border: rgba(201,168,76,0.1);

            --btn-secondary-bg: rgba(201,168,76,0.05);
            --btn-secondary-hover-bg: rgba(201,168,76,0.15);
            --btn-secondary-text: #F5EDD8;

            --toggle-bg: rgba(201,168,76,0.1);
            --toggle-border: rgba(201,168,76,0.3);
            --toggle-icon-color: #E8C96A;
            --toggle-hover-bg: rgba(201,168,76,0.2);

            --features-gradient: linear-gradient(180deg, #0A0A0A 0%, #111111 100%);
            --cta-gradient: linear-gradient(135deg, #111111, #1A1A1A);
        }

        /* ========== LIGHT MODE ========== */
        [data-theme="light"] {
            --gold: #A67C2A;
            --gold-light: #C9A84C;
            --gold-dim: rgba(166,124,42,0.12);

            --bg-primary: #FFFBF2;
            --bg-secondary: #FEF6E4;
            --bg-tertiary: #F5EDD8;
            --bg-card: rgba(255,251,242,0.85);
            --bg-card-hover: rgba(255,251,242,0.98);

            --text-primary: #1C150A;
            --text-dim: rgba(28,21,10,0.72);
            --text-muted: rgba(28,21,10,0.5);

            --border-subtle: rgba(166,124,42,0.15);
            --border-hover: rgba(166,124,42,0.5);

            --hero-overlay: radial-gradient(circle at center, rgba(255,251,242,0.1) 0%, rgba(10,8,3,0.6) 100%);
            --hero-brightness: brightness(0.55) saturate(0.9);

            --footer-bg: #FEF6E4;
            --footer-border: rgba(166,124,42,0.15);

            --btn-secondary-bg: rgba(255,255,255,0.5);
            --btn-secondary-hover-bg: rgba(255,255,255,0.8);
            --btn-secondary-text: #1C150A;

            --toggle-bg: rgba(255,255,255,0.7);
            --toggle-border: rgba(166,124,42,0.35);
            --toggle-icon-color: #A67C2A;
            --toggle-hover-bg: rgba(255,255,255,0.95);

            --features-gradient: linear-gradient(180deg, #FFFBF2 0%, #FEF6E4 100%);
            --cta-gradient: linear-gradient(135deg, #FEF6E4, #F5EDD8);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }

        /* ========== THEME TOGGLE BUTTON ========== */
        .theme-toggle {
            position: fixed;
            top: 1.2rem;
            right: 1.5rem;
            z-index: 1000;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .theme-toggle:hover {
            background: var(--toggle-hover-bg);
            border-color: var(--gold);
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 6px 20px rgba(201,168,76,0.25);
        }

        .theme-toggle i {
            font-size: 18px;
            color: var(--toggle-icon-color);
            transition: all 0.3s ease;
        }

        /* Hide/show icons based on theme */
        [data-theme="dark"] .icon-sun { display: block; }
        [data-theme="dark"] .icon-moon { display: none; }
        [data-theme="light"] .icon-sun { display: none; }
        [data-theme="light"] .icon-moon { display: block; }

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
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes shimmerText {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
            font-style: italic;
            background: linear-gradient(90deg,
                var(--gold) 0%,
                var(--gold-light) 40%,
                #FFFFFF 50%,
                var(--gold-light) 60%,
                var(--gold) 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmerText 2s ease-in-out infinite;
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
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover no-repeat;
            filter: var(--hero-brightness);
            z-index: 0;
            transform: scale(1.05);
            transition: transform 8s ease, filter 0.4s ease;
        }

        .hero:hover .hero-bg { transform: scale(1.1); }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--hero-overlay);
            z-index: 1;
            transition: background 0.4s ease;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .logo { margin-bottom: 2rem; }

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
            color: #F5EDD8; /* always light in hero since bg is dark image */
        }

        .hero-description {
            font-size: clamp(0.95rem, 2vw, 1.1rem);
            color: rgba(245,237,216,0.75);
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
            color: #0A0A0A;
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
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before { left: 100%; }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(201,168,76,0.4);
            color: #0A0A0A;
        }

        /* Hero secondary button always light since hero is dark */
        .btn-secondary {
            border: 1px solid rgba(245,237,216,0.4);
            color: #F5EDD8;
            padding: 12px 32px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(245,237,216,0.05);
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary:hover {
            border-color: var(--gold-light);
            color: var(--gold-light);
            background: rgba(201,168,76,0.12);
            transform: translateY(-3px);
        }

        /* ========== FEATURES SECTION ========== */
        .features {
            padding: 6rem 2rem;
            background: var(--features-gradient);
            position: relative;
            transition: background 0.4s ease;
        }

        .section-title {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 3rem;
            position: relative;
            color: var(--text-primary);
            transition: color 0.4s ease;
        }

        .section-title span { color: var(--gold); }

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
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            transition: all 0.4s ease;
            backdrop-filter: blur(8px);
        }

        .feature-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-8px);
            background: var(--bg-card-hover);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        [data-theme="light"] .feature-card:hover {
            box-shadow: 0 20px 40px rgba(166,124,42,0.1);
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

        .feature-card:hover .feature-icon { transform: scale(1.1); }

        .feature-icon i {
            font-size: 28px;
            color: var(--gold);
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            transition: color 0.4s ease;
        }

        .feature-desc {
            font-size: 0.85rem;
            color: var(--text-dim);
            line-height: 1.6;
            transition: color 0.4s ease;
        }

        /* ========== MENU PREVIEW SECTION ========== */
        .menu-preview {
            padding: 6rem 2rem;
            background: var(--bg-primary);
            position: relative;
            transition: background 0.4s ease;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.8rem;
            max-width: 1200px;
            margin: 2rem auto;
        }

        .menu-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            border-color: var(--border-hover);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        [data-theme="light"] .menu-card:hover {
            box-shadow: 0 20px 40px rgba(166,124,42,0.12);
        }

        .menu-img {
            height: 250px;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
        }

        .menu-card:hover .menu-img { transform: scale(1.05); }

        .menu-info { padding: 1.2rem; }

        .menu-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
            transition: color 0.4s ease;
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
            transition: gap 0.3s ease, background 0.3s ease, border-color 0.3s ease;
            padding: 10px 24px;
            border: 1px solid var(--border-subtle);
            border-radius: 40px;
            background: var(--gold-dim);
        }

        .btn-view-all a:hover {
            gap: 14px;
            background: rgba(201,168,76,0.12);
            border-color: var(--gold);
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            padding: 5rem 2rem;
            background: var(--cta-gradient);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: background 0.4s ease;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%; left: -20%;
            width: 140%; height: 200%;
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
            color: var(--text-primary);
            transition: color 0.4s ease;
        }

        .cta-description {
            color: var(--text-dim);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            transition: color 0.4s ease;
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: #0A0A0A;
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
            color: #0A0A0A;
        }

        /* ========== FOOTER ========== */
        .footer {
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--footer-border);
            font-size: 0.75rem;
            color: var(--text-muted);
            background: var(--footer-bg);
            transition: all 0.4s ease;
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

        .footer-links a:hover { color: var(--gold); }

        /* ========== LIGHT MODE EXTRA POLISH ========== */
        /* Subtle texture for light bg */
        [data-theme="light"] body {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        [data-theme="light"] .features {
            box-shadow: inset 0 -1px 0 rgba(166,124,42,0.08);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .features, .menu-preview, .cta-section { padding: 3rem 1rem; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .btn-primary, .btn-secondary { width: 220px; justify-content: center; }
            .section-title { font-size: 2rem; }
            .features-grid { grid-template-columns: 1fr; }
            .menu-grid { grid-template-columns: 1fr; }
            .footer-links { gap: 1rem; }
            .theme-toggle { top: 0.8rem; right: 0.8rem; width: 40px; height: 40px; }
            .theme-toggle i { font-size: 16px; }
        }
    </style>
</head>
<body>

    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle light/dark mode" title="Ganti tema">
        <i class="fas fa-sun icon-sun"></i>
        <i class="fas fa-moon icon-moon"></i>
    </button>

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
                <div class="menu-img" style="background-image: url('{{ asset("images/products/halzenutt_coffe.jpeg") }}');"></div>
                <div class="menu-info">
                    <div class="menu-name">Hazelnut Coffee</div>
                    <div class="menu-price">Rp 40.000</div>
                </div>
            </div>
            <div class="menu-card animate-zoom delay-2">
                <div class="menu-img" style="background-image: url('{{ asset("images/products/matcha_latte.jpeg") }}');"></div>
                <div class="menu-info">
                    <div class="menu-name">Matcha Latte</div>
                    <div class="menu-price">Rp 45.000</div>
                </div>
            </div>
            <div class="menu-card animate-zoom delay-3">
                <div class="menu-img" style="background-image: url('{{ asset("images/products/french_fries.jpeg") }}');"></div>
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

    <script>
        const toggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Load saved preference
        const saved = localStorage.getItem('nongki-theme') || 'dark';
        html.setAttribute('data-theme', saved);

        toggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('nongki-theme', next);
        });
    </script>
</body>
</html>
