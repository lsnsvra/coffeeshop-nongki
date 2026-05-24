@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    // ============================================================
    // STATE
    // ============================================================
    let cart = [];
    let selectedMethod = '';
    let pollingInterval = null;
    let timerInterval = null;
    let currentOrderId = null;
    let pollingAttempts = 0;
    const MAX_POLLING_ATTEMPTS = 200; 
    const MANUAL_FALLBACK_AFTER = 100; 

    // ============================================================
    // KERANJANG & KALKULASI PAJAK CENTRALISASI (FIXED REGEX)
    // ============================================================
    function loadCart() {
        cart = JSON.parse(localStorage.getItem('cart_items_u16')) || [];
        console.log("Isi mentah Local Storage:", cart); // Intip isi asli data lu
        renderCart();
    }

    function calculateTotal() {
        let subtotal = 0;
        
        cart.forEach(item => {
            // BACKUP: Hapus "Rp", titik, koma, dan spasi agar murni jadi angka instan
            let cleanPrice = 0;
            if (item.price) {
                cleanPrice = parseInt(item.price.toString().replace(/[^0-9]/g, '')) || 0;
            }
            
            let qty = parseInt(item.quantity) || 1;
            subtotal += (cleanPrice * qty);
        });

        let pajak = Math.round(subtotal * 0.1); // Pajak 10%
        let grandTotal = subtotal + pajak;

        return { subtotal, pajak, grandTotal };
    }

    function renderCart() {
        const container = document.getElementById('cartItemsList');
        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = `
                <div style="text-align:center; padding: 2rem 0; color: #A0A0A0;">
                    <i class="fas fa-shopping-basket" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display:block;"></i>
                    <p>Keranjang belanja Anda masih kosong.</p>
                </div>`;
            document.getElementById('subtotalAmount').innerText = 'Rp 0';
            document.getElementById('pajakAmount').innerText = 'Rp 0';
            document.getElementById('totalAmount').innerText = 'Rp 0';
            return;
        }

        let html = '';
        cart.forEach(item => {
            // Bersihkan harga item untuk tampilan eceran
            let cleanPrice = parseInt(item.price.toString().replace(/[^0-9]/g, '')) || 0;
            let qty = parseInt(item.quantity) || 1;

            html += `
                <div class="order-item">
                    <img class="order-item-img" src="${item.img || ''}" alt="${item.name}"
                         onerror="this.src='https://placehold.co/100x100?text=Kopi'">
                    <div style="flex:1">
                        <div style="font-weight:700; color:#f0ece3; font-size:1.05rem;">${item.name}</div>
                        <div style="font-size:0.85rem; color:var(--gold); margin-top:4px;">Rp ${cleanPrice.toLocaleString('id-ID')}</div>
                        <div style="font-size:0.8rem; color:#A0A0A0; margin-top:2px;">Jumlah: ${qty}x</div>
                    </div>
                    <div style="font-weight:800; color:#f0ece3; display:flex; align-items:center;">
                        Rp ${(cleanPrice * qty).toLocaleString('id-ID')}
                    </div>
                </div>`;
        });
        container.innerHTML = html;

        // Distribusikan hasil kalkulasi bersih ke elemen UI teks ringkasan
        const dataUang = calculateTotal();
        document.getElementById('subtotalAmount').innerText = `Rp ${dataUang.subtotal.toLocaleString('id-ID')}`;
        document.getElementById('pajakAmount').innerText = `Rp ${dataUang.pajak.toLocaleString('id-ID')}`;
        document.getElementById('totalAmount').innerText = `Rp ${dataUang.grandTotal.toLocaleString('id-ID')}`;
    }

    // ============================================================
    // PILIH METODE
    // ============================================================
    document.querySelectorAll('.method-item').forEach(m => {
        m.addEventListener('click', function() {
            document.querySelectorAll('.method-item').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            selectedMethod = this.getAttribute('data-method');
        });
    });

    // ============================================================
    // ALERT SYSTEM
    // ============================================================
    function showNongkiAlert(message) {
        document.getElementById('nongkiAlertMessage').innerText = message;
        document.getElementById('nongkiAlertModal').classList.add('active');
    }
    function closeNongkiAlert() {
        document.getElementById('nongkiAlertModal').classList.remove('active');
    }

    // ============================================================
    // CHECKOUT — KIRIM KE BACKEND → MIDTRANS
    // ============================================================
    document.getElementById('checkoutBtn').addEventListener('click', async function() {
        if (cart.length === 0) {
            showNongkiAlert('Keranjang belanja Anda masih kosong.');
            return;
        }
        if (!selectedMethod) {
            showNongkiAlert('Silakan pilih salah satu metode pembayaran terlebih dahulu.');
            return;
        }

        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:8px;"></i> Memproses...';
        showModal('loading');

        const calc = calculateTotal(); // Mengambil nominal Grand Total final ter-update

        try {
            const response = await fetch("{{ route('payment.create') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    payment_method: selectedMethod,
                    total: calc.grandTotal, // Nilai Rp 24.200 dikirim ke server backend
                    items: cart.map(i => ({
                        id: i.id,
                        name: i.name,
                        price: parseInt(i.price.toString().replace(/[^0-9]/g, '')) || 0,
                        quantity: parseInt(i.quantity) || 1
                    }))
                })
            });

            if (!response.ok) throw new Error('Server error ' + response.status);
            const data = await response.json();

            if (!data.success) throw new Error(data.message || 'Gagal membuat transaksi.');

            currentOrderId = data.order_id;

            // ---- MIDTRANS SNAP ----
            if (data.snap_token) {
                document.getElementById('paymentModal').classList.remove('active');
                snap.pay(data.snap_token, {
                    onSuccess: function(result) { handlePaymentSuccess(result); },
                    onPending: function(result) {
                        currentOrderId = result.order_id;
                        showModal('polling');
                        startPolling(result.order_id);
                        startTimer(15 * 60);
                    },
                    onError: function(result) { handlePaymentError('Pembayaran gagal: ' + result.status_message); },
                    onClose: function() { resetCheckoutButton(); }
                });
                return;
            }

            // ---- NON-SNAP ----
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

    function resetCheckoutButton() {
        const btn = document.getElementById('checkoutBtn');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock" style="margin-right:8px;font-size:0.85rem;"></i> Buat Pesanan Sekarang';
        }
    }

    // ============================================================
    // RENDER DETAIL PEMBAYARAN (NON-SNAP)
    // ============================================================
    function renderPaymentDetail(data, method) {
        const modalBody = document.getElementById('modalBody');
        const calc = calculateTotal();
        const total = data.total || calc.grandTotal;

        if (method === 'qris') {
            const qrUrl = data.qr_code_url || `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(data.order_id)}`;
            modalBody.innerHTML = `
                <div class="qr-code"><img src="${qrUrl}" width="200" height="200" alt="QR Code"></div>
                <h2 style="color:var(--gold); margin:5px 0 10px; font-size:2rem; font-weight:800;">Rp ${total.toLocaleString('id-ID')}</h2>
                <p style="font-size:0.9rem; color:#A0A0A0; line-height:1.5; margin:0;">Scan QR menggunakan M-Banking atau E-Wallet.</p>`;
        } else {
            const va = data.va_numbers?.[0] || {};
            modalBody.innerHTML = `
                <div class="bank-detail">
                    <p style="color:#A0A0A0; font-size:0.8rem; text-transform:uppercase; margin-bottom:4px;">${va.bank ? va.bank.toUpperCase() : 'VIRTUAL ACCOUNT'}</p>
                    <p style="font-size:1.4rem; font-weight:800; color:#f0ece3; margin:0; letter-spacing:2px;">${va.va_number || data.payment_code || '-'}</p>
                    <p style="font-size:0.8rem; color:var(--gold); margin-top:2px;">a.n. NONGKI Coffee</p>
                </div>
                <p style="color:#A0A0A0; font-size:0.9rem; margin-bottom:4px;">Total Tagihan:</p>
                <h2 style="color:var(--gold); margin:0 0 8px; font-size:2rem; font-weight:800;">Rp ${total.toLocaleString('id-ID')}</h2>`;
        }
    }

    // ============================================================
    // CONTROLLER MODAL STATE & POLLING
    // ============================================================
    function showModal(state) {
        document.getElementById('paymentModal').classList.add('active');
        const list = ['loadingState', 'modalBody', 'statusBar', 'paymentTimer', 'successState'];
        list.forEach(id => {
            const el = document.getElementById(id);
            if(el) el.style.display = 'none';
        });
        document.getElementById('manualConfirmBtn').style.display = 'none';

        if (state === 'loading') document.getElementById('loadingState').style.display = 'flex';
        if (state === 'payment') {
            document.getElementById('modalBody').style.display = 'block';
            document.getElementById('statusBar').style.display = 'flex';
            document.getElementById('paymentTimer').style.display = 'flex';
        }
        if (state === 'polling') {
            document.getElementById('statusBar').style.display = 'flex';
            document.getElementById('paymentTimer').style.display = 'flex';
        }
        if (state === 'success') document.getElementById('successState').style.display = 'flex';
    }

    function startPolling(orderId) {
        stopPolling();
        pollingAttempts = 0;
        updateStatusBar('waiting');

        pollingInterval = setInterval(async () => {
            pollingAttempts++;
            if (pollingAttempts % 3 === 0) updateStatusBar('checking');

            try {
                const res = await fetch(`{{ url('/payment/status') }}/${orderId}`);
                const data = await res.json();
                let status = data.transaction_status || data.status;

                if (['capture', 'settlement', 'paid'].includes(status)) {
                    stopPolling(); stopTimer();
                    showModal('success');
                    localStorage.removeItem('cart_items_u16'); 
                    setTimeout(() => { window.location.href = '/dashboard'; }, 3000);
                } else if (['deny', 'cancel', 'expire', 'failed'].includes(status)) {
                    stopPolling(); stopTimer();
                    showNongkiAlert('Transaksi gagal. Silakan coba lagi.');
                    document.getElementById('paymentModal').classList.remove('active');
                    resetCheckoutButton();
                }
            } catch (e) { console.warn('Polling error, retrying...'); }

            if (pollingAttempts === MANUAL_FALLBACK_AFTER) document.getElementById('manualConfirmBtn').style.display = 'block';
        }, 3000);
    }

    function stopPolling() { if (pollingInterval) clearInterval(pollingInterval); }

    function updateStatusBar(state) {
        const dot = document.getElementById('statusDot');
        const val = document.getElementById('statusValue');
        if(!dot || !val) return;
        dot.className = 'status-dot';

        if (state === 'waiting') { dot.classList.add('waiting'); val.innerText = 'Menunggu pembayaran...'; }
        if (state === 'checking') { dot.classList.add('checking'); val.innerText = 'Memeriksa pembayaran...'; }
    }

    function startTimer(duration) {
        stopTimer();
        let timer = duration;
        timerInterval = setInterval(() => {
            let minutes = parseInt(timer / 60, 10);
            let seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            const el = document.getElementById('timerDisplay');
            if(el) el.innerText = minutes + ":" + seconds;
            if (--timer < 0) stopTimer();
        }, 1000);
    }
    function stopTimer() { if (timerInterval) clearInterval(timerInterval); }

    document.getElementById('closeModalBtn').addEventListener('click', () => {
        stopPolling(); stopTimer();
        document.getElementById('paymentModal').classList.remove('active');
        resetCheckoutButton();
    });

    document.addEventListener("DOMContentLoaded", loadCart);
</script>
@endpush