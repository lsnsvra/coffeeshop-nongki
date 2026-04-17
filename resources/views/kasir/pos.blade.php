<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NONGKI - POS Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
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
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #2A241F; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBA052; }
        
        /* Modal Animation */
        @keyframes modalEnter {
            0% { opacity: 0; transform: scale(0.9) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal {
            animation: modalEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Dashed Divider for Receipt */
        .receipt-divider {
            background-image: linear-gradient(to right, #2A241F 50%, transparent 50%);
            background-size: 10px 1px;
            background-repeat: repeat-x;
            height: 1px;
            width: 100%;
        }
        
        /* Print Styles */
        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { 
                position: absolute; left: 0; top: 0; width: 100%; color: black; background: white; padding: 20px; 
                box-shadow: none; border: none;
            }
            .no-print { display: none !important; }
            #printArea .text-gray-200, #printArea .text-nongki-text { color: #000 !important; }
            #printArea .text-nongki-muted { color: #555 !important; }
            #printArea .text-nongki-gold { color: #000 !important; font-weight: bold; }
            .receipt-divider { background-image: linear-gradient(to right, #ccc 50%, transparent 50%); }
        }
    </style>
</head>
<body class="bg-nongki-bg text-gray-200 h-screen overflow-hidden flex flex-col select-none relative">

    @php
        $menus = [
            // KOPI
            ['id'=>1, 'name'=>'Americano','cat'=>'kopi','desc'=>'Double shot espresso dengan hot water.','price'=>28000,'price_str'=>'Rp 28.000','img'=>'images/products/americano.jpeg'],
            ['id'=>2, 'name'=>'Coffee Milk Aren Sugar','cat'=>'kopi','desc'=>'Kopi susu dengan gula aren.','price'=>35000,'price_str'=>'Rp 35.000','img'=>'images/products/coffe_milk_aren_sugar.jpeg'],
            ['id'=>3, 'name'=>'Coffee Milk Pandan','cat'=>'kopi','desc'=>'Kopi susu dengan aroma pandan.','price'=>35000,'price_str'=>'Rp 35.000','img'=>'images/products/coffe_milk_pandan.jpeg'],
            ['id'=>4, 'name'=>'Hazelnut Coffee','cat'=>'kopi','desc'=>'Kopi dengan sentuhan rasa hazelnut.','price'=>40000,'price_str'=>'Rp 40.000','img'=>'images/products/halzenutt_coffe.jpeg'],
            ['id'=>5, 'name'=>'Machiatto','cat'=>'kopi','desc'=>'Espresso dengan busa susu yang lembut.','price'=>38000,'price_str'=>'Rp 38.000','img'=>'images/products/machiatto.jpeg'],
            ['id'=>6, 'name'=>'Vanilla Latte','cat'=>'kopi','desc'=>'Cappuccino klasik sentuhan vanilla.','price'=>38000,'price_str'=>'Rp 38.000','img'=>'images/products/vanilla_latte.jpeg'],
            
            // NON KOPI
            ['id'=>7, 'name'=>'Matcha Latte','cat'=>'non-kopi','desc'=>'Matcha premium Jepang.','price'=>45000,'price_str'=>'Rp 45.000','img'=>'images/products/matcha_latte.jpeg'],
            ['id'=>8, 'name'=>'Chocolate Avocado','cat'=>'non-kopi','desc'=>'Perpaduan coklat dan alpukat.','price'=>40000,'price_str'=>'Rp 40.000','img'=>'images/products/chocolate_avocado.jpeg'],
            ['id'=>9, 'name'=>'Chocolate Drink','cat'=>'non-kopi','desc'=>'Minuman coklat hangat.','price'=>30000,'price_str'=>'Rp 30.000','img'=>'images/products/chocolate.jpeg'],
            ['id'=>10, 'name'=>'Mango Smoothie','cat'=>'non-kopi','desc'=>'Smoothie mangga segar.','price'=>35000,'price_str'=>'Rp 35.000','img'=>'images/products/manggo_smoothie.jpeg'],
            
            // MAKANAN
            ['id'=>11, 'name'=>'Baked Macaroni','cat'=>'makanan','desc'=>'Macaroni panggang dengan keju leleh.','price'=>32000,'price_str'=>'Rp 32.000','img'=>'images/products/baked_macaroni.jpeg'],
            ['id'=>12, 'name'=>'Chicken Katsu Curry','cat'=>'makanan','desc'=>'Chicken katsu saus kari Jepang.','price'=>45000,'price_str'=>'Rp 45.000','img'=>'images/products/chicken_katsu_curry.jpeg'],
            ['id'=>13, 'name'=>'Enoki Crispy','cat'=>'makanan','desc'=>'Jamur enoki goreng crispy.','price'=>25000,'price_str'=>'Rp 25.000','img'=>'images/products/enoki_crispy.jpeg'],
            ['id'=>14, 'name'=>'French Fries','cat'=>'makanan','desc'=>'Kentang goreng crispy.','price'=>22000,'price_str'=>'Rp 22.000','img'=>'images/products/french_fries.jpeg'],
            ['id'=>15, 'name'=>'Noodles','cat'=>'makanan','desc'=>'Mie goreng spesial.','price'=>28000,'price_str'=>'Rp 28.000','img'=>'images/products/noodles.jpeg'],
        ];
    @endphp

    <header class="h-16 border-b border-nongki-border flex items-center justify-between px-6 shrink-0 bg-nongki-bg relative z-10 no-print">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 text-nongki-gold">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 19h10c2.21 0 4-1.79 4-4v-6H2v6c0 2.21 1.79 4 4 4zm14-10h1c1.66 0 3 1.34 3 3s-1.34 3-3 3h-1v-6z"/>
                    <path d="M7 7c0-1.11.89-2 2-2s2-.89 2-2H9c0 1.11-.89 2-2 2s-2 .89-2 2h2z"/>
                    <path d="M12 7c0-1.11.89-2 2-2s2-.89 2-2h-2c0 1.11-.89 2-2 2s-2 .89-2 2h2z"/>
                </svg>
                <span class="font-serif font-medium text-2xl tracking-wide">NONGKI</span>
                <span class="text-nongki-muted text-xs font-sans tracking-widest ml-2 border-l border-nongki-border pl-3">KASIR</span>
            </div>
        </div>
        
        <div class="flex-1 max-w-xl mx-8 relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-nongki-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="searchInput" placeholder="Cari menu..." class="w-full bg-nongki-card border border-nongki-border text-sm rounded-full py-2 pl-10 pr-4 text-nongki-text focus:outline-none focus:border-nongki-gold transition-colors">
        </div>

        <div class="flex items-center gap-4 text-sm">
            <button onclick="toggleDrawer()" class="px-4 py-1.5 rounded-full border border-nongki-gold/50 bg-nongki-gold/10 text-nongki-gold hover:bg-nongki-gold hover:text-nongki-bg transition-colors flex items-center gap-2 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Riwayat
            </button>

            <div class="h-6 w-px bg-nongki-border mx-1"></div>

            <div class="px-3 py-1.5 rounded-full border border-nongki-border text-nongki-muted flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Shift Sore
            </div>
            <div class="text-nongki-text font-medium w-16 text-center" id="realTimeClock">--.--</div>
            
            <div class="flex items-center gap-3 ml-2">
                <div class="w-8 h-8 rounded-full bg-nongki-gold text-nongki-bg font-bold flex items-center justify-center shadow-[0_0_15px_-3px_rgba(203,160,82,0.4)]">KS</div>
                <form id="logout-form" action="{{ route('logout') ?? url('/logout') }}" method="POST" class="m-0 p-0 hidden">
                    @csrf
                </form>
                <button type="button" onclick="openLogoutModal()" class="p-2 text-nongki-muted hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-colors flex items-center justify-center" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 flex overflow-hidden no-print relative">
        <div class="flex-1 flex flex-col h-full bg-nongki-bg">
            <div class="p-6 pb-2 shrink-0">
                <div class="text-xs text-nongki-muted font-semibold tracking-wider mb-3 uppercase">Kategori</div>
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide" id="categoryFilter">
                    <button class="cat-btn active px-5 py-1.5 rounded-full text-sm font-medium border border-nongki-gold bg-nongki-gold/10 text-nongki-gold transition-all" data-cat="semua">Semua</button>
                    <button class="cat-btn px-5 py-1.5 rounded-full text-sm font-medium border border-nongki-border text-nongki-muted hover:border-nongki-gold/50 hover:text-nongki-text transition-all" data-cat="kopi">Kopi</button>
                    <button class="cat-btn px-5 py-1.5 rounded-full text-sm font-medium border border-nongki-border text-nongki-muted hover:border-nongki-gold/50 hover:text-nongki-text transition-all" data-cat="non-kopi">Non-Kopi</button>
                    <button class="cat-btn px-5 py-1.5 rounded-full text-sm font-medium border border-nongki-border text-nongki-muted hover:border-nongki-gold/50 hover:text-nongki-text transition-all" data-cat="makanan">Makanan</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 pt-2">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5" id="productGrid">
                    @foreach($menus as $menu)
                    <div class="menu-card bg-nongki-card rounded-2xl border border-nongki-border hover:border-nongki-gold/50 transition-all cursor-pointer group flex flex-col h-full relative overflow-hidden" 
                         data-cat="{{ $menu['cat'] }}" 
                         data-name="{{ strtolower($menu['name']) }}"
                         onclick="addToCart({{ $menu['id'] }}, '{{ $menu['name'] }}', {{ $menu['price'] }})">
                        
                        <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-white group-hover:bg-nongki-gold group-hover:border-nongki-gold transition-all z-10 shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </div>

                        <div class="h-36 w-full bg-[#2A241F] overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-t from-nongki-card to-transparent z-0 opacity-80"></div>
                            <img src="{{ asset($menu['img']) }}" alt="{{ $menu['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <div class="p-4 pt-3 mt-auto relative z-10 bg-nongki-card">
                            <h3 class="text-sm font-semibold text-gray-200 line-clamp-1 group-hover:text-nongki-gold transition-colors">{{ $menu['name'] }}</h3>
                            <p class="text-nongki-muted text-[10px] mt-1 line-clamp-1">{{ $menu['desc'] }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-nongki-gold text-sm font-bold">{{ $menu['price_str'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="w-[400px] bg-nongki-card border-l border-nongki-border flex flex-col h-full shrink-0 shadow-[-10px_0_30px_-15px_rgba(0,0,0,0.5)] z-20">
            <div class="p-5 border-b border-nongki-border flex items-center justify-between bg-nongki-card">
                <div class="flex items-center gap-3 text-lg font-medium">
                    <svg class="w-5 h-5 text-nongki-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pesanan Baru <span id="cartCountBadge" class="bg-nongki-gold text-nongki-bg text-xs font-bold px-2 py-0.5 rounded-full">0</span>
                </div>
                <button onclick="openClearCartModal()" class="text-sm text-nongki-muted hover:text-red-400 transition-colors">Batal</button>
            </div>

            <div class="p-4 grid grid-cols-3 gap-2 border-b border-nongki-border bg-nongki-bg/30">
                <button class="order-type-btn active py-2 text-xs font-medium rounded-lg bg-nongki-gold/10 text-nongki-gold border border-nongki-gold">Dine In</button>
                <button class="order-type-btn py-2 text-xs font-medium rounded-lg bg-nongki-bg text-nongki-muted border border-nongki-border hover:border-nongki-gold/30">Take Away</button>
                <button class="order-type-btn py-2 text-xs font-medium rounded-lg bg-nongki-bg text-nongki-muted border border-nongki-border hover:border-nongki-gold/30">Delivery</button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="cartItemsContainer">
                <div class="h-full flex flex-col items-center justify-center text-nongki-muted text-sm" id="emptyCartMessage">
                    <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Belum ada pesanan.
                </div>
            </div>

            <div class="p-5 border-t border-nongki-border bg-nongki-bg">
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between text-nongki-muted">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-nongki-muted">
                        <span>PPN 11%</span>
                        <span id="taxDisplay">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-nongki-text pt-3 border-t border-nongki-border mt-3">
                        <span>Total</span>
                        <span id="totalDisplay" class="text-nongki-gold">Rp 0</span>
                    </div>
                </div>

                <div class="space-y-3 mb-5">
                    <div class="flex items-center justify-between text-sm">
                        <label class="text-nongki-muted">Uang Masuk</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-nongki-muted">Rp</span>
                            <input type="number" id="inputUang" class="bg-nongki-card border border-nongki-border rounded-lg pl-8 pr-3 py-2 w-36 text-right focus:outline-none focus:border-nongki-gold focus:ring-1 focus:ring-nongki-gold text-nongki-text transition-all" placeholder="0">
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-nongki-muted">Kembalian</span>
                        <span id="kembalianDisplay" class="font-medium text-nongki-muted">-</span>
                    </div>
                </div>

                <button id="btnProses" onclick="processPayment()" class="w-full bg-nongki-gold hover:bg-nongki-goldHover text-nongki-bg font-bold py-3.5 rounded-xl transition-all shadow-[0_4px_20px_-5px_rgba(203,160,82,0.4)] hover:shadow-[0_4px_25px_-5px_rgba(203,160,82,0.6)] flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none" disabled>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Proses Pembayaran
                </button>
            </div>
        </div>

        <div id="drawerOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm z-30 opacity-0 pointer-events-none transition-opacity duration-300" onclick="toggleDrawer()"></div>
        
        <div id="sideDrawer" class="absolute top-0 right-0 h-full w-[400px] bg-nongki-card border-l border-nongki-border z-40 transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
            <div class="p-6 border-b border-nongki-border flex justify-between items-center bg-nongki-bg/50">
                <h2 class="text-xl font-bold text-nongki-gold flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pusat Pesanan
                </h2>
                <button onclick="toggleDrawer()" class="p-2 text-nongki-muted hover:text-white rounded-full hover:bg-nongki-border transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-4 grid grid-cols-2 gap-2 border-b border-nongki-border bg-nongki-bg">
                <button id="tabAktif" onclick="switchDrawerTab('aktif')" class="py-2.5 text-sm font-medium rounded-lg bg-nongki-gold/10 text-nongki-gold border border-nongki-gold transition-all">Pesanan Aktif (3)</button>
                <button id="tabRiwayat" onclick="switchDrawerTab('riwayat')" class="py-2.5 text-sm font-medium rounded-lg bg-nongki-card text-nongki-muted border border-nongki-border hover:border-nongki-gold/50 transition-all">Riwayat Selesai</button>
            </div>

            <div id="contentAktif" class="flex-1 overflow-y-auto p-4 space-y-4 block">
                <div class="bg-nongki-bg border border-nongki-border rounded-xl p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs font-mono text-nongki-muted block">#ORD-0248</span>
                            <span class="font-bold text-gray-200">Meja 04 - Budi</span>
                        </div>
                        <span class="px-2 py-1 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-[10px] rounded-full uppercase tracking-wider font-bold">Diproses</span>
                    </div>
                    <div class="text-sm text-nongki-muted mb-3 border-l-2 border-nongki-border pl-2">2x Vanilla Latte<br>1x French Fries</div>
                    <div class="flex justify-between items-center pt-3 border-t border-nongki-border">
                        <span class="font-bold text-nongki-gold">Rp 98.000</span>
                        <button class="px-3 py-1.5 bg-nongki-card border border-nongki-border text-nongki-text hover:border-nongki-gold text-xs rounded-lg transition-colors">Ubah</button>
                    </div>
                </div>
                
                <div class="bg-nongki-bg border border-nongki-border rounded-xl p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs font-mono text-nongki-muted block">#ORD-0249</span>
                            <span class="font-bold text-gray-200">Take Away - Sarah</span>
                        </div>
                        <span class="px-2 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] rounded-full uppercase tracking-wider font-bold">Siap Saji</span>
                    </div>
                    <div class="text-sm text-nongki-muted mb-3 border-l-2 border-nongki-border pl-2">1x Matcha Latte<br>1x Chicken Katsu</div>
                    <div class="flex justify-between items-center pt-3 border-t border-nongki-border">
                        <span class="font-bold text-nongki-gold">Rp 90.000</span>
                        <button class="px-3 py-1.5 bg-nongki-gold text-nongki-bg text-xs font-bold rounded-lg transition-colors">Selesaikan</button>
                    </div>
                </div>
            </div>

            <div id="contentRiwayat" class="flex-1 overflow-y-auto p-4 space-y-4 hidden">
                <div class="bg-nongki-bg border border-nongki-border rounded-xl p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs font-mono text-nongki-muted block">TRX-982103</span>
                            <span class="text-xs text-nongki-muted block">Hari ini, 08:45 WIB</span>
                        </div>
                        <span class="px-2 py-1 bg-green-500/10 text-green-500 border border-green-500/20 text-[10px] rounded-full uppercase tracking-wider font-bold">Sukses</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-nongki-border">
                        <span class="font-bold text-gray-200">Rp 120.000</span>
                        <button class="px-3 py-1.5 bg-nongki-card border border-nongki-border text-nongki-text hover:text-white text-xs rounded-lg transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Struk
                        </button>
                    </div>
                </div>
                <div class="bg-nongki-bg border border-nongki-border rounded-xl p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs font-mono text-nongki-muted block">TRX-982102</span>
                            <span class="text-xs text-nongki-muted block">Hari ini, 08:15 WIB</span>
                        </div>
                        <span class="px-2 py-1 bg-green-500/10 text-green-500 border border-green-500/20 text-[10px] rounded-full uppercase tracking-wider font-bold">Sukses</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-nongki-border">
                        <span class="font-bold text-gray-200">Rp 35.000</span>
                        <button class="px-3 py-1.5 bg-nongki-card border border-nongki-border text-nongki-text hover:text-white text-xs rounded-lg transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Struk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="logoutModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div id="logoutModalContent" class="bg-nongki-card border border-nongki-border w-full max-w-sm rounded-2xl p-6 shadow-2xl transform transition-all duration-300 scale-95 opacity-0 text-center relative">
            <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/20 shadow-[0_0_15px_rgba(239,68,68,0.2)] relative z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-200 mb-2 relative z-10">Konfirmasi Keluar</h2>
            <p class="text-nongki-muted text-sm mb-6 relative z-10">Apakah Anda yakin ingin keluar dari halaman kasir NONGKI?</p>
            <div class="flex gap-3 relative z-10">
                <button onclick="closeLogoutModal()" class="flex-1 py-3 rounded-xl border border-nongki-border text-nongki-text hover:bg-nongki-bg transition-colors text-sm font-medium">Batal</button>
                <button onclick="executeLogout()" class="flex-1 py-3 rounded-xl bg-nongki-gold text-nongki-bg font-bold hover:bg-nongki-goldHover transition-colors text-sm">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="clearCartModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div id="clearCartModalContent" class="bg-nongki-card border border-nongki-border w-full max-w-sm rounded-2xl p-6 shadow-2xl transform transition-all duration-300 scale-95 opacity-0 text-center relative">
            <div class="w-16 h-16 bg-red-500/10 text-red-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/20 shadow-[0_0_15px_rgba(248,113,113,0.2)]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-200 mb-2">Hapus Pesanan</h2>
            <p class="text-nongki-muted text-sm mb-6">Apakah Anda yakin ingin membatalkan dan menghapus pesanan saat ini?</p>
            <div class="flex gap-3">
                <button onclick="closeClearCartModal()" class="flex-1 py-3 rounded-xl border border-nongki-border text-nongki-text hover:bg-nongki-bg transition-colors text-sm font-medium">Kembali</button>
                <button onclick="executeClearCart()" class="flex-1 py-3 rounded-xl bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-colors text-sm font-bold">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-4">
        <div id="modalContent" class="w-full max-w-md transform transition-all opacity-0 scale-90">
            <div id="printArea" class="bg-nongki-card border border-nongki-gold/20 shadow-[0_0_50px_-10px_rgba(203,160,82,0.15)] rounded-2xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-nongki-gold/20 to-transparent no-print"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-nongki-gold/10 to-transparent no-print"></div>

                <div class="text-center mb-6 relative z-10">
                    <div class="flex items-center justify-center gap-2 text-nongki-gold mb-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M4 19h10c2.21 0 4-1.79 4-4v-6H2v6c0 2.21 1.79 4 4 4zm14-10h1c1.66 0 3 1.34 3 3s-1.34 3-3 3h-1v-6z"/><path d="M7 7c0-1.11.89-2 2-2s2-.89 2-2H9c0 1.11-.89 2-2 2s-2 .89-2 2h2z"/><path d="M12 7c0-1.11.89-2 2-2s2-.89 2-2h-2c0 1.11-.89 2-2 2s-2 .89-2 2h2z"/></svg>
                        <span class="font-serif font-bold text-xl tracking-widest">NONGKI</span>
                    </div>
                    <h2 class="text-sm font-medium text-nongki-text tracking-widest uppercase mb-1">Struk Pembayaran</h2>
                    <p class="text-nongki-muted text-xs" id="receiptDate">--</p>
                    <p class="text-nongki-muted text-xs mt-1 font-mono" id="receiptTrx">TRX-000000</p>
                </div>

                <div class="receipt-divider mb-4"></div>

                <div class="py-2 mb-2 space-y-3 min-h-[100px] max-h-[250px] overflow-y-auto scrollbar-hide" id="receiptItems"></div>

                <div class="receipt-divider mt-2 mb-4"></div>

                <div class="space-y-2 text-sm mb-6 relative z-10">
                    <div class="flex justify-between text-nongki-muted">
                        <span>Subtotal</span><span id="receiptSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-nongki-muted">
                        <span>PPN 11%</span><span id="receiptTax">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-gray-100 font-bold pt-3 mt-2 border-t border-nongki-border">
                        <span>Total Transaksi</span><span id="receiptTotal" class="text-nongki-gold">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-nongki-muted pt-2">
                        <span>Tunai / Masuk</span><span id="receiptCash">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-nongki-text font-medium mt-1">
                        <span>Kembalian</span><span id="receiptChange">Rp 0</span>
                    </div>
                </div>

                <div class="text-center text-xs text-nongki-muted mt-8 relative z-10">
                    <p class="mb-1">Terima kasih atas kunjungan Anda!</p>
                    <p>Powered by NONGKI POS</p>
                </div>
            </div>

            <div class="flex gap-4 mt-6 no-print">
                <button onclick="window.print()" class="flex-1 py-3.5 rounded-xl border border-nongki-border text-nongki-text bg-nongki-card hover:bg-nongki-border hover:text-white transition-all text-sm font-medium flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Struk
                </button>
                <button onclick="closePaymentModal()" class="flex-1 py-3.5 rounded-xl bg-nongki-gold text-nongki-bg font-bold hover:bg-nongki-goldHover transition-all text-sm shadow-[0_0_15px_rgba(203,160,82,0.3)] flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Selesai & Baru
                </button>
            </div>
        </div>
    </div>

    <script>
        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

        let cart = [];
        let totalVal = 0;
        let subtotalVal = 0;
        let taxVal = 0;

        // Elements
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartCountBadge = document.getElementById('cartCountBadge');
        const inputUang = document.getElementById('inputUang');
        const kembalianDisplay = document.getElementById('kembalianDisplay');
        const btnProses = document.getElementById('btnProses');

        // Clock
        setInterval(() => {
            const now = new Date();
            document.getElementById('realTimeClock').innerText = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute:'2-digit' }).replace(/:/g, '.');
        }, 1000);

        // --- DRAWER (PESANAN & RIWAYAT) LOGIC ---
        let drawerOpen = false;
        const sideDrawer = document.getElementById('sideDrawer');
        const drawerOverlay = document.getElementById('drawerOverlay');
        const tabAktif = document.getElementById('tabAktif');
        const tabRiwayat = document.getElementById('tabRiwayat');
        const contentAktif = document.getElementById('contentAktif');
        const contentRiwayat = document.getElementById('contentRiwayat');

        function toggleDrawer() {
            drawerOpen = !drawerOpen;
            if(drawerOpen) {
                drawerOverlay.classList.remove('opacity-0', 'pointer-events-none');
                drawerOverlay.classList.add('opacity-100');
                sideDrawer.classList.remove('translate-x-full');
            } else {
                drawerOverlay.classList.remove('opacity-100');
                drawerOverlay.classList.add('opacity-0', 'pointer-events-none');
                sideDrawer.classList.add('translate-x-full');
            }
        }

        function switchDrawerTab(tab) {
            if(tab === 'aktif') {
                tabAktif.className = 'py-2.5 text-sm font-medium rounded-lg bg-nongki-gold/10 text-nongki-gold border border-nongki-gold transition-all';
                tabRiwayat.className = 'py-2.5 text-sm font-medium rounded-lg bg-nongki-card text-nongki-muted border border-nongki-border hover:border-nongki-gold/50 transition-all';
                contentAktif.classList.remove('hidden');
                contentRiwayat.classList.add('hidden');
            } else {
                tabRiwayat.className = 'py-2.5 text-sm font-medium rounded-lg bg-nongki-gold/10 text-nongki-gold border border-nongki-gold transition-all';
                tabAktif.className = 'py-2.5 text-sm font-medium rounded-lg bg-nongki-card text-nongki-muted border border-nongki-border hover:border-nongki-gold/50 transition-all';
                contentRiwayat.classList.remove('hidden');
                contentAktif.classList.add('hidden');
            }
        }


        // --- CUSTOM MODAL LOGIC: LOGOUT ---
        const logoutModal = document.getElementById('logoutModal');
        const logoutModalContent = document.getElementById('logoutModalContent');

        function openLogoutModal() {
            logoutModal.classList.remove('hidden');
            logoutModal.classList.add('flex');
            setTimeout(() => {
                logoutModal.classList.remove('opacity-0');
                logoutModalContent.classList.remove('scale-95', 'opacity-0');
                logoutModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeLogoutModal() {
            logoutModal.classList.add('opacity-0');
            logoutModalContent.classList.remove('scale-100', 'opacity-100');
            logoutModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                logoutModal.classList.add('hidden');
                logoutModal.classList.remove('flex');
            }, 300);
        }

        function executeLogout() { document.getElementById('logout-form').submit(); }

        // --- CUSTOM MODAL LOGIC: CLEAR CART ---
        const clearCartModal = document.getElementById('clearCartModal');
        const clearCartModalContent = document.getElementById('clearCartModalContent');

        function openClearCartModal() {
            if (cart.length === 0) return; 
            clearCartModal.classList.remove('hidden');
            clearCartModal.classList.add('flex');
            setTimeout(() => {
                clearCartModal.classList.remove('opacity-0');
                clearCartModalContent.classList.remove('scale-95', 'opacity-0');
                clearCartModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeClearCartModal() {
            clearCartModal.classList.add('opacity-0');
            clearCartModalContent.classList.remove('scale-100', 'opacity-100');
            clearCartModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                clearCartModal.classList.add('hidden');
                clearCartModal.classList.remove('flex');
            }, 300);
        }

        function executeClearCart() {
            cart = [];
            inputUang.value = '';
            updateCartUI();
            closeClearCartModal();
        }

        // --- CART LOGIC ---
        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) existingItem.qty += 1;
            else cart.push({ id, name, price, qty: 1 });
            updateCartUI();
        }

        function updateQty(id, delta) {
            const index = cart.findIndex(item => item.id === id);
            if (index > -1) {
                cart[index].qty += delta;
                if (cart[index].qty <= 0) cart.splice(index, 1);
                updateCartUI();
            }
        }

        function updateCartUI() {
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '';
                cartItemsContainer.appendChild(emptyCartMessage);
                emptyCartMessage.style.display = 'flex';
                cartCountBadge.innerText = '0';
                
                document.getElementById('subtotalDisplay').innerText = 'Rp 0';
                document.getElementById('taxDisplay').innerText = 'Rp 0';
                document.getElementById('totalDisplay').innerText = 'Rp 0';
                
                totalVal = 0;
            } else {
                emptyCartMessage.style.display = 'none';
                cartItemsContainer.innerHTML = '';
                
                let totalItems = 0;
                subtotalVal = 0;

                cart.forEach(item => {
                    totalItems += item.qty;
                    subtotalVal += (item.price * item.qty);

                    cartItemsContainer.innerHTML += `
                        <div class="flex items-center justify-between p-3 bg-nongki-bg rounded-xl border border-nongki-border shadow-sm">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-200 line-clamp-1">${item.name}</h4>
                                <p class="text-xs text-nongki-gold mt-1">${formatRupiah(item.price)}</p>
                            </div>
                            <div class="flex items-center gap-3 bg-nongki-card rounded-lg p-1 border border-nongki-border">
                                <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 flex items-center justify-center text-nongki-muted hover:text-white transition-colors">-</button>
                                <span class="text-sm w-4 text-center">${item.qty}</span>
                                <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 flex items-center justify-center text-nongki-muted hover:text-white transition-colors">+</button>
                            </div>
                        </div>
                    `;
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
            const uangMasuk = parseFloat(inputUang.value) || 0;
            
            if (cart.length === 0) {
                kembalianDisplay.innerText = '-';
                kembalianDisplay.className = 'font-medium text-nongki-muted';
                btnProses.disabled = true;
                return;
            }

            const kembalian = uangMasuk - totalVal;
            
            if (uangMasuk === 0) {
                kembalianDisplay.innerText = '-';
                kembalianDisplay.className = 'font-medium text-nongki-muted';
                btnProses.disabled = true;
            } else if (kembalian < 0) {
                kembalianDisplay.innerText = 'Kurang: ' + formatRupiah(Math.abs(kembalian));
                kembalianDisplay.className = 'font-medium text-red-400';
                btnProses.disabled = true;
            } else {
                kembalianDisplay.innerText = formatRupiah(kembalian);
                kembalianDisplay.className = 'font-medium text-nongki-gold text-lg';
                btnProses.disabled = false;
            }
        }

        inputUang.addEventListener('input', calculateChange);

        // --- PAYMENT & RECEIPT MODAL LOGIC ---
        const paymentModal = document.getElementById('paymentModal');
        const paymentModalContent = document.getElementById('modalContent');

        function processPayment() {
            const uangMasuk = parseFloat(inputUang.value) || 0;
            const kembalian = uangMasuk - totalVal;

            const randomId = Math.floor(100000 + Math.random() * 900000);
            document.getElementById('receiptTrx').innerText = 'TRX-' + randomId;

            const now = new Date();
            const options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('receiptDate').innerText = now.toLocaleDateString('id-ID', options);

            const receiptItems = document.getElementById('receiptItems');
            receiptItems.innerHTML = '';
            cart.forEach(item => {
                receiptItems.innerHTML += `
                    <div class="flex justify-between text-sm">
                        <div class="text-gray-300">
                            <div class="line-clamp-1">${item.name}</div>
                            <div class="text-xs text-nongki-muted mt-0.5">${item.qty} x ${formatRupiah(item.price)}</div>
                        </div>
                        <div class="text-gray-200 font-medium">${formatRupiah(item.qty * item.price)}</div>
                    </div>
                `;
            });

            document.getElementById('receiptSubtotal').innerText = formatRupiah(subtotalVal);
            document.getElementById('receiptTax').innerText = formatRupiah(taxVal);
            document.getElementById('receiptTotal').innerText = formatRupiah(totalVal);
            document.getElementById('receiptCash').innerText = formatRupiah(uangMasuk);
            document.getElementById('receiptChange').innerText = formatRupiah(kembalian);

            paymentModal.classList.remove('hidden');
            paymentModal.classList.add('flex');
            paymentModalContent.classList.remove('opacity-0', 'scale-90');
            paymentModalContent.classList.add('animate-modal');
            
            // Note: Di sistem asli, di sini Anda bisa me-refresh data Riwayat Drawer via AJAX.
        }

        function closePaymentModal() {
            paymentModalContent.classList.remove('animate-modal');
            paymentModalContent.classList.add('opacity-0', 'scale-90');
            
            setTimeout(() => {
                paymentModal.classList.add('hidden');
                paymentModal.classList.remove('flex');
                
                cart = [];
                inputUang.value = '';
                updateCartUI();
            }, 200); 
        }

        // --- FILTER LOGIC ---
        const searchInput = document.getElementById('searchInput');
        const menuCards = document.querySelectorAll('.menu-card');
        const catBtns = document.querySelectorAll('.cat-btn');

        function filterMenu(query = '', category = 'semua') {
            menuCards.forEach(card => {
                const name = card.dataset.name;
                const cat = card.dataset.cat;
                const matchQuery = name.includes(query.toLowerCase());
                const matchCat = category === 'semua' || cat === category;
                card.style.display = (matchQuery && matchCat) ? 'flex' : 'none';
            });
        }

        searchInput.addEventListener('input', (e) => {
            const activeCat = document.querySelector('.cat-btn.active').dataset.cat;
            filterMenu(e.target.value, activeCat);
        });

        catBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                catBtns.forEach(b => {
                    b.classList.remove('active', 'bg-nongki-gold/10', 'text-nongki-gold', 'border-nongki-gold');
                    b.classList.add('text-nongki-muted', 'border-nongki-border');
                });
                const clicked = e.target;
                clicked.classList.add('active', 'bg-nongki-gold/10', 'text-nongki-gold', 'border-nongki-gold');
                clicked.classList.remove('text-nongki-muted', 'border-nongki-border');
                filterMenu(searchInput.value, clicked.dataset.cat);
            });
        });
    </script>
</body>
</html>