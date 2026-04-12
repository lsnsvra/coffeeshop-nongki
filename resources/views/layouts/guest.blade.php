<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NONGKI Coffee')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.15);
            --dark: #0F0C07;
            --dark-soft: #1A1610;
            --glass: rgba(20, 18, 14, 0.85);
            --cream: #F5EDD8;
            --cream-dim: rgba(245,237,216,0.7);
            --text-muted: rgba(245,237,216,0.5);
            --border: rgba(201,168,76,0.25);
            --error: #E05252;
            --success: #52B788;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            background: var(--dark);
        }

        /* Background dengan gambar kopi yang lebih dramatis */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=2070&auto=format') center/cover no-repeat;
            filter: brightness(0.25) saturate(1.2);
            z-index: 0;
            transform: scale(1.05);
            transition: transform 8s ease;
        }

        body:hover::before {
            transform: scale(1.1);
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 40%, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.8) 100%);
            z-index: 0;
        }

        /* Card utama dengan glassmorphism */
        .guest-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 25px 45px rgba(0,0,0,0.5), 0 0 0 1px rgba(201,168,76,0.1) inset;
            transition: all 0.3s ease;
        }

        .guest-card:hover {
            border-color: rgba(201,168,76,0.4);
            box-shadow: 0 30px 50px rgba(0,0,0,0.6);
        }

        /* Logo */
        .guest-logo {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .guest-logo a {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--gold-light);
            text-decoration: none;
            letter-spacing: 3px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        /* Title */
        .guest-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 500;
            text-align: center;
            color: var(--cream);
            margin-bottom: 0.5rem;
        }

        .guest-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--cream-dim);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            background: rgba(0,0,0,0.4);
            border: 1px solid var(--border);
            border-radius: 14px;
            color: var(--cream);
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--gold);
            background: rgba(0,0,0,0.6);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(105deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            border-radius: 40px;
            color: var(--dark);
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(201,168,76,0.35);
            filter: brightness(1.05);
        }

        .back-link {
            text-align: center;
            margin-top: 1.8rem;
        }

        .back-link a {
            color: var(--cream-dim);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link a:hover {
            color: var(--gold);
        }

        /* Message */
        .error-message, .success-message {
            border-radius: 12px;
            padding: 0.8rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            backdrop-filter: blur(4px);
        }

        .error-message {
            background: rgba(224,82,82,0.15);
            border: 1px solid rgba(224,82,82,0.3);
            color: #ff8a8a;
        }

        .success-message {
            background: rgba(82,183,136,0.15);
            border: 1px solid rgba(82,183,136,0.3);
            color: #7bdcb5;
        }

        /* Responsive */
        @media (max-width: 500px) {
            body {
                padding: 1rem;
            }
            .guest-card {
                padding: 1.5rem;
            }
            .guest-title {
                font-size: 1.6rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="guest-card">
        <div class="guest-logo">
            <a href="{{ route('home') }}">NONGKI</a>
        </div>
        <div class="guest-title">
            @yield('title', 'Reset Password')
        </div>
        <div class="guest-subtitle">
            {{ __('Masukkan email Anda, kami akan kirim link reset password.') }}
        </div>

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input class="form-input" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com">
            </div>
            <button type="submit" class="btn-submit">Kirim Link Reset</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Kembali ke Login
            </a>
        </div>
    </div>
    @stack('scripts')
</body>
</html>