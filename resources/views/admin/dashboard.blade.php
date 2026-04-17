@extends('layouts.admin')

@section('title', 'Dashboard Admin — NONGKI')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang, <strong>{{ Auth::user()->Nama }}</strong>. Pantau performa NONGKI hari ini.</p>
</div>

<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div class="stat-card-value">Rp 4.200.000</div>
        <div class="stat-card-label">Total Penjualan Hari Ini</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 12% dari kemarin</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-receipt"></i></div>
        <div class="stat-card-value">87</div>
        <div class="stat-card-label">Total Transaksi</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 5 transaksi</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-mug-saucer"></i></div>
        <div class="stat-card-value">24</div>
        <div class="stat-card-label">Menu Aktif</div>
        <div class="stat-card-change">4 menu baru</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fa-solid fa-users"></i></div>
        <div class="stat-card-value">312</div>
        <div class="stat-card-label">Total Pelanggan</div>
        <div class="stat-card-change"><i class="fa-solid fa-arrow-up"></i> 18 pelanggan baru</div>
    </div>
</div>

{{-- Tabel Pesanan Terbaru --}}
<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-top: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; color: var(--cream);">Pesanan Terbaru</h3>
        <a href="#" style="color: var(--gold); font-size: 13px; text-decoration: none;">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <table style="width: 100%; border-collapse: collapse; color: var(--cream-dim); font-size: 14px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border); color: rgba(245,237,216,0.5); text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                <th style="padding: 12px 8px; text-align: left;">ID Pesanan</th>
                <th style="padding: 12px 8px; text-align: left;">Pelanggan</th>
                <th style="padding: 12px 8px; text-align: left;">Total</th>
                <th style="padding: 12px 8px; text-align: left;">Status</th>
                <th style="padding: 12px 8px; text-align: left;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0245</td>
                <td style="padding: 14px 8px;">Sarah A.</td>
                <td style="padding: 14px 8px;">Rp 85.000</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(201,168,76,0.15); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-size: 11px;">Selesai</span></td>
                <td style="padding: 14px 8px;">10:30 WIB</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0244</td>
                <td style="padding: 14px 8px;">Budi S.</td>
                <td style="padding: 14px 8px;">Rp 120.000</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(76,175,80,0.15); color: #8bc34a; padding: 4px 10px; border-radius: 20px; font-size: 11px;">Diproses</span></td>
                <td style="padding: 14px 8px;">09:15 WIB</td>
            </tr>
            <tr>
                <td style="padding: 14px 8px; color: var(--gold);">#NGK-0243</td>
                <td style="padding: 14px 8px;">Dian P.</td>
                <td style="padding: 14px 8px;">Rp 65.000</td>
                <td style="padding: 14px 8px;"><span style="background: rgba(201,168,76,0.15); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-size: 11px;">Selesai</span></td>
                <td style="padding: 14px 8px;">08:45 WIB</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection