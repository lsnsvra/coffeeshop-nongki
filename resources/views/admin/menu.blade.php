@extends('layouts.admin')

@section('title', 'Manajemen Menu — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI & FLOW ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== LAYOUT SPACING ========== */
    .menu-management-container { padding: 5px; }
    
    .dashboard-header { margin-bottom: 2rem; }

    /* ========== ACTION BAR (LEFT ALIGNED) ========== */
    .menu-action-bar { 
        display: flex; 
        gap: 1.5rem; 
        margin-bottom: 2.5rem; 
        align-items: center; 
        justify-content: flex-start; /* Memastikan semua aksi di kiri */
    }

    .btn-add-menu {
        background: var(--gold); 
        color: var(--dark); 
        border: none; 
        padding: 12px 28px; 
        border-radius: 12px; 
        font-weight: 700; 
        cursor: pointer; 
        transition: 0.3s; 
        display: flex; 
        align-items: center; 
        gap: 10px;
    }
    .btn-add-menu:hover { 
        background: var(--gold-light); 
        transform: translateY(-3px); 
        box-shadow: 0 8px 20px rgba(201,168,76,0.3); 
    }

    /* ========== PREMIUM TABLE (ANTI-PADAT) ========== */
    .menu-panel { 
        background: var(--dark-2); 
        border: 1px solid var(--border); 
        border-radius: 20px; 
        padding: 2rem; 
    }
    
    .nongki-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    
    .nongki-table th { 
        padding: 1rem; 
        text-align: left; 
        font-size: 0.7rem; 
        text-transform: uppercase; 
        color: var(--text-muted-c); 
        letter-spacing: 1.5px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .nongki-table td { 
        padding: 1.2rem 1rem; 
        border-top: 1px solid rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.02);
        color: var(--cream-dim); 
        vertical-align: middle; 
    }
    
    /* Rounded corners for each row */
    .nongki-table td:first-child { border-left: 1px solid rgba(255,255,255,0.02); border-radius: 12px 0 0 12px; }
    .nongki-table td:last-child { border-right: 1px solid rgba(255,255,255,0.02); border-radius: 0 12px 12px 0; }

    .nongki-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .menu-img-preview { 
        width: 50px; height: 50px; border-radius: 10px; 
        object-fit: cover; border: 1px solid rgba(201,168,76,0.2); 
    }

    /* ========== AKSI DI KIRI ========== */
    .action-col { width: 100px; text-align: center; }
    .action-btns { display: flex; gap: 8px; justify-content: center; }
    
    .btn-table-action {
        width: 34px; height: 34px; border-radius: 8px; display: flex;
        align-items: center; justify-content: center; font-size: 0.85rem;
        cursor: pointer; transition: 0.3s; border: 1px solid rgba(255,255,255,0.05);
    }
    .btn-edit { background: rgba(201,168,76,0.1); color: var(--gold); }
    .btn-edit:hover { background: var(--gold); color: var(--dark); }
    .btn-delete { background: rgba(224, 82, 82, 0.1); color: #e05252; }
    .btn-delete:hover { background: #e05252; color: white; }

    .cat-badge { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .badge-kopi { background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.2); }
</style>
@endpush

@section('content')
@php
    // 1. Ambil data langsung dari tabel products
    $menus = \Illuminate\Support\Facades\DB::table('products')->where('IsDeleted', 0)->get();

    // 2. Helper Kategori (Karna di DB products belum ada kolom kategori)
    function getCategory($name) {
        $name = strtolower($name);
        $kopi = ['americano', 'coffee', 'macchiato', 'latte', 'aren', 'pandan'];
        $makanan = ['macaroni', 'katsu', 'crispy', 'fries', 'noodles', 'noodle'];
        
        foreach($kopi as $k) { if(strpos($name, $k) !== false) return 'kopi'; }
        foreach($makanan as $m) { if(strpos($name, $m) !== false) return 'makanan'; }
        return 'non-kopi';
    }
@endphp

<div class="menu-management-container fade-in-up">
    <div class="dashboard-header">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Menu Inventory</h1>
        <p style="color: var(--text-muted-c);">Atur total koleksi produk aktif di NONGKI.</p>
    </div>

    {{-- ACTION BAR (SUDAH DI KIRI SEMUA) --}}
    <div class="menu-action-bar">
        <button class="btn-add-menu">
            <i class="fa-solid fa-plus-circle"></i> Tambah Produk Baru
        </button>
        <div style="color: var(--text-muted-c); font-size: 0.85rem; border-left: 1px solid var(--border); padding-left: 1.5rem;">
            Total: <strong>{{ count($menus) }} Produk</strong>
        </div>
    </div>

    {{-- TABLE PANEL --}}
    <div class="menu-panel">
        <div style="overflow-x: auto;">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th class="action-col">Aksi</th>
                        <th>Preview</th>
                        <th>Informasi Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        {{-- AKSI DI KIRI --}}
                        <td class="action-col">
                            <div class="action-btns">
                                <button class="btn-table-action btn-edit"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-table-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                        <td>
                            <img src="{{ asset('images/products/' . $menu->image) }}" class="menu-img-preview" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream); font-size: 1rem;">{{ $menu->NamaKopi }}</div>
                            <div style="font-size: 0.7rem; color: var(--gold);">#PROD-{{ str_pad($menu->id ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td><span class="cat-badge badge-kopi">{{ getCategory($menu->NamaKopi) }}</span></td>
                        <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($menu->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection