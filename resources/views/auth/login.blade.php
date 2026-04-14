<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — NONGKI Coffee</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
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
      --gold-dark: #A8883A;
      --gold-dim: rgba(201, 168, 76, 0.12);
      --dark-bg: #0A0A0A;
      --dark-card: #111111;
      --dark-surface: #1A1A1A;
      --dark-elevated: #222222;
      --text-primary: #FFFFFF;
      --text-secondary: rgba(255, 255, 255, 0.7);
      --text-muted: rgba(255, 255, 255, 0.5);
      --border: rgba(255, 255, 255, 0.08);
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

    /* Simple elegant animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes glowPulse {
      0% { box-shadow: 0 0 0 0 rgba(201,168,76,0.4); }
      70% { box-shadow: 0 0 0 10px rgba(201,168,76,0); }
      100% { box-shadow: 0 0 0 0 rgba(201,168,76,0); }
    }

    @keyframes shine {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }

    .animate-fade {
      animation: fadeIn 0.8s ease forwards;
    }

    .animate-slide {
      animation: slideUp 0.6s ease forwards;
      opacity: 0;
    }

    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.2s; }
    .delay-5 { animation-delay: 0.25s; }
    .delay-6 { animation-delay: 0.3s; }

    /* LEFT PANEL - BRAND SECTION */
    .brand-panel {
      flex: 1;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.85) 100%), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80');
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
      background: radial-gradient(circle at 30% 50%, rgba(201,168,76,0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Logo yang lebih bagus */
    .brand-logo {
      position: relative;
      z-index: 2;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-icon {
      width: 52px;
      height: 52px;
      background: linear-gradient(145deg, var(--gold), var(--gold-dark));
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 24px rgba(201,168,76,0.3);
      transition: transform 0.3s ease;
    }

    .logo-icon:hover {
      transform: scale(1.03);
    }

    .logo-icon svg {
      width: 28px;
      height: 28px;
      color: var(--dark-bg);
      filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
    }

    .logo-text {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, var(--gold-dark) 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 0 2px 10px rgba(201,168,76,0.2);
    }

    .brand-content {
      position: relative;
      z-index: 2;
      max-width: 400px;
    }

    /* Brand title dengan efek lebih menarik */
    .brand-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 3.2rem;
      font-weight: 400;
      line-height: 1.2;
      margin-bottom: 1rem;
      position: relative;
    }

    .brand-title em {
      font-style: italic;
      color: var(--gold);
      position: relative;
      display: inline-block;
    }

    .brand-title em::after {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, var(--gold), transparent);
    }

    .brand-description {
      font-size: 0.95rem;
      color: var(--text-secondary);
      line-height: 1.6;
      margin-bottom: 2rem;
    }

    .brand-stats {
      display: flex;
      gap: 2.5rem;
    }

    .stat-item {
      text-align: left;
    }

    .stat-number {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 600;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      line-height: 1;
    }

    .stat-label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-muted);
      margin-top: 0.25rem;
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
      width: 520px;
      background: rgba(17,17,17,0.95);
      backdrop-filter: blur(10px);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem;
      position: relative;
      overflow-y: auto;
      border-left: 1px solid var(--border);
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
      gap: 0.5rem;
      background: var(--dark-surface);
      padding: 0.5rem;
      border-radius: 14px;
      margin-bottom: 2rem;
    }

    .auth-tab {
      flex: 1;
      text-align: center;
      padding: 0.75rem;
      border-radius: 10px;
      text-decoration: none;
      color: var(--text-secondary);
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .auth-tab.active {
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      color: var(--dark-bg);
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(201,168,76,0.3);
    }

    .auth-tab:not(.active):hover {
      color: var(--gold);
    }

    .form-header {
      margin-bottom: 2rem;
    }

    .form-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 500;
      background: linear-gradient(135deg, #fff, var(--gold-light));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 0.5rem;
    }

    .form-subtitle {
      font-size: 0.85rem;
      color: var(--text-muted);
    }

    .form-group {
      margin-bottom: 1.25rem;
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
      transition: color 0.3s ease;
    }

    .input-wrapper input {
      width: 100%;
      padding: 0.875rem 1rem 0.875rem 2.75rem;
      background: var(--dark-surface);
      border: 1px solid var(--border);
      border-radius: 12px;
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

    .input-wrapper input:focus+.input-icon {
      color: var(--gold);
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

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
    }

    .checkbox-wrapper input {
      display: none;
    }

    .checkmark {
      width: 18px;
      height: 18px;
      border: 1.5px solid var(--border);
      border-radius: 5px;
      background: var(--dark-surface);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .checkbox-wrapper input:checked+.checkmark {
      background: var(--gold);
      border-color: var(--gold);
    }

    .checkbox-wrapper input:checked+.checkmark::after {
      content: '';
      width: 10px;
      height: 6px;
      border-left: 2px solid var(--dark-bg);
      border-bottom: 2px solid var(--dark-bg);
      transform: rotate(-45deg) translateY(-1px);
    }

    .checkbox-label {
      font-size: 0.85rem;
      color: var(--text-secondary);
    }

    .forgot-link {
      font-size: 0.85rem;
      color: var(--gold);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .forgot-link:hover {
      color: var(--gold-light);
      text-decoration: underline;
    }

    .btn-submit {
      width: 100%;
      padding: 0.875rem;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      border: none;
      border-radius: 12px;
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
      position: relative;
      overflow: hidden;
    }

    .btn-submit::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }

    .btn-submit:hover::before {
      left: 100%;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(201, 168, 76, 0.4);
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
      background: linear-gradient(90deg, transparent, var(--border), transparent);
    }

    .divider-text {
      font-size: 0.7rem;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .btn-google {
      width: 100%;
      padding: 0.875rem;
      background: transparent;
      border: 1px solid var(--border);
      border-radius: 12px;
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
      transform: translateY(-1px);
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
      transition: color 0.3s;
    }

    .form-footer a:hover {
      color: var(--gold-light);
      text-decoration: underline;
    }

    .error-message {
      background: rgba(224, 82, 82, 0.1);
      border: 1px solid rgba(224, 82, 82, 0.3);
      border-radius: 12px;
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

    @media (max-width: 500px) {
      .form-panel {
        padding: 2rem 1.5rem;
      }
      .brand-stats {
        gap: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="brand-panel animate-fade">
    <div class="brand-logo">
      <div class="logo-icon">
        <!-- Icon gelas kopi yang lebih bagus dan modern -->
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
          <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
          <line x1="6" y1="1" x2="6" y2="4"/>
          <line x1="10" y1="1" x2="10" y2="4"/>
          <line x1="14" y1="1" x2="14" y2="4"/>
        </svg>
      </div>
      <span class="logo-text">NONGKI</span>
    </div>

    <div class="brand-content">
      <h1 class="brand-title">
        Your perfect cup,<br>
        <em>always waiting.</em>
      </h1>
      <p class="brand-description">
        Pesan kopi favoritmu kapan saja. Nikmati pengalaman nongkrong yang lebih simpel.
      </p>
      <div class="brand-stats">
        <div class="stat-item">
          <div class="stat-number">50+</div>
          <div class="stat-label">MENU</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">4.9</div>
          <div class="stat-label">RATING</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">10K+</div>
          <div class="stat-label">PELANGGAN</div>
        </div>
      </div>
    </div>

    <div class="brand-footer">
      <span>© 2026 NONGKI Coffee</span>
      <span>Privasi · Syarat</span>
    </div>
  </div>

  <div class="form-panel">
    <div class="auth-tabs animate-slide delay-1">
      <a href="{{ route('login') }}" class="auth-tab active">Masuk</a>
      <a href="{{ route('register') }}" class="auth-tab">Daftar</a>
    </div>

    <div class="form-header animate-slide delay-2">
      <h2 class="form-title">Selamat Datang Kembali</h2>
      <p class="form-subtitle">Masuk ke akunmu untuk memesan</p>
    </div>

    @if ($errors->any())
    <div class="error-message animate-slide delay-3">
      <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
      @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
      @endforeach
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST" id="loginForm">
      @csrf

      <div class="form-group animate-slide delay-3">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrapper">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="3" />
            <path d="m2 7 10 7 10-7" />
          </svg>
          <input type="email" id="email" name="email" placeholder="melanggan@nongki.com" value="{{ old('email') }}"
            required autocomplete="email">
        </div>
      </div>

      <div class="form-group animate-slide delay-4">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrapper">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
          </svg>
          <input type="password" id="password" name="password" placeholder="••••••••" required
            autocomplete="current-password">
          <span class="toggle-password" onclick="togglePassword('password', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          </span>
        </div>
      </div>

      <div class="form-options animate-slide delay-5">
        <label class="checkbox-wrapper">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <span class="checkmark"></span>
          <span class="checkbox-label">Ingat saya</span>
        </label>
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
        @endif
      </div>

      <button type="submit" class="btn-submit animate-slide delay-6">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
          <polyline points="10 17 15 12 10 7" />
          <line x1="15" y1="12" x2="3" y2="12" />
        </svg>
        Masuk Sekarang
      </button>
    </form>

    <div class="divider animate-slide delay-6">
      <div class="divider-line"></div>
      <span class="divider-text">atau masuk dengan</span>
      <div class="divider-line"></div>
    </div>

    <a href="{{ route('google.login') }}" class="btn-google animate-slide delay-6">
      <svg width="18" height="18" viewBox="0 0 24 24">
        <path fill="#4285F4"
          d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
        <path fill="#34A853"
          d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
        <path fill="#FBBC05"
          d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
        <path fill="#EA4335"
          d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
      </svg>
      Lanjutkan dengan Google
    </a>

    <p class="form-footer animate-slide delay-6">
      Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>
  </div>

  <script>
    function togglePassword(id, element) {
      const input = document.getElementById(id);
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;
      element.style.color = type === 'text' ? 'var(--gold)' : 'var(--text-muted)';
      
      // Update icon
      const svg = element.querySelector('svg');
      if (type === 'text') {
        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><line x1="3" y1="3" x2="21" y2="21"/><circle cx="12" cy="12" r="3"/>';
      } else {
        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
      }
    }
  </script>
</body>

</html>