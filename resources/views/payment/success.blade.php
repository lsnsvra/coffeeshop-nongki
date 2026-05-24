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
    .btn-outline-gold {
        background: transparent;
        border: 1px solid var(--gold, #d4af37);
        color: var(--gold, #d4af37);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-outline-gold:hover {
        background: var(--gold-dim, rgba(212, 175, 55, 0.1));
        color: var(--gold-light, #f3e5ab);
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
        
        // 🌟 Sinkronisasi ID Database/String ke teks display halaman
        const methodMap = {
            '1': 'Transfer Bank',
            '2': 'QRIS',
            '3': 'E-Wallet',
            'transfer': 'Transfer Bank',
            'qris': 'QRIS',
            'ewallet': 'E-Wallet'
        };
        
        let itemsHtml = '';
        
        if (order.items && order.items.length > 0) {
            order.items.forEach(item => {
                // Menghitung subtotal per item dengan aman
                const price = Number(item.price) || 0;
                const qty = Number(item.quantity) || Number(item.Qty) || 0;
                const itemName = item.name || item.ProductName || 'Menu';
                const itemImg = item.img || 'https://placehold.co/40x40?text=☕';

                itemsHtml += `
                    <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border, #333);">
                        <img src="${itemImg}" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;" onerror="this.src='https://placehold.co/40x40?text=☕'">
                        <div style="flex:1">
                            <div>${itemName} x ${qty}</div>
                            <div style="font-size:0.8rem; color: var(--gold);">Rp ${(price * qty).toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                `;
            });
        }

        // Pengaman isi variabel agar tidak muncul 'undefined' jika dikirim berbeda oleh controller
        const displayId = order.orderId || order.order_code || '-';
        const displayMethod = methodMap[order.method] || order.method || 'Lainnya';
        const displayDate = order.date ? new Date(order.date).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : new Date().toLocaleString('id-ID');
        const displayTotal = Number(order.total).toLocaleString('id-ID');

        const detailHtml = `
            <div><strong>Nomor Pesanan:</strong> <span style="color: var(--gold);">${displayId}</span></div>
            <div style="margin: 0.5rem 0;"><strong>Metode Pembayaran:</strong> ${displayMethod}</div>
            <div><strong>Tanggal Transaksi:</strong> ${displayDate}</div>
            <hr style="border-color:var(--border, #333); margin: 1rem 0;">
            <div style="margin-bottom: 0.5rem;"><strong>Item Pesanan:</strong></div>
            ${itemsHtml}
            <hr style="border-color:var(--border, #333); margin: 0.5rem 0;">
            <div style="text-align:right; font-size:1.2rem; font-weight:bold; color:var(--gold);">Total Bayar: Rp ${displayTotal}</div>
        `;
        
        document.getElementById('orderDetail').innerHTML = detailHtml;
        
        // Opsional: Hapus baris komentar di bawah jika ingin langsung membersihkan keranjang setelah sukses tampil
        // localStorage.removeItem('lastOrder');
    } else {
        document.getElementById('orderDetail').innerHTML = '<p style="text-align:center;">Tidak ada data pesanan terbaru aktif.</p>';
    }
</script>
@endpush