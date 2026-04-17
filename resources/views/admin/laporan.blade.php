@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@section('content')
<div class="page-header">
    <h1>Laporan Penjualan</h1>
    <p>Pantau performa penjualan NONGKI Coffee secara real-time.</p>
</div>

{{-- Filter Tanggal --}}
<div style="display: flex; gap: 16px; align-items: center; margin-bottom: 24px; background: var(--dark-3); padding: 16px 20px; border-radius: 12px; border: 1px solid var(--border);">
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-calendar" style="color: var(--gold);"></i>
        <span style="color: var(--cream-dim);">Periode:</span>
    </div>
    <input type="date" value="2026-04-01" style="background: var(--dark-2); border: 1px solid var(--border); color: var(--cream); padding: 8px 12px; border-radius: 8px;">
    <span style="color: var(--cream-dim);">—</span>
    <input type="date" value="2026-04-16" style="background: var(--dark-2); border: 1px solid var(--border); color: var(--cream); padding: 8px 12px; border-radius: 8px;">
    <button style="background: var(--gold); color: #000; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; margin-left: auto; cursor: pointer;">Terapkan</button>
    <button style="background: transparent; border: 1px solid var(--border); color: var(--cream-dim); padding: 8px 16px; border-radius: 8px; cursor: pointer;"><i class="fa-solid fa-download"></i> Export</button>
</div>

{{-- Ringkasan Utama --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div class="stat-card-value">Rp 4.200.000</div>
        <div class="stat-card-label">Total Penjualan</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 12%</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-receipt"></i></div>
        <div class="stat-card-value">87</div>
        <div class="stat-card-label">Total Transaksi</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 5</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-mug-saucer"></i></div>
        <div class="stat-card-value">Rp 95.000</div>
        <div class="stat-card-label">Rata-rata / Transaksi</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 8%</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-crown"></i></div>
        <div class="stat-card-value">Coffee Milk Aren</div>
        <div class="stat-card-label">Menu Terlaris</div>
        <div class="stat-card-change">124 pcs</div>
    </div>
</div>

{{-- Grafik & Tabel --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    {{-- Grafik Batang (Placeholder) --}}
    <div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 18px; margin-bottom: 16px;">Tren Penjualan 7 Hari Terakhir</h3>
        <div style="height: 200px; display: flex; align-items: flex-end; gap: 12px; justify-content: center;">
            @php $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; $values = [65, 72, 58, 81, 90, 87, 95]; @endphp
            @foreach($days as $i => $day)
            <div style="text-align: center; flex:1;">
                <div style="height: {{ $values[$i] }}px; background: linear-gradient(to top, var(--gold), var(--gold-light)); width: 100%; border-radius: 6px 6px 0 0; opacity: 0.8; min-height: 4px;"></div>
                <div style="margin-top: 8px; font-size: 12px; color: var(--text-muted);">{{ $day }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Kategori Terlaris (Placeholder) --}}
    <div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 18px; margin-bottom: 16px;">Penjualan per Kategori</h3>
        @php $categories = ['Kopi' => 45, 'Non-Kopi' => 30, 'Makanan' => 25]; @endphp
        @foreach($categories as $cat => $pct)
        <div style="margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><span>{{ $cat }}</span><span>{{ $pct }}%</span></div>
            <div style="background: var(--dark-4); height: 8px; border-radius: 4px;"><div style="width: {{ $pct }}%; background: var(--gold); height: 8px; border-radius: 4px;"></div></div>
        </div>
        @endforeach
    </div>
</div>

{{-- Tabel Transaksi Terbaru --}}
<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; color: var(--cream);">Detail Transaksi Terbaru</h3>
        <a href="#" style="color: var(--gold); font-size: 13px; text-decoration: none;">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <table style="width: 100%; border-collapse: collapse; color: var(--cream-dim); font-size: 14px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border); color: rgba(245,237,216,0.5); text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                <th style="padding: 12px 8px; text-align: left;">ID Pesanan</th>
                <th style="padding: 12px 8px; text-align: left;">Pelanggan</th>
                <th style="padding: 12px 8px; text-align: left;">Total</th>
                <th style="padding: 12px 8px; text-align: left;">Metode</th>
                <th style="padding: 12px 8px; text-align: left;">Status</th>
                <th style="padding: 12px 8px; text-align: left;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0245</td>
                <td style="padding: 14px 8px;">Sarah A.</td>
                <td style="padding: 14px 8px;">Rp 85.000</td>
                <td style="padding: 14px 8px;">QRIS</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(201,168,76,0.15); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-size: 11px;">Selesai</span></td>
                <td style="padding: 14px 8px;">10:30</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0244</td>
                <td style="padding: 14px 8px;">Budi S.</td>
                <td style="padding: 14px 8px;">Rp 120.000</td>
                <td style="padding: 14px 8px;">Tunai</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(76,175,80,0.15); color: #8bc34a; padding: 4px 10px; border-radius: 20px; font-size: 11px;">Diproses</span></td>
                <td style="padding: 14px 8px;">09:15</td>
            </tr>
            <tr>
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0243</td>
                <td style="padding: 14px 8px;">Dian P.</td>
                <td style="padding: 14px 8px;">Rp 65.000</td>
                <td style="padding: 14px 8px;">Transfer</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(201,168,76,0.15); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-size: 11px;">Selesai</span></td>
                <td style="padding: 14px 8px;">08:45</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection