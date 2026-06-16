@extends('layouts.kasir')

@section('title', 'POS Kasir — NONGKI')

@push('styles')

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { 
                    sans: ['Inter', 'sans-serif'],
                    serif: ['Playfair Display', 'serif'] 
                },
                colors: {
                    nongki: {
                        bg: '#14110E',
                        card: '#1C1815',
                        border: '#2A241F',
                        gold: '#CBA052',
                        goldHover: '#B38A40',
                        text: '#D1D1D1',
                        muted: '#7A7A7A'
                    }
                }
            }
        }
    }
</script>
<style>
    /* Override layout kasir agar POS bisa full height */


    body { overflow: hidden !important; }
.kasir-main { 
    padding: 0 !important; 
    overflow: hidden !important; 
    height: 100vh;
    display: flex;
    flex-direction: column;
}

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #2A241F; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #CBA052; }
    
    @keyframes modalEnter {
        0% { opacity: 0; transform: scale(0.9) translateY(20px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-modal { animation: modalEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-item { animation: slideDown 0.3s ease forwards; }

    .receipt-divider {
        background-image: linear-gradient(to right, #2A241F 50%, transparent 50%);
        background-size: 10px 1px;
        background-repeat: repeat-x;
        height: 1px;
        width: 100%;
    }
    
    @media print {
        @page { margin: 0; size: 80mm auto; } 
        body { background: white !important; color: black !important; display: block !important; }
        .kasir-sidebar, header, main, #sideDrawer, #drawerOverlay, .no-print { display: none !important; }
        #paymentModal { position: relative !important; display: block !important; background: white !important; }
        #printArea { 
            display: block !important; visibility: visible !important; position: relative !important; 
            width: 76mm !important; margin: 0 auto !important; padding: 10px !important; 
            box-shadow: none !important; border: none !important; background: white !important; color: black !important;
        }
        #receiptItems { max-height: none !important; overflow: visible !important; }
        #printArea .text-gray-200, #printArea .text-gray-300 { color: #000 !important; font-weight: 700 !important; }
        #printArea .text-nongki-gold { color: #000 !important; font-weight: 800 !important; }
        .receipt-divider { background-image: linear-gradient(to right, #000 50%, transparent 50%) !important; }
    }
</style>
@endpush

@section('content')
@php
    $menus = \Illuminate\Support\Facades\DB::table('products')->where('IsDeleted', 0)->get();

    function getCategory($name) {
        $name = strtolower($name);
        $kopi = ['americano', 'coffee', 'macchiato', 'latte'];
        $makanan = ['macaroni', 'katsu', 'crispy', 'fries', 'noodles'];
        foreach($kopi as $k) { if(strpos($name, $k) !== false) return 'kopi'; }
        foreach($makanan as $m) { if(strpos($name, $m) !== false) return 'makanan'; }
        return 'non-kopi';
    }

    function getDeskripsi($nama) {
        $nama = strtolower($nama);
        if (strpos($nama, 'americano') !== false) return 'Double shot espresso dengan air panas.';
        if (strpos($nama, 'halzenut') !== false || strpos($nama, 'hazelnut') !== false) return 'Kopi dengan sentuhan rasa hazelnut.';
        if (strpos($nama, 'matcha') !== false) return 'Matcha premium Jepang dengan susu.';
        if (strpos($nama, 'vanilla') !== false) return 'Cappuccino klasik sentuhan vanilla.';
        if (strpos($nama, 'macchiato') !== false) return 'Espresso dengan busa susu lembut.';
        if (strpos($nama, 'aren') !== false) return 'Kopi susu dengan gula aren asli.';
        if (strpos($nama, 'pandan') !== false) return 'Kopi susu dengan aroma pandan.';
        if (strpos($nama, 'chocolate drink') !== false) return 'Minuman coklat pekat yang hangat.';
        if (strpos($nama, 'avocado') !== false) return 'Perpaduan coklat dan alpukat segar.';
        if (strpos($nama, 'manggo') !== false || strpos($nama, 'mango') !== false) return 'Smoothie mangga segar dan manis.';
        if (strpos($nama, 'fries') !== false) return 'Kentang goreng renyah gurih.';
        if (strpos($nama, 'macaroni') !== false) return 'Macaroni panggang dengan keju leleh.';
        if (strpos($nama, 'katsu') !== false) return 'Chicken katsu saus kari Jepang.';
        if (strpos($nama, 'enoki') !== false) return 'Jamur enoki goreng tepung renyah.';
        if (strpos($nama, 'noodle') !== false) return 'Mie goreng bumbu spesial NONGKI.';
        return 'Sajian menu spesial dari NONGKI.';
    }
@endphp

{{-- WRAPPER POS FULL HEIGHT --}}
<div class="flex overflow-hidden bg-[#14110E] text-gray-200 select-none h-full w-full">

    {{-- Panel Kiri: Grid Menu --}}
    <div class="flex-1 flex flex-col min-h-0">

        
        {{-- Header POS --}}
<div class="h-20 border-b border-[#2A241F] flex items-center justify-between px-5 shrink-0 bg-[#14110E]">
    <div class="pt-4"> {{-- Tambahkan class pt-4 di sini untuk memberi jarak sedikit ke bawah --}}
        <div class="text-xs text-[#7A7A7A] font-semibold tracking-wider uppercase mb-1">Kategori</div>
        <div class="flex gap-2 overflow-x-auto" id="categoryFilter">
            <button class="cat-btn active px-4 py-1 rounded-full text-xs font-medium border border-[#CBA052] bg-[#CBA052]/10 text-[#CBA052] transition-all" data-cat="semua">Semua</button>
            <button class="cat-btn px-4 py-1 rounded-full text-xs font-medium border border-[#2A241F] text-[#7A7A7A] hover:border-[#CBA052]/50 transition-all" data-cat="kopi">Kopi</button>
            <button class="cat-btn px-4 py-1 rounded-full text-xs font-medium border border-[#2A241F] text-[#7A7A7A] hover:border-[#CBA052]/50 transition-all" data-cat="non-kopi">Non-Kopi</button>
            <button class="cat-btn px-4 py-1 rounded-full text-xs font-medium border border-[#2A241F] text-[#7A7A7A] hover:border-[#CBA052]/50 transition-all" data-cat="makanan">Makanan</button>
        </div>
    </div>
    <div class="relative pt-4"> {{-- Tambahkan pt-4 juga di sini agar posisi search sejajar --}}
        <svg class="w-4 h-4 text-[#7A7A7A] absolute left-3 top-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" id="searchInput" placeholder="Cari menu..." class="bg-[#1C1815] border border-[#2A241F] text-sm rounded-full py-2 pl-9 pr-4 text-[#D1D1D1] focus:outline-none focus:border-[#CBA052] transition-colors w-56">
    </div>
</div>

        {{-- Grid Menu --}}
        <div class="flex-1 overflow-y-auto p-4 min-h-0">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="productGrid">
                @foreach($menus as $menu)
                @php $cat = getCategory($menu->NamaKopi); @endphp
                <div class="menu-card bg-[#1C1815] rounded-2xl border border-[#2A241F] hover:border-[#CBA052]/50 transition-all cursor-pointer group flex flex-col relative overflow-hidden"
                     data-cat="{{ $cat }}"
                     data-name="{{ strtolower($menu->NamaKopi) }}"
                     onclick="addToCart({{ $menu->ProductID }}, '{{ addslashes($menu->NamaKopi) }}', {{ $menu->Harga }})">

                    <div class="absolute top-2 left-2 w-7 h-7 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-white group-hover:bg-[#CBA052] group-hover:border-[#CBA052] transition-all z-10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>

                    <div class="h-28 w-full bg-[#2A241F] overflow-hidden">
                        <img src="{{ asset('images/products/' . $menu->image) }}" alt="{{ $menu->NamaKopi }}"
                             onerror="this.src='https://placehold.co/400x300?text={{ urlencode($menu->NamaKopi) }}'"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-3 bg-[#1C1815]">
                        <h3 class="text-xs font-semibold text-gray-200 line-clamp-1 group-hover:text-[#CBA052] transition-colors">{{ $menu->NamaKopi }}</h3>
                        <p class="text-[#7A7A7A] text-[10px] mt-0.5 line-clamp-1">{{ getDeskripsi($menu->NamaKopi) }}</p>
                        <p class="text-[#CBA052] text-xs font-bold mt-2">Rp {{ number_format($menu->Harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Panel Kanan: Order --}}
    <div class="w-[360px] bg-[#1C1815] border-l border-[#2A241F] flex flex-col h-full min-h-0 shrink-0">

        <div class="p-4 border-b border-[#2A241F] flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2 font-medium text-sm">
                Pesanan Baru
                <span id="cartCountBadge" class="bg-[#CBA052] text-[#14110E] text-xs font-bold px-2 py-0.5 rounded-full">0</span>
            </div>
            <button onclick="openClearCartModal()" class="text-xs text-[#7A7A7A] hover:text-red-400 transition-colors">Batal</button>
        </div>

        <div class="p-3 grid grid-cols-2 gap-2 border-b border-[#2A241F] shrink-0">
            <button id="btnDineIn" onclick="setOrderType('dinein')" class="py-2 text-xs font-medium rounded-lg bg-[#CBA052]/10 text-[#CBA052] border border-[#CBA052] transition-all">Dine In</button>
            <button id="btnTakeAway" onclick="setOrderType('takeaway')" class="py-2 text-xs font-medium rounded-lg bg-[#14110E] text-[#7A7A7A] border border-[#2A241F] hover:border-[#CBA052]/30 transition-all">Take Away</button>
        </div>

        <div class="flex-1 overflow-y-auto p-3 relative min-h-0">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-[#7A7A7A] text-sm" id="emptyCartMessage">
                <svg class="w-10 h-10 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Belum ada pesanan.
            </div>
            <div id="cartList" class="space-y-2 hidden pb-4"></div>
        </div>

        <div class="p-4 border-t border-[#2A241F] bg-[#14110E] shrink-0">
            <div class="space-y-1.5 mb-4 text-sm">
                <div class="flex justify-between text-[#7A7A7A]">
                    <span>Subtotal</span><span id="subtotalDisplay">Rp 0</span>
                </div>
                <div class="flex justify-between text-[#7A7A7A]">
                    <span>PPN 11%</span><span id="taxDisplay">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-base text-[#D1D1D1] pt-2 border-t border-[#2A241F] mt-2">
                    <span>Total</span>
                    <span id="totalDisplay" class="text-[#CBA052]">Rp 0</span>
                </div>
            </div>

            <div class="space-y-2 mb-4 text-sm">
                <div class="flex items-center justify-between">
                    <label class="text-[#7A7A7A]">Uang Masuk</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-[#7A7A7A] text-xs">Rp</span>
                        <input type="number" id="inputUang" class="bg-[#1C1815] border border-[#2A241F] rounded-lg pl-8 pr-3 py-2 w-32 text-right focus:outline-none focus:border-[#CBA052] text-[#D1D1D1] text-sm transition-all" placeholder="0">
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-[#7A7A7A]">Kembalian</span>
                    <span id="kembalianDisplay" class="font-medium text-[#7A7A7A]">-</span>
                </div>
            </div>

            <button id="btnProses" onclick="processPayment()" class="w-full bg-[#CBA052] hover:bg-[#B38A40] text-[#14110E] font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Proses Pembayaran
            </button>
        </div>
    </div>
</div>

{{-- Modal: Hapus Pesanan --}}
<div id="clearCartModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-4 opacity-0">
    <div id="clearCartModalContent" class="bg-[#1C1815] border border-[#2A241F] w-full max-w-sm rounded-2xl p-6 shadow-2xl text-center scale-95 opacity-0 transition-all duration-300">
        <div class="w-14 h-14 bg-red-500/10 text-red-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/20">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h2 class="text-lg font-bold text-gray-200 mb-2">Hapus Pesanan</h2>
        <p class="text-[#7A7A7A] text-sm mb-5">Apakah Anda yakin ingin membatalkan pesanan saat ini?</p>
        <div class="flex gap-3">
            <button onclick="closeClearCartModal()" class="flex-1 py-2.5 rounded-xl border border-[#2A241F] text-[#D1D1D1] hover:bg-[#14110E] transition-colors text-sm">Kembali</button>
            <button onclick="executeClearCart()" class="flex-1 py-2.5 rounded-xl bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-colors text-sm font-bold">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- Modal: Payment Receipt --}}
<div id="paymentModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden overflow-y-auto no-print">
    <div class="min-h-screen flex items-center justify-center p-4 py-10">
        <div id="modalContent" class="w-full max-w-sm transform transition-all opacity-0 scale-90 m-auto">
            <div id="printArea" class="bg-[#1C1815] border border-[#2A241F] shadow-2xl rounded-2xl p-8">
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center gap-2 text-[#CBA052] mb-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M4 19h10c2.21 0 4-1.79 4-4v-6H2v6c0 2.21 1.79 4 4 4zm14-10h1c1.66 0 3 1.34 3 3s-1.34 3-3 3h-1v-6z"/></svg>
                        <span class="font-serif font-bold text-xl tracking-widest">NONGKI</span>
                    </div>
                    <h2 class="text-sm font-medium text-[#D1D1D1] tracking-widest uppercase mb-1">Struk Pembayaran</h2>
                    <p class="text-[#7A7A7A] text-xs" id="receiptDate">--</p>
                    <p class="text-[#7A7A7A] text-xs mt-1 font-mono" id="receiptTrx">TRX-000000</p>
                    <p class="text-[#CBA052] text-xs mt-1 font-medium" id="receiptOrderType">--</p>
                    <p class="text-[#7A7A7A] text-xs mt-0.5 font-medium" id="receiptPayMethod">Tunai</p>
                </div>

                <div class="receipt-divider mb-4"></div>
                <div class="py-2 mb-2 space-y-3" id="receiptItems"></div>
                <div class="receipt-divider mt-2 mb-4"></div>

                <div class="space-y-2 text-sm mb-6">
                    <div class="flex justify-between text-[#7A7A7A]">
                        <span>Subtotal</span><span id="receiptSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-[#7A7A7A]">
                        <span>PPN 11%</span><span id="receiptTax">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-gray-100 font-bold pt-3 mt-2 border-t border-[#2A241F]">
                        <span>Total Transaksi</span><span id="receiptTotal" class="text-[#CBA052]">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-[#7A7A7A] pt-2 border-t border-[#2A241F] border-dashed mt-2">
                        <span>Tunai / Masuk</span><span id="receiptCash">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-[#D1D1D1] font-medium mt-1">
                        <span>Kembalian</span><span id="receiptChange">Rp 0</span>
                    </div>
                </div>

                <div class="text-center text-xs text-[#7A7A7A] mt-6">
                    <p class="mb-1">Terima kasih atas kunjungan Anda!</p>
                    <p>Powered by NONGKI POS</p>
                </div>
            </div>

            <div class="flex gap-4 mt-6 no-print">
                <button onclick="window.print()" class="flex-1 py-3 rounded-xl border border-[#2A241F] text-[#D1D1D1] bg-[#1C1815] hover:bg-[#2A241F] transition-all text-sm font-medium flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Struk
                </button>
                <button onclick="closePaymentModal()" class="flex-1 py-3 rounded-xl bg-[#CBA052] text-[#14110E] font-bold hover:bg-[#B38A40] transition-all text-sm flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Selesai & Baru
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const formatRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

    let cart = [], totalVal = 0, subtotalVal = 0, taxVal = 0;
    let selectedOrderType = 'dinein';

    const cartList = document.getElementById('cartList');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const cartCountBadge = document.getElementById('cartCountBadge');
    const inputUang = document.getElementById('inputUang');
    const kembalianDisplay = document.getElementById('kembalianDisplay');
    const btnProses = document.getElementById('btnProses');
    const paymentModal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');

    function setOrderType(type) {
        selectedOrderType = type;
        const btnDineIn = document.getElementById('btnDineIn');
        const btnTakeAway = document.getElementById('btnTakeAway');
        if (type === 'dinein') {
            btnDineIn.className = 'py-2 text-xs font-medium rounded-lg bg-[#CBA052]/10 text-[#CBA052] border border-[#CBA052] transition-all';
            btnTakeAway.className = 'py-2 text-xs font-medium rounded-lg bg-[#14110E] text-[#7A7A7A] border border-[#2A241F] transition-all';
        } else {
            btnTakeAway.className = 'py-2 text-xs font-medium rounded-lg bg-[#CBA052]/10 text-[#CBA052] border border-[#CBA052] transition-all';
            btnDineIn.className = 'py-2 text-xs font-medium rounded-lg bg-[#14110E] text-[#7A7A7A] border border-[#2A241F] transition-all';
        }
    }

    function addToCart(id, name, price) {
        const existing = cart.find(i => i.id === id);
        if (existing) { existing.qty++; } else { cart.unshift({ id, name, price, qty: 1 }); }
        updateCartUI();
    }

    function updateQty(id, delta) {
        const idx = cart.findIndex(i => i.id === id);
        if (idx > -1) {
            cart[idx].qty += delta;
            if (cart[idx].qty <= 0) cart.splice(idx, 1);
            updateCartUI();
        }
    }

    function updateCartUI() {
        if (cart.length === 0) {
            cartList.innerHTML = '';
            cartList.classList.add('hidden');
            emptyCartMessage.style.display = 'flex';
            cartCountBadge.innerText = '0';
            document.getElementById('subtotalDisplay').innerText = 'Rp 0';
            document.getElementById('taxDisplay').innerText = 'Rp 0';
            document.getElementById('totalDisplay').innerText = 'Rp 0';
            totalVal = 0;
        } else {
            emptyCartMessage.style.display = 'none';
            cartList.classList.remove('hidden');
            cartList.innerHTML = '';
            let totalItems = 0; subtotalVal = 0;
            cart.forEach((item, idx) => {
                totalItems += item.qty;
                subtotalVal += item.price * item.qty;
                cartList.innerHTML += `
                    <div class="flex items-center justify-between p-3 bg-[#14110E] rounded-xl border border-[#2A241F] ${idx === 0 ? 'animate-item' : ''}">
                        <div class="flex-1">
                            <h4 class="text-xs font-medium text-gray-200 line-clamp-1">${item.name}</h4>
                            <p class="text-xs text-[#CBA052] mt-0.5">${formatRupiah(item.price)}</p>
                        </div>
                        <div class="flex items-center gap-2 bg-[#1C1815] rounded-lg p-1 border border-[#2A241F]">
                            <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 flex items-center justify-center text-[#7A7A7A] hover:text-white transition-colors text-sm">-</button>
                            <span class="text-xs w-4 text-center">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 flex items-center justify-center text-[#7A7A7A] hover:text-white transition-colors text-sm">+</button>
                        </div>
                    </div>`;
            });
            cartCountBadge.innerText = totalItems;
            taxVal = subtotalVal * 0.11;
            totalVal = subtotalVal + taxVal;
            document.getElementById('subtotalDisplay').innerText = formatRupiah(subtotalVal);
            document.getElementById('taxDisplay').innerText = formatRupiah(taxVal);
            document.getElementById('totalDisplay').innerText = formatRupiah(totalVal);
        }
        calculateChange();
    }

    function calculateChange() {
        const uang = parseFloat(inputUang.value) || 0;
        if (cart.length === 0) { kembalianDisplay.innerText = '-'; kembalianDisplay.className = 'font-medium text-[#7A7A7A]'; btnProses.disabled = true; return; }
        const kembalian = uang - totalVal;
        if (uang === 0) { kembalianDisplay.innerText = '-'; kembalianDisplay.className = 'font-medium text-[#7A7A7A]'; btnProses.disabled = true; }
        else if (kembalian < 0) { kembalianDisplay.innerText = 'Kurang: ' + formatRupiah(Math.abs(kembalian)); kembalianDisplay.className = 'font-medium text-red-400'; btnProses.disabled = true; }
        else { kembalianDisplay.innerText = formatRupiah(kembalian); kembalianDisplay.className = 'font-medium text-[#CBA052] text-base'; btnProses.disabled = false; }
    }
    inputUang.addEventListener('input', calculateChange);

    function processPayment() {
        const uang = parseFloat(inputUang.value) || 0;
        sendOrderToBackend(uang, uang - totalVal);
    }

   async function sendOrderToBackend(uangMasuk, kembalian) {
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = meta ? meta.getAttribute('content') : '';
    
    if (!csrfToken) {
        alert('CSRF token tidak ditemukan. Coba refresh halaman.');
        resetBtn();
        return;
    }
    
    btnProses.disabled = true;
    btnProses.innerHTML = 'Memproses...';
    
    try {
        const response = await fetch("{{ route('kasir.transaksi.store') }}", {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify({
                cart, subtotal: subtotalVal, tax: taxVal, total: totalVal,
                cash_received: uangMasuk, order_type: selectedOrderType
            })
        });
        const result = await response.json();
        if (result.success) { showReceipt(result.trx_code, uangMasuk, kembalian); }
        else { alert(result.message || 'Transaksi gagal.'); resetBtn(); }
    } catch (err) { 
        console.error(err); 
        alert('Kesalahan koneksi.'); 
        resetBtn(); 
    }
}

    function resetBtn() {
        btnProses.disabled = false;
        btnProses.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Proses Pembayaran`;
    }

    function showReceipt(trxCode, uangMasuk, kembalian) {
        document.getElementById('receiptTrx').innerText = trxCode;
        const now = new Date();
        document.getElementById('receiptDate').innerText = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        document.getElementById('receiptOrderType').innerText = selectedOrderType === 'dinein' ? '🍽️ Dine In' : '🥡 Take Away';
        document.getElementById('receiptPayMethod').innerText = '💵 Tunai';

        const receiptItems = document.getElementById('receiptItems');
        receiptItems.innerHTML = '';
        cart.forEach(item => {
            receiptItems.innerHTML += `
                <div class="flex justify-between text-sm">
                    <div class="text-gray-300">
                        <div class="line-clamp-1">${item.name}</div>
                        <div class="text-xs text-[#7A7A7A] mt-0.5">${item.qty} x ${formatRupiah(item.price)}</div>
                    </div>
                    <div class="text-gray-200 font-medium">${formatRupiah(item.qty * item.price)}</div>
                </div>`;
        });

        document.getElementById('receiptSubtotal').innerText = formatRupiah(subtotalVal);
        document.getElementById('receiptTax').innerText = formatRupiah(taxVal);
        document.getElementById('receiptTotal').innerText = formatRupiah(totalVal);
        document.getElementById('receiptCash').innerText = formatRupiah(uangMasuk);
        document.getElementById('receiptChange').innerText = formatRupiah(kembalian);

        paymentModal.classList.remove('hidden');
        paymentModal.classList.add('block');
        modalContent.classList.remove('opacity-0', 'scale-90');
        modalContent.classList.add('animate-modal');
    }

    function closePaymentModal() {
        modalContent.classList.remove('animate-modal');
        modalContent.classList.add('opacity-0', 'scale-90');
        setTimeout(() => { location.reload(); }, 200);
    }

    // Filter
    const searchInput = document.getElementById('searchInput');
    const menuCards = document.querySelectorAll('.menu-card');
    const catBtns = document.querySelectorAll('.cat-btn');

    function filterMenu(query = '', category = 'semua') {
        menuCards.forEach(card => {
            const matchQ = card.dataset.name.includes(query.toLowerCase());
            const matchC = category === 'semua' || card.dataset.cat === category;
            card.style.display = (matchQ && matchC) ? 'flex' : 'none';
        });
    }
    searchInput.addEventListener('input', e => filterMenu(e.target.value, document.querySelector('.cat-btn.active')?.dataset.cat));
    catBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            catBtns.forEach(b => { b.classList.remove('active'); b.className = 'cat-btn px-4 py-1 rounded-full text-xs font-medium border border-[#2A241F] text-[#7A7A7A] hover:border-[#CBA052]/50 transition-all'; });
            e.target.classList.add('active');
            e.target.className = 'cat-btn active px-4 py-1 rounded-full text-xs font-medium border border-[#CBA052] bg-[#CBA052]/10 text-[#CBA052] transition-all';
            filterMenu(searchInput.value, e.target.dataset.cat);
        });
    });

    // Modal helpers
    function openClearCartModal() {
        if (cart.length === 0) return;
        const m = document.getElementById('clearCartModal');
        const mc = document.getElementById('clearCartModalContent');
        m.classList.remove('hidden'); m.classList.add('flex');
        setTimeout(() => { m.classList.remove('opacity-0'); mc.classList.remove('scale-95', 'opacity-0'); }, 10);
    }
    function closeClearCartModal() {
        const mc = document.getElementById('clearCartModalContent');
        mc.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { document.getElementById('clearCartModal').classList.add('hidden'); document.getElementById('clearCartModal').classList.remove('flex', 'opacity-0'); }, 300);
    }
    function executeClearCart() { cart = []; inputUang.value = ''; updateCartUI(); closeClearCartModal(); }
</script>
@endpush