<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NONGKI Coffee')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.12);
            --dark: #0F0C07;
            --dark-2: #1A1509;
            --dark-3: #241E10;
            --dark-4: #2F2615;
            --cream: #F5EDD8;
            --cream-dim: rgba(245,237,216,0.65);
            --text-muted-c: rgba(245,237,216,0.42);
            --border: rgba(201,168,76,0.18);
            --sidebar-w: 260px;
            --header-h: 64px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            margin: 0;
        }

        /* HEADER */
        .app-header {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--header-h);
            background: rgba(15,12,7,0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 1.5rem;
            z-index: 1000;
            gap: 1rem;
        }

        .header-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
            width: calc(var(--sidebar-w) - 1.5rem);
        }

        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(201,168,76,0.3);
        }

        .brand-icon svg { width: 18px; height: 18px; fill: var(--dark); }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem; font-weight: 600;
            letter-spacing: 0.1em;
            color: var(--gold-light);
        }

        .header-search {
            flex: 1; max-width: 400px;
            position: relative;
        }

        .header-search svg {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; color: var(--text-muted-c);
            pointer-events: none;
        }

        .header-search input {
            width: 100%;
            padding: 9px 12px 9px 38px;
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--cream);
            font-size: 0.875rem;
            outline: none;
        }

        .header-search input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .header-actions {
            margin-left: auto;
            display: flex; align-items: center; gap: 8px;
        }

        .header-btn {
            width: 38px; height: 38px;
            background: var(--dark-3); border: 1px solid var(--border);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: var(--cream-dim);
            transition: all 0.2s;
            position: relative;
            text-decoration: none;
        }

        .header-btn:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
        .header-btn svg { width: 18px; height: 18px; }

        .header-badge {
            position: absolute; top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--gold); border-radius: 50%;
        }

        .header-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 600;
            color: var(--dark); cursor: pointer;
            border: 2px solid var(--border);
            text-decoration: none;
        }

        .header-avatar:hover { border-color: var(--gold); }

        .sidebar-toggle {
            display: none;
            background: none; border: none;
            color: var(--cream-dim); cursor: pointer;
        }
        .sidebar-toggle svg { width: 22px; height: 22px; }

        /* SIDEBAR */
        .app-sidebar {
            position: fixed; top: var(--header-h); left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--dark-2);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 900;
        }

        .sidebar-section { padding: 1.2rem 1rem 0.5rem; }

        .sidebar-section-label {
            font-size: 0.68rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted-c);
            padding: 0 0.6rem;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 9px;
            color: var(--cream-dim);
            text-decoration: none;
            font-size: 0.88rem;
            transition: all 0.2s;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover {
            background: var(--gold-dim);
            color: var(--cream);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(201,168,76,0.18), rgba(201,168,76,0.08));
            color: var(--gold-light);
            border: 1px solid var(--border);
        }

        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: var(--dark);
            font-size: 0.68rem;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* USER CARD (hanya untuk yang login) */
        .sidebar-user {
            margin: auto 1rem 1rem;
            padding: 12px;
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .sidebar-user-info {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 10px;
        }

        .sidebar-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 600; color: var(--dark);
        }

        .sidebar-user-name { font-size: 0.88rem; font-weight: 500; color: var(--cream); }
        .sidebar-user-role { font-size: 0.75rem; color: var(--text-muted-c); }

        .btn-logout {
            width: 100%; padding: 8px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-muted-c);
            font-size: 0.82rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-logout:hover { border-color: #e05252; color: #e05252; background: rgba(224,82,82,0.08); }

        /* MAIN CONTENT */
        .app-main {
            margin-left: var(--sidebar-w);
            margin-top: var(--header-h);
            min-height: calc(100vh - var(--header-h));
        }

        .page-content {
            padding: 2rem;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark);
            border: none;
            border-radius: 9px;
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
        }

        .btn-gold:hover {
            box-shadow: 0 6px 18px rgba(201,168,76,0.35);
            transform: translateY(-1px);
        }

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 800;
        }

        @media (max-width: 992px) {
            .sidebar-toggle { display: flex; }
            .app-sidebar { transform: translateX(-100%); }
            .app-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .app-main { margin-left: 0; }
        }

        @media (max-width: 576px) {
            .page-content { padding: 1.2rem; }
            .header-search { display: none; }
        }

        @yield('styles')
    </style>
    @stack('styles')
</head>
<body>

    <!-- HEADER -->
    <header class="app-header">
        <button class="sidebar-toggle" id="sidebarToggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        <a href="{{ route('home') }}" class="header-brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5h2V5h-2v3zm-2 5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4V5h12v8z"/></svg>
            </div>
            <span class="brand-name">NONGKI</span>
        </a>

        <div class="header-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Cari menu, pesanan...">
        </div>

        <div class="header-actions">
            @auth
                @if(auth()->user()->role !== 'admin')
                <a href="#" class="header-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="header-badge"></span>
                </a>
                @endif
            @endauth

            @auth
                <div class="dropdown">
                    <a href="#" class="header-avatar" data-bs-toggle="dropdown">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="background:var(--dark-3);border:1px solid var(--border);border-radius:12px;">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}" style="color:var(--cream);">Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color:#e05252;">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-gold" style="padding:8px 16px;">Masuk</a>
            @endauth
        </div>
    </header>

    <!-- SIDEBAR (Selalu Muncul) -->
    <aside class="app-sidebar" id="appSidebar">
        <!-- Menu untuk semua pengunjung (baik login maupun belum) -->
        <div class="sidebar-section">
            <div class="sidebar-section-label">Navigasi</div>
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Beranda
            </a>
            <a href="{{ route('menu.index') }}" class="nav-item {{ request()->routeIs('menu*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                Menu Kopi
            </a>

            @auth
                <!-- Menu khusus yang sudah login -->
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Keranjang
                    <span class="nav-badge">3</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                    Riwayat Pesanan
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    Favorit
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil Saya
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2m0 16v2M2 12h2m16 0h2"/></svg>
                    Pengaturan
                </a>
            @else
                <!-- Menu untuk yang belum login -->
                <a href="{{ route('login') }}" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Daftar
                </a>
            @endauth
        </div>

        @auth
        <!-- User card untuk yang sudah login -->
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role ?? 'Pelanggan') }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="app-main">
        <div class="page-content">
            @hasSection('page_header')
            <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
                <div>
                    <h1 class="page-title" style="font-family:'Cormorant Garamond',serif;font-size:2rem;">@yield('page_title')</h1>
                    <div class="page-breadcrumb" style="color:var(--text-muted-c);">@yield('breadcrumb')</div>
                </div>
                <div>@yield('page_actions')</div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    </script>
    @stack('scripts')
</body>
</html>