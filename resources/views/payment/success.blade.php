@extends('layouts.app')

@section('title', 'Pesanan Berhasil — NONGKI')

@push('styles')
<style>
    .success-container {
        max-width: 600px;
        margin: 2rem auto;
        text-align: center;
    }

    /* Animasi centang bawaan kamu */
    .checkmark-wrapper {
        margin: 0 auto 1.5rem;
        width: 100px;
        height: 100px;
        position: relative;
    }
    .checkmark-circle {
        width: 100px;
        height: 100px;
        background: #52b788;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        transform: scale(0);
    }
    .checkmark-icon {
        width: 50px;
        height: 50px;
        stroke: white;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        stroke-dasharray: 50;
        stroke-dashoffset: 50;
        animation: drawCheck 0.4s ease-out 0.3s forwards;
    }
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes drawCheck {
        0% { stroke-dashoffset: 50; }
        100% { stroke-dashoffset: 0; }
    }

    /* Teks detail pesanan */
    .order-detail {
        background: var(--dark-2, #1a1a1a);
        border: 1px solid var(--border, #333);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: left;
        margin: 1.5rem 0;
        color: var(--cream, #f5f5dc);
    }
    .order-detail a, .order-detail a:hover {
        color: inherit;
        text-decoration: none;
    }

    /* ── Ukuran Tombol Bulat Lonjong (Capsule) Agak Gedean Dikit & Pas ── */
    .btn-gold, .btn-outline-gold {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.92rem;          
        font-weight: 500;
        padding: 0.5rem 1.5rem;      
        border-radius: 40px;         /* Mempertahankan bentuk bulat lonjong capsule */
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        height: 38px;                /* Tinggi diperbesar sedikit agar pas mantap */
        min-width: 140px;            
    }

    .btn-gold {
        background: var(--gold, #d4af37);
        color: #000 !important;
        border: 1px solid var(--gold, #d4af37);
    }
    .btn-gold:hover {
        background: #f3e5ab;
        border-color: #f3e5ab;
    }

    .btn-outline-gold {
        background: transparent;
        border: 1px solid var(--gold, #d4af37);
        color: var(--gold, #d4af37) !important;
    }
    .btn-outline-gold:hover {
        background: var(--gold-dim, rgba(212, 175, 55, 0.1));
        color: var(--gold-light, #f3e5ab) !important;
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="checkmark-wrapper">
        <div class="checkmark-circle">
            <svg class="checkmark-icon" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </div>
    </div>

    <h2>Pesanan Berhasil!</h2>
    <p>Terima kasih, pesanan Anda telah kami terima.</p>

    <div class="order-detail" id="orderDetail">
        <div>
            <strong>Nomor Pesanan:</strong> 
            <span style="color: var(--gold);">{{ $order->order_code ?? $order->OrderID }}</span>
        </div>
        <div style="margin: 0.5rem 0;">
            <strong>Metode Pembayaran:</strong> 
            {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'Midtrans Otomatis')) }}
        </div>
        <div>
            <strong>Tanggal Transaksi:</strong> 
            {{ $order->TanggalOrder ? \Carbon\Carbon::parse($order->TanggalOrder)->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y, H:i') }} WIB
        </div>
        
        <hr style="border-color:var(--border, #333); margin: 1rem 0;">
        <div style="margin-bottom: 0.5rem;"><strong>Item Pesanan:</strong></div>
        
        @if($order->orderDetails && $order->orderDetails->count() > 0)
            @foreach($order->orderDetails as $detail)
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border, #333); align-items: center;">
                    
                    @php
                        // Cari data produk langsung berdasarkan foreign key pembawa item detail
                        $idProduk = $detail->ProductID ?? $detail->product_id ?? null;
                        $produkLangsung = App\Models\Product::where('ProductID', $idProduk)->first();
                        
                        // Tarik nama file image dan nama kopi berdasarkan database asli Anda
                        $namaGambar = $produkLangsung ? $produkLangsung->image : ($detail->product->image ?? '');
                        $namaKopi = $produkLangsung ? $produkLangsung->NameKopi : ($detail->product->NameKopi ?? 'Menu Kopi');
                    @endphp
                    
                    <img src="{{ asset('products/' . $namaGambar) }}" 
                         style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;" 
                         onerror="this.src='https://placehold.co/40x40?text=☕'">
                    
                    <div style="flex:1">
                        <div>{{ $namaKopi }} x {{ $detail->Qty }}</div>
                        <div style="font-size:0.8rem; color: var(--gold);">Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <p style="color: #888; font-size: 0.9rem;">Detail item tersimpan di sistem.</p>
        @endif

        <hr style="border-color:var(--border, #333); margin: 0.5rem 0;">
        <div style="text-align:right; font-size:1.2rem; font-weight:bold; color:var(--gold);">
            Total Bayar: Rp {{ number_format($order->TotalHarga, 0, ',', '.') }}
        </div>
    </div>

    <div style="display: flex; gap: 0.75rem; justify-content: center; margin-top: 1.5rem;">
        <a href="/menu" class="btn-gold">Pesan Lagi</a>
        <a href="/riwayat-pesanan" class="btn-outline-gold">Lihat Riwayat</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    localStorage.removeItem('lastOrder');
    localStorage.removeItem('pendingOrder');
</script>
@endpush