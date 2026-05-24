@push('scripts')
<script>
    // =====================================================================
    // CART KEY — ambil dari window yang sudah di-inject layouts/app.blade.php
    // =====================================================================
    const CART_KEY       = window.CART_ITEMS_KEY   || 'cart_items_u0';
    const CART_COUNT_KEY = window.CART_STORAGE_KEY || 'cart_count_u0';

    /* ========================================= */
    /* MODAL NONGKI                               */
    /* ========================================= */
    const modalOverlay = document.getElementById('nongkiModal');
    const modalIcon    = document.getElementById('nongkiModalIcon');
    const modalTitle   = document.getElementById('nongkiModalTitle');
    const modalMessage = document.getElementById('nongkiModalMessage');
    const modalActions = document.getElementById('nongkiModalActions');

    const icons = {
        info:    `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`,
        warning: `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`,
        danger:  `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>`
    };

    function closeModal() { modalOverlay.classList.remove('active'); }

    function nongkiAlert(title, message, type = 'info') {
        modalIcon.className = `modal-icon ${type}`;
        modalIcon.innerHTML = icons[type] || icons.info;
        modalTitle.innerText   = title;
        modalMessage.innerText = message;
        modalActions.innerHTML = `<button class="btn-modal-solid" onclick="closeModal()">Mengerti</button>`;
        modalOverlay.classList.add('active');
    }

    function nongkiConfirm(title, message, onConfirm, type = 'danger') {
        modalIcon.className = `modal-icon ${type}`;
        modalIcon.innerHTML = icons[type] || icons.danger;
        modalTitle.innerText   = title;
        modalMessage.innerText = message;
        const confirmClass = type === 'danger' ? 'btn-modal-solid btn-modal-danger' : 'btn-modal-solid';
        modalActions.innerHTML = `
            <button class="btn-modal-outline" onclick="closeModal()">Batal</button>
            <button id="modalConfirmBtn" class="${confirmClass}">Ya, Lanjutkan</button>
        `;
        document.getElementById('modalConfirmBtn').onclick = () => { closeModal(); if (onConfirm) onConfirm(); };
        modalOverlay.classList.add('active');
    }

    /* ========================================= */
    /* CART CORE — PENANGANAN FALLBACK QUANTITY   */
    /* ========================================= */
    function getCart() {
        let raw = localStorage.getItem(CART_KEY);
        let cart = raw ? JSON.parse(raw) : [];
        
        let validCart = [];
        cart.forEach(item => {
            if (item && item.id && item.name) {
                // Bersihkan harga seandainya tersimpan dalam bentuk string format mata uang
                let cleanPrice = typeof item.price === 'string' ? 
                    parseInt(item.price.replace(/[^0-9]/g, '')) : parseInt(item.price);
                
                // FIXED: Jika quantity tidak terdefinisi/nol, paksa isi jadi 1 agar tidak hilang ter-filter
                let cleanQty = parseInt(item.quantity) || 1;

                if (cleanPrice > 0) {
                    item.price = cleanPrice;
                    item.quantity = cleanQty;
                    validCart.push(item);
                }
            }
        });
        return validCart;
    }

    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));

        // Hitung total item
        let totalItems = cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);

        // Simpan count dengan key per user
        localStorage.setItem(CART_COUNT_KEY, totalItems);

        // Update badge di header & sidebar
        if (typeof updateBadges === 'function') {
            updateBadges(totalItems);
        } else {
            const hb = document.getElementById('cartBadgeHeader');
            const sb = document.getElementById('cartBadgeSidebar');
            if (hb) { hb.textContent = totalItems; hb.style.display = totalItems > 0 ? 'flex' : 'none'; }
            if (sb) { sb.textContent = totalItems; sb.style.display = totalItems > 0 ? 'inline-block' : 'none'; }
        }
    }

    /* ========================================= */
    /* RENDER CART                               */
    /* ========================================= */
    function renderCart() {
        const cart = getCart();
        const container      = document.getElementById('cartItemsList');
        const summaryEl      = document.getElementById('summaryDetails');
        const grandTotalEl   = document.getElementById('grandTotal');
        const clearBtn       = document.getElementById('clearAllBtn');

        if (!cart.length) {
            container.innerHTML = `
                <div style="text-align: center; padding: 5rem 2rem;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" style="margin-bottom: 1rem;">
                        <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <h3 style="color: var(--cream); margin-bottom: 0.5rem;">Keranjang Masih Kosong</h3>
                    <p style="color: var(--text-muted-c); margin-bottom: 1.5rem;">Pilih minuman dan makanan favoritmu dulu yuk!</p>
                    <a href="{{ route('menu.index') }}" class="btn-gold" style="display: inline-block; padding: 0.6rem 1.5rem; border-radius: 20px; color: var(--dark);">Lihat Menu</a>
                </div>
            `;
            summaryEl.innerHTML = `<div style="text-align: center; padding: 2rem 0; color: var(--text-muted-c);">Belum ada item</div>`;
            grandTotalEl.innerText = 'Rp 0';
            if (clearBtn) clearBtn.style.display = 'none';
            saveCart([]); 
            return;
        }

        if (clearBtn) clearBtn.style.display = 'flex';

        let itemsHtml = '';
        let subtotal  = 0;

        cart.forEach((item) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            itemsHtml += `
                <div class="cart-item" data-id="${item.id}">
                    <div class="cart-actions-left">
                        <button class="remove-item-btn" data-id="${item.id}" title="Hapus Menu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>
                        </button>
                        <div class="qty-control">
                            <button class="qty-btn" data-id="${item.id}" data-delta="-1">−</button>
                            <span>${item.quantity}</span>
                            <button class="qty-btn" data-id="${item.id}" data-delta="1">+</button>
                        </div>
                    </div>
                    <div class="cart-item-img">
                        ${item.img ? `<img src="${escapeHtml(item.img)}" alt="${escapeHtml(item.name)}">` : '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2rem;">☕</div>'}
                    </div>
                    <div class="cart-item-info">
                        <div class="item-name">${escapeHtml(item.name)}</div>
                        <div class="item-variant">${item.variant ? escapeHtml(item.variant) : 'Reguler'}</div>
                        <div class="item-price">${formatRupiah(item.price)} <span style="color:var(--text-muted-c); font-size:0.8rem;">/ item</span></div>
                    </div>
                    <div class="item-total-price">${formatRupiah(itemTotal)}</div>
                </div>
            `;
        });

        container.innerHTML = itemsHtml;

        const tax      = Math.round(subtotal * 0.1);
        const discount = 0;
        const total    = subtotal + tax - discount;

        summaryEl.innerHTML = `
            <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
                <span>Subtotal Barang</span>
                <span style="color:var(--cream);font-weight:500;">${formatRupiah(subtotal)}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
                <span>Total Diskon</span>
                <span style="color:#52b788;font-weight:500;">- ${formatRupiah(discount)}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-size:0.95rem;color:var(--text-muted-c);">
                <span>Pajak (10%)</span>
                <span style="color:var(--cream);font-weight:500;">${formatRupiah(tax)}</span>
            </div>
        `;

        grandTotalEl.innerText = formatRupiah(total);
        
        // Simpan state bersih kembali ke LocalStorage agar halaman pembongkaran checkout sinkron punya data quantity
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }

    /* ========================================= */
    /* HELPERS                                   */
    /* ========================================= */
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"']/g, function(m) {
            return { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[m];
        });
    }

    /* ========================================= */
    /* AKSI ITEM (qty & hapus)                   */
    /* ========================================= */
    function updateItemQuantity(id, delta) {
        let cart  = getCart();
        const idx = cart.findIndex(item => item.id === id);
        if (idx === -1) return;

        const newQty = cart[idx].quantity + delta;
        if (newQty <= 0) {
            nongkiConfirm(
                'Hapus Menu',
                `Hapus "${cart[idx].name}" dari keranjang?`,
                () => { cart.splice(idx, 1); saveCart(cart); renderCart(); },
                'warning'
            );
        } else {
            cart[idx].quantity = newQty;
            saveCart(cart);
            renderCart();
        }
    }

    function removeItem(id) {
        let cart  = getCart();
        const idx = cart.findIndex(item => item.id === id);
        if (idx === -1) return;
        nongkiConfirm(
            'Hapus Menu',
            `Hapus "${cart[idx].name}" dari keranjang?`,
            () => { cart.splice(idx, 1); saveCart(cart); renderCart(); },
            'warning'
        );
    }

    /* ========================================= */
    /* EVENT LISTENERS                           */
    /* ========================================= */
    function attachCartEvents() {
        document.getElementById('cartItemsList')?.addEventListener('click', (e) => {
            const qtyBtn = e.target.closest('.qty-btn');
            if (qtyBtn) {
                const id    = parseInt(qtyBtn.dataset.id);
                const delta = parseInt(qtyBtn.dataset.delta);
                if (!isNaN(id) && !isNaN(delta)) updateItemQuantity(id, delta);
            }

            const removeBtn = e.target.closest('.remove-item-btn');
            if (removeBtn) {
                const id = parseInt(removeBtn.dataset.id);
                if (!isNaN(id)) removeItem(id);
            }
        });

        document.getElementById('clearAllBtn')?.addEventListener('click', () => {
            nongkiConfirm(
                'Kosongkan Keranjang?',
                'Semua pesanan yang sudah kamu pilih akan dihapus. Yakin mau dilanjutkan?',
                () => { saveCart([]); renderCart(); },
                'danger'
            );
        });

        document.getElementById('applyPromoBtn')?.addEventListener('click', () => {
            const code = document.getElementById('promoCode').value.trim();
            if (!code) {
                nongkiAlert('Kode Promo Kosong', 'Silakan masukkan kode promo terlebih dahulu sebelum menekan tombol pakai.', 'warning');
            } else {
                nongkiAlert('Promo Tidak Valid', `Maaf, kode promo "${code}" belum tersedia atau sudah kadaluarsa.`, 'info');
            }
        });

        document.getElementById('checkoutBtn')?.addEventListener('click', () => {
            if (getCart().length === 0) {
                nongkiAlert('Keranjang Kosong', 'Keranjang kamu masih kosong. Tambah menu kopi atau makanan dulu yuk!', 'info');
            } else {
                window.location.href = "{{ route('payment.index') }}";
            }
        });
    }

    /* ========================================= */
    /* INIT                                      */
    /* ========================================= */
    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
        attachCartEvents();
    });
</script>
@endpush