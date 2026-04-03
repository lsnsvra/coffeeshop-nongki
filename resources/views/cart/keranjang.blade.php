@extends('layouts.app')

@section('title', 'Keranjang Belanja — NONGKI')

@section('page_title', 'Keranjang Belanja')
@section('breadcrumb')
    <a href="{{ route('home') }}">Beranda</a> · Keranjang
@endsection

@section('page_actions')
    {{-- bisa ditambah tombol jika perlu --}}
@endsection

@section('content')
<div class="cart-layout" style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">
    <!-- Daftar Item Keranjang -->
    <div class="card-nongki" style="padding: 0;">
        <div class="card-nongki-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); margin-bottom: 0;">
            <span>Item Pesanan</span>
            <button class="clear-btn" style="background: none; border: none; color: var(--red); font-size: 0.8rem; cursor: pointer;">Hapus Semua</button>
        </div>

        <!-- Item 1 -->
        <div class="cart-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);">
            <div style="width: 64px; height: 64px; background: var(--dark-3); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">☕</div>
            <div style="flex: 1;">
                <div style="font-weight: 500;">Caramel Latte</div>
                <div style="font-size: 0.75rem; color: var(--text-muted-c);">Ukuran: Large · Gula: Normal</div>
                <div style="font-weight: 600; color: var(--gold); margin-top: 4px;">Rp 38.000</div>
            </div>
            <div style="display: flex; align-items: center; gap: 0; background: var(--dark-3); border: 1px solid var(--border); border-radius: 10px;">
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">−</button>
                <span style="width: 32px; text-align: center; border-left: 1px solid var(--border); border-right: 1px solid var(--border); line-height: 34px;">1</span>
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">+</button>
            </div>
            <button style="width: 34px; height: 34px; background: none; border: 1px solid var(--border); border-radius: 8px; color: var(--text-dim); cursor: pointer;">🗑</button>
        </div>

        <!-- Item 2 -->
        <div class="cart-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);">
            <div style="width: 64px; height: 64px; background: var(--dark-3); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">🍵</div>
            <div style="flex: 1;">
                <div style="font-weight: 500;">Matcha Oat Latte</div>
                <div style="font-size: 0.75rem; color: var(--text-muted-c);">Ukuran: Medium · Gula: Less</div>
                <div style="font-weight: 600; color: var(--gold); margin-top: 4px;">Rp 42.000</div>
            </div>
            <div style="display: flex; align-items: center; gap: 0; background: var(--dark-3); border: 1px solid var(--border); border-radius: 10px;">
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">−</button>
                <span style="width: 32px; text-align: center; border-left: 1px solid var(--border); border-right: 1px solid var(--border); line-height: 34px;">1</span>
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">+</button>
            </div>
            <button style="width: 34px; height: 34px; background: none; border: 1px solid var(--border); border-radius: 8px; color: var(--text-dim); cursor: pointer;">🗑</button>
        </div>

        <!-- Item 3 -->
        <div class="cart-item" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem;">
            <div style="width: 64px; height: 64px; background: var(--dark-3); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">🥐</div>
            <div style="flex: 1;">
                <div style="font-weight: 500;">Croissant Butter</div>
                <div style="font-size: 0.75rem; color: var(--text-muted-c);">Original</div>
                <div style="font-weight: 600; color: var(--gold); margin-top: 4px;">Rp 28.000</div>
            </div>
            <div style="display: flex; align-items: center; gap: 0; background: var(--dark-3); border: 1px solid var(--border); border-radius: 10px;">
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">−</button>
                <span style="width: 32px; text-align: center; border-left: 1px solid var(--border); border-right: 1px solid var(--border); line-height: 34px;">1</span>
                <button class="qty-btn" style="width: 34px; height: 34px; background: none; border: none; color: var(--text-muted-c); font-size: 1.2rem; cursor: pointer;">+</button>
            </div>
            <button style="width: 34px; height: 34px; background: none; border: 1px solid var(--border); border-radius: 8px; color: var(--text-dim); cursor: pointer;">🗑</button>
        </div>
    </div>

    <!-- Ringkasan Pesanan -->
    <div class="card-nongki" style="position: sticky; top: 88px;">
        <div class="card-nongki-header">Ringkasan Pesanan</div>
        <div style="margin-top: 0.5rem;">
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Caramel Latte × 1</span>
                <span>Rp 38.000</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Matcha Oat Latte × 1</span>
                <span>Rp 42.000</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Croissant Butter × 1</span>
                <span>Rp 28.000</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Subtotal</span>
                <span>Rp 108.000</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Diskon</span>
                <span style="color: var(--green);">- Rp 0</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid var(--border);">
                <span>Pajak (10%)</span>
                <span>Rp 10.800</span>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem; margin: 1rem 0;">
            <input type="text" placeholder="Kode promo..." style="flex: 1; background: var(--dark-3); border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; color: var(--cream);">
            <button class="btn-gold" style="padding: 0.5rem 1rem;">Pakai</button>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <span style="font-weight: 600;">Total</span>
            <span style="font-size: 1.3rem; font-weight: 700; color: var(--gold);">Rp 118.800</span>
        </div>
        <button class="btn-gold" style="width: 100%; margin-top: 1rem;">Lanjut ke Pembayaran →</button>
        <a href="{{ route('menu.index') }}" style="display: block; text-align: center; margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted-c); text-decoration: none;">← Tambah Menu Lain</a>
    </div>
</div>

{{-- Script untuk qty button --}}
@push('scripts')
<script>
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            let delta = this.innerText === '+' ? 1 : -1;
            let numSpan = this.parentNode.querySelector('span');
            let val = parseInt(numSpan.innerText) + delta;
            if (val < 1) val = 1;
            numSpan.innerText = val;
            // di sini nanti bisa tambah AJAX update cart
        });
    });
</script>
@endpush
@endsection