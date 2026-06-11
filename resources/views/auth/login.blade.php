<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — NONGKI Coffee</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    --transition: 0.3s ease;
  }

  [data-theme="dark"] {
    --bg: #0A0A0A;
    --card: #111111;
    --surface: #1A1A1A;
    --elevated: #222222;
    --text-1: #FFFFFF;
    --text-2: rgba(255, 255, 255, 0.7);
    --text-3: rgba(255, 255, 255, 0.45);
    --border: rgba(255, 255, 255, 0.09);
    --border-strong: rgba(255, 255, 255, 0.18);
    --input-bg: #1A1A1A;
    --panel-bg: rgba(17, 17, 17, 0.97);
    --tab-bg: #1A1A1A;
    --shadow: 0 2px 16px rgba(0, 0, 0, 0.5);
    --brand-overlay: linear-gradient(135deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.8) 100%);
  }

  [data-theme="light"] {
    --bg: #F5F0E8;
    --card: #FFFFFF;
    --surface: #F0EBE1;
    --elevated: #E8E2D8;
    --text-1: #1A1208;
    --text-2: rgba(26, 18, 8, 0.65);
    --text-3: rgba(26, 18, 8, 0.42);
    --border: rgba(26, 18, 8, 0.1);
    --border-strong: rgba(26, 18, 8, 0.22);
    --input-bg: #FFFFFF;
    --panel-bg: rgba(255, 255, 255, 0.98);
    --tab-bg: #EDE7DB;
    --shadow: 0 2px 16px rgba(160, 130, 60, 0.10);
    --brand-overlay: linear-gradient(135deg, rgba(15, 10, 5, 0.42) 0%, rgba(15, 10, 5, 0.78) 100%);
  }

  @media (prefers-color-scheme: light) {
    html:not([data-theme]) {
      --bg: #F5F0E8;
      --card: #FFFFFF;
      --surface: #F0EBE1;
      --elevated: #E8E2D8;
      --text-1: #1A1208;
      --text-2: rgba(26, 18, 8, 0.65);
      --text-3: rgba(26, 18, 8, 0.42);
      --border: rgba(26, 18, 8, 0.1);
      --border-strong: rgba(26, 18, 8, 0.22);
      --input-bg: #FFFFFF;
      --panel-bg: rgba(255, 255, 255, 0.98);
      --tab-bg: #EDE7DB;
      --shadow: 0 2px 16px rgba(160, 130, 60, 0.10);
      --brand-overlay: linear-gradient(135deg, rgba(15, 10, 5, 0.42) 0%, rgba(15, 10, 5, 0.78) 100%);
    }
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text-1);
    min-height: 100vh;
    display: flex;
    transition: background var(--transition), color var(--transition);
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .a-fade { animation: fadeIn 0.7s ease forwards; }
  .a-up { animation: slideUp 0.55s ease forwards; opacity: 0; }
  .d1 { animation-delay: .05s; }
  .d2 { animation-delay: .1s; }
  .d3 { animation-delay: .15s; }
  .d4 { animation-delay: .2s; }
  .d5 { animation-delay: .25s; }
  .d6 { animation-delay: .3s; }

  /* BRAND PANEL */
  .brand-panel {
    flex: 1;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 2.5rem;
    background: var(--brand-overlay), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80');
    background-size: cover;
    background-position: center;
  }

  .brand-panel::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 30% 55%, rgba(201, 168, 76, 0.09) 0%, transparent 65%);
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
    width: 50px;
    height: 50px;
    background: linear-gradient(145deg, var(--gold), var(--gold-dark));
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(201, 168, 76, 0.28);
  }

  .logo-icon svg {
    width: 26px;
    height: 26px;
    color: #0A0A0A;
  }

  .logo-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 600;
    letter-spacing: .1em;
    background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .brand-content {
    position: relative;
    z-index: 2;
    max-width: 380px;
  }

  .brand-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    font-weight: 400;
    line-height: 1.2;
    margin-bottom: .9rem;
    color: #fff;
  }

  .brand-title em {
    font-style: italic;
    color: var(--gold);
    position: relative;
  }

  .brand-title em::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), transparent);
  }

  .brand-desc {
    font-size: .9rem;
    color: rgba(255, 255, 255, 0.68);
    line-height: 1.65;
    margin-bottom: 1.75rem;
  }

  .brand-stats { display: flex; gap: 2.2rem; }

  .stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .stat-label {
    font-size: .68rem;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: rgba(255, 255, 255, 0.45);
    margin-top: .2rem;
  }

  .brand-footer {
    position: relative;
    z-index: 2;
    font-size: .72rem;
    color: rgba(255, 255, 255, 0.38);
    display: flex;
    justify-content: space-between;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1.25rem;
  }

  /* FORM PANEL */
  .form-panel {
    width: 510px;
    background: var(--panel-bg);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2.75rem;
    position: relative;
    overflow-y: auto;
    border-left: 1px solid var(--border);
    box-shadow: var(--shadow);
    transition: background var(--transition), border-color var(--transition);
  }

  .form-panel::-webkit-scrollbar { width: 3px; }
  .form-panel::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

  /* THEME TOGGLE */
  .theme-toggle {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid var(--border-strong);
    background: var(--surface);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition);
    color: var(--text-2);
    font-size: 16px;
  }

  .theme-toggle:hover {
    border-color: var(--gold);
    color: var(--gold);
    background: var(--gold-dim);
  }

  /* SYSTEM BADGE */
  .sys-badge {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    font-size: .68rem;
    color: var(--text-3);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: .25rem .65rem;
    display: flex;
    align-items: center;
    gap: .35rem;
    cursor: pointer;
    transition: all var(--transition);
  }

  .sys-badge:hover { border-color: var(--gold); color: var(--gold); }

  .sys-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--gold);
    flex-shrink: 0;
  }

  /* TABS */
  .auth-tabs {
    display: flex;
    gap: .4rem;
    background: var(--tab-bg);
    padding: .45rem;
    border-radius: 13px;
    margin-bottom: 1.75rem;
    transition: background var(--transition);
  }

  .auth-tab {
    flex: 1;
    text-align: center;
    padding: .68rem;
    border-radius: 9px;
    text-decoration: none;
    color: var(--text-2);
    font-weight: 500;
    font-size: .88rem;
    transition: all var(--transition);
  }

  .auth-tab.active {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: #0A0A0A;
    font-weight: 600;
    box-shadow: 0 3px 12px rgba(201, 168, 76, 0.28);
  }

  .auth-tab:not(.active):hover { color: var(--gold); }

  /* FORM HEADER */
  .form-header { margin-bottom: 1.75rem; }

  .form-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 400;
    color: var(--text-1);
    margin-bottom: .35rem;
    transition: color var(--transition);
  }

  .form-subtitle { font-size: .83rem; color: var(--text-3); }

  /* INPUTS */
  .form-group { margin-bottom: 1.1rem; }

  .form-label {
    display: block;
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-2);
    margin-bottom: .45rem;
  }

  .input-wrap { position: relative; }

  .input-icon {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    width: 17px;
    height: 17px;
    color: var(--text-3);
    transition: color var(--transition);
    pointer-events: none;
  }

  .input-wrap input {
    width: 100%;
    padding: .82rem .95rem .82rem 2.6rem;
    background: var(--input-bg);
    border: 1px solid var(--border-strong);
    border-radius: 11px;
    color: var(--text-1);
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem;
    transition: all var(--transition);
  }

  .input-wrap input:focus {
    outline: none;
    border-color: var(--gold);
    box-shadow: 0 0 0 3px var(--gold-dim);
  }

  .input-wrap input:focus ~ .input-icon { color: var(--gold); }
  .input-wrap input::placeholder { color: var(--text-3); }

  .eye-toggle {
    position: absolute;
    right: .9rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--text-3);
    transition: color var(--transition);
  }

  .eye-toggle:hover { color: var(--gold); }

  /* OPTIONS */
  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.35rem;
  }

  .check-wrap {
    display: flex;
    align-items: center;
    gap: .5rem;
    cursor: pointer;
    user-select: none;
  }

  .check-wrap input { display: none; }

  .checkmark {
    width: 17px;
    height: 17px;
    border: 1.5px solid var(--border-strong);
    border-radius: 5px;
    background: var(--input-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition);
    flex-shrink: 0;
  }

  .check-wrap input:checked + .checkmark {
    background: var(--gold);
    border-color: var(--gold);
  }

  .check-wrap input:checked + .checkmark::after {
    content: '';
    width: 9px;
    height: 5px;
    border-left: 2px solid #0A0A0A;
    border-bottom: 2px solid #0A0A0A;
    transform: rotate(-45deg) translateY(-1px);
  }

  .check-label { font-size: .83rem; color: var(--text-2); }

  .forgot {
    font-size: .83rem;
    color: var(--gold);
    text-decoration: none;
    transition: color var(--transition);
  }

  .forgot:hover { color: var(--gold-light); text-decoration: underline; }

  /* BUTTONS */
  .btn-submit {
    width: 100%;
    padding: .82rem;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    border: none;
    border-radius: 11px;
    color: #0A0A0A;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .92rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    transition: all var(--transition);
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
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
    transition: left .5s ease;
  }

  .btn-submit:hover::before { left: 100%; }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 22px rgba(201, 168, 76, 0.38);
  }

  .divider {
    display: flex;
    align-items: center;
    gap: .9rem;
    margin: 1.3rem 0;
  }

  .div-line { flex: 1; height: 1px; background: var(--border-strong); }
  .div-text { font-size: .68rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }

  .btn-social {
    width: 100%;
    padding: .78rem;
    background: transparent;
    border: 1px solid var(--border-strong);
    border-radius: 11px;
    color: var(--text-2);
    font-family: 'DM Sans', sans-serif;
    font-size: .87rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .65rem;
    transition: all var(--transition);
    text-decoration: none;
    margin-bottom: .65rem;
  }

  .btn-social:last-child { margin-bottom: 0; }

  .btn-social:hover {
    border-color: var(--gold);
    background: var(--gold-dim);
    color: var(--text-1);
    transform: translateY(-1px);
  }

  .form-footer {
    text-align: center;
    margin-top: 1.35rem;
    font-size: .83rem;
    color: var(--text-3);
  }

  .form-footer a {
    color: var(--gold);
    text-decoration: none;
    font-weight: 500;
    transition: color var(--transition);
  }

  .form-footer a:hover { color: var(--gold-light); text-decoration: underline; }

  .error-box {
    background: rgba(224, 82, 82, 0.1);
    border: 1px solid rgba(224, 82, 82, 0.28);
    border-radius: 11px;
    padding: .7rem 1rem;
    margin-bottom: 1.35rem;
    color: #E05252;
    font-size: .83rem;
  }

  @media (max-width: 860px) {
    .brand-panel { display: none; }
    .form-panel { width: 100%; }
  }

  @media (max-width: 480px) {
    .form-panel { padding: 2rem 1.5rem; }
  }
  </style>
</head>

<body>
  <!-- BRAND PANEL -->
  <div class="brand-panel a-fade">
    <div class="brand-logo">
      <div class="logo-icon">
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
      <h1 class="brand-title">Your perfect cup,<br><em>always waiting.</em></h1>
      <p class="brand-desc">Pesan kopi favoritmu kapan saja. Nikmati pengalaman nongkrong yang lebih simpel dan menyenangkan.</p>
      <div class="brand-stats">
        <div>
          <div class="stat-num">50+</div>
          <div class="stat-label">Menu</div>
        </div>
        <div>
          <div class="stat-num">4.9</div>
          <div class="stat-label">Rating</div>
        </div>
        <div>
          <div class="stat-num">10K+</div>
          <div class="stat-label">Pelanggan</div>
        </div>
      </div>
    </div>

    <div class="brand-footer">
      <span>© 2026 NONGKI Coffee</span>
      <span>Privasi · Syarat</span>
    </div>
  </div>

  <!-- FORM PANEL -->
  <div class="form-panel">
    <!-- Badge status tema (klik untuk reset ke sistem) -->
    <div class="sys-badge" id="sysBadge" title="Klik untuk kembali ikuti sistem">
      <div class="sys-dot"></div>
      <span id="sysLabel">Ikut sistem</span>
    </div>

    <!-- Tombol toggle tema -->
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle tema">☀️</button>

    <div class="auth-tabs a-up d1">
      <a href="{{ route('login') }}" class="auth-tab active">Masuk</a>
      <a href="{{ route('register') }}" class="auth-tab">Daftar</a>
    </div>

    <div class="form-header a-up d2">
      <h2 class="form-title">Selamat Datang Kembali</h2>
      <p class="form-subtitle">Masuk ke akunmu untuk memesan</p>
    </div>

    @if ($errors->any())
    <div class="error-box a-up d3">
      <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST" id="loginForm">
      @csrf

      <div class="form-group a-up d3">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="3"/>
            <path d="m2 7 10 7 10-7"/>
          </svg>
          <input type="email" id="email" name="email" placeholder="pelanggan@nongki.com"
            value="{{ old('email') }}" required autocomplete="email">
        </div>
      </div>

      <div class="form-group a-up d4">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="••••••••"
            required autocomplete="current-password">
          <span class="eye-toggle" onclick="togglePwd()" id="eyeBtn" title="Tampilkan/sembunyikan password">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </span>
        </div>
      </div>

      <div class="form-options a-up d5">
        <label class="check-wrap">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <span class="checkmark"></span>
          <span class="check-label">Ingat saya</span>
        </label>
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
        @endif
      </div>

      <button type="submit" class="btn-submit a-up d6">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        Masuk Sekarang
      </button>
    </form>

    <div class="divider a-up d6">
      <div class="div-line"></div>
      <span class="div-text">atau masuk dengan</span>
      <div class="div-line"></div>
    </div>

    <div class="a-up d6">
      <a href="{{ route('google.login') }}" class="btn-social">
        <svg width="18" height="18" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Lanjutkan dengan Google
      </a>

      <a href="{{ route('login.wa') }}" class="btn-social"
        onmouseover="this.style.borderColor='#25D366';this.style.color='#25D366'"
        onmouseout="this.style.borderColor='';this.style.color=''">
        <svg width="18" height="18" viewBox="0 0 16 16">
          <path fill="#25D366" d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
        </svg>
        Lanjutkan dengan WhatsApp
      </a>
    </div>

    <p class="form-footer a-up d6">
      Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>
  </div>

  <script>
  const html = document.documentElement;
  const btn = document.getElementById('themeToggle');
  const sysBadge = document.getElementById('sysBadge');
  const sysLabel = document.getElementById('sysLabel');
  const mq = window.matchMedia('(prefers-color-scheme: dark)');
  let manual = false;

  function applyTheme(theme, isSys) {
    html.setAttribute('data-theme', theme);
    btn.textContent = theme === 'dark' ? '☀️' : '🌙';
    btn.title = theme === 'dark' ? 'Ganti ke mode terang' : 'Ganti ke mode gelap';
    sysLabel.textContent = isSys ? 'Ikut sistem' : (theme === 'dark' ? 'Mode gelap' : 'Mode terang');
  }

  function getSysTheme() { return mq.matches ? 'dark' : 'light'; }

  // Init: cek localStorage dulu, kalau tidak ada ikut sistem
  try {
    const saved = localStorage.getItem('nongki-theme');
    if (saved) { manual = true; applyTheme(saved, false); }
    else { applyTheme(getSysTheme(), true); }
  } catch(e) { applyTheme(getSysTheme(), true); }

  // Toggle manual
  btn.addEventListener('click', () => {
    manual = true;
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    applyTheme(next, false);
    try { localStorage.setItem('nongki-theme', next); } catch(e) {}
  });

  // Klik badge = reset ke sistem
  sysBadge.addEventListener('click', () => {
    manual = false;
    try { localStorage.removeItem('nongki-theme'); } catch(e) {}
    applyTheme(getSysTheme(), true);
  });

  // Otomatis ikut sistem kalau belum manual
  mq.addEventListener('change', e => {
    if (!manual) applyTheme(e.matches ? 'dark' : 'light', true);
  });

  // Toggle password
  let pwdVisible = false;
  function togglePwd() {
    const inp = document.getElementById('password');
    const ic = document.getElementById('eyeIcon');
    pwdVisible = !pwdVisible;
    inp.type = pwdVisible ? 'text' : 'password';
    document.getElementById('eyeBtn').style.color = pwdVisible ? 'var(--gold)' : 'var(--text-3)';
    ic.innerHTML = pwdVisible
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><line x1="3" y1="3" x2="21" y2="21"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
  </script>
</body>

</html>

