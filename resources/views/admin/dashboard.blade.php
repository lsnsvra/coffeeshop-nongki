@extends('layouts.admin')

@section('title', 'Dashboard Admin — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI DASAR ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    /* ========== HEADER DASHBOARD ========== */
    .dashboard-header { margin-bottom: 2rem; }
    .dashboard-title { 
        font-family: 'Cormorant Garamond', serif; 
        font-size: 2.2rem; color: var(--gold); 
        font-weight: 600; margin-bottom: 0.3rem;
    }
    .dashboard-subtitle { color: rgba(245, 237, 216, 0.6); font-size: 0.95rem; }
    .dashboard-subtitle strong { color: var(--cream); font-weight: 500; }

    /* ========== STAT CARDS (CLEAN & MINIMALIST) ========== */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2.5rem;
    }
    .stat-card-premium {
        background: var(--dark-2); /* Warna solid elegan, tidak butek */
        border: 1px solid rgba(201, 168, 76, 0.15);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        display: flex; flex-direction: column;
    }
    .stat-card-premium:hover {
        transform: translateY(-4px);
        border-color: rgba(201, 168, 76, 0.5);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3), 0 0 15px rgba(201, 168, 76, 0.08);
    }
    
    .stat-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 1rem;
    }
    .stat-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: rgba(201, 168, 76, 0.1);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: var(--gold);
    }
    .stat-label { 
        color: rgba(245, 237, 216, 0.5); font-size: 0.8rem; 
        text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;
        margin-top: 5px;
    }
    
    .stat-value {
        font-size: 1.6rem; font-weight: 700; color: var(--cream);
        margin-bottom: 0.5rem;
    }
    
    .stat-trend {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.75rem; font-weight: 600;
    }
    .trend-up { color: #5DCAA5; } /* Hijau NONGKI */
    .trend-up i { background: rgba(93, 202, 165, 0.15); padding: 4px; border-radius: 50%; }
    .trend-neutral { color: var(--gold-light); }
    .trend-neutral i { background: rgba(201, 168, 76, 0.15); padding: 4px; border-radius: 50%; }

    /* ========== TABEL (SLEEK MODERN) ========== */
    .table-wrapper {
        background: var(--dark-2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
    }
    .table-header { margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between; }
    
    /* Judul tabel diganti jadi Sans-Serif biar modern dan tidak tabrakan dengan data */
    .table-title { font-size: 1.1rem; color: var(--cream); font-weight: 600; margin: 0; }

    .nongki-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .nongki-table th {
        text-align: left; padding: 1rem 1rem 1rem 0; color: rgba(245, 237, 216, 0.4);
        font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .nongki-table td {
        padding: 1rem 1rem 1rem 0; color: var(--cream-dim); font-size: 0.88rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        vertical-align: middle; transition: background 0.2s;
    }
    .nongki-table tbody tr:hover td { background: rgba(255, 255, 255, 0.02); }
    .nongki-table tbody tr:last-child td { border-bottom: none; }

    /* Aksen Warna Text Tabel */
    .text-gold { color: var(--gold); font-weight: 600; }
    .text-bold { color: var(--cream); font-weight: 500; }

    /* Status Badge Ringan */
    .status-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;
    }
    .status-done { background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.2); }
    .status-process { background: rgba(93, 202, 165, 0.1); color: #5DCAA5; border: 1px solid rgba(93, 202, 165, 0.2); }
</style>
@endpush

@section('content')
<div class="dashboard-header fade-in-up">
    <h1 class="dashboard-title">Overview Dashboard</h1>
    <p class="dashboard-subtitle">Selamat datang, <strong>{{ Auth::user()->Nama ?? 'Administrator' }}</strong>. Ini adalah ringkasan performa bisnis NONGKI.</p>
</div>

<!-- STATISTIK KARTU (CLEAN DESIGN) -->
<div class="stat-grid">
    <div class="stat-card-premium fade-in-up delay-1">
        <div class="stat-header">
            <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
            <div class="stat-label">Penjualan Hari Ini</div>
        </div>
        <div class="stat-value">Rp 4.200.000</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-arrow-up"></i> 12% vs Kemarin
        </div>
    </div>
    
    <div class="stat-card-premium fade-in-up delay-1">
        <div class="stat-header">
            <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-value">87</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-arrow-up"></i> 5 Transaksi Baru
        </div>
    </div>
    
    <div class="stat-card-premium fade-in-up delay-2">
        <div class="stat-header">
            <div class="stat-icon"><i class="fa-solid fa-mug-hot"></i></div>
            <div class="stat-label">Menu Aktif</div>
        </div>
        <div class="stat-value">24</div>
        <div class="stat-trend trend-neutral">
            <i class="fa-solid fa-star"></i> 4 Menu Baru
        </div>
    </div>
    
    <div class="stat-card-premium fade-in-up delay-2">
        <div class="stat-header">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-label">Total Pelanggan</div>
        </div>
        <div class="stat-value">312</div>
        <div class="stat-trend trend-up">
            <i class="fa-solid fa-user-plus"></i> 18 Pengguna Baru
        </div>
    </div>
</div>

<!-- TABEL PESANAN (SLEEK MODERN) -->
<div class="table-wrapper fade-in-up delay-2">
    <div class="table-header">
        <h3 class="table-title">Riwayat Pesanan Terbaru</h3>
    </div>
    
    <div style="overflow-x: auto;">
        <table class="nongki-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-gold">#NGK-0245</td>
                    <td class="text-bold">Sarah A.</td>
                    <td>Rp 85.000</td>
                    <td><span class="status-badge status-done">Selesai</span></td>
                    <td>10:30 WIB</td>
                </tr>
                <tr>
                    <td class="text-gold">#NGK-0244</td>
                    <td class="text-bold">Budi S.</td>
                    <td>Rp 120.000</td>
                    <td><span class="status-badge status-process">Diproses</span></td>
                    <td>09:15 WIB</td>
                </tr>
                <tr>
                    <td class="text-gold">#NGK-0243</td>
                    <td class="text-bold">Dian P.</td>
                    <td>Rp 65.000</td>
                    <td><span class="status-badge status-done">Selesai</span></td>
                    <td>08:45 WIB</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection