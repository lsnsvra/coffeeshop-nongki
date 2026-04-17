<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'NONGKI Coffee')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <style>
  /* ... (Semua CSS kamu tetap sama, tidak saya ubah) ... */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  :root {
    --gold: #C9A84C;
    --gold-light: #E8C96A;
    --gold-dim: rgba(201, 168, 76, 0.15);
    --dark: #0F0C07;
    --dark-soft: #1A1610;
    --glass: rgba(20, 18, 14, 0.85);
    --cream: #F5EDD8;
    --cream-dim: rgba(245, 237, 216, 0.7);
    --text-muted: rgba(245, 237, 216, 0.5);
    --border: rgba(201, 168, 76, 0.25);
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
    overflow-x: hidden;
  }

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

  body::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 40%, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.8) 100%);
    z-index: 0;
  }

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
    box-shadow: 0 25px 45px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(201, 168, 76, 0.1) inset;
    transition: all 0.3s ease;
  }

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
  }

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
    background: rgba(0, 0, 0, 0.4);
    border: 1px solid var(--border);
    border-radius: 14px;
    color: var(--cream);
    font-size: 0.9rem;
    outline: none;
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
    margin-top: 0.5rem;
  }

  .back-link {
    text-align: center;
    margin-top: 1.8rem;
  }

  .back-link a {
    color: var(--cream-dim);
    text-decoration: none;
    font-size: 0.85rem;
  }

  .error-message {
    background: rgba(224, 82, 82, 0.15);
    border: 1px solid rgba(224, 82, 82, 0.3);
    color: #ff8a8a;
    padding: 0.8rem;
    border-radius: 12px;
    margin-bottom: 1rem;
  }
  </style>
</head>

<body>
  <div class="guest-card">
    <div class="guest-logo">
      <a href="{{ route('home') }}">NONGKI</a>
    </div>

    {{ $slot }}

  </div>
</body>

</html>