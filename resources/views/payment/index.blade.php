@extends('layouts.app')

@section('title', 'Pembayaran — NONGKI')

@section('page_title', 'Pilih Metode Pembayaran')
@section('breadcrumb')
    <a href="{{ route('checkout') }}">Checkout</a> · Pembayaran
@endsection

@push('styles')
<style>
    .payment-method {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .payment-method:hover {
        border-color: var(--gold);
    }
    .payment-method.active {
        border-color: var(--gold);
        background: var(--gold-dim);
    }
    .method-icon {
        width: 40px;
        height: 40px;
        background: rgba(201,168,76,0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card-nongki">
            <h5 class="mb-3" style="font-family:'Cormorant Garamond';">Metode Pembayaran</h5>
            <div class="payment-method" onclick="selectMethod(this)">
                <div class="d-flex align-items-center">
                    <div class="method-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="fw-bold">Transfer Bank</div>
                        <small class="text-muted">BCA, Mandiri, BNI, BRI</small>
                    </div>
                </div>
            </div>
            <div class="payment-method" onclick="selectMethod(this)">
                <div class="d-flex align-items-center">
                    <div class="method-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <div class="fw-bold">E-Wallet</div>
                        <small class="text-muted">OVO, GoPay, Dana, LinkAja</small>
                    </div>
                </div>
            </div>
            <div class="payment-method" onclick="selectMethod(this)">
                <div class="d-flex align-items-center">
                    <div class="method-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                    </div>
                    <div>
                        <div class="fw-bold">Tunai di Tempat</div>
                        <small class="text-muted">Bayar langsung saat ambil pesanan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-nongki">
            <h5 class="mb-3" style="font-family:'Cormorant Garamond';">Detail Pesanan</h5>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span>Rp 197.000</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>
            <hr class="border-secondary">
            <div class="d-flex justify-content-between mb-4">
                <strong>Total</strong>
                <strong class="text-gold">Rp 197.000</strong>
            </div>
            <a href="{{ route('payment.success') }}" class="btn-gold w-100 text-center">Bayar Sekarang</a>
        </div>
    </div>
</div>

<script>
    function selectMethod(element) {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        element.classList.add('active');
    }
</script>
@endsection