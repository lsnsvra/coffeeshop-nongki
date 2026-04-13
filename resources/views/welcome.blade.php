<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NONGKI Coffee - Kopi Terbaik untuk Harimu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --dark: #0F0C07;
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

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1600&q=80') center/cover no-repeat;
            filter: brightness(0.3) saturate(0.7);
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(15,12,7,0.4) 0%, rgba(15,12,7,0.85) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Efek Shimmer untuk "harimu" */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        .shimmer-text {
            background: linear-gradient(90deg, 
                var(--gold) 0%, 
                var(--gold-light) 25%, 
                var(--gold) 50%, 
                var(--gold-light) 75%, 
                var(--gold) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 3s linear infinite;
            font-style: italic;
        }

        .logo {
            margin-bottom: 2rem;
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--gold-light);
        }

        .since-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(201,168,76,0.15);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 40px;
            font-size: 0.7rem;
            color: var(--gold-light);
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 400;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-description {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            color: var(--cream-dim);
            max-width: 550px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
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
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(201,168,76,0.4);
        }

        .btn-secondary {
            border: 1px solid var(--border, rgba(201,168,76,0.3));
            color: var(--cream);
            padding: 12px 32px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-secondary:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(201,168,76,0.1);
        }

        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: var(--dark);
            position: relative;
        }

        .section-title {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 3rem;
        }

        .section-title span {
            color: var(--gold);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            background: rgba(26,21,9,0.5);
            border: 1px solid rgba(201,168,76,0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: rgba(201,168,76,0.3);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(201,168,76,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .feature-icon svg {
            width: 28px;
            height: 28px;
            color: var(--gold);
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.85rem;
            color: var(--cream-dim);
            line-height: 1.5;
        }

        /* Footer */
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
            gap: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        @media (max-width: 768px) {
            .features {
                padding: 3rem 1rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn-primary, .btn-secondary {
                width: 200px;
                justify-content: center;
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
            <div class="logo">
                <div class="logo-text">NONGKI</div>
            </div>
            <div class="since-badge">SINCE 2024</div>
            <h1 class="hero-title">
                Kopi terbaik<br>
                untuk <em class="shimmer-text">harimu</em>
            </h1>
            <p class="hero-description">
                Tempat terbaik untuk produktivitas atau sekadar menikmati aroma kopi pilihan di tengah kesibukanmu.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Kenapa <span>NONGKI</span>?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                </div>
                <h3 class="feature-title">50+ Menu Pilihan</h3>
                <p class="feature-desc">Dari espresso klasik hingga kreasi spesial, semua tersedia untuk menemani harimu.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3 class="feature-title">Pesan Lebih Cepat</h3>
                <p class="feature-desc">Pesan online, ambil tanpa antri. Lebih praktis untuk harimu yang padat.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Simpan Favorit</h3>
                <p class="feature-desc">Simpan menu favoritmu dan lihat riwayat pesanan kapan saja.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#">Privasi</a>
            <a href="#">Syarat</a>
            <a href="#">Bantuan</a>
        </div>
        <p>©️ 2026 NONGKI Coffee. Hak cipta dilindungi.</p>
    </footer>
</body>
</html>