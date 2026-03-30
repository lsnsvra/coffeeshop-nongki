@extends('layouts.app')

@section('title', 'Dashboard Admin — NONGKI')

@section('page_header')
@endsection

@section('page_title', 'Dashboard Admin')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a> · Dashboard
@endsection

@section('page_actions')
    <button class="btn-gold">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14m-7-7h14"/></svg>
        Laporan Baru
    </button>
@endsection

@push('styles')
<style>
    /* Stat Cards */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.4rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--gold), transparent);
        opacity: 0.6;
    }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-icon svg { width: 20px; height: 20px; }

    .stat-icon.gold { background: rgba(201,168,76,0.15); color: var(--gold); }
    .stat-icon.green { background: rgba(82,183,136,0.12); color: #52b788; }
    .stat-icon.blue { background: rgba(112,184,255,0.1); color: #70b8ff; }
    .stat-icon.orange { background: rgba(224,159,62,0.12); color: #e09f3e; }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem; font-weight: 600;
        color: var(--cream); line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label { font-size: 0.8rem; color: var(--text-muted-c); margin-bottom: 12px; }

    .stat-change {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.78rem; font-weight: 500;
        padding: 3px 9px; border-radius: 20px;
    }

    .stat-change.up { background: rgba(82,183,136,0.12); color: #52b788; }
    .stat-change.down { background: rgba(224,82,82,0.12); color: #e05252; }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }

    /* Table */
    .table-wrap { overflow-x: auto; }

    .nongki-table {
        width: 100%; border-collapse: collapse;
    }

    .nongki-table th {
        font-size: 0.72rem; font-weight: 500;
        letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--text-muted-c);
        padding: 10px 14px;
        border-bottom: 1px solid var(--border);
        text-align: left;
    }

    .nongki-table td {
        padding: 13px 14px;
        font-size: 0.875rem;
        color: var(--cream-dim);
        border-bottom: 1px solid rgba(201,168,76,0.08);
        vertical-align: middle;
    }

    .nongki-table tr:last-child td { border-bottom: none; }

    .nongki-table tr:hover td { background: rgba(201,168,76,0.04); }

    .order-id { font-family: 'DM Sans', sans-serif; font-weight: 500; color: var(--cream); }

    .customer-cell { display: flex; align-items: center; gap: 9px; }

    .mini-avatar {
        width: 30px; height: 30px;
        background: var(--dark-4);
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 600;
        color: var(--gold); flex-shrink: 0;
    }

    .customer-name { font-size: 0.875rem; color: var(--cream); }
    .customer-items { font-size: 0.75rem; color: var(--text-muted-c); }

    .price-val { font-weight: 500; color: var(--gold-light); }

    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 500;
    }

    .status-pill::before {
        content: ''; width: 6px; height: 6px; border-radius: 50%;
        background: currentColor; opacity: 0.7;
    }

    .status-selesai { background: rgba(82,183,136,0.12); color: #52b788; }
    .status-proses  { background: rgba(201,168,76,0.12); color: var(--gold); }
    .status-pending { background: rgba(224,159,62,0.12); color: #e09f3e; }
    .status-batal   { background: rgba(224,82,82,0.12); color: #e05252; }

    /* Top menu */
    .top-menu-list { display: flex; flex-direction: column; gap: 10px; }

    .top-menu-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        transition: border-color 0.2s;
    }

    .top-menu-item:hover { border-color: var(--gold); }

    .menu-rank {
        width: 26px; height: 26px;
        background: var(--gold-dim);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 600;
        color: var(--gold); flex-shrink: 0;
    }

    .menu-rank.top1 { background: rgba(201,168,76,0.25); }

    .menu-info { flex: 1; }
    .menu-nm { font-size: 0.875rem; color: var(--cream); font-weight: 500; }
    .menu-cnt { font-size: 0.75rem; color: var(--text-muted-c); }

    .menu-bar-wrap { width: 60px; }
    .menu-bar-bg { height: 4px; background: var(--dark-4); border-radius: 2px; overflow: hidden; }
    .menu-bar-fill { height: 100%; background: var(--gold); border-radius: 2px; transition: width 0.4s; }

    /* Quick actions */
    .quick-actions {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
    }

    .quick-btn {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 11px;
        padding: 14px 12px;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
        cursor: pointer; transition: all 0.2s;
        text-decoration: none;
        color: var(--cream-dim);
    }

    .quick-btn:hover { border-color: var(--gold); background: var(--gold-dim); color: var(--gold); }

    .quick-btn svg { width: 20px; height: 20px; }
    .quick-btn span { font-size: 0.78rem; font-weight: 500; text-align: center; }

    @media (max-width: 1200px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 900px)  { .content-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px)  { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@section('content')

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-value">Rp 4,2jt</div>
        <div class="stat-label">Pendapatan Hari Ini</div>
        <span class="stat-change up">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            +12.5%
        </span>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
        </div>
        <div class="stat-value">87</div>
        <div class="stat-label">Total Pesanan</div>
        <span class="stat-change up">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            +8 dari kemarin
        </span>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-value">1.284</div>
        <div class="stat-label">Total Pelanggan</div>
        <span class="stat-change up">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            +23 bulan ini
        </span>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-value">14</div>
        <div class="stat-label">Pesanan Menunggu</div>
        <span class="stat-change down">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            Perlu diproses
        </span>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">

    <!-- Recent Orders -->
    <div class="card-nongki">
        <div style="display:flex;align-items:center;justify-content:space-between;" class="card-nongki-header">
            <span>Pesanan Terbaru</span>
            <a href="{{ route('menu.index') }}" style="font-size:0.8rem;color:var(--gold);text-decoration:none;font-family:'DM Sans',sans-serif;">Lihat semua →</a>
        </div>
        <div class="table-wrap">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $dummyOrders = [
                        ['id'=>'#NGK-0241','name'=>'Rizki A.','items'=>'Latte, Croissant','total'=>'Rp 55.000','status'=>'selesai'],
                        ['id'=>'#NGK-0240','name'=>'Sari W.','items'=>'Americano × 2','total'=>'Rp 48.000','status'=>'proses'],
                        ['id'=>'#NGK-0239','name'=>'Budi S.','items'=>'Matcha, Sandwich','total'=>'Rp 72.000','status'=>'pending'],
                        ['id'=>'#NGK-0238','name'=>'Dewi P.','items'=>'Cappuccino','total'=>'Rp 32.000','status'=>'selesai'],
                        ['id'=>'#NGK-0237','name'=>'Andi K.','items'=>'Cold Brew × 3','total'=>'Rp 90.000','status'=>'batal'],
                    ];
                    @endphp

                    @foreach($dummyOrders as $order)
                    <tr>
                        <td><span class="order-id">{{ $order['id'] }}</span></td>
                        <td>
                            <div class="customer-cell">
                                <div class="mini-avatar">{{ strtoupper(substr($order['name'], 0, 2)) }}</div>
                                <div>
                                    <div class="customer-name">{{ $order['name'] }}</div>
                                    <div class="customer-items">{{ $order['items'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="price-val">{{ $order['total'] }}</span></td>
                        <td>
                            <span class="status-pill status-{{ $order['status'] }}">
                                {{ ucfirst($order['status']) }}
                            </span>
                        </td>
                        <td>
                            <a href="#" style="font-size:0.78rem;color:var(--gold);text-decoration:none;">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column -->
    <div style="display:flex;flex-direction:column;gap:1.2rem;">

        <!-- Top Menu -->
        <div class="card-nongki">
            <div class="card-nongki-header">Menu Terlaris</div>
            <div class="top-menu-list">
                @php
                $topMenus = [
                    ['rank'=>1,'name'=>'Caramel Latte','count'=>'342 terjual','pct'=>100],
                    ['rank'=>2,'name'=>'Cold Brew Classic','count'=>'287 terjual','pct'=>84],
                    ['rank'=>3,'name'=>'Matcha Oat Latte','count'=>'241 terjual','pct'=>70],
                    ['rank'=>4,'name'=>'Americano','count'=>'198 terjual','pct'=>58],
                    ['rank'=>5,'name'=>'Vanilla Cappuccino','count'=>'156 terjual','pct'=>46],
                ];
                @endphp
                @foreach($topMenus as $menu)
                <div class="top-menu-item">
                    <div class="menu-rank {{ $menu['rank'] === 1 ? 'top1' : '' }}">{{ $menu['rank'] }}</div>
                    <div class="menu-info">
                        <div class="menu-nm">{{ $menu['name'] }}</div>
                        <div class="menu-cnt">{{ $menu['count'] }}</div>
                    </div>
                    <div class="menu-bar-wrap">
                        <div class="menu-bar-bg">
                            <div class="menu-bar-fill" style="width:{{ $menu['pct'] }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-nongki">
            <div class="card-nongki-header">Aksi Cepat</div>
            <div class="quick-actions">
                <a href="{{ route('menu.index') }}" class="quick-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    <span>Tambah Menu</span>
                </a>
                <a href="{{ route('menu.index') }}" class="quick-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                    <span>Kelola Pesanan</span>
                </a>
                <a href="{{ route('dashboard') }}" class="quick-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Lihat Laporan</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="quick-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2m0 16v2M2 12h2m16 0h2"/></svg>
                    <span>Pengaturan</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection