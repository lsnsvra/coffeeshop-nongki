<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — NONGKI Coffee')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
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
            --text-muted: rgba(245,237,216,0.42);
            --border: rgba(201,168,76,0.18);
            --sidebar-w: 260px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            display: flex;
            min-height: 100vh;
        }
        /* ========== SIDEBAR ========== */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            padding: 24px 0;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 0 24px 24px;
            border-bottom: 1px solid var(--border);
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-section {
            padding: 20px 24px 8px;
            font-size: 10px;
            letter-spacing: 2px;
            color: var(--text-muted);
            text-transform: uppercase;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: var(--cream-dim);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: var(--gold);
            background: rgba(201,168,76,0.08);
            border-right: 2px solid var(--gold);
        }
        .sidebar-nav a i {
            width: 18px;
            text-align: center;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding: 20px 24px;
            border-top: 1px solid var(--border);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
            background: var(--dark-3);
        }
        .sidebar-user .avatar-fallback {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--dark);
        }
        .sidebar-user-info .name {
            font-size: 14px;
            font-weight: 600;
            color: var(--cream);
        }
        .sidebar-user-info .role {
            font-size: 11px;
            color: var(--gold);
            text-transform: uppercase;
        }
        .btn-logout {
            width: 100%;
            padding: 8px;
            margin-top: 12px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--cream-dim);
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            border-color: #e05252;
            color: #e05252;
            background: rgba(224,82,82,0.08);
        }
        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 32px;
        }
        .page-header {
            margin-bottom: 28px;
        }
        .page-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            color: var(--cream);
            margin-bottom: 4px;
        }
        .page-header p {
            font-size: 13px;
            color: var(--text-muted);
        }
        /* ========== STAT CARD (digunakan di dashboard) ========== */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
        }
        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(201,168,76,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 18px;
            margin-bottom: 14px;
        }
        .stat-card-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--cream);
        }
        .stat-card-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .stat-card-change {
            font-size: 12px;
            margin-top: 8px;
            color: #5fcc7f;
        }
        @media (max-width: 768px) {
            .sidebar { width: 0; padding: 0; overflow: hidden; }
            .main-content { margin-left: 0; padding: 20px; }
            .stat-cards { grid-template-columns: 1fr; }
        }
        @yield('extra-styles')
    </style>
    @stack('styles')
</head>
<body>
    @php
        $user = Auth::user();
        $avatar = $user->avatar ?? null;
        if ($avatar && (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://'))) {
            $avatarUrl = preg_replace('/=s\d+-c/', '=s256-c', $avatar);
        } elseif ($avatar) {
            $avatarUrl = asset('storage/' . $avatar);
        } else {
            $avatarUrl = null;
        }
        $initials = strtoupper(substr($user->Nama ?? 'U', 0, 2));
    @endphp

    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-mug-hot"></i> NONGKI
        </div>
        <div class="sidebar-section">Dashboard</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
        </nav>
        <div class="sidebar-section">Laporan</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Laporan Penjualan
            </a>
        </nav>
        <div class="sidebar-section">Manajemen</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.stok') }}" class="{{ request()->routeIs('admin.stok*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i> Stok Bahan
            </a>
            <a href="{{ route('admin.menu') }}" class="{{ request()->routeIs('admin.menu*') ? 'active' : '' }}">
                <i class="fa-solid fa-utensils"></i> Menu
            </a>
            <a href="{{ route('admin.pengguna') }}" class="{{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Pengguna
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="Avatar" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'avatar-fallback\'>{{ $initials }}</div>';">
                @else
                    <div class="avatar-fallback">{{ $initials }}</div>
                @endif
                <div class="sidebar-user-info">
                    <div class="name">{{ $user->Nama }}</div>
                    <div class="role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>