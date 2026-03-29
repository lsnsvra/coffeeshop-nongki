@extends('layouts.app')

@section('title', 'Dashboard — NONGKI')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house"></i>
        <span>Home</span>
        <i class="bi bi-chevron-right" style="font-size:.65rem;"></i>
        <span>Dashboard</span>
    </div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Selamat datang kembali! Berikut ringkasan bisnis kamu hari ini.</p>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFF3CD;">
                <i class="bi bi-receipt" style="color:#D4860B;"></i>
            </div>
            <div class="stat-label">Order Hari Ini</div>
            <div class="stat-value">24</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+12% dari kemarin</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D4EDDA;">
                <i class="bi bi-cash-stack" style="color:#2D7A4F;"></i>
            </div>
            <div class="stat-label">Pendapatan</div>
            <div class="stat-value" style="font-size:1.2rem;">Rp 1,2Jt</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i>+8% dari kemarin</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--brown-100);">
                <i class="bi bi-box-seam" style="color:var(--brown-600);"></i>
            </div>
            <div class="stat-label">Produk Aktif</div>
            <div class="stat-value">9</div>
            <div class="stat-change" style="color:var(--text-soft);">dari 9 total produk</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FDDDDB;">
                <i class="bi bi-clock-history" style="color:#C0392B;"></i>
            </div>
            <div class="stat-label">Order Pending</div>
            <div class="stat-value">3</div>
            <div class="stat-change down">Perlu diproses segera</div>
        </div>
    </div>

</div>

{{-- CONTENT ROW --}}
<div class="row g-4">

    {{-- Order Terbaru --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-receipt me-2" style="color:var(--brown-400);"></i>Order Terbaru</h3>
                <a href="#" class="btn-ghost" style="font-size:.8rem;">Lihat semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="table-custom" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $dummyOrders = [
                            ['ORD-ABC123', 'Budi Santoso',   'Rp 46.000', 'QRIS',  'paid'],
                            ['ORD-DEF456', 'Siti Rahma',     'Rp 22.000', 'Cash',  'paid'],
                            ['ORD-GHI789', 'Agus Wijaya',    'Rp 75.000', 'QRIS',  'pending'],
                            ['ORD-JKL012', 'Rina Susanti',   'Rp 28.000', 'Cash',  'pending'],
                            ['ORD-MNO345', 'Dani Pratama',   'Rp 55.000', 'QRIS',  'paid'],
                        ];
                        @endphp
                        @foreach($dummyOrders as $o)
                        <tr>
                            <td><span style="font-weight:700;color:var(--brown-700);">#{{ $o[0] }}</span></td>
                            <td>{{ $o[1] }}</td>
                            <td style="font-weight:600;">{{ $o[2] }}</td>
                            <td>
                                <span class="badge-custom {{ $o[3] === 'QRIS' ? 'badge-info' : 'badge-warning' }}">
                                    <i class="bi bi-{{ $o[3] === 'QRIS' ? 'qr-code' : 'cash' }}"></i>
                                    {{ $o[3] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-custom {{ $o[4] === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                    <i class="bi bi-circle-fill" style="font-size:.4rem;"></i>
                                    {{ ucfirst($o[4]) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Produk --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-trophy me-2" style="color:var(--brown-400);"></i>Top Produk</h3>
            </div>
            <div class="card-body">
                @php
                $topProduk = [
                    ['Cappuccino',    142, 85],
                    ['Matcha Latte',  98,  60],
                    ['Latte',         87,  52],
                    ['Espresso',      64,  38],
                    ['Red Velvet',    41,  25],
                ];
                @endphp
                @foreach($topProduk as $i => $p)
                <div style="margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.35rem;">
                        <div style="display:flex;align-items:center;gap:.6rem;">
                            <span style="width:22px;height:22px;background:var(--brown-{{ $i === 0 ? '300' : ($i === 1 ? '200' : '100') }});border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:var(--brown-800);">{{ $i+1 }}</span>
                            <span style="font-size:.875rem;font-weight:600;">{{ $p[0] }}</span>
                        </div>
                        <span style="font-size:.78rem;color:var(--text-soft);">{{ $p[1] }} terjual</span>
                    </div>
                    <div style="height:5px;background:var(--brown-50);border-radius:50px;overflow:hidden;">
                        <div style="height:100%;width:{{ $p[2] }}%;background:var(--brown-{{ $i === 0 ? '400' : ($i === 1 ? '300' : '200') }});border-radius:50px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
