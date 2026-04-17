<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir — NONGKI Coffee')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.1);
            --dark: #0B0906;
            --dark-2: #14110C;
            --dark-3: #1E1A13;
            --cream: #F3EDE1;
            --cream-dim: rgba(243,237,225,0.7);
            --text-muted: rgba(243,237,225,0.45);
            --border: rgba(201,168,76,0.15);
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.2);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.3);
            --radius-card: 24px;
            --radius-btn: 40px;
            --sidebar-width: 260px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--cream);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar */
        .kasir-sidebar {
            width: var(--sidebar-width);
            background: var(--dark-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 32px 20px;
            flex-shrink: 0;
        }
        .sidebar-logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
            margin-bottom: 48px;
            padding-left: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-nav { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 16px;
            color: var(--cream-dim);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: 0.2s;
        }
        .nav-item i { width: 22px; font-size: 18px; }
        .nav-item:hover { background: var(--gold-dim); color: var(--gold); }
        .nav-item.active { background: var(--gold); color: var(--dark); box-shadow: var(--shadow-sm); }
        .sidebar-footer { border-top: 1px solid var(--border); padding-top: 24px; margin-top: 24px; }
        .user-info { display: flex; align-items: center; gap: 14px; padding: 8px; }
        .user-avatar {
            width: 44px; height: 44px;
            background: linear-gradient(145deg, var(--gold), var(--gold-light));
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: var(--dark); font-size: 18px;
        }
        .user-detail h4 { font-size: 15px; font-weight: 600; color: var(--cream); }
        .user-detail span { font-size: 12px; color: var(--gold); }
        .logout-btn {
            margin-top: 20px; width: 100%; padding: 12px;
            background: transparent; border: 1px solid var(--border);
            border-radius: var(--radius-btn); color: var(--cream-dim);
            font-weight: 500; cursor: pointer; display: flex;
            align-items: center; justify-content: center; gap: 10px; transition: 0.2s;
        }
        .logout-btn:hover { border-color: #e05252; color: #e05252; background: rgba(224,82,82,0.05); }

        /* Main */
        .kasir-main {
            flex: 1;
            overflow-y: auto;
            padding: 24px 32px;
            background: var(--dark);
        }
        .kasir-main::-webkit-scrollbar { width: 6px; }
        .kasir-main::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>
    @php $user = Auth::user(); $initials = strtoupper(substr($user->Nama ?? 'U', 0, 2)); @endphp
    <aside class="kasir-sidebar">
        <div class="sidebar-logo"><i class="fa-solid fa-mug-saucer"></i> NONGKI</div>
        <nav class="sidebar-nav">
            <a href="{{ route('kasir.pos') }}" class="nav-item {{ request()->routeIs('kasir.pos') ? 'active' : '' }}"><i class="fa-solid fa-cash-register"></i> POS</a>
            <a href="{{ route('kasir.menu') }}" class="nav-item {{ request()->routeIs('kasir.menu') ? 'active' : '' }}"><i class="fa-solid fa-utensils"></i> Menu</a>
            <a href="{{ route('kasir.transaksi') }}" class="nav-item {{ request()->routeIs('kasir.transaksi*') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left"></i> Transaksi</a>
            <a href="{{ route('kasir.pesanan') }}" class="nav-item {{ request()->routeIs('kasir.pesanan*') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Pesanan</a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ $initials }}</div>
                <div class="user-detail"><h4>{{ $user->Nama }}</h4><span>Kasir</span></div>
            </div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button></form>
        </div>
    </aside>
    <main class="kasir-main">@yield('content')</main>
    @stack('scripts')
</body>
</html>