@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@section('content')
<div class="page-header">
    <h1>Laporan Penjualan</h1>
    <p>Ringkasan performa penjualan NONGKI Coffee.</p>
</div>

<div style="display: flex; gap: 16px; margin-bottom: 24px;">
    <div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 12px; padding: 20px; flex: 1;">
        <div style="color: var(--gold); font-size: 14px; margin-bottom: 8px;">Total Penjualan Bulan Ini</div>
        <div style="font-size: 28px; font-weight: 700; color: var(--cream);">Rp 28.450.000</div>
        <div style="color: #5fcc7f; font-size: 13px; margin-top: 8px;">↑ 8.2% dari bulan lalu</div>
    </div>
    <div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 12px; padding: 20px; flex: 1;">
        <div style="color: var(--gold); font-size: 14px; margin-bottom: 8px;">Rata-rata Transaksi</div>
        <div style="font-size: 28px; font-weight: 700; color: var(--cream);">Rp 95.000</div>
        <div style="color: #5fcc7f; font-size: 13px; margin-top: 8px;">↑ 5.1% dari bulan lalu</div>
    </div>
    <div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 12px; padding: 20px; flex: 1;">
        <div style="color: var(--gold); font-size: 14px; margin-bottom: 8px;">Menu Terlaris</div>
        <div style="font-size: 18px; font-weight: 600; color: var(--cream);">Coffee Milk Aren Sugar</div>
        <div style="color: var(--text-muted); font-size: 13px; margin-top: 8px;">Terjual 124 pcs bulan ini</div>
    </div>
</div>

<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
    <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; margin-bottom: 20px;">Detail Penjualan Harian</h3>
    <p style="color: var(--text-muted);">Grafik dan tabel detail akan ditampilkan di sini.</p>
</div>
@endsection