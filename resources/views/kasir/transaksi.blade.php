@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi — NONGKI Kasir')

@section('content')
<div class="pos-left">
    <h3 style="font-family: 'Cormorant Garamond', serif; margin-bottom: 20px;">Riwayat Transaksi</h3>
    <table style="width:100%; border-collapse:collapse; color: var(--cream-dim);">
        <thead><tr style="border-bottom:1px solid var(--border);"><th style="padding:12px 8px;">ID</th><th>Total</th><th>Waktu</th><th>Status</th></tr></thead>
        <tbody>
            <tr><td>#TRX-001</td><td>Rp 85.000</td><td>10:30</td><td><span style="color:#8bc34a;">Selesai</span></td></tr>
            <tr><td>#TRX-002</td><td>Rp 120.000</td><td>09:15</td><td><span style="color:#ff9800;">Diproses</span></td></tr>
        </tbody>
    </table>
</div>
<div class="pos-right">
    <h4>Filter</h4>
    <input type="date" style="width:100%; background:var(--dark-3); border:1px solid var(--border); color:var(--cream); padding:10px; border-radius:8px;">
</div>
@endsection