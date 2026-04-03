@extends('layouts.app')

@section('title', 'Pesanan Berhasil — NONGKI')

@push('styles')
<style>
    .success-container {
        max-width: 600px;
        margin: 2rem auto;
        text-align: center;
    }

    /* Animasi centang */
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

    /* Perbaikan warna teks agar tidak biru seperti link */
    .order-detail {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: left;
        margin: 1.5rem 0;
        color: var(--cream); /* teks putih/krem */
    }
    .order-detail a, .order-detail a:hover {
        color: inherit;
        text-decoration: none;
    }
    .btn-outline-gold {
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        text-decoration: none;
    }
    .btn-outline-gold:hover {
        background: var(--gold-dim);
        color: var(--gold-light);
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <!-- Animasi Centang -->
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
        Memuat detail pesanan...
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
        <a href="{{ route('menu.index') }}" class="btn-gold">Pesan Lagi</a>
        <a href="{{ route('riwayat.pesanan') }}" class="btn-outline-gold">Lihat Riwayat</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const lastOrder = localStorage.getItem('lastOrder');
    if (lastOrder) {
        const order = JSON.parse(lastOrder);
        const methodMap = {
            'transfer': 'Transfer Bank',
            'qris': 'QRIS',
            'ewallet': 'E-Wallet'
        };
        let itemsHtml = '';
        order.items.forEach(item => {
            itemsHtml += `
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
                    <img src="${item.img}" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;" onerror="this.src='https://placehold.co/40x40?text=☕'">
                    <div style="flex:1">
                        <div>${item.name} x ${item.quantity}</div>
                        <div style="font-size:0.8rem;">Rp ${(item.price * item.quantity).toLocaleString()}</div>
                    </div>
                </div>
            `;
        });
        const detailHtml = `
            <div><strong>Nomor Pesanan:</strong> ${order.orderId}</div>
            <div style="margin: 0.5rem 0;"><strong>Metode Pembayaran:</strong> ${methodMap[order.method]}</div>
            <div><strong>Tanggal:</strong> ${new Date(order.date).toLocaleString('id-ID')}</div>
            <hr style="border-color:var(--border); margin: 1rem 0;">
            <div><strong>Detail Pesanan:</strong></div>
            ${itemsHtml}
            <hr style="border-color:var(--border); margin: 0.5rem 0;">
            <div style="text-align:right; font-size:1.2rem; font-weight:bold; color:var(--gold);">Total: Rp ${order.total.toLocaleString()}</div>
        `;
        document.getElementById('orderDetail').innerHTML = detailHtml;
        // Optional: hapus lastOrder setelah ditampilkan
        // localStorage.removeItem('lastOrder');
    } else {
        document.getElementById('orderDetail').innerHTML = '<p>Tidak ada data pesanan.</p>';
    }
</script>
@endpush