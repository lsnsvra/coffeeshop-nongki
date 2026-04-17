<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NONGKI Coffee')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        /* ========== HEADER ========== */
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

        /* ========== ROLE BADGE di header ========== */
        .header-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .role-badge-admin {
            background: rgba(201,168,76,0.15);
            border: 1px solid rgba(201,168,76,0.35);
            color: var(--gold-light);
        }
        .role-badge-kasir {
            background: rgba(93,202,165,0.12);
            border: 1px solid rgba(93,202,165,0.3);
            color: #5DCAA5;
        }
        .role-badge-user {
            background: rgba(245,237,216,0.08);
            border: 1px solid var(--border);
            color: var(--cream-dim);
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
        .header-badge-number {
            position: absolute;
            top: -6px; right: -6px;
            background: var(--gold); color: #000;
            font-size: 10px; font-weight: bold;
            min-width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 0 4px;
            border: 1px solid var(--dark);
        }

        /* ========== AVATAR ========== */
        .header-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            border: 2px solid var(--border);
            text-decoration: none;
            overflow: hidden; position: relative;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
        }
        .header-avatar:hover { border-color: var(--gold); }
        .header-avatar img {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; display: block; border-radius: 50%;
        }
        .header-avatar .avatar-fallback {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark); font-weight: 600; font-size: 0.8rem; border-radius: 50%;
        }
        .sidebar-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; font-weight: 600; color: var(--dark);
            flex-shrink: 0; overflow: hidden; position: relative;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
        }
        .sidebar-avatar img {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; display: block; border-radius: 12px;
        }
        .sidebar-avatar .avatar-fallback {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark); font-weight: 600; font-size: 0.9rem; border-radius: 12px;
        }
        .sidebar-toggle {
            display: none;
            background: none; border: none;
            color: var(--cream-dim); cursor: pointer;
        }
        .sidebar-toggle svg { width: 22px; height: 22px; }

        /* ========== SIDEBAR ========== */
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
            font-size: 0.68rem; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--text-muted-c);
            padding: 0 0.6rem; margin-bottom: 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 9px;
            color: var(--cream-dim); text-decoration: none;
            font-size: 0.88rem; transition: all 0.2s;
            margin-bottom: 2px; position: relative;
        }
        .nav-item:hover { background: var(--gold-dim); color: var(--cream); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(201,168,76,0.18), rgba(201,168,76,0.08));
            color: var(--gold-light);
            border: 1px solid var(--border);
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; background: var(--gold); border-radius: 0 3px 3px 0;
        }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-badge {
            margin-left: auto;
            background: var(--gold); color: var(--dark);
            font-size: 0.68rem; padding: 2px 7px; border-radius: 20px;
        }

        /* ========== DIVIDER ROLE ========== */
        .nav-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 12px;
        }

        /* ========== SIDEBAR USER ========== */
        .sidebar-user {
            margin: auto 1rem 1rem;
            padding: 12px;
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: 16px;
        }
        .sidebar-user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .sidebar-user-name { font-size: 0.88rem; font-weight: 500; color: var(--cream); }
        .sidebar-user-role { font-size: 0.75rem; color: var(--text-muted-c); }
        .btn-logout {
            width: 100%; padding: 8px;
            background: transparent; border: 1px solid var(--border);
            border-radius: 8px; color: var(--text-muted-c);
            font-size: 0.82rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-logout:hover { border-color: #e05252; color: #e05252; background: rgba(224,82,82,0.08); }

        /* ========== MAIN ========== */
        .app-main {
            margin-left: var(--sidebar-w);
            margin-top: var(--header-h);
            min-height: calc(100vh - var(--header-h));
        }
        .page-content { padding: 2rem; }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark); border: none; border-radius: 9px;
            padding: 10px 20px; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none;
        }
        .btn-gold:hover { box-shadow: 0 6px 18px rgba(201,168,76,0.35); transform: translateY(-1px); }
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 800;
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

    {{-- ========== PREPARE USER DATA ========== --}}
    @auth
    @php
        $user      = auth()->user();
        $userRole  = $user->role ?? 'user'; // 'admin' | 'kasir' | 'user'
        $avatar    = $user->avatar;

        if ($avatar && (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://'))) {
            $avatarUrl = preg_replace('/=s\d+(-c)?$/', '=s256-c', $avatar);
            if ($avatarUrl === $avatar && !str_contains($avatar, '=s')) {
                $avatarUrl = rtrim($avatar, '/') . '=s256-c';
            }
        } elseif ($avatar) {
            $avatarUrl = asset('storage/' . $avatar);
        } else {
            $avatarUrl = null;
        }
        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
    @endphp
    @endauth

    <!-- ========== HEADER ========== -->
    <header class="app-header">
        <button class="sidebar-toggle" id="sidebarToggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        <a href="{{ route('home') }}" class="header-brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
            </div>
            <span class="brand-name">NONGKI</span>
        </a>

        {{-- Role badge tampil di samping logo --}}
        @auth
            @if($userRole === 'admin')
                <span class="header-role-badge role-badge-admin">
                    <i class="fa-solid fa-shield-halved" style="font-size:0.65rem;"></i> Admin
                </span>
            @elseif($userRole === 'kasir')
                <span class="header-role-badge role-badge-kasir">
                    <i class="fa-solid fa-cash-register" style="font-size:0.65rem;"></i> Kasir
                </span>
            @else
                <span class="header-role-badge role-badge-user">
                    <i class="fa-solid fa-user" style="font-size:0.65rem;"></i> Pelanggan
                </span>
            @endif
        @endauth

        <div class="header-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Cari menu, pesanan...">
        </div>

        <div class="header-actions">
            @auth
                {{-- Keranjang hanya untuk role user/pelanggan --}}
                @if($userRole === 'user' || $userRole === 'pelanggan')
                    <a href="{{ route('keranjang') }}" class="header-btn" id="cartHeaderBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span class="header-badge-number" id="cartBadgeHeader" style="display:none;">0</span>
                    </a>
                @endif

                {{-- Notifikasi untuk admin --}}
                @if($userRole === 'admin')
                    <a href="{{ route('admin.notifikasi') ?? '#' }}" class="header-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </a>
                @endif

                <div class="dropdown">
                    <a href="#" class="header-avatar" data-bs-toggle="dropdown" aria-expanded="false">
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $initials }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="avatar-fallback" style="display:none;">{{ $initials }}</span>
                        @else
                            <span class="avatar-fallback">{{ $initials }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end"
                        style="background:var(--dark-3);border:1px solid var(--border);border-radius:12px;">
                        <li>
                            <div style="padding:8px 12px; border-bottom:1px solid var(--border);">
                                <div style="font-weight:600;color:var(--cream);">{{ $user->name }}</div>
                                <div style="font-size:0.7rem; color:var(--text-muted-c);">{{ $user->email }}</div>
                                <div style="font-size:0.7rem; margin-top:2px; color:var(--gold);">
                                    {{ ucfirst($userRole) }}
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider" style="border-color:var(--border);"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}"
                               style="color:var(--cream-dim);">Profil Saya</a>
                        </li>
                        @if($userRole === 'admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}"
                                   style="color:var(--cream-dim);">Dashboard Admin</a>
                            </li>
                        @endif
                        @if($userRole === 'kasir')
                            <li>
                                <a class="dropdown-item" href="{{ route('kasir.pos') }}"
                                   style="color:var(--cream-dim);">POS Kasir</a>
                            </li>
                        @endif
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

    <!-- ========== SIDEBAR ========== -->
    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-section">

            {{-- ============================================================
                 NAVIGASI ADMIN
                 ============================================================ --}}
            @auth
            @if($userRole === 'admin')
                <div class="sidebar-section-label">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Overview
                </a>

                <div class="nav-divider"></div>
                <div class="sidebar-section-label">Laporan</div>

                <a href="{{ route('admin.laporan.penjualan') }}"
                   class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Laporan Penjualan
                </a>

                <a href="{{ route('admin.laporan.harian') }}"
                   class="nav-item {{ request()->routeIs('admin.laporan.harian') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Laporan Harian
                </a>

                <div class="nav-divider"></div>
                <div class="sidebar-section-label">Manajemen</div>

                <a href="{{ route('admin.stok') }}"
                   class="nav-item {{ request()->routeIs('admin.stok*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                    Stok Bahan
                </a>

                <a href="{{ route('admin.menu') }}"
                   class="nav-item {{ request()->routeIs('admin.menu*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Menu
                </a>

                <a href="{{ route('admin.pengguna') }}"
                   class="nav-item {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Pengguna
                </a>

                <a href="{{ route('pengaturan') }}"
                   class="nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2m0 16v2M2 12h2m16 0h2"/>
                    </svg>
                    Pengaturan
                </a>

            {{-- ============================================================
                 NAVIGASI KASIR
                 ============================================================ --}}
            @elseif($userRole === 'kasir')
                <div class="sidebar-section-label">POS</div>

                <a href="{{ route('kasir.pos') }}"
                   class="nav-item {{ request()->routeIs('kasir.pos') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    Kasir / POS
                </a>

                <a href="{{ route('kasir.menu') }}"
                   class="nav-item {{ request()->routeIs('kasir.menu*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Daftar Menu
                </a>

                <div class="nav-divider"></div>
                <div class="sidebar-section-label">Transaksi</div>

                <a href="{{ route('kasir.transaksi') }}"
                   class="nav-item {{ request()->routeIs('kasir.transaksi*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Riwayat Transaksi
                </a>

                <a href="{{ route('kasir.pesanan') }}"
                   class="nav-item {{ request()->routeIs('kasir.pesanan*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="2"/>
                    </svg>
                    Pesanan Masuk
                </a>

            {{-- ============================================================
                 NAVIGASI USER / PELANGGAN (default)
                 ============================================================ --}}
            @else
                <div class="sidebar-section-label">Navigasi</div>

                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Beranda
                </a>

                <a href="{{ route('menu.index') }}"
                   class="nav-item {{ request()->routeIs('menu*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Menu Kopi
                </a>

                <a href="{{ route('keranjang') }}"
                   class="nav-item {{ request()->routeIs('keranjang') ? 'active' : '' }}"
                   id="sidebarCartLink">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Keranjang
                    <span class="nav-badge" id="cartBadgeSidebar" style="display:none;">0</span>
                </a>

                <a href="{{ route('riwayat.pesanan') }}"
                   class="nav-item {{ request()->routeIs('riwayat.pesanan') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="2"/>
                    </svg>
                    Riwayat Pesanan
                </a>

                <a href="{{ route('favorit') }}"
                   class="nav-item {{ request()->routeIs('favorit') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    Favorit
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Profil Saya
                </a>

                <a href="{{ route('pengaturan') }}"
                   class="nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2m0 16v2M2 12h2m16 0h2"/>
                    </svg>
                    Pengaturan
                </a>
            @endif
            @else
                {{-- Guest: tidak login --}}
                <div class="sidebar-section-label">Menu</div>
                <a href="{{ route('menu.index') }}"
                   class="nav-item {{ request()->routeIs('menu*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 21h16v-2H2v2zM18 3H2v10c0 3.31 2.69 6 6 6h4c3.31 0 6-2.69 6-6v-1h2c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Menu Kopi
                </a>
                <div class="nav-divider"></div>
                <a href="{{ route('login') }}" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    Daftar
                </a>
            @endauth
        </div>

        {{-- ========== SIDEBAR USER INFO ========== --}}
        @auth
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-avatar">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $initials }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <span class="avatar-fallback" style="display:none;">{{ $initials }}</span>
                    @else
                        <span class="avatar-fallback">{{ $initials }}</span>
                    @endif
                </div>
                <div>
                    <div class="sidebar-user-name">{{ $user->name }}</div>
                    <div class="sidebar-user-role">
                        @if($userRole === 'admin')
                            <span style="color:var(--gold);">&#9679;</span> Administrator
                        @elseif($userRole === 'kasir')
                            <span style="color:#5DCAA5;">&#9679;</span> Kasir
                        @else
                            Pelanggan
                        @endif
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="app-main">
        <div class="page-content">
            @hasSection('page_header')
            <div class="page-header"
                 style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
                <div>
                    <h1 class="page-title"
                        style="font-family:'Cormorant Garamond',serif;font-size:2rem;">
                        @yield('page_title')
                    </h1>
                    <div class="page-breadcrumb" style="color:var(--text-muted-c);">
                        @yield('breadcrumb')
                    </div>
                </div>
                <div>@yield('page_actions')</div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ========== CART (hanya aktif untuk role user) ==========
        function getCartCount() {
            return parseInt(localStorage.getItem('cartCount') || '0');
        }
        function updateBadges(count) {
            const headerBadge  = document.getElementById('cartBadgeHeader');
            const sidebarBadge = document.getElementById('cartBadgeSidebar');
            if (headerBadge) {
                if (count > 0) {
                    headerBadge.textContent = count;
                    headerBadge.style.display = 'flex';
                    headerBadge.style.transform = 'scale(1.2)';
                    setTimeout(() => headerBadge.style.transform = 'scale(1)', 200);
                } else {
                    headerBadge.style.display = 'none';
                }
            }
            if (sidebarBadge) {
                if (count > 0) {
                    sidebarBadge.textContent = count;
                    sidebarBadge.style.display = 'inline-block';
                } else {
                    sidebarBadge.style.display = 'none';
                }
            }
        }
        function setCartCount(count) {
            localStorage.setItem('cartCount', count);
            updateBadges(count);
        }
        function addToCart(button, itemName = '', price = '') {
            setCartCount(getCartCount() + 1);
            const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
            items.push({ name: itemName, price: price, addedAt: new Date().toISOString() });
            localStorage.setItem('cartItems', JSON.stringify(items));
            if (button) {
                const original = button.innerHTML;
                button.innerHTML = '✓';
                button.style.background = '#52b788';
                setTimeout(() => {
                    button.innerHTML = original;
                    button.style.background = '';
                }, 800);
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            updateBadges(getCartCount());
            document.body.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-add, .add-to-cart-btn');
                if (btn) {
                    e.preventDefault();
                    addToCart(btn, btn.getAttribute('data-name') || '', btn.getAttribute('data-price') || '');
                }
            });
        });
        window.addToCartHandler = addToCart;

        // ========== SIDEBAR TOGGLE ==========
        const toggle  = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>