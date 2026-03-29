@extends('layouts.app')

@section('title', 'NONGKI — Coffee Shop & Workspace')

@section('content')
<div class="container-fluid p-0">
  {{-- ── HERO SECTION ── --}}
  <div class="hero-nongki" style="background: linear-gradient(135deg, var(--brown-800) 0%, var(--brown-600) 100%); 
               border-radius: var(--radius-lg); padding: 5rem 2rem; margin-bottom: 3rem; 
               position: relative; overflow: hidden; text-align: center; color: white;
               box-shadow: var(--shadow-lg);">

    <div style="position:relative; z-index:2; max-width:800px; margin: 0 auto;">
      <div class="badge-nongki mb-3" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                        background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); 
                        padding: 0.5rem 1.5rem; border-radius: 50px; border: 1px solid rgba(255,255,255,0.2);">
        <i class="bi bi-cup-hot-fill text-warning"></i>
        <span style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.1em;">AUTHENTIC COFFEE EXPERIENCE</span>
      </div>

      <h1
        style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 1rem;">
        Welcome to Nongki ☕
      </h1>
      <p style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; margin: 0 auto 2.5rem;">
        Tempat terbaik untuk produktivitas atau sekadar menikmati aroma kopi pilihan di tengah kesibukanmu.
      </p>

      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="{{ route('menu.index') }}" class="btn-primary-custom px-5 py-3 shadow-lg">
          <i class="bi bi-cup-straw"></i> Lihat Menu
        </a>
        @guest
        <a href="{{ route('login') }}" class="btn-outline-custom px-5 py-3"
          style="color: white; border-color: rgba(255,255,255,0.4);">
          <i class="bi bi-person"></i> Masuk Akun
        </a>
        @endguest
      </div>
    </div>
  </div>

  @endsection