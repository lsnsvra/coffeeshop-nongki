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
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    }
    .method-item:hover {
        background: rgba(212,175,55,0.05);
        border-color: rgba(212,175,55,0.3);
        transform: translateY(-2px);
    }
    .method-item.active {
        background: rgba(212,175,55,0.1);
        border-color: var(--gold);
        box-shadow: 0 5px 15px rgba(212,175,55,0.15);
    }
    .method-icon {
        font-size: 1.5rem;
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.2); border-radius: 10px;
        color: var(--gold);
        flex-shrink: 0;
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
        align-items: center;
    }
    .order-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .order-item-img {
        width: 60px; height: 60px;
        border-radius: 12px; object-fit: cover;
        border: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
        background: var(--dark-3);
    }
    .summary-row {
        display: flex; justify-content: space-between;
        padding: 0.5rem 0; font-size: 0.9rem; color: #A0A0A0;
    }
    .summary-row span:last-child { color: #f0ece3; font-weight: 500; }
    .summary-total {
        display: flex; justify-content: space-between;
        padding-top: 1.5rem; margin-top: 1rem;
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
    .btn-checkout:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* ========== MODAL OVERLAY ========== */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.4s ease;
        padding: 1rem;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: linear-gradient(145deg, var(--dark-2) 0%, #0a0a0a 100%);
        border: 1px solid rgba(212,175,55,0.25);
        border-radius: 28px;
        padding: 2.5rem 2rem;
        width: 100%; max-width: 420px;
        text-align: center;
        max-height: 85vh;
        overflow-y: auto;
        transform: translateY(30px) scale(0.95);
        transition: 0.5s cubic-bezier(0.175,0.885,0.32,1.275);
        box-shadow: 0 30px 60px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.05);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }
    .nongki-modal-box::-webkit-scrollbar { width: 6px; }
    .nongki-modal-box::-webkit-scrollbar-track { background: transparent; }
    .nongki-modal-box::-webkit-scrollbar-thumb { background: rgba(212,175,55,0.3); border-radius: 10px; }

    /* ========== PAYMENT DETAIL ========== */
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

    /* ========== STATUS BAR ========== */
    .payment-status-bar {
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .status-dot {
        width: 12px; height: 12px;
        border-radius: 50%; flex-shrink: 0;
        background: #ffc107;
        animation: pulse-waiting 1.5s infinite;
    }
    .status-dot.checking { background: #4fc3f7; animation: pulse-checking 1s infinite; }
    .status-dot.paid     { background: #4caf50; animation: pulse-paid 0.5s ease forwards; }
    .status-dot.failed   { background: #f44336; animation: none; }

    @keyframes pulse-waiting  { 0%{box-shadow:0 0 0 0 rgba(255,193,7,0.6)} 70%{box-shadow:0 0 0 10px rgba(255,193,7,0)} 100%{box-shadow:0 0 0 0 rgba(255,193,7,0)} }
    @keyframes pulse-checking { 0%{box-shadow:0 0 0 0 rgba(79,195,247,0.6)} 70%{box-shadow:0 0 0 10px rgba(79,195,247,0)} 100%{box-shadow:0 0 0 0 rgba(79,195,247,0)} }
    @keyframes pulse-paid     { 0%{transform:scale(1)} 50%{transform:scale(1.5)} 100%{transform:scale(1)} }

    .status-text-wrap { text-align: left; }
    .status-label { font-size: 0.75rem; color: #A0A0A0; text-transform: uppercase; letter-spacing: 1px; }
    .status-value { font-size: 0.95rem; font-weight: 700; color: #f0ece3; margin-top: 2px; }

    .payment-timer {
        font-size: 0.8rem; color: #A0A0A0; margin-top: 0.5rem;
        display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    }
    .timer-value { color: #ffc107; font-weight: 700; font-variant-numeric: tabular-nums; }

    /* ========== SUCCESS STATE ========== */
    .success-animation {
        display: none; flex-direction: column; align-items: center; padding: 1.5rem 0;
    }
    .success-check {
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(76,175,80,0.15); border: 2px solid #4caf50;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; color: #4caf50;
        margin-bottom: 1.2rem;
        animation: popIn 0.5s cubic-bezier(0.175,0.885,0.32,1.275);
    }
    @keyframes popIn { from{transform:scale(0);opacity:0} to{transform:scale(1);opacity:1} }

    /* ========== TOMBOL MODAL ========== */
    .btn-manual-fallback {
        width: 100%; background: transparent;
        border: 1px solid rgba(212,175,55,0.4);
        color: var(--gold); font-weight: 700; padding: 1rem;
        border-radius: 14px; cursor: pointer; transition: 0.3s;
        font-size: 0.9rem; margin-top: 1rem; display: none;
    }
    .btn-manual-fallback:hover { background: rgba(212,175,55,0.1); }
    .btn-cancel-modal {
        margin-top: 1rem; background: transparent;
        border: 1px solid rgba(255,255,255,0.1);
        color: #A0A0A0; padding: 1rem; border-radius: 14px;
        width: 100%; cursor: pointer; transition: 0.3s; font-weight: 600;
    }
    .btn-cancel-modal:hover { background: rgba(255,255,255,0.05); color: #fff; }

    /* ========== ALERT ========== */
    .alert-icon-warning {
        width: 75px; height: 75px; margin: 0 auto 1.5rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 2.2rem;
        background: rgba(255,193,7,0.1); color: #ffc107;
        border: 1px solid rgba(255,193,7,0.3);
    }
    .btn-gold-modal {
        width: 100%; background: linear-gradient(135deg, var(--gold) 0%, #e6c147 100%);
        color: #000; font-weight: 800; padding: 1.2rem; border: none;
        border-radius: 14px; cursor: pointer; transition: 0.3s; margin-top: 1.5rem;
        font-size: 1rem; letter-spacing: 0.5px;
    }
    .btn-gold-modal:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(212,175,55,0.3); }

    /* ========== SPINNER ========== */
    .spinner-wrap {
        display: flex; flex-direction: column; align-items: center;
        gap: 1rem; padding: 2rem 0;
    }
    .spinner {
        width: 48px; height: 48px;
        border: 4px solid rgba(212,175,55,0.15);
        border-top-color: var(--gold);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 900px) {
        .checkout-container { grid-template-columns: 1fr; }
        .order-summary { position: static; }
    }
    @media (max-width: 576px) {
        .payment-methods-grid { grid-template-columns: 1fr; }
        .checkout-section { padding: 1.25rem; }
        .order-summary { padding: 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div>
        <div class="checkout-section">
            <div class="section-title"><i class="fas fa-wallet"></i> Pilih Metode Pembayaran</div>
            <div class="payment-methods-grid" id="paymentMethods">
                <div class="method-item" data-method="qris">
                    <div class="method-icon"><i class="fas fa-qrcode"></i></div>
                    <span>QRIS / GoPay</span>
                </div>
                <div class="method-item" data-method="bank_transfer">
                    <div class="method-icon"><i class="fas fa-university"></i></div>
                    <span>Transfer Bank</span>
                </div>
                <div class="method-item" data-method="bca_klikpay">
                    <div class="method-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                             height="22" alt="BCA" style="filter:brightness(10)">
                    </div>
                    <span>BCA KlikPay</span>
                </div>
                <div class="method-item" data-method="shopeepay">
                    <div class="method-icon"><i class="fas fa-shopping-bag"></i></div>
                    <span>ShopeePay</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="order-summary">
            <div class="section-title"><i class="fas fa-receipt"></i> Ringkasan Pesanan</div>
            <div id="cartItemsList">
                <div style="text-align:center;padding:2rem 0;color:#A0A0A0;">
                    <i class="fas fa-circle-notch fa-spin" style="font-size:1.5rem;margin-bottom:0.75rem;display:block;color:var(--gold);"></i>
                    Memuat pesanan...
                </div>
            </div>

            <div style="margin-top:1rem;border-top:1px dashed rgba(255,255,255,0.07);padding-top:1rem;" id="summaryRows" style="display:none;">
                <div class="summary-row"><span>Subtotal</span><span id="subtotalAmount">Rp 0</span></div>
                <div class="summary-row"><span>Pajak (10%)</span><span id="pajakAmount">Rp 0</span></div>
            </div>

            <div class="summary-total">
                <span>Total Pembayaran</span>
                <span id="totalAmount">Rp 0</span>
            </div>
            <button class="btn-checkout" id="checkoutBtn">
                <i class="fas fa-lock" style="margin-right:8px;font-size:0.85rem;"></i>
                Buat Pesanan Sekarang
            </button>
        </div>
    </div>
</div>

{{-- ====== MODAL PEMBAYARAN ====== --}}
<div class="nongki-modal-overlay" id="paymentModal">
    <div class="nongki-modal-box">
        <h3 id="modalTitle" style="color:var(--gold);margin-top:0;font-size:1.4rem;font-family:'Cormorant Garamond',serif;">
            Konfirmasi Pembayaran
        </h3>
        <p style="color:#A0A0A0;font-size:0.9rem;margin-bottom:0;">
            Selesaikan pembayaran Anda untuk memproses pesanan.
        </p>

        <div id="loadingState" class="spinner-wrap">
            <div class="spinner"></div>
            <p style="color:#A0A0A0;font-size:0.9rem;">Menyiapkan transaksi...</p>
        </div>

        <div id="modalBody" style="display:none;"></div>

        <div class="payment-status-bar" id="statusBar" style="display:none;">
            <div class="status-dot" id="statusDot"></div>
            <div class="status-text-wrap">
                <div class="status-label">Status Transaksi</div>
                <div class="status-value" id="statusValue">Menunggu pembayaran...</div>
            </div>
        </div>

        <div class="payment-timer" id="paymentTimer" style="display:none;">
            <i class="fas fa-clock"></i>
            Berlaku selama <span class="timer-value" id="timerDisplay">15:00</span>
        </div>

        <div class="success-animation" id="successState">
            <div class="success-check"><i class="fas fa-check"></i></div>
            <h3 style="color:#4caf50;margin:0 0 0.5rem;">Pembayaran Berhasil!</h3>
            <p style="color:#A0A0A0;font-size:0.9rem;margin:0;">Mengalihkan ke halaman konfirmasi...</p>
        </div>

        <button id="manualConfirmBtn" class="btn-manual-fallback" onclick="handleManualConfirm()">
            <i class="fas fa-check-circle" style="margin-right:6px;"></i>
            Saya Sudah Bayar (Konfirmasi Manual)
        </button>

        <button id="closeModalBtn" class="btn-cancel-modal">
            <i class="fas fa-arrow-left" style="margin-right:6px;"></i>
            Ubah Metode Pembayaran
        </button>
    </div>
</div>

{{-- ====== MODAL ALERT ====== --}}
<div class="nongki-modal-overlay" id="nongkiAlertModal">
    <div class="nongki-modal-box" style="max-width:380px;">
        <div class="alert-icon-warning"><i class="fas fa-exclamation-triangle"></i></div>
        <h3 style="color:#f0ece3;margin-bottom:0.8rem;font-weight:800;font-size:1.4rem;">Perhatian!</h3>
        <p id="nongkiAlertMessage" style="color:rgba(240,236,227,0.7);font-size:0.95rem;margin-bottom:2rem;line-height:1.6;"></p>
        <button type="button" class="btn-gold-modal" style="margin-top:0;" onclick="closeNongkiAlert()">Mengerti</button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
// ============================================================
// KEY PER USER
// ============================================================
const PAY_CART_KEY       = window.CART_ITEMS_KEY   || 'cart_items_u0';
const PAY_CART_COUNT_KEY = window.CART_STORAGE_KEY || 'cart_count_u0';

// ============================================================
// STATE
// ============================================================
let cart = [];
let selectedMethod   = '';
let pollingInterval  = null;
let timerInterval    = null;
let currentOrderId   = null;
let pollingAttempts  = 0;
const MAX_POLLING_ATTEMPTS  = 200;
const MANUAL_FALLBACK_AFTER = 100;

// ============================================================
// INITIAL LOAD
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    
    // Event listener untuk tombol close modal agar reset state tombol utama
    const closeBtn = document.getElementById('closeModalBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            document.getElementById('paymentModal').classList.remove('active');
            stopPolling();
            stopTimer();
            resetCheckoutButton();
        });
    }
});

function loadCart() {
    try {
        const raw = localStorage.getItem(PAY_CART_KEY);
        cart = raw ? JSON.parse(raw) : [];
    } catch(e) {
        cart = [];
    }

    cart = cart
        .map(item => ({
            ...item,
            id:       String(item.id),
            price:    parseInt(String(item.price).replace(/[^0-9]/g, '')) || 0,
            quantity: parseInt(item.quantity) || 1
        }))
        .filter(item => item.id && item.name && item.price > 0 && item.quantity > 0);

    renderCart();
}

function calculateTotal() {
    const subtotal   = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
    const pajak      = Math.round(subtotal * 0.1);
    const grandTotal = subtotal + pajak;
    return { subtotal, pajak, grandTotal };
}

function renderCart() {
    const container = document.getElementById('cartItemsList');
    const summaryRows = document.getElementById('summaryRows');
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = `
            <div style="text-align:center;padding:2rem 0;color:#A0A0A0;">
                <i class="fas fa-shopping-basket" style="font-size:3rem;opacity:0.2;margin-bottom:1rem;display:block;"></i>
                <p>Keranjang belanja Anda masih kosong.</p>
            </div>`;
        document.getElementById('subtotalAmount').innerText = 'Rp 0';
        document.getElementById('pajakAmount').innerText    = 'Rp 0';
        document.getElementById('totalAmount').innerText    = 'Rp 0';
        if (summaryRows) summaryRows.style.display = 'none';
        return;
    }

    let html = '';
    cart.forEach(item => {
        html += `
            <div class="order-item">
                <img class="order-item-img"
                     src="${escapeHtml(item.img || '')}"
                     alt="${escapeHtml(item.name)}"
                     onerror="this.src='https://placehold.co/100x100?text=Kopi'">
                <div style="flex:1;">
                    <div style="font-weight:700;color:#f0ece3;font-size:1rem;">${escapeHtml(item.name)}</div>
                    <div style="font-size:0.85rem;color:var(--gold);margin-top:4px;">
                        Rp ${item.price.toLocaleString('id-ID')} × ${item.quantity}
                    </div>
                </div>
                <div style="font-weight:800;color:#f0ece3;white-space:nowrap;">
                    Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                </div>
            </div>`;
    });
    container.innerHTML = html;

    const calc = calculateTotal();
    document.getElementById('subtotalAmount').innerText = `Rp ${calc.subtotal.toLocaleString('id-ID')}`;
    document.getElementById('pajakAmount').innerText    = `Rp ${calc.pajak.toLocaleString('id-ID')}`;
    document.getElementById('totalAmount').innerText    = `Rp ${calc.grandTotal.toLocaleString('id-ID')}`;
    if (summaryRows) summaryRows.style.display = 'block';
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m =>
        ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m])
    );
}

// ============================================================
// PILIH METODE PEMBAYARAN
// ============================================================
document.querySelectorAll('.method-item').forEach(m => {
    m.addEventListener('click', function() {
        document.querySelectorAll('.method-item').forEach(x => x.classList.remove('active'));
        this.classList.add('active');
        selectedMethod = this.getAttribute('data-method');
    });
});

function showNongkiAlert(message) {
    document.getElementById('nongkiAlertMessage').innerText = message;
    document.getElementById('nongkiAlertModal').classList.add('active');
}
function closeNongkiAlert() {
    document.getElementById('nongkiAlertModal').classList.remove('active');
}

function resetCheckoutButton() {
    const btn = document.getElementById('checkoutBtn');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock" style="margin-right:8px;font-size:0.85rem;"></i> Buat Pesanan Sekarang';
    }
}

// ============================================================
// PROSES PEMBUATAN TRANSAKSI (CHECKOUT)
// ============================================================
document.getElementById('checkoutBtn').addEventListener('click', async function() {
    if (cart.length === 0) {
        showNongkiAlert('Keranjang belanja Anda masih kosong. Silakan pilih menu terlebih dahulu.');
        return;
    }
    if (!selectedMethod) {
        showNongkiAlert('Silakan pilih salah satu metode pembayaran terlebih dahulu.');
        return;
    }

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:8px;"></i> Memproses...';
    showModal('loading');

    const calc = calculateTotal();

    try {
        const response = await fetch("{{ route('payment.create') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
                'Accept':        'application/json'
            },
            body: JSON.stringify({
                payment_method: selectedMethod,
                total:          calc.grandTotal,
                items:          cart.map(i => ({
                    id:       i.id,
                    name:     i.name,
                    price:    i.price,
                    quantity: i.quantity
                }))
            })
        });

        if (!response.ok) throw new Error('Server error ' + response.status);
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Gagal membuat transaksi.');

        currentOrderId = data.order_id;

        // ---- MIDTRANS SNAP FLOW ----
        if (data.snap_token) {
            document.getElementById('paymentModal').classList.remove('active');
            snap.pay(data.snap_token, {
                onSuccess: result => {
                    const orderId = result.order_id || result.order_code || currentOrderId;
                    handlePaymentSuccess({ order_id: orderId, transaction_status: result.transaction_status });
                },
                onPending: result => {
                    currentOrderId = result.order_id || currentOrderId;
                    showModal('polling');
                    startPolling(currentOrderId);
                    startTimer(15 * 60);
                },
                onError: result => handlePaymentError('Pembayaran gagal: ' + (result.status_message || 'Silakan coba lagi.')),
                onClose: () => resetCheckoutButton()
            });
            return;
        }

        // ---- NON-SNAP CUSTOM PAYMENT DETAIL ----
        renderPaymentDetail(data, selectedMethod);
        showModal('payment');
        startPolling(data.order_id);
        startTimer(15 * 60);

    } catch (err) {
        document.getElementById('paymentModal').classList.remove('active');
        showNongkiAlert('Terjadi kesalahan: ' + err.message);
        resetCheckoutButton();
    }
});

function renderPaymentDetail(data, method) {
    const modalBody = document.getElementById('modalBody');
    const calc      = calculateTotal();
    const total     = data.total || calc.grandTotal;

    if (method === 'qris') {
        const qrUrl = data.qr_code_url || `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(data.order_id)}`;
        modalBody.innerHTML = `
            <div class="qr-code">
                <img src="${qrUrl}" width="200" height="200" alt="QR Code NONGKI">
            </div>
            <h2 style="color:var(--gold);margin:5px 0 10px;font-size:2rem;font-weight:800;">
                Rp ${total.toLocaleString('id-ID')}
            </h2>
            <p style="font-size:0.9rem;color:#A0A0A0;line-height:1.5;margin:0;">
                Scan QR Code menggunakan M-Banking atau E-Wallet (GoPay, OVO, DANA, dll).
            </p>`;
    } else if (method === 'bank_transfer') {
        const va = data.va_numbers?.[0] || {};
        modalBody.innerHTML = `
            <div class="bank-detail">
                <p style="color:#A0A0A0;font-size:0.8rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">
                    ${va.bank ? va.bank.toUpperCase() : 'Virtual Account'}
                </p>
                <p style="font-size:1.4rem;font-weight:800;color:#f0ece3;margin:0;letter-spacing:2px;">
                    ${va.va_number || data.payment_code || '-'}
                </p>
                <p style="font-size:0.8rem;color:var(--gold);margin-top:2px;">a.n. NONGKI Coffee</p>
            </div>
            <p style="color:#A0A0A0;font-size:0.9rem;margin-bottom:4px;">Total yang harus ditransfer:</p>
            <h2 style="color:var(--gold);margin:0 0 8px;font-size:2rem;font-weight:800;">
                Rp ${total.toLocaleString('id-ID')}
            </h2>
            <p style="font-size:0.8rem;color:#A0A0A0;">
                <i class="fas fa-info-circle"></i> Transfer nominal PERSIS sesuai tagihan.
            </p>`;
    } else {
        modalBody.innerHTML = `
            <div class="bank-detail" style="text-align:center;padding:2rem;">
                <p style="color:#A0A0A0;font-size:0.9rem;margin-bottom:8px;">Kode Pembayaran</p>
                <p style="font-size:1.6rem;font-weight:800;color:var(--gold);letter-spacing:3px;margin:0;">
                    ${data.payment_code || data.order_id}
                </p>
            </div>
            <h2 style="color:var(--gold);margin:0 0 10px;font-size:2rem;font-weight:800;">
                Rp ${total.toLocaleString('id-ID')}
            </h2>`;
    }
}

function showModal(state) {
    document.getElementById('paymentModal').classList.add('active');
    ['loadingState','modalBody','statusBar','paymentTimer','successState','manualConfirmBtn','closeModalBtn']
        .forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });

    const show = id => { const el = document.getElementById(id); if (el) el.style.display = ''; };

    if (state === 'loading') {
        show('loadingState');
    } else if (state === 'payment') {
        show('modalBody'); show('statusBar'); show('paymentTimer'); show('closeModalBtn');
    } else if (state === 'polling') {
        show('statusBar'); show('paymentTimer'); show('closeModalBtn');
    } else if (state === 'success') {
        show('successState');
    }
}

// ============================================================
// AUTOMATIC POLLING SYSTEM
// ============================================================
function startPolling(orderId) {
    stopPolling();
    pollingAttempts = 0;
    updateStatusBar('waiting');

    pollingInterval = setInterval(async () => {
        pollingAttempts++;
        if (pollingAttempts % 3 === 0) updateStatusBar('checking');

        try {
            const res = await fetch(`{{ url('/payment/status') }}/${orderId}`, {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            if (!res.ok) throw new Error('Network error');
            const data = await res.json();
            const status = data.transaction_status || data.status;
            handleStatusResponse(status, orderId);
        } catch(e) {
            console.warn('[Polling] retrying...', e);
            updateStatusBar('waiting');
        }

        if (pollingAttempts === MANUAL_FALLBACK_AFTER) {
            const mb = document.getElementById('manualConfirmBtn');
            if (mb) mb.style.display = 'block';
        }
        if (pollingAttempts >= MAX_POLLING_ATTEMPTS) {
            stopPolling(); stopTimer();
            updateStatusBar('timeout');
            const mb = document.getElementById('manualConfirmBtn');
            if (mb) mb.style.display = 'block';
        }
    }, 3000);
}

function stopPolling() {
    if (pollingInterval) { clearInterval(pollingInterval); pollingInterval = null; }
}

function handleStatusResponse(status, orderId) {
    switch (status) {
        case 'capture': case 'settlement': case 'paid':
            stopPolling(); stopTimer();
            handlePaymentSuccess({ order_id: orderId, transaction_status: status });
            break;
        case 'pending':
            updateStatusBar('waiting');
            break;
        case 'deny': case 'cancel': case 'expire': case 'failure': case 'failed':
            stopPolling(); stopTimer();
            handlePaymentError('Transaksi ' + status + '. Silakan buat pesanan baru.');
            break;
        default:
            updateStatusBar('waiting');
    }
}

// ============================================================
// CALLBACK HANDLERS (SUCCESS & ERROR)
// ============================================================
function handlePaymentSuccess(result) {
    stopPolling();
    stopTimer();
    showModal('success');
    updateStatusBar('paid');

    // Kosongkan Keranjang Belanja lokal user
    localStorage.removeItem(PAY_CART_KEY);
    localStorage.removeItem(PAY_CART_COUNT_KEY);

    if (typeof updateBadges === 'function') updateBadges(0);

    const orderData = JSON.parse(localStorage.getItem('pendingOrder') || '{}');
    orderData.transaction_status = result.transaction_status || 'settlement';
    localStorage.setItem('lastOrder', JSON.stringify(orderData));
    localStorage.removeItem('pendingOrder');

    // Ambil order id untuk dialihkan secara aman lewat URL dinamis
    const successOrderId = result.order_id || result.order_code || currentOrderId;

    setTimeout(() => { 
        window.location.href = "/order-success/" + successOrderId; 
    }, 2000);
}

function handlePaymentError(msg) {
    stopPolling();
    stopTimer();
    document.getElementById('paymentModal').classList.remove('active');
    showNongkiAlert(msg);
    resetCheckoutButton();
}

function handleManualConfirm() {
    if (currentOrderId) {
        handlePaymentSuccess({ order_id: currentOrderId, transaction_status: 'settlement' });
    }
}

// ============================================================
// INTERFACE REALTIME COUNTER
// ============================================================
function updateStatusBar(state) {
    const dot   = document.getElementById('statusDot');
    const value = document.getElementById('statusValue');
    if (!dot || !value) return;
    dot.className = 'status-dot';
    const map = {
        waiting: { cls: '',         text: 'Menunggu pembayaran...' },
        checking:{ cls: 'checking', text: 'Memeriksa transaksi...' },
        paid:    { cls: 'paid',     text: 'Pembayaran dikonfirmasi! ✓' },
        failed:  { cls: 'failed',   text: 'Transaksi gagal / kedaluwarsa.' },
        timeout: { cls: 'failed',   text: 'Waktu cek habis. Konfirmasi manual jika sudah bayar.' },
    };
    const s = map[state] || map.waiting;
    if (s.cls) dot.classList.add(s.cls);
    value.textContent = s.text;
}

function startTimer(seconds) {
    stopTimer();
    let remaining = seconds;
    updateTimerDisplay(remaining);
    timerInterval = setInterval(() => {
        remaining--;
        updateTimerDisplay(remaining);
        if (remaining <= 0) {
            stopTimer(); stopPolling();
            updateStatusBar('timeout');
            const mb = document.getElementById('manualConfirmBtn');
            if (mb) mb.style.display = 'block';
        }
    }, 1000);
}

function stopTimer() {
    if (timerInterval) { clearInterval(timerInterval); timerInterval = null; }
}

function updateTimerDisplay(seconds) {
    const m = String(Math.floor(seconds / 60)).padStart(2, '0');
    const s = String(seconds % 60).padStart(2, '0');
    const el = document.getElementById('timerDisplay');
    if (el) el.textContent = `${m}:${s}`;
}
</script>
@endpush