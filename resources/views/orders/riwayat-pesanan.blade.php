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
  .back-btn {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--bg-card); border: 1px solid var(--border);
    color: var(--text-primary);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
  }
  .back-btn:hover { background: var(--gold); color: #000; border-color: var(--gold); }
  .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--gold); }

  /* Filter Tabs */
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
    border-radius: 14px;
    padding: 1.3rem;
    margin-bottom: 1rem;
    transition: border-color 0.2s;
    animation: fadeUp 0.4s ease both;
    cursor: pointer;
  }
  .order-card:hover { border-color: var(--gold); }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .order-card:nth-child(1) { animation-delay: 0.04s; }
  .order-card:nth-child(2) { animation-delay: 0.08s; }
  .order-card:nth-child(3) { animation-delay: 0.12s; }
  .order-card:nth-child(4) { animation-delay: 0.16s; }
  .order-card:nth-child(5) { animation-delay: 0.2s; }

  .order-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 0.8rem;
  }
  .order-id { font-family: 'Playfair Display', serif; font-size: 1rem; }
  .order-date { color: var(--text-muted); font-size: 0.8rem; margin-top: 3px; }

  .status-badge {
    padding: 4px 12px; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600;
  }
  .status-selesai { background: rgba(39,174,96,0.15); color: var(--green); border: 1px solid rgba(39,174,96,0.3); }
  .status-proses { background: rgba(230,126,34,0.15); color: var(--orange); border: 1px solid rgba(230,126,34,0.3); }
  .status-pending { background: rgba(41,128,185,0.15); color: var(--blue); border: 1px solid rgba(41,128,185,0.3); }
  .status-batal { background: rgba(192,57,43,0.15); color: var(--red); border: 1px solid rgba(192,57,43,0.3); }

  .order-items { color: var(--text-muted); font-size: 0.88rem; margin-bottom: 0.8rem; }

  .order-bottom {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 0.8rem;
    border-top: 1px solid var(--border);
  }
  .order-total { color: var(--gold); font-weight: 600; font-size: 1rem; }
  .reorder-btn {
    padding: 6px 16px; border-radius: 8px;
    border: 1px solid var(--gold);
    background: transparent;
    color: var(--gold);
    font-size: 0.82rem;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
  }
  .reorder-btn:hover { background: var(--gold); color: #000; }
</style>
@endpush

@section('content')
<div class="page-container">
  <div class="page-header">
    <a href="{{ url('/') }}" class="back-btn">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
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
        <span class="order-total">Rp 55.000</span>
        <button class="reorder-btn">Pesan Lagi</button>
      </div>
    </div>

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
        <span class="order-total">Rp 48.000</span>
        <button class="reorder-btn">Lacak</button>
      </div>
    </div>

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
        <span class="order-total">Rp 72.000</span>
        <button class="reorder-btn">Detail</button>
      </div>
    </div>

    <div class="order-card" data-status="selesai">
      <div class="order-top">
        <div>
          <div class="order-id">#NGK-0238</div>
          <div class="order-date">2 April 2026 • 16:30</div>
        </div>
        <span class="status-badge status-selesai">✓ Selesai</span>
      </div>
      <div class="order-items">Cappuccino</div>
      <div class="order-bottom">
        <span class="order-total">Rp 32.000</span>
        <button class="reorder-btn">Pesan Lagi</button>
      </div>
    </div>

    <div class="order-card" data-status="batal">
      <div class="order-top">
        <div>
          <div class="order-id">#NGK-0237</div>
          <div class="order-date">2 April 2026 • 11:05</div>
        </div>
        <span class="status-badge status-batal">✕ Dibatalkan</span>
      </div>
      <div class="order-items">Cold Brew × 3</div>
      <div class="order-bottom">
        <span class="order-total">Rp 90.000</span>
        <button class="reorder-btn">Pesan Lagi</button>
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