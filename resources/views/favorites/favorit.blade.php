@extends('layouts.app')

@section('title', 'Menu Favorit — NONGKI')

@push('styles')
<style>
  .favorite-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
  }
  .fav-card {
    background: var(--dark-2);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
  }
  .fav-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold);
    box-shadow: 0 12px 24px rgba(0,0,0,0.3);
  }
  .fav-img {
    height: 160px;
    background-size: cover;
    background-position: center;
    position: relative;
  }
  .fav-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(201,168,76,0.9);
    color: #000;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .fav-body {
    padding: 1rem;
  }
  .fav-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
  }
  .fav-price {
    color: var(--gold);
    font-weight: 600;
    margin-bottom: 0.75rem;
  }
  .fav-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
  }
  .remove-fav {
    background: none;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 12px;
    color: var(--text-muted-c);
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    flex: 1;
  }
  .remove-fav:hover {
    border-color: var(--red);
    color: var(--red);
  }
  .add-to-cart {
    background: var(--gold);
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    color: #000;
    font-weight: 600;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    flex: 1;
  }
  .add-to-cart:hover {
    background: var(--gold-light);
    transform: scale(1.02);
  }
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }
  .empty-state svg {
    width: 64px;
    height: 64px;
    opacity: 0.4;
    margin-bottom: 1rem;
  }

  /* Perbaiki breadcrumb */
  .page-breadcrumb a {
    color: var(--gold);
    text-decoration: none;
  }
  .page-breadcrumb a:hover {
    text-decoration: underline;
  }
  .page-breadcrumb {
    color: var(--text-muted-c);
  }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
  <div>
    <h1 class="page-title" style="font-family:'Cormorant Garamond',serif; font-size: 2rem;">Menu Favorit</h1>
    <div class="page-breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> &raquo; <span>Favorit</span>
    </div>
  </div>
</div>

<div class="favorite-grid" id="favoriteGrid">
  <!-- Card favorit 1 -->
  <div class="fav-card" data-id="1">
    <div class="fav-img" style="background-image: url('https://images.unsplash.com/photo-1541167760496-1628856ab772?w=400&q=80');">
      <div class="fav-badge">❤️ Favorit</div>
    </div>
    <div class="fav-body">
      <div class="fav-name">Caramel Latte</div>
      <div class="fav-price">Rp 42.000</div>
      <div class="fav-footer">
        <button class="remove-fav" onclick="removeFavorite(this)">Hapus</button>
        <button class="add-to-cart" onclick="addToCart(this, 'Caramel Latte')">+ Keranjang</button>
      </div>
    </div>
  </div>

  <!-- Card favorit 2 -->
  <div class="fav-card" data-id="2">
    <div class="fav-img" style="background-image: url('https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&q=80');">
      <div class="fav-badge">❤️ Favorit</div>
    </div>
    <div class="fav-body">
      <div class="fav-name">Cold Brew Classic</div>
      <div class="fav-price">Rp 38.000</div>
      <div class="fav-footer">
        <button class="remove-fav" onclick="removeFavorite(this)">Hapus</button>
        <button class="add-to-cart" onclick="addToCart(this, 'Cold Brew Classic')">+ Keranjang</button>
      </div>
    </div>
  </div>

  <!-- Card favorit 3 -->
  <div class="fav-card" data-id="3">
    <div class="fav-img" style="background-image: url('https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?w=400&q=80');">
      <div class="fav-badge">❤️ Favorit</div>
    </div>
    <div class="fav-body">
      <div class="fav-name">Matcha Oat Latte</div>
      <div class="fav-price">Rp 45.000</div>
      <div class="fav-footer">
        <button class="remove-fav" onclick="removeFavorite(this)">Hapus</button>
        <button class="add-to-cart" onclick="addToCart(this, 'Matcha Oat Latte')">+ Keranjang</button>
      </div>
    </div>
  </div>
</div>

<!-- Empty state (awalnya disembunyikan) -->
<div class="empty-state" id="emptyState" style="display: none;">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
  </svg>
  <h3>Belum ada favorit</h3>
  <p>Tambahkan menu favoritmu dengan klik ikon hati di menu kopi.</p>
  <a href="{{ route('menu.index') }}" class="btn-gold" style="display: inline-block; margin-top: 1rem;">Lihat Menu</a>
</div>
@endsection

@push('scripts')
<script>
  function removeFavorite(btn) {
    let card = btn.closest('.fav-card');
    card.style.opacity = '0.5';
    card.style.transition = 'opacity 0.2s';
    setTimeout(() => {
      card.remove();
      // Cek apakah masih ada card favorit
      let remainingCards = document.querySelectorAll('.fav-card').length;
      if (remainingCards === 0) {
        document.getElementById('favoriteGrid').style.display = 'none';
        document.getElementById('emptyState').style.display = 'block';
      }
    }, 200);
  }

  function addToCart(btn, itemName) {
    let originalText = btn.innerHTML;
    btn.innerHTML = '✓ Ditambahkan';
    btn.style.background = '#52b788';
    setTimeout(() => {
      btn.innerHTML = originalText;
      btn.style.background = '';
    }, 1500);
    // Nanti bisa ditambah AJAX
  }
</script>
@endpush