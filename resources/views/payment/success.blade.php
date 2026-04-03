@extends('layouts.app')

@section('title', 'Pesanan Berhasil — NONGKI')

@section('page_title', 'Pesanan Berhasil!')
@section('breadcrumb')
    <span class="text-muted">Sukses</span>
@endsection

@push('styles')
<style>
    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .success-icon svg {
        width: 40px;
        height: 40px;
        color: var(--dark);
    }
    .order-number {
        background: var(--dark-3);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        display: inline-block;
        font-family: monospace;
        letter-spacing: 1px;
    }
</style>
@endpush

@section('content')
<div class="text-center py-5">
    <div class="success-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <h2 style="font-family:'Cormorant Garamond';">Terima Kasih!</h2>
    <p class="text-muted mb-3">Pesanan Anda telah kami terima dan akan segera diproses.</p>
    <div class="order-number mb-4">#NGK-20260331-001</div>
    <p class="mb-4">Silakan tunjukkan nomor pesanan saat mengambil pesanan.</p>
    <a href="{{ route('home') }}" class="btn-gold">Kembali ke Beranda</a>
    <a href="{{ route('menu.index') }}" class="btn-outline-gold ms-2">Lihat Menu Lagi</a>
</div>
@endsection