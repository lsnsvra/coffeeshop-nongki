<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — NONGKI Coffee</title>
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
    --surface: #1A1A1A;
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
    --error: #E05252;
    --success: #52B788;
  }

  [data-theme="light"] {
    --bg: #F5F0E8;
    --surface: #F0EBE1;
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
    --error: #C0392B;
    --success: #27794A;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text-1);
    min-height: 100vh;
    display: flex;
    transition: background var(--transition), color var(--transition);
  }

  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

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

  .logo-icon svg { width: 26px; height: 26px; color: #0A0A0A; }

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

  .benefits { display: flex; flex-direction: column; gap: .7rem; }
  .benefit-item { display: flex; align-items: center; gap: .75rem; }

  .benefit-icon {
    width: 28px;
    height: 28px;
    background: rgba(201, 168, 76, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .benefit-icon svg { width: 14px; height: 14px; color: var(--gold); }
  .benefit-text { font-size: .84rem; color: rgba(255, 255, 255, 0.68); }

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
    width: 550px;
    background: var(--panel-bg);
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Mengubah center ke flex-start agar sejajar dari atas */
    padding: 3.5rem 2.75rem 2.75rem 2.75rem; /* Memberikan ruang ideal di atas */
    position: relative;
    overflow-y: auto;
    border-left: 1px solid var(--border);
    box-shadow: var(--shadow);
    transition: background var(--transition), border-color var(--transition);
  }

  .form-panel::-webkit-scrollbar { width: 3px; }
  .form-panel::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

  /* NAVIGATION / TOP CONTROL OVERLAYS */
  .panel-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }

  .sys-badge {
    font-size: .68rem;
    color: var(--text-3);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: .35rem .75rem;
    display: flex;
    align-items: center;
    gap: .35rem;
    cursor: pointer;
    transition: all var(--transition);
  }

  .sys-badge:hover { border-color: var(--gold); color: var(--gold); }
  .sys-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }

  .theme-toggle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 1px solid var(--border-strong);
    background: var(--surface);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition);
    font-size: 14px;
  }

  .theme-toggle:hover { border-color: var(--gold); background: var(--gold-dim); }

  /* TABS */
  .auth-tabs {
    display: flex;
    gap: .4rem;
    background: var(--tab-bg);
    padding: .45rem;
    border-radius: 13px;
    margin-bottom: 1.5rem;
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
  .form-header { margin-bottom: 1.5rem; }
  .form-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 400;
    color: var(--text-1);
    margin-bottom: .25rem;
    transition: color var(--transition);
  }
  .form-subtitle { font-size: .83rem; color: var(--text-3); }

  /* INPUTS */
  .form-group { margin-bottom: 1rem; position: relative; }
  .form-label {
    display: block;
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-2);
    margin-bottom: .4rem;
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
    padding: .78rem .95rem .78rem 2.6rem;
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

  /* PASSWORD STRENGTH (Optimized Space) */
  .strength-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 6px;
  }
  .strength-bar { display: flex; gap: 3px; width: 80px; }
  .strength-segment {
    flex: 1;
    height: 3px;
    background: var(--border-strong);
    border-radius: 2px;
    transition: all var(--transition);
  }
  .strength-segment.weak { background: #E05252; }
  .strength-segment.fair { background: #E09F3E; }
  .strength-segment.good { background: #70B8FF; }
  .strength-segment.strong { background: #52B788; }
  .strength-text { font-size: .7rem; color: var(--text-3); }

  /* TERMS */
  .terms-wrap {
    display: flex;
    align-items: flex-start;
    gap: .7rem;
    margin: 1.25rem 0;
    cursor: pointer;
    user-select: none;
  }
  .terms-wrap input { display: none; }
  .terms-check {
    width: 17px;
    height: 17px;
    border: 1.5px solid var(--border-strong);
    border-radius: 5px; 
    background: var(--input-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
    transition: all var(--transition);
  }

  .terms-wrap input:checked + .terms-check { background: var(--gold); border-color: var(--gold); }
  .terms-wrap input:checked + .terms-check::after {
    content: '';
    width: 9px;
    height: 5px;
    border-left: 2px solid #0A0A0A;
    border-bottom: 2px solid #0A0A0A;
    transform: rotate(-45deg) translateY(-1px);
  }
  .terms-text { font-size: .8rem; color: var(--text-2); line-height: 1.45; }
  .terms-text a { color: var(--gold); text-decoration: none; }
  .terms-text a:hover { text-decoration: underline; }

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
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
    transition: left .5s ease;
  }
  .btn-submit:hover::before { left: 100%; }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 7px 22px rgba(201, 168, 76, 0.38); }

  .divider { display: flex; align-items: center; gap: .9rem; margin: 1.25rem 0; }
  .div-line { flex: 1; height: 1px; background: var(--border-strong); }
  .div-text { font-size: .68rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }

  .btn-google {
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
  }
  .btn-google:hover { border-color: var(--gold); background: var(--gold-dim); color: var(--text-1); transform: translateY(-1px); }

  .form-footer { text-align: center; margin-top: 1.25rem; font-size: .83rem; color: var(--text-3); }
  .form-footer a { color: var(--gold); text-decoration: none; font-weight: 500; transition: color var(--transition); }
  .form-footer a:hover { color: var(--gold-light); text-decoration: underline; }

  .error-box {
    background: rgba(224, 82, 82, 0.1);
    border: 1px solid rgba(224, 82, 82, 0.28);
    border-radius: 11px;
    padding: .7rem 1rem;
    margin-bottom: 1.25rem;
    color: var(--error);
    font-size: .83rem;
  }

  @media (max-width: 900px) { .brand-panel { display: none; } .form-panel { width: 100%; } }
  @media (max-width: 480px) { .form-panel { padding: 2rem 1.5rem; } }
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
      <h1 class="brand-title">Bergabung dan<br><em>mulai menikmati.</em></h1>
      <p class="brand-desc">Buat akunmu sekarang dan dapatkan pengalaman memesan kopi favorit yang lebih mudah dan menyenangkan.</p>
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

  <!-- FORM PANEL -->
  <div class="form-panel">
    <!-- CONTROLS CONTAINER -->
    <div class="panel-controls a-up d1">
      <div class="sys-badge" id="sysBadge" title="Klik untuk kembali ikuti sistem">
        <div class="sys-dot"></div>
        <span id="sysLabel">Ikut sistem</span>
      </div>
      <button class="theme-toggle" id="themeToggle" aria-label="Toggle tema">☀️</button>
    </div>

    <div class="auth-tabs a-up d1">
      <a href="{{ route('login') }}" class="auth-tab">Masuk</a>
      <a href="{{ route('register') }}" class="auth-tab active">Daftar</a>
    </div>

    <div class="form-header a-up d2">
      <h2 class="form-title">Buat Akun Baru</h2>
      <p class="form-subtitle">Isi data di bawah untuk memulai</p>
    </div>

    @if ($errors->any())
    <div class="error-box a-up d3">
      <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" id="registerForm">
      @csrf

      <div class="form-group a-up d3">
        <label class="form-label" for="name">Nama</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <input type="text" id="name" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" required autocomplete="name">
        </div>
      </div>

      <div class="form-group a-up d4">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="3"/>
            <path d="m2 7 10 7 10-7"/>
          </svg>
          <input type="email" id="email" name="email" placeholder="kamu@email.com" value="{{ old('email') }}" required autocomplete="email">
        </div>
      </div>

      <div class="form-group a-up d4">
        <label class="form-label" for="phone">Nomor HP</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6.5-6.5 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.56a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
          <input type="tel" id="phone" name="phone_number" placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" autocomplete="tel">
        </div>
      </div>

      <div class="form-group a-up d5">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required
            autocomplete="new-password" oninput="checkStrength(this.value)">
          <span class="eye-toggle" onclick="togglePwd('password', this)" id="eye1">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon1">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </span>
        </div>
        <div class="strength-container">
          <div class="strength-text" id="strength-label">Masukkan password</div>
          <div class="strength-bar">
            <div class="strength-segment" id="s1"></div>
            <div class="strength-segment" id="s2"></div>
            <div class="strength-segment" id="s3"></div>
            <div class="strength-segment" id="s4"></div>
          </div>
        </div>
      </div>

      <div class="form-group a-up d5">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrap">
          <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password"
            required autocomplete="new-password">
          <span class="eye-toggle" onclick="togglePwd('password_confirmation', this)" id="eye2">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </span>
        </div>
      </div>

      <label class="terms-wrap a-up d6">
        <input type="checkbox" name="terms" required>
        <span class="terms-check"></span>
        <span class="terms-text">
          Dengan mendaftar, saya menyetujui <a href="#">Syarat &amp; Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> NONGKI Coffee.
        </span>
      </label>

      <button type="submit" class="btn-submit a-up d6">
        <i class="fas fa-user-plus"></i>
        Buat Akun Sekarang
      </button>
    </form>

    <div class="divider a-up d6">
      <div class="div-line"></div>
      <span class="div-text">atau daftar dengan</span>
      <div class="div-line"></div>
    </div>

    <a href="{{ route('google.login') }}" class="btn-google a-up d6">
      <svg width="18" height="18" viewBox="0 0 24 24">
        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
      </svg>
      Daftar dengan Google
    </a>

    <p class="form-footer a-up d6">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </p>
  </div>

  <script>
  // THEME SYSTEM
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

  try {
    const saved = localStorage.getItem('nongki-theme');
    if (saved) { manual = true; applyTheme(saved, false); }
    else { applyTheme(getSysTheme(), true); }
  } catch(e) { applyTheme(getSysTheme(), true); }

  btn.addEventListener('click', () => {
    manual = true;
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    applyTheme(next, false);
    try { localStorage.setItem('nongki-theme', next); } catch(e) {}
  });

  sysBadge.addEventListener('click', () => {
    manual = false;
    try { localStorage.removeItem('nongki-theme'); } catch(e) {}
    applyTheme(getSysTheme(), true);
  });

  mq.addEventListener('change', e => {
    if (!manual) applyTheme(e.matches ? 'dark' : 'light', true);
  });

  // TOGGLE PASSWORD
  const pwdState = { password: false, password_confirmation: false };

  function togglePwd(id, el) {
    const inp = document.getElementById(id);
    pwdState[id] = !pwdState[id];
    inp.type = pwdState[id] ? 'text' : 'password';
    el.style.color = pwdState[id] ? 'var(--gold)' : 'var(--text-3)';
    const iconId = id === 'password' ? 'eyeIcon1' : 'eyeIcon2';
    document.getElementById(iconId).innerHTML = pwdState[id]
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><line x1="3" y1="3" x2="21" y2="21"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }

  // PASSWORD STRENGTH
  function checkStrength(val) {
    const segs = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    const label = document.getElementById('strength-label');

    if (!val) {
      segs.forEach(s => s.className = 'strength-segment');
      label.textContent = 'Masukkan password';
      label.style.color = '';
      return;
    }

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = ['weak', 'fair', 'good', 'strong'];
    const texts  = ['Sangat lemah', 'Cukup', 'Baik', 'Kuat'];
    const colors = ['#E05252', '#E09F3E', '#70B8FF', '#52B788'];

    segs.forEach((s, i) => {
      s.className = 'strength-segment' + (i < score ? ' ' + levels[score - 1] : '');
    });

    label.textContent = 'Kekuatan: ' + texts[score - 1];
    label.style.color = colors[score - 1];
  }
  </script>
</body>
</html>