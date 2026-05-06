@extends('layouts.app')

@section('title', 'Riwayat Pesanan — NONGKI')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap');

  :root {
    --bg-dark: #0f0e0c;
    --bg-card: #1a1814;
    --bg-card2: #22201a;
    --gold: #c9a84c;
    --gold-light: #e8c97a;
    --text-primary: #f0ece3;
    --text-muted: #7a7465;
    --border: #2e2b24;
    --green: #27ae60;
    --orange: #e67e22;
    --red: #c0392b;
    --blue: #2980b9;
  }

  .page-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1.5rem 5rem;
  }

  .page-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
  }
  
  /* Sesuai request: Tombol Back sudah di kiri */
  .back-btn {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--bg-card); border: 1px solid var(--border);
    color: var(--text-primary);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
  }
  .back-btn:hover { background: var(--gold); color: #000; border-color: var(--gold); }
  .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--gold); }

  /* Filter Tabs - Tetap di kiri */
  .filter-tabs {
    display: flex; gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }
  .tab {
    padding: 0.45rem 1.1rem;
    border-radius: 20px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    color: var(--text-muted);
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
  }
  .tab:hover { border-color: var(--gold); color: var(--gold); }
  .tab.active { background: var(--gold); color: #000; border-color: var(--gold); font-weight: 600; }

  /* Order Card */
  .order-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.2rem;
    transition: all 0.3s ease;
    animation: fadeUp 0.4s ease both;
  }
  .order-card:hover { 
    border-color: var(--gold); 
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    transform: translateY(-2px);
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .order-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 1rem;
  }
  .order-id { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--gold-light); }
  .order-date { color: var(--text-muted); font-size: 0.8rem; margin-top: 3px; }

  /* Badge Status - Pindah ke kanan */
  .status-badge {
    padding: 6px 14px; border-radius: 20px;
    font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .status-selesai { background: rgba(39,174,96,0.1); color: var(--green); border: 1px solid rgba(39,174,96,0.2); }
  .status-proses { background: rgba(230,126,34,0.1); color: var(--orange); border: 1px solid rgba(230,126,34,0.2); }
  .status-pending { background: rgba(41,128,185,0.1); color: var(--blue); border: 1px solid rgba(41,128,185,0.2); }
  .status-batal { background: rgba(192,57,43,0.1); color: var(--red); border: 1px solid rgba(192,57,43,0.2); }

  .order-items { 
    color: var(--text-primary); 
    font-size: 0.95rem; 
    margin-bottom: 1.25rem;
    padding: 10px 15px;
    background: rgba(255,255,255,0.03);
    border-radius: 10px;
    border-left: 3px solid var(--gold);
  }

  .order-bottom {
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
  }

  /* REORDER BTN - Pindah ke KIRI */
  .reorder-btn {
    padding: 8px 18px; border-radius: 10px;
    border: 1px solid var(--gold);
    background: var(--gold);
    color: #000;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .reorder-btn:hover { 
    background: var(--gold-light); 
    border-color: var(--gold-light);
    transform: scale(1.05);
  }

  /* TOTAL - Pindah ke KANAN */
  .order-total-group {
    text-align: right;
  }
  .total-label { font-size: 0.75rem; color: var(--text-muted); display: block; }
  .order-total { color: var(--text-primary); font-weight: 700; font-size: 1.1rem; }
</style>
@endpush

@section('content')
<div class="page-container">
  <div class="page-header">
    <a href="{{ url('/') }}" class="back-btn">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="page-title">Riwayat Pesanan</h1>
  </div>

  <div class="filter-tabs">
    <div class="tab active" onclick="filterTab(this, 'semua')">Semua</div>
    <div class="tab" onclick="filterTab(this, 'selesai')">Selesai</div>
    <div class="tab" onclick="filterTab(this, 'proses')">Diproses</div>
    <div class="tab" onclick="filterTab(this, 'pending')">Pending</div>
    <div class="tab" onclick="filterTab(this, 'batal')">Dibatalkan</div>
  </div>

  <div id="orderList">
    <!-- ITEM 1 -->
    <div class="order-card" data-status="selesai">
      <div class="order-top">
        <div>
          <div class="order-id">#NGK-0241</div>
          <div class="order-date">3 April 2026 • 14:22</div>
        </div>
        <span class="status-badge status-selesai">✓ Selesai</span>
      </div>
      <div class="order-items">Latte, Croissant</div>
      <div class="order-bottom">
        <button class="reorder-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6M1 20v-6h6M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
          Pesan Lagi
        </button>
        <div class="order-total-group">
          <span class="total-label">Total Pembayaran</span>
          <span class="order-total">Rp 55.000</span>
        </div>
      </div>
    </div>

    <!-- ITEM 2 -->
    <div class="order-card" data-status="proses">
      <div class="order-top">
        <div>
          <div class="order-id">#NGK-0240</div>
          <div class="order-date">3 April 2026 • 13:45</div>
        </div>
        <span class="status-badge status-proses">⟳ Diproses</span>
      </div>
      <div class="order-items">Americano × 2</div>
      <div class="order-bottom">
        <button class="reorder-btn" style="background: transparent; color: var(--gold);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          Lacak Pesanan
        </button>
        <div class="order-total-group">
          <span class="total-label">Total Pembayaran</span>
          <span class="order-total">Rp 48.000</span>
        </div>
      </div>
    </div>

    <!-- ITEM 3 -->
    <div class="order-card" data-status="pending">
      <div class="order-top">
        <div>
          <div class="order-id">#NGK-0239</div>
          <div class="order-date">3 April 2026 • 12:10</div>
        </div>
        <span class="status-badge status-pending">◷ Pending</span>
      </div>
      <div class="order-items">Matcha, Sandwich</div>
      <div class="order-bottom">
        <button class="reorder-btn" style="background: transparent; color: var(--gold);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          Lihat Detail
        </button>
        <div class="order-total-group">
          <span class="total-label">Total Pembayaran</span>
          <span class="order-total">Rp 72.000</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function filterTab(el, status) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.order-card').forEach(card => {
    if (status === 'semua' || card.dataset.status === status) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>
@endpush