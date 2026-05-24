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

    /* ========== STAT CARDS ========== */  
    .stat-grid {  
        display: grid;  
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));  
        gap: 1.2rem;  
        margin-bottom: 2.5rem;  
    }  
    .stat-card-premium {  
        background: var(--dark-2); 
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
    .trend-up { color: #5DCAA5; } 
    .trend-up i { background: rgba(93, 202, 165, 0.15); padding: 4px; border-radius: 50%; }  
    .trend-neutral { color: var(--gold-light); }  
    .trend-neutral i { background: rgba(201, 168, 76, 0.15); padding: 4px; border-radius: 50%; }

    /* ========== TABEL ========== */  
    .table-wrapper {  
        background: var(--dark-2);  
        border: 1px solid rgba(255, 255, 255, 0.05);  
        border-radius: 16px;  
        padding: 1.5rem;  
    }  
    .table-header { margin-bottom: 1.2rem; display: flex; align-items: center; justify-content: space-between; }  
      
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

    .text-gold { color: var(--gold); font-weight: 600; }  
    .text-bold { color: var(--cream); font-weight: 500; }

    /* Status Badge */  
    .status-badge {  
        display: inline-flex; align-items: center; justify-content: center;  
        padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;  
    }  
    .status-done { background: rgba(93, 202, 165, 0.1); color: #5DCAA5; border: 1px solid rgba(93, 202, 165, 0.2); }  
    .status-process { background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.2); }  
</style>  
@endpush

@section('content')  
<div class="dashboard-header fade-in-up">  
    <h1 class="dashboard-title">Overview Dashboard</h1>  
    <p class="dashboard-subtitle">Selamat datang, <strong>{{ Auth::user()->Nama ?? Auth::user()->name ?? 'Administrator' }}</strong>. Menampilkan data transaksi per tanggal: <strong>{{ \Carbon\Carbon::parse($hariIni)->format('d F Y') }}</strong></p>  
</div>

<div class="stat-grid">  
    <div class="stat-card-premium fade-in-up delay-1">  
        <div class="stat-header">  
            <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>  
            <div class="stat-label">Penjualan Terdeteksi</div>  
        </div>  
        <div class="stat-value">Rp {{ number_format($revenueToday, 0, ',', '.') }}</div>  
        <div class="stat-trend trend-up">  
            <i class="fa-solid fa-arrow-up"></i> Terkini  
        </div>  
    </div>  
      
    <div class="stat-card-premium fade-in-up delay-1">  
        <div class="stat-header">  
            <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>  
            <div class="stat-label">Total Transaksi</div>  
        </div>  
        <div class="stat-value">{{ $ordersToday }}</div>  
        <div class="stat-trend trend-up">  
            <i class="fa-solid fa-arrow-up"></i> Order Masuk  
        </div>  
    </div>  
      
    <div class="stat-card-premium fade-in-up delay-2">  
        <div class="stat-header">  
            <div class="stat-icon"><i class="fa-solid fa-mug-hot"></i></div>  
            <div class="stat-label">Menu Aktif</div>  
        </div>  
        <div class="stat-value">{{ $activeProducts }}</div>  
        <div class="stat-trend trend-neutral">  
            <i class="fa-solid fa-star"></i> Tersedia  
        </div>  
    </div>  
      
    <div class="stat-card-premium fade-in-up delay-2">  
        <div class="stat-header">  
            <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>  
            <div class="stat-label">Pesanan Pending</div>  
        </div>  
        <div class="stat-value">{{ $pendingOrders }}</div>  
        <div class="stat-trend trend-neutral">  
            <i class="fa-solid fa-spinner"></i> Menunggu  
        </div>  
    </div>  
</div>

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
                @forelse($recentOrders as $order)
                <tr>  
                    <td class="text-gold">#{{ str_pad($order->OrderID, 5, '0', STR_PAD_LEFT) }}</td> 
                    
                    <td class="text-bold">{{ $order->nama_user ?? 'Guest/Kasir' }}</td>  
                    
                    <td>Rp {{ number_format($order->TotalHarga ?? 0, 0, ',', '.') }}</td>  
                    
                    <td>
                        @if(strtolower($order->StatusOrder ?? '') == 'paid')
                            <span class="status-badge status-done">Lunas</span>
                        @else
                            <span class="status-badge status-process">Pending</span>
                        @endif
                    </td>  
                    
                    <td>
                        @if(!empty($order->created_at))
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y — H:i') }} WIB
                        @elseif(!empty($order->CreatedDate))
                            {{ \Carbon\Carbon::parse($order->CreatedDate)->format('d M Y — H:i') }} WIB
                        @else
                            -- Mei 2026 --
                        @endif
                    </td> 
                </tr>  
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: rgba(245, 237, 216, 0.4); padding: 2rem;">Belum ada riwayat pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>  
    </div>  
</div>  
@endsection