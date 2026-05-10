@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@push('styles')
<style>
    .report-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .report-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        padding: 1.5rem;
        border-radius: 16px;
    }
    .report-card .label { color: var(--text-muted-c); font-size: 0.8rem; text-transform: uppercase; }
    .report-card .value { color: var(--gold); font-size: 1.8rem; font-weight: 700; margin-top: 5px; }
    
    .table-wrapper {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem;
    }
    
    .filter-box {
        background: var(--dark-2);
        border: 1px solid var(--border);
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    @media print { .no-print { display: none !important; } }
</style>
@endpush

@section('content')
<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color: var(--gold); font-family: 'Cormorant Garamond', serif;">Laporan Penjualan</h1>
        <button onclick="window.print()" class="btn-nongki-primary no-print">Cetak Laporan</button>
    </div>

    <div class="filter-box no-print">
        <form action="" method="GET" class="d-flex align-items-center" style="gap: 15px;">
            <input type="date" name="start" value="{{ $start }}" class="form-control-nongki">
            <span style="color: var(--border);">to</span>
            <input type="date" name="end" value="{{ $end }}" class="form-control-nongki">
            <button type="submit" class="btn-nongki-primary">Filter</button>
        </form>
    </div>

    <div class="report-card-grid">
        <div class="report-card">
            <div class="label">Total Omzet</div>
            <div class="value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="report-card">
            <div class="label">Transaksi</div>
            <div class="value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="report-card">
            <div class="label">Menu Terlaris</div>
            <div class="value" style="font-size: 1.2rem;">{{ $terlaris->NamaProduk ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="table-wrapper">
        <h4 style="color: var(--cream); margin-bottom: 1.5rem;">Riwayat Penjualan Terakhir</h4>
        <div class="table-responsive">
            <table class="nongki-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>Waktu Transaksi</th>
                        <th class="text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiTerakhir as $t)
                    <tr>
                        <td style="color: var(--gold);">#{{ $t->OrderID }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->CreatedDate)->format('d M Y, H:i') }}</td>
                        <td class="text-right" style="color: var(--cream);">Rp {{ number_format($t->TotalBayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection