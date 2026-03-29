<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'NONGKI — Coffee Shop')</title>

  {{-- Bootstrap 5 CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  {{-- Google Fonts: Playfair Display + DM Sans --}}
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <style>
  /* ═══════════════════════════════════════════
           CSS VARIABLES — NONGKI Design System
        ═══════════════════════════════════════════ */
  :root {
    --brown-900: #1C0F08;
    --brown-800: #2D1810;
    --brown-700: #4A2C17;
    --brown-600: #6B3F22;
    --brown-500: #8B5130;
    --brown-400: #A8683E;
    --brown-300: #C8894A;
    --brown-200: #DFB48A;
    --brown-100: #F2DFC9;
    --brown-50: #FBF5EE;

    --cream: #FEFAF5;
    --warm-gray: #8A7B72;
    --text-dark: #1C0F08;
    --text-mid: #4A3728;
    --text-soft: #8A7B72;

    --success: #2D7A4F;
    --danger: #C0392B;
    --warning: #D4860B;

    --sidebar-w: 260px;
    --header-h: 64px;

    --shadow-sm: 0 1px 3px rgba(28, 15, 8, .08);
    --shadow-md: 0 4px 16px rgba(28, 15, 8, .10);
    --shadow-lg: 0 8px 32px rgba(28, 15, 8, .14);

    --radius-sm: 8px;
    --radius-md: 14px;
    --radius-lg: 20px;
    --radius-xl: 28px;
  }

  /* ═══════════════════════════════════════════
           BASE
        ═══════════════════════════════════════════ */
  *,
  *::before,
  *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--text-dark);
    font-size: 14px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: var(--text-dark);
  }

  /* ═══════════════════════════════════════════
           HEADER / TOP NAVBAR
        ═══════════════════════════════════════════ */
  .app-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: var(--header-h);
    background: var(--brown-800);
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    z-index: 1050;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .25);
  }

  .header-brand {
    display: flex;
    align-items: center;
    gap: .75rem;
    text-decoration: none;
    width: var(--sidebar-w);
    flex-shrink: 0;
  }

  .header-brand-icon {
    width: 36px;
    height: 36px;
    background: var(--brown-300);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #fff;
    flex-shrink: 0;
  }

  .header-brand-text {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    font-size: 1.2rem;
    color: #fff;
    letter-spacing: .02em;
  }

  .header-brand-sub {
    font-size: .65rem;
    color: var(--brown-200);
    font-weight: 400;
    letter-spacing: .05em;
    text-transform: uppercase;
    line-height: 1;
    margin-top: 1px;
  }

  .header-middle {
    flex: 1;
    padding: 0 1.5rem;
  }

  .header-search {
    position: relative;
    max-width: 380px;
  }

  .header-search input {
    width: 100%;
    background: rgba(255, 255, 255, .1);
    border: 1px solid rgba(255, 255, 255, .15);
    border-radius: 50px;
    padding: .45rem 1rem .45rem 2.5rem;
    color: #fff;
    font-size: .85rem;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: all .2s;
  }

  .header-search input::placeholder {
    color: rgba(255, 255, 255, .45);
  }

  .header-search input:focus {
    background: rgba(255, 255, 255, .18);
    border-color: var(--brown-300);
  }

  .header-search i {
    position: absolute;
    left: .85rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, .5);
    font-size: .9rem;
  }

  .header-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .header-btn {
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, .1);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 10px;
    color: rgba(255, 255, 255, .8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    text-decoration: none;
  }

  .header-btn:hover {
    background: rgba(255, 255, 255, .2);
    color: #fff;
  }

  .header-btn .badge-dot {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 8px;
    height: 8px;
    background: var(--brown-300);
    border-radius: 50%;
    border: 2px solid var(--brown-800);
  }

  .header-avatar {
    width: 38px;
    height: 38px;
    background: var(--brown-300);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
    border: 2px solid rgba(255, 255, 255, .2);
  }

  /* ═══════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════ */
  .app-sidebar {
    position: fixed;
    top: var(--header-h);
    left: 0;
    width: var(--sidebar-w);
    height: calc(100vh - var(--header-h));
    background: var(--brown-900);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1040;
    border-right: 1px solid rgba(255, 255, 255, .05);
  }

  .sidebar-section {
    padding: 1.25rem 1rem .5rem;
  }

  .sidebar-section-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--brown-400);
    padding: 0 .5rem;
    margin-bottom: .4rem;
  }

  .nav-item-custom {
    list-style: none;
  }

  .nav-link-custom {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .6rem .75rem;
    border-radius: var(--radius-sm);
    color: rgba(255, 255, 255, .6);
    text-decoration: none;
    font-size: .88rem;
    font-weight: 500;
    transition: all .18s;
    position: relative;
    margin-bottom: 2px;
  }

  .nav-link-custom:hover {
    background: rgba(255, 255, 255, .07);
    color: rgba(255, 255, 255, .95);
  }

  .nav-link-custom.active {
    background: var(--brown-700);
    color: #fff;
  }

  .nav-link-custom.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    bottom: 20%;
    width: 3px;
    background: var(--brown-300);
    border-radius: 0 3px 3px 0;
  }

  .nav-link-custom i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
  }

  .nav-link-custom .nav-badge {
    margin-left: auto;
    background: var(--brown-300);
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    padding: .1rem .45rem;
    border-radius: 50px;
  }

  /* Sidebar divider */
  .sidebar-divider {
    height: 1px;
    background: rgba(255, 255, 255, .06);
    margin: .5rem 1rem;
  }

  /* Sidebar bottom user card */
  .sidebar-user {
    margin-top: auto;
    padding: 1rem;
    border-top: 1px solid rgba(255, 255, 255, .06);
  }

  .sidebar-user-card {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .65rem .75rem;
    border-radius: var(--radius-sm);
    background: rgba(255, 255, 255, .05);
  }

  .sidebar-user-avatar {
    width: 34px;
    height: 34px;
    background: var(--brown-300);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
  }

  .sidebar-user-name {
    font-size: .85rem;
    font-weight: 600;
    color: #fff;
    line-height: 1.2;
  }

  .sidebar-user-role {
    font-size: .7rem;
    color: var(--brown-300);
    text-transform: capitalize;
  }

  .sidebar-user-logout {
    margin-left: auto;
    color: rgba(255, 255, 255, .4);
    font-size: 1rem;
    cursor: pointer;
    transition: color .2s;
    background: none;
    border: none;
    padding: 0;
  }

  .sidebar-user-logout:hover {
    color: #ff6b6b;
  }

  /* ═══════════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════════ */
  .app-main {
    margin-left: var(--sidebar-w);
    margin-top: var(--header-h);
    min-height: calc(100vh - var(--header-h));
    padding: 2rem;
  }

  /* Page header inside content */
  .page-header {
    margin-bottom: 1.75rem;
  }

  .page-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: .25rem;
  }

  .page-subtitle {
    font-size: .88rem;
    color: var(--text-soft);
    font-weight: 400;
  }

  .page-breadcrumb {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .78rem;
    color: var(--text-soft);
    margin-bottom: .5rem;
  }

  .page-breadcrumb a {
    color: var(--brown-500);
    text-decoration: none;
  }

  .page-breadcrumb a:hover {
    color: var(--brown-700);
  }

  /* ═══════════════════════════════════════════
           CARDS
        ═══════════════════════════════════════════ */
  .card {
    background: #fff;
    border: 1px solid rgba(28, 15, 8, .07);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
  }

  .card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(28, 15, 8, .06);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
  }

  .card-title {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
  }

  .card-body {
    padding: 1.25rem;
  }

  /* Stat card */
  .stat-card {
    background: #fff;
    border: 1px solid rgba(28, 15, 8, .07);
    border-radius: var(--radius-md);
    padding: 1.25rem;
    box-shadow: var(--shadow-sm);
    transition: transform .2s, box-shadow .2s;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  .stat-icon {
    width: 46px;
    height: 46px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    margin-bottom: .9rem;
  }

  .stat-label {
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-soft);
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: .3rem;
  }

  .stat-value {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1;
  }

  .stat-change {
    font-size: .75rem;
    font-weight: 600;
    margin-top: .4rem;
  }

  .stat-change.up {
    color: var(--success);
  }

  .stat-change.down {
    color: var(--danger);
  }

  /* ═══════════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════════ */
  .btn-primary-custom {
    background: var(--brown-700);
    color: #fff;
    border: none;
    padding: .55rem 1.25rem;
    border-radius: var(--radius-sm);
    font-size: .875rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
  }

  .btn-primary-custom:hover {
    background: var(--brown-800);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(74, 44, 23, .3);
  }

  .btn-outline-custom {
    background: transparent;
    color: var(--brown-700);
    border: 1.5px solid var(--brown-300);
    padding: .5rem 1.2rem;
    border-radius: var(--radius-sm);
    font-size: .875rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
  }

  .btn-outline-custom:hover {
    background: var(--brown-50);
    border-color: var(--brown-500);
    color: var(--brown-800);
  }

  .btn-ghost {
    background: transparent;
    color: var(--text-soft);
    border: none;
    padding: .45rem .85rem;
    border-radius: var(--radius-sm);
    font-size: .875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .18s;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
  }

  .btn-ghost:hover {
    background: var(--brown-50);
    color: var(--text-dark);
  }

  /* ═══════════════════════════════════════════
           BADGES
        ═══════════════════════════════════════════ */
  .badge-custom {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .25rem .7rem;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .02em;
  }

  .badge-success {
    background: #D4EDDA;
    color: var(--success);
  }

  .badge-warning {
    background: #FFF3CD;
    color: var(--warning);
  }

  .badge-danger {
    background: #FDDDDB;
    color: var(--danger);
  }

  .badge-info {
    background: var(--brown-100);
    color: var(--brown-700);
  }

  /* ═══════════════════════════════════════════
           TABLE
        ═══════════════════════════════════════════ */
  .table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .table-custom thead tr th {
    padding: .75rem 1rem;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--text-soft);
    background: var(--brown-50);
    border-bottom: 1px solid rgba(28, 15, 8, .07);
  }

  .table-custom tbody tr td {
    padding: .9rem 1rem;
    border-bottom: 1px solid rgba(28, 15, 8, .05);
    font-size: .875rem;
    color: var(--text-dark);
    vertical-align: middle;
  }

  .table-custom tbody tr:last-child td {
    border-bottom: none;
  }

  .table-custom tbody tr:hover td {
    background: var(--brown-50);
  }

  /* ═══════════════════════════════════════════
           FORMS
        ═══════════════════════════════════════════ */
  .form-label-custom {
    font-size: .8rem;
    font-weight: 700;
    color: var(--text-mid);
    margin-bottom: .4rem;
    display: block;
    letter-spacing: .02em;
  }

  .form-control-custom {
    width: 100%;
    padding: .6rem .9rem;
    border: 1.5px solid rgba(28, 15, 8, .12);
    border-radius: var(--radius-sm);
    font-size: .875rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-dark);
    background: #fff;
    outline: none;
    transition: all .18s;
  }

  .form-control-custom:focus {
    border-color: var(--brown-400);
    box-shadow: 0 0 0 3px rgba(200, 137, 74, .15);
  }

  /* ═══════════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════════ */
  .alert-custom {
    padding: .85rem 1.1rem;
    border-radius: var(--radius-sm);
    font-size: .875rem;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    border: 1px solid transparent;
  }

  .alert-success-custom {
    background: #D4EDDA;
    border-color: #A8D5B5;
    color: var(--success);
  }

  .alert-danger-custom {
    background: #FDDDDB;
    border-color: #F5B5B1;
    color: var(--danger);
  }

  .alert-warning-custom {
    background: #FFF3CD;
    border-color: #FFE38A;
    color: var(--warning);
  }

  /* ═══════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════ */
  .app-footer {
    margin-left: var(--sidebar-w);
    padding: 1.25rem 2rem;
    border-top: 1px solid rgba(28, 15, 8, .07);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .78rem;
    color: var(--text-soft);
  }

  .footer-brand {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-weight: 600;
    color: var(--brown-600);
  }

  /* ═══════════════════════════════════════════
           RESPONSIVE — Mobile sidebar toggle
        ═══════════════════════════════════════════ */
  .sidebar-toggle {
    display: none;
    background: none;
    border: none;
    color: rgba(255, 255, 255, .8);
    font-size: 1.3rem;
    cursor: pointer;
    margin-right: .5rem;
  }

  @media (max-width: 991px) {
    .sidebar-toggle {
      display: block;
    }

    .app-sidebar {
      transform: translateX(-100%);
      transition: transform .25s ease;
    }

    .app-sidebar.show {
      transform: translateX(0);
    }

    .app-main,
    .app-footer {
      margin-left: 0;
    }

    .header-brand {
      width: auto;
    }

    .header-search {
      display: none;
    }
  }

  /* ═══════════════════════════════════════════
           SCROLLBAR
        ═══════════════════════════════════════════ */
  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }

  ::-webkit-scrollbar-track {
    background: transparent;
  }

  ::-webkit-scrollbar-thumb {
    background: var(--brown-200);
    border-radius: 3px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: var(--brown-300);
  }
  </style>

  @stack('styles')
</head>

<body>

  {{-- ══════════════════════════════════════
         HEADER (Always renders)
    ══════════════════════════════════════ --}}
  <header class="app-header">
    {{-- Mobile toggle --}}
    <button class="sidebar-toggle" id="sidebarToggle">
      <i class="bi bi-list"></i>
    </button>

    {{-- Brand / Logo --}}
    <a href="{{ route('menu.index') }}" class="header-brand">
      <div class="header-brand-icon">
        <i class="bi bi-cup-hot-fill"></i>
      </div>
      <div>
        <div class="header-brand-text">NONGKI</div>
        <div class="header-brand-sub">Coffee Shop</div>
      </div>
    </a>

    {{-- Search --}}
    <div class="header-middle">
      <div class="header-search">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Cari menu, order...">
      </div>
    </div>

    {{-- Actions --}}
    <div class="header-actions">
      {{-- Cart (pelanggan) --}}
      @auth
      @if(Auth::user()->role === 'pelanggan')
      <a href="{{ route('cart.index') }}" class="header-btn">
        <i class="bi bi-cart3"></i>
        @if(count(session('cart', [])) > 0)
        <span class="badge-dot"></span>
        @endif
      </a>
      @endif
      @endauth

      {{-- Notifikasi --}}
      <button class="header-btn">
        <i class="bi bi-bell"></i>
        <span class="badge-dot"></span>
      </button>

      {{-- User Dropdown --}}
      @auth
      <div class="dropdown">
        <div class="header-avatar" data-bs-toggle="dropdown">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
          style="border-radius:var(--radius-md);min-width:200px;">
          <li class="px-3 py-2">
            <div style="font-weight:700;font-size:.9rem;">{{ Auth::user()->name }}</div>
            <div style="font-size:.75rem;color:var(--text-soft);text-transform:capitalize;">{{ Auth::user()->role }}
            </div>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="{{ route('order.history') }}"><i
                class="bi bi-clock-history me-2"></i>Riwayat Order</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
            </form>
          </li>
        </ul>
      </div>
      @else
      <a href="{{ route('login') }}" class="btn-primary-custom"
        style="border-radius:50px;padding:.4rem 1rem;font-size:.8rem;">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </a>
      @endauth
    </div>
  </header>

  {{-- ══════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════ --}}
  <aside class="app-sidebar" id="appSidebar">

    {{-- ── PELANGGAN MENU ── --}}
    @auth
    @if(Auth::user()->role === 'pelanggan')
    <div class="sidebar-section">
      <div class="sidebar-section-label">Menu</div>
      <ul style="list-style:none;padding:0;margin:0;">
        <li class="nav-item-custom">
          <a href="{{ route('menu.index') }}"
            class="nav-link-custom {{ request()->routeIs('menu.*') ? 'active' : '' }}">
            <i class="bi bi-cup-hot"></i> Menu Kopi
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('cart.index') }}"
            class="nav-link-custom {{ request()->routeIs('cart.*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i> Keranjang
            @if(count(session('cart', [])) > 0)
            <span class="nav-badge">{{ count(session('cart', [])) }}</span>
            @endif
            @endauth
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('order.history') }}"
            class="nav-link-custom {{ request()->routeIs('order.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Order
          </a>
        </li>
      </ul>
    </div>

    {{-- ── MANAGER / ADMIN MENU ── --}}
    @if(in_array((Auth::user()->role ?? ''), ['manager', 'admin']))
    <div class="sidebar-section">
      <div class="sidebar-section-label">Overview</div>
      <ul style="list-style:none;padding:0;margin:0;">
        <li class="nav-item-custom">
          <a href="{{ route('manager.dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('manager.laporan') }}"
            class="nav-link-custom {{ request()->routeIs('manager.laporan*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Laporan
          </a>
        </li>
      </ul>
    </div>
    <div class="sidebar-divider"></div>
    <div class="sidebar-section">
      <div class="sidebar-section-label">Manajemen</div>
      <ul style="list-style:none;padding:0;margin:0;">
        <li class="nav-item-custom">
          <a href="{{ route('manager.products.index') }}"
            class="nav-link-custom {{ request()->routeIs('manager.products.index') || request()->routeIs('manager.products.create') || request()->routeIs('manager.products.edit') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produk
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('manager.products.trash') }}"
            class="nav-link-custom {{ request()->routeIs('manager.products.trash') ? 'active' : '' }}">
            <i class="bi bi-trash"></i> Sampah
          </a>
        </li>
      </ul>
    </div>
    @endif

    {{-- ── KASIR MENU ── --}}
    @if(Auth::user()->role === 'kasir')
    <div class="sidebar-section">
      <div class="sidebar-section-label">Kasir</div>
      <ul style="list-style:none;padding:0;margin:0;">
        <li class="nav-item-custom">
          <a href="{{ route('kasir.dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Order Masuk
          </a>
        </li>
      </ul>
    </div>
    @endif
    @endauth

    {{-- ── GUEST ── --}}
    @guest
    <div class="sidebar-section">
      <ul style="list-style:none;padding:0;margin:0;">
        <li class="nav-item-custom">
          <a href="{{ route('menu.index') }}"
            class="nav-link-custom {{ request()->routeIs('menu.*') ? 'active' : '' }}">
            <i class="bi bi-cup-hot"></i> Menu Kopi
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('login') }}" class="nav-link-custom">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        </li>
        <li class="nav-item-custom">
          <a href="{{ route('register') }}" class="nav-link-custom">
            <i class="bi bi-person-plus"></i> Daftar
          </a>
        </li>
      </ul>
    </div>
    @endguest

    {{-- ── USER CARD (bottom) ── --}}
    @auth
    <div class="sidebar-user">
      <div class="sidebar-user-card">
        <div class="sidebar-user-avatar">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
          <div class="sidebar-user-name">{{ Str::limit(Auth::user()->name, 16) }}</div>
          <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" class="sidebar-user-logout" title="Logout">
            <i class="bi bi-box-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
    @endauth

  </aside>

  {{-- ══════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════ --}}
  <main class="app-main">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert-custom alert-success-custom mb-4">
      <i class="bi bi-check-circle-fill" style="margin-top:1px;flex-shrink:0;"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-custom alert-danger-custom mb-4">
      <i class="bi bi-exclamation-circle-fill" style="margin-top:1px;flex-shrink:0;"></i>
      <span>{{ session('error') }}</span>
    </div>
    @endif

    @if(session('info'))
    <div class="alert-custom alert-warning-custom mb-4">
      <i class="bi bi-info-circle-fill" style="margin-top:1px;flex-shrink:0;"></i>
      <span>{{ session('info') }}</span>
    </div>
    @endif

    {{-- PAGE CONTENT --}}
    @yield('content')

  </main>

  {{-- ══════════════════════════════════════
         FOOTER
    ══════════════════════════════════════ --}}
  <footer class="app-footer">
    <div class="footer-brand">
      <i class="bi bi-cup-hot-fill"></i>
      NONGKI Coffee Shop
    </div>
    <div>
      &copy; {{ date('Y') }} &mdash; Kelompok 1 Pemrograman Web 2
    </div>
    <div>
      Dibuat dengan <i class="bi bi-heart-fill" style="color:var(--brown-400);"></i> oleh Tim NONGKI
    </div>
  </footer>

  {{-- Bootstrap 5 JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Sidebar toggle (mobile)
  const toggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('appSidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', () => sidebar.classList.toggle('show'));
    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.remove('show');
      }
    });
  }

  // Auto-dismiss alerts
  setTimeout(() => {
    document.querySelectorAll('.alert-custom').forEach(el => {
      el.style.transition = 'opacity .5s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 500);
    });
  }, 4000);
  </script>

  @stack('scripts')
</body>

</html>