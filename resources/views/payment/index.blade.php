@extends('layouts.app')

@section('title', 'Checkout — NONGKI')

@push('styles')
<style>
    /* ========== LAYOUT DASAR ========== */
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        align-items: start;
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .checkout-section {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--gold);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 1rem;
    }

    /* ========== METODE PEMBAYARAN ========== */
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .method-item {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .method-item:hover {
        background: rgba(212, 175, 55, 0.05);
        border-color: rgba(212, 175, 55, 0.3);
        transform: translateY(-2px);
    }
    .method-item.active {
        background: rgba(212, 175, 55, 0.1);
        border-color: var(--gold);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.15);
    }
    .method-icon {
        font-size: 1.5rem;
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.2); border-radius: 10px;
        color: var(--gold);
    }
    .method-item span { font-weight: 600; color: #f0ece3; letter-spacing: 0.5px; }

    /* ========== RINGKASAN PESANAN ========== */
    .order-summary {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2rem;
        position: sticky;
        top: 88px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .order-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }
    .order-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .order-item-img {
        width: 60px; height: 60px;
        border-radius: 12px; object-fit: cover;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .summary-total {
        display: flex; justify-content: space-between;
        padding-top: 1.5rem; margin-top: 1.5rem;
        border-top: 1px solid rgba(212,175,55,0.3);
        font-weight: 800; font-size: 1.2rem; color: var(--gold);
    }
    .btn-checkout {
        width: 100%; background: linear-gradient(135deg, var(--gold) 0%, #e6c147 100%);
        color: #000; font-weight: 800; padding: 1.2rem; border: none; border-radius: 14px;
        margin-top: 2rem; cursor: pointer; transition: 0.3s; font-size: 1rem;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .btn-checkout:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(212,175,55,0.3); }

    /* ========== NONGKI PREMIUM MODAL (PEMBAYARAN & ALERT) ========== */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.4s ease;
        padding: 1rem; /* Biar ngga nabrak pinggir layar di HP */
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    
    .nongki-modal-box {
        background: linear-gradient(145deg, var(--dark-2) 0%, #0a0a0a 100%); 
        border: 1px solid rgba(212,175,55,0.25); 
        border-radius: 28px;
        padding: 2.5rem 2rem; 
        width: 100%; max-width: 420px; 
        text-align: center;
        
        /* Solusi Anti-Potong */
        max-height: 85vh; 
        overflow-y: auto; 
        
        transform: translateY(30px) scale(0.95); 
        transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 30px 60px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.05);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }

    /* Custom Scrollbar khusus Modal */
    .nongki-modal-box::-webkit-scrollbar { width: 6px; }
    .nongki-modal-box::-webkit-scrollbar-track { background: transparent; }
    .nongki-modal-box::-webkit-scrollbar-thumb { background: rgba(212,175,55,0.3); border-radius: 10px; }
    
    /* Style Khusus Modal Pembayaran */
    .qr-code { 
        background: #ffffff; 
        padding: 1.2rem; 
        border-radius: 20px; 
        display: inline-block; 
        margin: 1.2rem 0; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.3); 
    }
    .qr-code img { border-radius: 8px; display: block; }
    
    .bank-detail { 
        background: rgba(0,0,0,0.2); 
        border: 1px solid rgba(255,255,255,0.05); 
        padding: 1.5rem; 
        border-radius: 20px; 
        text-align: left; 
        margin: 1.5rem 0; 
    }
    
    .btn-gold-modal { 
        width: 100%; background: linear-gradient(135deg, var(--gold) 0%, #e6c147 100%); 
        color: #000; font-weight: 800; padding: 1.2rem; border: none; 
        border-radius: 14px; cursor: pointer; transition: 0.3s; margin-top: 1.5rem; 
        font-size: 1rem; letter-spacing: 0.5px;
    }
    .btn-gold-modal:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(212,175,55,0.3); }
    
    .btn-cancel-modal { 
        margin-top: 1rem; background: transparent; border: 1px solid rgba(255,255,255,0.1); 
        color: #A0A0A0; padding: 1rem; border-radius: 14px; width: 100%; 
        cursor: pointer; transition: 0.3s; font-weight: 600; 
    }
    .btn-cancel-modal:hover { background: rgba(255,255,255,0.05); color: #fff; }

    /* Style Khusus Alert Warning */
    .alert-icon-warning { 
        width: 75px; height: 75px; margin: 0 auto 1.5rem; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; font-size: 2.2rem; 
        background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); 
    }

    @media (max-width: 768px) {
        .checkout-container { grid-template-columns: 1fr; }
        .payment-methods-grid { grid-template-columns: 1fr; }
        .order-summary { position: static; }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div>
        <div class="checkout-section">
            <div class="section-title"><i class="fas fa-wallet"></i> Pilih Metode Pembayaran</div>
            <div class="payment-methods-grid" id="paymentMethods">
                <div class="method-item" data-method="transfer">
                    <div class="method-icon"><i class="fas fa-university"></i></div>
                    <span>Transfer Bank</span>
                </div>
                <div class="method-item" data-method="qris">
                    <div class="method-icon"><i class="fas fa-qrcode"></i></div>
                    <span>QRIS Scan</span>
                </div>
                <div class="method-item" data-method="ewallet">
                    <div class="method-icon"><i class="fas fa-mobile-alt"></i></div>
                    <span>E-Wallet</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="order-summary">
            <div class="section-title"><i class="fas fa-receipt"></i> Ringkasan Pesanan</div>
            <div id="cartItemsList"></div>
            <div class="summary-total">
                <span>Total Pembayaran</span>
                <span id="totalAmount">Rp 0</span>
            </div>
            <button class="btn-checkout" id="checkoutBtn">Buat Pesanan Sekarang</button>
        </div>
    </div>
</div>

<div class="nongki-modal-overlay" id="paymentModal">
    <div class="nongki-modal-box">
        <h3 id="modalTitle" style="color: var(--gold); margin-top: 0; font-size: 1.5rem; font-family: 'Cormorant Garamond', serif;">Konfirmasi Pembayaran</h3>
        <p style="color: #A0A0A0; font-size: 0.9rem; margin-bottom: 0;">Selesaikan pembayaran Anda untuk memproses pesanan.</p>
        
        <div id="modalBody"></div>
        
        <button id="confirmPaymentBtn" class="btn-gold-modal">SAYA SUDAH BAYAR</button>
        <button id="closeModalBtn" class="btn-cancel-modal">Ubah Metode Pembayaran</button>
    </div>
</div>

<div class="nongki-modal-overlay" id="nongkiAlertModal">
    <div class="nongki-modal-box" style="max-width: 380px;">
        <div class="alert-icon-warning"><i class="fas fa-exclamation-triangle"></i></div>
        <h3 style="color: #f0ece3; margin-bottom: 0.8rem; font-weight: 800; font-size: 1.4rem;">Perhatian!</h3>
        <p id="nongkiAlertMessage" style="color: rgba(240, 236, 227, 0.7); font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.6;"></p>
        <button type="button" class="btn-gold-modal" style="margin-top:0;" onclick="closeNongkiAlert()">Mengerti</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = [];
    let selectedMethod = '';

    // Inisialisasi Keranjang
    function loadCart() {
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        renderCart();
        updateTotal();
    }

    function renderCart() {
        const container = document.getElementById('cartItemsList');
        if (cart.length === 0) {
            container.innerHTML = `
                <div style="text-align:center; padding: 2rem 0; color: #A0A0A0;">
                    <i class="fas fa-shopping-basket" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem;"></i>
                    <p>Keranjang belanja Anda masih kosong.</p>
                </div>`;
            return;
        }
        let html = '';
        cart.forEach(item => {
            html += `
                <div class="order-item">
                    <img class="order-item-img" src="${item.img}" alt="${item.name}" onerror="this.src='https://placehold.co/100x100?text=Kopi'">
                    <div style="flex:1">
                        <div style="font-weight: 700; color: #f0ece3; font-size: 1.05rem;">${item.name}</div>
                        <div style="font-size:0.85rem; color:var(--gold); margin-top:4px;">Rp ${item.price.toLocaleString()}</div>
                        <div style="font-size:0.8rem; color:#A0A0A0; margin-top:2px;">Jumlah: ${item.quantity}x</div>
                    </div>
                    <div style="font-weight: 800; color: #f0ece3; display:flex; align-items:center;">
                        Rp ${(item.price * item.quantity).toLocaleString()}
                    </div>
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

    // Pilihan Metode Pembayaran
    document.querySelectorAll('.method-item').forEach(m => {
        m.addEventListener('click', function() {
            document.querySelectorAll('.method-item').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            selectedMethod = this.getAttribute('data-method');
        });
    });

    // SISTEM ALERT NONGKI
    function showNongkiAlert(message) {
        document.getElementById('nongkiAlertMessage').innerText = message;
        document.getElementById('nongkiAlertModal').classList.add('active');
    }

    function closeNongkiAlert() {
        document.getElementById('nongkiAlertModal').classList.remove('active');
    }

    // Proses Checkout
    document.getElementById('checkoutBtn').addEventListener('click', function() {
        if (cart.length === 0) {
            showNongkiAlert('Keranjang belanja Anda masih kosong. Silakan pilih menu terlebih dahulu sebelum melakukan checkout.');
            return;
        }
        if (!selectedMethod) {
            showNongkiAlert('Silakan pilih salah satu metode pembayaran terlebih dahulu untuk melanjutkan pesanan.');
            return;
        }
        
        const total = updateTotal();
        const orderId = 'NGK-' + Date.now();
        const orderData = { orderId, items: cart, total, method: selectedMethod, date: new Date().toISOString() };
        localStorage.setItem('pendingOrder', JSON.stringify(orderData));
        
        showPaymentModal(selectedMethod, total, orderId);
    });

    // Modal Instruksi Pembayaran
    function showPaymentModal(method, total, orderId) {
        const modal = document.getElementById('paymentModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');

        if (method === 'qris') {
            modalTitle.innerText = 'Scan QRIS NONGKI';
            // Ukuran QR sedikit dikecilkan biar nggak menuh-menuhin layar
            const qrData = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=NONGKI|${orderId}|${total}`;
            modalBody.innerHTML = `
                <div class="qr-code"><img src="${qrData}" width="180" height="180" alt="QR Code NONGKI"></div>
                <h2 style="color: var(--gold); margin: 5px 0 10px 0; font-size: 2.2rem; font-weight: 800;">Rp ${total.toLocaleString()}</h2>
                <p style="font-size:0.9rem; color:#A0A0A0; line-height: 1.5; margin-bottom: 0;">Buka aplikasi M-Banking atau E-Wallet (BCA, Mandiri, GoPay, OVO, dll), lalu scan QR Code di atas.</p>
            `;
        } else if (method === 'transfer') {
            modalTitle.innerText = 'Transfer Bank';
            modalBody.innerHTML = `
                <div class="bank-detail">
                    <p style="color:#A0A0A0; font-size:0.85rem; margin-bottom:4px; text-transform:uppercase; letter-spacing:1px;">Bank BCA</p>
                    <p style="font-size:1.3rem; font-weight:800; color:#f0ece3; margin:0; letter-spacing: 2px;">123 456 7890</p>
                    <p style="font-size:0.8rem; color:var(--gold); margin-top:2px;">a.n. PT NONGKI Coffee</p>
                    
                    <hr style="border-color:rgba(255,255,255,0.05); margin: 1.5rem 0;">
                    
                    <p style="color:#A0A0A0; font-size:0.85rem; margin-bottom:4px; text-transform:uppercase; letter-spacing:1px;">Bank Mandiri</p>
                    <p style="font-size:1.3rem; font-weight:800; color:#f0ece3; margin:0; letter-spacing: 2px;">987 654 3210</p>
                    <p style="font-size:0.8rem; color:var(--gold); margin-top:2px;">a.n. PT NONGKI Coffee</p>
                </div>
                <p style="color:#A0A0A0; font-size:0.95rem; margin-bottom: 5px;">Total yang harus ditransfer:</p>
                <h2 style="color: var(--gold); margin: 0 0 10px 0; font-size: 2.2rem; font-weight: 800;">Rp ${total.toLocaleString()}</h2>
            `;
        } else if (method === 'ewallet') {
            modalTitle.innerText = 'Pembayaran E-Wallet';
            modalBody.innerHTML = `
                <div class="bank-detail" style="text-align: center; padding: 2.5rem 1.5rem;">
                    <p style="color:#A0A0A0; font-size:0.9rem; margin-bottom:10px;">Virtual Account (GoPay / OVO / Dana)</p>
                    <p style="font-size:1.8rem; font-weight:800; color:var(--gold); margin:0; letter-spacing: 3px;">0888 1234 5678</p>
                </div>
                <p style="color:#A0A0A0; font-size:0.95rem; margin-bottom: 5px;">Total Tagihan:</p>
                <h2 style="color: var(--gold); margin: 0 0 10px 0; font-size: 2.2rem; font-weight: 800;">Rp ${total.toLocaleString()}</h2>
            `;
        }
        modal.classList.add('active');
    }

    // Konfirmasi Sukses Pembayaran
    document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
        const pending = localStorage.getItem('pendingOrder');
        if (pending) {
            localStorage.setItem('lastOrder', pending);
            localStorage.removeItem('cart');
            localStorage.removeItem('cartCount');
            localStorage.removeItem('pendingOrder');
            window.location.href = "{{ route('order.success') }}";
        } else {
            document.getElementById('paymentModal').classList.remove('active');
            showNongkiAlert('Sistem tidak menemukan pesanan yang sedang diproses. Silakan buat pesanan ulang.');
        }
    });

    // Batal / Tutup Modal Pembayaran
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('paymentModal').classList.remove('active');
        localStorage.removeItem('pendingOrder');
    });

    // Menutup Modal saat klik area gelap di luar box
    window.onclick = function(e) {
        if (e.target == document.getElementById('nongkiAlertModal')) {
            closeNongkiAlert();
        }
        if (e.target == document.getElementById('paymentModal')) {
            document.getElementById('paymentModal').classList.remove('active');
            localStorage.removeItem('pendingOrder');
        }
    }

    // Load keranjang
    loadCart();
</script>
@endpush