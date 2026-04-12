<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NONGKI Coffee')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: rgba(201,168,76,0.12);
            --dark-bg: #0A0A0A;
            --dark-card: #111111;
            --dark-surface: #1A1A1A;
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255,255,255,0.7);
            --text-muted: rgba(255,255,255,0.5);
            --border: rgba(255,255,255,0.1);
            --error: #E05252;
            --success: #52B788;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo a {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gold-light);
            text-decoration: none;
            letter-spacing: 2px;
        }
        .title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            background: var(--dark-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 0.9rem;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            border-radius: 10px;
            color: var(--dark-bg);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.3);
        }
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            color: var(--gold);
            text-decoration: none;
            font-size: 0.85rem;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            background: rgba(224,82,82,0.1);
            border: 1px solid rgba(224,82,82,0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            color: var(--error);
            font-size: 0.85rem;
        }
        .success-message {
            background: rgba(82,183,136,0.1);
            border: 1px solid rgba(82,183,136,0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            color: var(--success);
            font-size: 0.85rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="card">
        <div class="logo">
            <a href="{{ route('home') }}">NONGKI</a>
        </div>
        <div class="title">{{ __('Lupa Password?') }}</div>
        <div class="subtitle">{{ __('Masukkan email Anda, kami akan kirim link reset password.') }}</div>
        
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
                <label class="form-label" for="email">Email</label>
                <input class="form-input" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn-submit">Kirim Link Reset Password</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Kembali ke Login</a>
        </div>
    </div>
    @stack('scripts')
</body>
</html>