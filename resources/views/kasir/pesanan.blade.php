@extends('layouts.kasir')
@section('title', 'Pesanan Masuk — NONGKI Kasir')

@push('styles')
<style>
    .order-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .order-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 24px;
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .order-id {
        color: var(--gold);
        font-weight: 700;
    }
    .order-items {
        margin: 16px 0;
        padding-left: 20px;
        color: var(--cream-dim);
    }
    .btn-status {
        background: var(--gold);
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="page-title">
    <i class="fa-solid fa-bell"></i> Pesanan Masuk (Dapur)
</div>
<div class="order-grid">
    @for($i=1; $i<=4; $i++)
    <div class="order-card">
        <div class="order-header">
            <span class="order-id">#NGK-00{{ $i }}</span>
            <span>{{ rand(1,10) }} menit lalu</span>
        </div>
        <p><strong>Meja 0{{ $i }}</strong></p>
        <ul class="order-items">
            <li>Americano 2x</li>
            <li>Croissant 1x</li>
        </ul>
        <button class="btn-status" onclick="alert('Status diubah')">Selesai</button>
    </div>
    @endfor
</div>
@endsection