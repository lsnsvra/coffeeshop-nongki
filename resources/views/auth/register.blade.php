<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — NONGKI Coffee</title>
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
            --gold-dark: #A8883A;
            --gold-dim: rgba(201, 168, 76, 0.12);
            --dark-bg: #0A0A0A;
            --dark-card: #111111;
            --dark-surface: #1A1A1A;
            --dark-elevated: #222222;
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            --border: rgba(255, 255, 255, 0.1);
            --error: #E05252;
            --success: #52B788;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* LEFT PANEL - BRAND SECTION */
        .brand-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.8) 100%), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80');
            background-size: cover;
            background-position: center;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(201,168,76,0.05) 0%, transparent 100%);
            pointer-events: none;
        }

        .brand-logo {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 26px;
            height: 26px;
            color: var(--dark-bg);
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: var(--gold-light);
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 400px;
        }

        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.2rem;
            font-weight: 400;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .brand-title em {
            font-style: italic;
            color: var(--gold);
        }

        .brand-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .benefits {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .benefit-icon {
            width: 28px;
            height: 28px;
            background: var(--gold-dim);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .benefit-icon svg {
            width: 14px;
            height: 14px;
            color: var(--gold);
        }

        .benefit-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--border);
            padding-top: 1.5rem;
        }

        /* RIGHT PANEL - FORM SECTION */
        .form-panel {
            width: 560px;
            background: var(--dark-card);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3rem;
            position: relative;
            overflow-y: auto;
        }

        .form-panel::-webkit-scrollbar {
            width: 4px;
        }

        .form-panel::-webkit-scrollbar-track {
            background: var(--dark-surface);
        }

        .form-panel::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }

        .auth-tabs {
            display: flex;
            gap: 1rem;
            background: var(--dark-surface);
            padding: 0.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .auth-tab.active {
            background: var(--gold);
            color: var(--dark-bg);
        }

        .auth-tab:not(.active):hover {
            color: var(--gold);
        }

        .form-header {
            margin-bottom: 1.5rem;
        }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--text-muted);
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            background: var(--dark-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .input-wrapper input::placeholder {
            color: var(--text-muted);
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--gold);
        }

        /* Password Strength */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .strength-segment {
            flex: 1;
            height: 3px;
            background: var(--border);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-segment.weak { background: var(--error); }
        .strength-segment.fair { background: #E09F3E; }
        .strength-segment.good { background: #70B8FF; }
        .strength-segment.strong { background: var(--success); }

        .strength-text {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Terms */
        .terms-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 1.5rem 0;
            cursor: pointer;
        }

        .terms-wrapper input {
            display: none;
        }

        .terms-checkmark {
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--border);
            border-radius: 5px;
            background: var(--dark-surface);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            transition: all 0.3s ease;
        }

        .terms-wrapper input:checked + .terms-checkmark {
            background: var(--gold);
            border-color: var(--gold);
        }

        .terms-wrapper input:checked + .terms-checkmark::after {
            content: '';
            width: 10px;
            height: 6px;
            border-left: 2px solid var(--dark-bg);
            border-bottom: 2px solid var(--dark-bg);
            transform: rotate(-45deg) translateY(-1px);
        }

        .terms-text {
            font-size: 0.8rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .terms-text a {
            color: var(--gold);
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            border-radius: 10px;
            color: var(--dark-bg);
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.3);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .btn-google {
            width: 100%;
            padding: 0.875rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-google:hover {
            border-color: var(--gold);
            background: var(--gold-dim);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .form-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(224,82,82,0.1);
            border: 1px solid rgba(224,82,82,0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            color: var(--error);
            font-size: 0.85rem;
        }

        @media (max-width: 900px) {
            .brand-panel {
                display: none;
            }
            .form-panel {
                width: 100%;
            }
        }

        @media (max-width: 560px) {
            .form-panel {
                padding: 2rem 1.5rem;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- LEFT PANEL - BRAND -->
    <div class="brand-panel">
        <div class="brand-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5h2V5h-2v3zm-2 5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4V5h12v8z"/>
                </svg>
            </div>
            <span class="logo-text">NONGKI</span>
        </div>

        <div class="brand-content">
            <h1 class="brand-title">
                Bergabung dan<br>
                <em>mulai menikmati.</em>
            </h1>
            <p class="brand-description">
                Buat akunmu sekarang dan dapatkan pengalaman memesan kopi favorit yang lebih mudah dan menyenangkan.
            </p>
            <div class="benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <span class="benefit-text">Akses 50+ menu kopi & non-kopi pilihan</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <span class="benefit-text">Pesan kapan saja, ambil tanpa antri</span>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <span class="benefit-text">Simpan favorit dan riwayat pesananmu</span>
                </div>
            </div>
        </div>

        <div class="brand-footer">
            <span>© 2026 NONGKI Coffee</span>
            <span>Privasi · Syarat</span>
        </div>
    </div>

    <!-- RIGHT PANEL - FORM -->
    <div class="form-panel">
        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="auth-tab">Masuk</a>
            <a href="{{ route('register') }}" class="auth-tab active">Daftar</a>
        </div>

        <div class="form-header">
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Isi data di bawah untuk memulai</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="first_name">Nama Depan</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input type="text" id="first_name" name="first_name" placeholder="Nama" value="{{ old('first_name') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="last_name">Nama Belakang</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input type="text" id="last_name" name="last_name" placeholder="Belakang" value="{{ old('last_name') }}">
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="3"/>
                            <path d="m2 7 10 7 10-7"/>
                        </svg>
                        <input type="email" id="email" name="email" placeholder="kamu@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <label class="form-label" for="phone">Nomor HP <span style="font-weight:400;text-transform:none;">(opsional)</span></label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6.5-6.5 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.56a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <input type="tel" id="phone" name="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required oninput="checkStrength(this.value)">
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-segment" id="s1"></div>
                        <div class="strength-segment" id="s2"></div>
                        <div class="strength-segment" id="s3"></div>
                        <div class="strength-segment" id="s4"></div>
                    </div>
                    <div class="strength-text" id="strength-label">Masukkan password</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                        <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <label class="terms-wrapper">
                <input type="checkbox" name="terms" required>
                <span class="terms-checkmark"></span>
                <span class="terms-text">
                    Dengan mendaftar, saya menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> NONGKI Coffee.
                </span>
            </label>

            <button type="submit" class="btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                Buat Akun Sekarang
            </button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">atau daftar dengan</span>
            <div class="divider-line"></div>
        </div>

        <div class="btn-google" onclick="alert('Fitur Google Login sedang dalam pengembangan. Silakan daftar menggunakan email dan password.')">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Daftar dengan Google
        </div>

        <p class="form-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>

    <script>
        function togglePassword(id, element) {
            const input = document.getElementById(id);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            element.style.color = type === 'text' ? 'var(--gold)' : 'var(--text-muted)';
        }

        function checkStrength(val) {
            const segs = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
            const label = document.getElementById('strength-label');

            if (!val) {
                segs.forEach(s => s.className = 'strength-segment');
                label.textContent = 'Masukkan password';
                return;
            }

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = ['weak', 'fair', 'good', 'strong'];
            const texts = ['Lemah', 'Cukup', 'Baik', 'Kuat'];

            segs.forEach((s, i) => {
                s.className = 'strength-segment' + (i < score ? ' ' + levels[score - 1] : '');
            });

            label.textContent = 'Kekuatan: ' + (texts[score - 1] || 'Sangat lemah');
            label.style.color = score >= 3 ? 'var(--success)' : score >= 2 ? 'var(--gold)' : 'var(--error)';
        }
    </script>
</body>
</html>