@extends('layouts.app')

@section('title', 'Checkout — NONGKI')

@section('page_title', 'Checkout')
@section('breadcrumb')
    <a href="{{ route('cart') }}">Keranjang</a> · Checkout
@endsection

@push('styles')
<style>
    .checkout-summary {
        background: var(--dark-2);
        border-radius: 14px;
        padding: 1.5rem;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card-nongki">
            <h5 class="mb-3" style="font-family:'Cormorant Garamond';">Informasi Pemesan</h5>
            <form>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" placeholder="Nama Anda" style="background:var(--dark-3); border:1px solid var(--border); color:var(--cream);">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Meja</label>
                    <input type="text" class="form-control" placeholder="Contoh: Meja 5 / Take Away" style="background:var(--dark-3); border:1px solid var(--border); color:var(--cream);">
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea class="form-control" rows="3" placeholder="Tambahkan catatan untuk pesanan Anda..." style="background:var(--dark-3); border:1px solid var(--border); color:var(--cream);"></textarea>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="checkout-summary">
            <h5 class="mb-3" style="font-family:'Cormorant Garamond';">Ringkasan Pesanan</h5>
            <div class="order-item">
                <span>Caramel Latte x2</span>
                <span>Rp 84.000</span>
            </div>
            <div class="order-item">
                <span>Cold Brew Classic x1</span>
                <span>Rp 38.000</span>
            </div>
            <div class="order-item">
                <span>Croissant Butter x3</span>
                <span>Rp 75.000</span>
            </div>
            <hr class="border-secondary">
            <div class="order-item mb-3">
                <strong>Total</strong>
                <strong class="text-gold">Rp 197.000</strong>
            </div>
            <a href="{{ route('payment') }}" class="btn-gold w-100 text-center">Lanjut ke Pembayaran</a>
        </div>
    </div>
</div>
@endsection