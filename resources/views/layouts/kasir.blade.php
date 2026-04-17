<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir — NONGKI Coffee')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
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
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ========== TOP BAR ========== */
        .pos-topbar {
            height: 64px;
            background: var(--dark-2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
        }
        .pos-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pos-logo i {
            font-size: 22px;
            color: var(--gold);
        }
        .pos-logo span {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--gold-light);
        }
        .pos-badge {
            background: rgba(76, 175, 80, 0.15);
            color: #8bc34a;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 12px;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }
        .pos-nav {
            display: flex;
            gap: 4px;
        }
        .pos-nav a {
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--cream-dim);
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pos-nav a i {
            font-size: 14px;
        }
        .pos-nav a:hover {
            background: var(--gold-dim);
            color: var(--cream);
        }
        .pos-nav a.active {
            background: rgba(201,168,76,0.18);
            color: var(--gold);
            border: 1px solid var(--border);
        }
        .pos-user {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .pos-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pos-avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--border);
            background: var(--dark-3);
        }
        .avatar-fallback {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--dark);
        }
        .pos-user-details {
            line-height: 1.3;
        }
        .pos-user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--cream);
        }
        .pos-user-role {
            font-size: 11px;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pos-logout-btn {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            color: var(--cream-dim);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .pos-logout-btn:hover {
            border-color: #e05252;
            color: #e05252;
            background: rgba(224,82,82,0.06);
        }

        /* ========== LAYOUT DUA KOLOM ========== */
        .pos-main {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .pos-left {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background: var(--dark);
        }
        .pos-right {
            width: 360px;
            background: var(--dark-2);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 24px;
            overflow-y: auto;
        }

        /* Scrollbar styling */
        .pos-left::-webkit-scrollbar,
        .pos-right::-webkit-scrollbar {
            width: 5px;
        }
        .pos-left::-webkit-scrollbar-track,
        .pos-right::-webkit-scrollbar-track {
            background: transparent;
        }
        .pos-left::-webkit-scrollbar-thumb,
        .pos-right::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        /* ========== UTILITY ========== */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark);
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-gold:hover {
            box-shadow: 0 8px 18px rgba(201,168,76,0.3);
            transform: translateY(-1px);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 16px;
            color: var(--cream-dim);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: var(--gold-dim);
        }

        @media (max-width: 900px) {
            .pos-nav a span { display: none; }
            .pos-nav a i { margin-right: 0; }
            .pos-right { width: 300px; }
        }
        @media (max-width: 600px) {
            .pos-main { flex-direction: column; }
            .pos-right { width: 100%; }
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

    {{-- TOP BAR --}}
    <header class="pos-topbar">
        <div class="pos-logo">
            <i class="fa-solid fa-mug-hot"></i>
            <span>NONGKI</span>
            <span class="pos-badge">KASIR</span>
        </div>
        <nav class="pos-nav">
            <a href="{{ route('kasir.pos') }}" class="{{ request()->routeIs('kasir.pos') ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register"></i>
                <span>POS</span>
            </a>
            <a href="{{ route('kasir.menu') }}" class="{{ request()->routeIs('kasir.menu') ? 'active' : '' }}">
                <i class="fa-solid fa-utensils"></i>
                <span>Menu</span>
            </a>
            <a href="{{ route('kasir.transaksi') }}" class="{{ request()->routeIs('kasir.transaksi*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Transaksi</span>
            </a>
            <a href="{{ route('kasir.pesanan') }}" class="{{ request()->routeIs('kasir.pesanan*') ? 'active' : '' }}">
                <i class="fa-solid fa-bell"></i>
                <span>Pesanan</span>
            </a>
        </nav>
        <div class="pos-user">
            <div class="pos-user-info">
                @if($avatarUrl)
                    <img class="pos-avatar" src="{{ $avatarUrl }}" alt="avatar" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'avatar-fallback\'>{{ $initials }}</div>';">
                @else
                    <div class="avatar-fallback">{{ $initials }}</div>
                @endif
                <div class="pos-user-details">
                    <div class="pos-user-name">{{ $user->Nama }}</div>
                    <div class="pos-user-role">Kasir</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="pos-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- MAIN CONTENT AREA (KIRI & KANAN) --}}
    <div class="pos-main">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>