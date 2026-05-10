@extends('layouts.kasir')

@section('title', 'Menu — NONGKI Kasir')

@push('styles')
<style>
    /* ========== ANIMASI ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ========== CONTAINER & HEADER ========== */
    .menu-container {
        background: var(--dark-2);
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid var(--border);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    /* ========== SEARCH BAR PREMIUM ========== */
    .search-bar-pos {
        display: flex;
        align-items: center;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 12px 20px;
        width: 320px;
        transition: 0.3s;
    }
    .search-bar-pos:focus-within { border-color: var(--gold); box-shadow: 0 0 10px rgba(201,168,76,0.1); }
    .search-bar-pos i { color: var(--gold); margin-right: 12px; font-size: 1.1rem; }
    .search-bar-pos input {
        background: transparent; border: none; color: var(--cream);
        width: 100%; outline: none; font-size: 0.95rem; font-family: inherit;
    }
    .search-bar-pos input::placeholder { color: var(--text-muted-c); }

    /* ========== CATEGORY TABS ========== */
    .category-tabs { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 5px; }
    .cat-tab {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-muted-c);
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    .cat-tab:hover { border-color: var(--gold); color: var(--gold); }
    .cat-tab.active { background: var(--gold); color: var(--dark); border-color: var(--gold); box-shadow: 0 5px 15px rgba(201,168,76,0.2); }

    /* ========== MENU GRID & CARDS ========== */
    .menu-grid-large {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.8rem;
    }
    
    .menu-card-large {
        background: var(--dark-3);
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.03);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .menu-card-large:hover {
        transform: translateY(-6px);
        border-color: rgba(201, 168, 76, 0.4);
        box-shadow: 0 12px 24px rgba(0,0,0,0.3), 0 0 15px rgba(201,168,76,0.1);
    }

    /* Image Wrapper with Hover Zoom */
    .menu-img-wrap {
        height: 170px;
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .menu-img-wrap img {
        width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;
    }
    .menu-card-large:hover .menu-img-wrap img { transform: scale(1.1); }

    /* Card Details */
    .menu-detail {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .menu-cat {
        display: inline-block;
        background: rgba(201,168,76,0.1);
        color: var(--gold);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .menu-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--cream);
        line-height: 1.3;
        margin-bottom: 1.2rem;
    }

    /* ========== CARD FOOTER (AKSI KIRI, HARGA KANAN) ========== */
    .menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        border-top: 1px dashed rgba(255,255,255,0.05);
        padding-top: 1rem;
    }
    
    /* Tombol Aksi di Kiri */
    .btn-add-cart {
        background: rgba(201,168,76,0.15);
        color: var(--gold);
        border: 1px solid rgba(201,168,76,0.3);
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        font-size: 1rem;
    }
    .btn-add-cart:hover {
        background: var(--gold);
        color: var(--dark);
        transform: scale(1.1);
    }

    /* Harga di Kanan */
    .menu-price-large {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--gold);
        font-family: 'DM Sans', sans-serif;
    }
</style>
@endpush

@section('content')
@php
    // DATA DUMMY (Supaya FE bisa dipresentasikan tanpa error BE)
    $menus = [
        ['id'=>1, 'name'=>'Americano','cat'=>'kopi','price'=>'Rp 28.000','img'=>'americano.jpeg'],
        ['id'=>2, 'name'=>'Coffee Milk Aren Sugar','cat'=>'kopi','price'=>'Rp 35.000','img'=>'coffe_milk_aren_sugar.jpeg'],
        ['id'=>3, 'name'=>'Coffee Milk Pandan','cat'=>'kopi','price'=>'Rp 35.000','img'=>'coffe_milk_pandan.jpeg'],
        ['id'=>4, 'name'=>'Hazelnut Coffee','cat'=>'kopi','price'=>'Rp 40.000','img'=>'halzenutt_coffe.jpeg'],
        ['id'=>5, 'name'=>'Machiatto','cat'=>'kopi','price'=>'Rp 38.000','img'=>'machiatto.jpeg'],
        ['id'=>6, 'name'=>'Vanilla Latte','cat'=>'kopi','price'=>'Rp 38.000','img'=>'vanilla_latte.jpeg'],
        ['id'=>7, 'name'=>'Matcha Latte','cat'=>'non-kopi','price'=>'Rp 45.000','img'=>'matcha_latte.jpeg'],
        ['id'=>8, 'name'=>'Chocolate Avocado','cat'=>'non-kopi','price'=>'Rp 40.000','img'=>'chocolate_avocado.jpeg'],
        ['id'=>9, 'name'=>'Chocolate Drink','cat'=>'non-kopi','price'=>'Rp 30.000','img'=>'chocolate.jpeg'],
        ['id'=>10, 'name'=>'Mango Smoothie','cat'=>'non-kopi','price'=>'Rp 35.000','img'=>'manggo_smoothie.jpeg'],
        ['id'=>11, 'name'=>'Baked Macaroni','cat'=>'makanan','price'=>'Rp 32.000','img'=>'baked_macaroni.jpeg'],
        ['id'=>12, 'name'=>'Chicken Katsu Curry','cat'=>'makanan','price'=>'Rp 45.000','img'=>'chicken_katsu_curry.jpeg'],
    ];
@endphp

<div class="page-header fade-in-up" style="margin-bottom: 2rem;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Sistem Kasir NONGKI</h1>
    <p style="color: var(--text-muted-c);">Pilih menu dan tambahkan ke keranjang pelanggan.</p>
</div>

<div class="menu-container fade-in-up" style="animation-delay: 0.1s;">
    {{-- HEADER KASIR (Search & Filter) --}}
    <div class="menu-header">
        <div class="search-bar-pos">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari nama menu...">
        </div>
        
        <div class="category-tabs">