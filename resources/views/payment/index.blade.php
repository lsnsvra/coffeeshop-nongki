@extends('layouts.app')

@section('title', 'Checkout — NONGKI')

@push('styles')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        align-items: start;
    }
    .checkout-section {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gold);
    }
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .method-item {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .method-item:hover, .method-item.active {
        border-color: var(--gold);
        background: var(--gold-dim);
    }
    .method-icon {
        font-size: 1.5rem;
        width: 32px;
        text-align: center;
    }
    .order-summary {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        position: sticky;
        top: 88px;
    }
    .order-item {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }
    .order-item-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
        font-weight: 700;
        font-size: 1.1rem;
    }
    .btn-checkout {
        width: 100%;
        background: var(--gold);
        color: #000;
        font-weight: 700;
        padding: 1rem;
        border: none;
        border-radius: 12px;
        margin-top: 1.5rem;
        cursor: pointer;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        max-width: 500px;
        width: 90%;
        padding: 1.5rem;
        text-align: center;
    }
    .qr-code {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        display: inline-block;
        margin: 1rem 0;
    }
    .bank-detail {
        background: var(--dark-3);
        padding: 1rem;
        border-radius: 12px;
        text-align: left;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <!-- Left: Payment Methods -->
    <div>
        <div class="checkout-section">
            <div class="section-title">Metode Pembayaran</div>
            <div class="payment-methods-grid" id="paymentMethods">
                <div class="method-item" data-method="transfer">
                    <i class="fas fa-university method-icon"></i>
                    <span>Transfer Bank</span>
                </div>
                <div class="method-item" data-method="qris">
                    <i class="fas fa-qrcode method-icon"></i>
                    <span>QRIS</span>
                </div>
                <div class="method-item" data-method="ewallet">
                    <i class="fas fa-wallet method-icon"></i>
                    <span>E-Wallet</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Order Summary -->
    <div>
        <div class="order-summary">
            <div class="section-title">Ringkasan Pesanan</div>
            <div id="cartItemsList"></div>
            <div class="summary-row">
                <span>Total</span>
                <span id="totalAmount">Rp 0</span>
            </div>
            <button class="btn-checkout" id="checkoutBtn">Buat Pesanan</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <h3 id="modalTitle">Konfirmasi Pembayaran</h3>
        <div id="modalBody"></div>
        <button id="confirmPaymentBtn" class="btn-gold" style="margin-top:1rem;">Saya Sudah Bayar</button>
        <button id="closeModalBtn" style="margin-top:0.5rem; background:none; border:none; color:var(--text-muted); cursor:pointer;">Tutup</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = [];
    let selectedMethod = '';

    function loadCart() {
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        renderCart();
        updateTotal();
    }

    function renderCart() {
        const container = document.getElementById('cartItemsList');
        if (cart.length === 0) {
            container.innerHTML = '<p>Keranjang kosong</p>';
            return;
        }
        let html = '';
        cart.forEach(item => {
            html += `
                <div class="order-item">
                    <img class="order-item-img" src="${item.img}" alt="${item.name}" onerror="this.src='https://placehold.co/50x50?text=Coffee'">
                    <div style="flex:1">
                        <div>${item.name}</div>
                        <div style="font-size:0.8rem; color:var(--gold);">Rp ${item.price.toLocaleString()}</div>
                        <div style="font-size:0.7rem;">x ${item.quantity}</div>
                    </div>
                    <div>Rp ${(item.price * item.quantity).toLocaleString()}</div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    function updateTotal() {
        let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('totalAmount').innerHTML = `Rp ${total.toLocaleString()}`;
        return total;
    }

    document.querySelectorAll('.method-item').forEach(m => {
        m.addEventListener('click', function() {
            document.querySelectorAll('.method-item').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            selectedMethod = this.getAttribute('data-method');
        });
    });

    document.getElementById('checkoutBtn').addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Keranjang kosong');
            return;
        }
        if (!selectedMethod) {
            alert('Pilih metode pembayaran');
            return;
        }
        const total = updateTotal();
        const orderId = 'NGK-' + Date.now();
        const orderData = { orderId, items: cart, total, method: selectedMethod, date: new Date().toISOString() };
        localStorage.setItem('pendingOrder', JSON.stringify(orderData));
        showPaymentModal(selectedMethod, total, orderId);
    });

    function showPaymentModal(method, total, orderId) {
        const modal = document.getElementById('paymentModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');

        if (method === 'qris') {
            modalTitle.innerText = 'Scan QRIS untuk Membayar';
            const qrData = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=NONGKI|${orderId}|${total}`;
            modalBody.innerHTML = `
                <div class="qr-code"><img src="${qrData}" width="200" height="200" alt="QR Code"></div>
                <p>Total: Rp ${total.toLocaleString()}</p>
                <p style="font-size:0.8rem;">Scan QR code menggunakan mobile banking atau e-wallet.</p>
                <p style="font-size:0.7rem;">Setelah scan, klik tombol "Saya Sudah Bayar".</p>
            `;
        } else if (method === 'transfer') {
            modalTitle.innerText = 'Transfer Bank';
            modalBody.innerHTML = `
                <div class="bank-detail">
                    <p><strong>Bank BCA</strong><br>123 456 7890 a.n. PT NONGKI Coffee</p>
                    <hr style="border-color:var(--border);">
                    <p><strong>Bank Mandiri</strong><br>987 654 3210 a.n. PT NONGKI Coffee</p>
                </div>
                <p>Total: Rp ${total.toLocaleString()}</p>
                <p style="font-size:0.8rem;">Transfer sesuai nominal, lalu klik tombol "Saya Sudah Bayar".</p>
            `;
        } else if (method === 'ewallet') {
            modalTitle.innerText = 'Bayar dengan E-Wallet';
            modalBody.innerHTML = `
                <div class="bank-detail">
                    <p><strong>GoPay / OVO / Dana</strong><br>Virtual Account: 0888 1234 5678</p>
                </div>
                <p>Total: Rp ${total.toLocaleString()}</p>
                <p style="font-size:0.8rem;">Lakukan pembayaran melalui e-wallet, lalu klik tombol "Saya Sudah Bayar".</p>
            `;
        }
        modal.classList.add('active');
    }

    document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
        const pending = localStorage.getItem('pendingOrder');
        if (pending) {
            localStorage.setItem('lastOrder', pending);
            localStorage.removeItem('cart');
            localStorage.removeItem('cartCount');
            localStorage.removeItem('pendingOrder');
            window.location.href = "{{ route('order.success') }}";
        } else {
            alert('Tidak ada pesanan pending');
        }
    });

    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('paymentModal').classList.remove('active');
        localStorage.removeItem('pendingOrder');
    });

    loadCart();
</script>
@endpush