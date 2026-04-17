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
            --sidebar-w: 280px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ENHANCED ========== */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--dark-2) 0%, var(--dark-3) 100%);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            padding: 28px 0;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.3);
        }
        .sidebar-logo {
            padding: 0 28px 28px;
            border-bottom: 1px solid var(--border);
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.5px;
        }
        .sidebar-section {
            padding: 24px 28px 8px;
            font-size: 11px;
            letter-spacing: 2px;
            color: var(--text-muted);
            text-transform: uppercase;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 28px;
            color: var(--cream-dim);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }
        .sidebar-nav a i {
            width: 22px;
            text-align: center;
            font-size: 1.2rem;
            transition: transform 0.2s;
        }
        .sidebar-nav a:hover {
            background: var(--gold-dim);
            color: var(--cream);
            border-left-color: var(--gold);
            padding-left: 32px;
        }
        .sidebar-nav a:hover i {
            transform: translateX(3px);
            color: var(--gold);
        }
        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(201,168,76,0.15) 0%, transparent 100%);
            color: var(--gold-light);
            border-left-color: var(--gold);
            font-weight: 600;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding: 24px 28px;
            border-top: 1px solid var(--border);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .sidebar-user img, .avatar-fallback {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid var(--gold);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .avatar-fallback {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark);
        }
        .sidebar-user-info .name {
            font-size: 15px;
            font-weight: 600;
            color: var(--cream);
        }
        .sidebar-user-info .role {
            font-size: 12px;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-logout {
            width: 100%;
            padding: 10px;
            margin-top: 16px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--cream-dim);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            border-color: #e05252;
            color: #e05252;
            background: rgba(224,82,82,0.06);
        }

        /* ========== MAIN CONTENT ENHANCED ========== */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 36px 40px;
            background: radial-gradient(circle at 20% 30%, rgba(201,168,76,0.03) 0%, transparent 50%);
        }
        .page-header {
            margin-bottom: 32px;
            position: relative;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--border);
        }
        .page-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 34px;
            font-weight: 600;
            color: var(--cream);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .page-header p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Stat Cards Glassmorphism */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: rgba(26,21,9,0.5);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px 20px;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .stat-card:hover {
            border-color: var(--gold);
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.4);
        }
        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(201,168,76,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 22px;
            margin-bottom: 18px;
        }
        .stat-card-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--cream);
            line-height: 1.2;
        }
        .stat-card-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
        }
        .stat-card-change {
            font-size: 13px;
            margin-top: 12px;
            color: #5fcc7f;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Table Styling */
        .table-container {
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            margin-top: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: var(--cream-dim);
            font-size: 14px;
        }
        th {
            text-align: left;
            padding: 14px 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1.5px;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 16px 12px;
            border-bottom: 1px solid var(--border);
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover td {
            background: rgba(201,168,76,0.05);
        }

        @media (max-width: 1024px) {
            .stat-cards { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .main-content { margin-left: 0; padding: 20px; }
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
                <i class="fa-solid fa-chart-pie"></i> Dashboard
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
                <i class="fa-solid fa-users-gear"></i> Pengguna
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'avatar-fallback\'>{{ $initials }}</div>';">
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