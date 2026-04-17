@extends('layouts.kasir')
@section('title', 'Transaksi — NONGKI Kasir')

@push('styles')
<style>
    .table-wrapper {
        background: var(--dark-2);
        border-radius: var(--radius-card);
        padding: 8px 0;
        border: 1px solid var(--border);
        overflow-x: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    .table th {
        text-align: left;
        padding: 18px 24px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
    }
    .table td {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        color: var(--cream);
    }
    .badge {
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-success { background: rgba(76,175,80,0.15); color: #8bc34a; }
    .badge-warning { background: rgba(255,152,0,0.15); color: #ffb74d; }
</style>
@endpush

@section('content')
<div class="page-title">
    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
</div>
<div class="table-wrapper">
    <table class="table">
        <thead><tr><th>ID</th><th>Pelanggan</th><th>Total</th><th>Metode</th><th>Waktu</th><th>Status</th></tr></thead>
        <tbody>
            @foreach([['#TRX-001','Sarah A.',85000,'QRIS','10:30','selesai'],['#TRX-002','Budi S.',120000,'Tunai','09:15','diproses']] as $trx)
            <tr>
                <td><strong style="color:var(--gold);">{{ $trx[0] }}</strong></td>
                <td>{{ $trx[1] }}</td>
                <td>Rp {{ number_format($trx[2],0,',','.') }}</td>
                <td>{{ $trx[3] }}</td>
                <td>{{ $trx[4] }}</td>
                <td><span class="badge {{ $trx[5]=='selesai'?'badge-success':'badge-warning' }}">{{ ucfirst($trx[5]) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection