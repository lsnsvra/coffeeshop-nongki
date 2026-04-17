@extends('layouts.kasir')
@section('title', 'Menu — NONGKI Kasir')

@push('styles')
<style>
    .menu-container {
        background: var(--dark-2);
        border-radius: var(--radius-card);
        padding: 28px;
        border: 1px solid var(--border);
    }
    .menu-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 32px;
    }
    .menu-grid-large {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    .menu-card-large {
        background: var(--dark-3);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .menu-img-large {
        height: 160px;
        background-size: cover;
    }
    .menu-detail {
        padding: 20px;
    }
    .menu-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .menu-cat {
        color: var(--gold);
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .menu-price-large {
        font-size: 20px;
        font-weight: 700;
        color: var(--gold);
    }
</style>
@endpush

@section('content')
<div class="page-title">
    <i class="fa-solid fa-utensils"></i> Daftar Menu
</div>
<div class="menu-container">
    <div class="menu-header">
        <div class="search-bar" style="width:300px;">
            <input type="text" class="search-input" placeholder="Cari menu...">
        </div>
        <div class="category-tabs">
            <button class="cat-tab active">Semua</button>
            <button class="cat-tab">Kopi</button>
            <button class="cat-tab">Non-Kopi</button>
            <button class="cat-tab">Makanan</button>
        </div>
    </div>
    <div class="menu-grid-large">
        @php $menus = [ /* sama seperti di pos */ ]; @endphp
        @foreach($menus as $menu)
        <div class="menu-card-large">
            <div class="menu-img-large" style="background-image: url('{{ asset($menu['img']) }}');"></div>
            <div class="menu-detail">
                <div class="menu-title">{{ $menu['name'] }}</div>
                <div class="menu-cat">{{ $menu['cat'] }}</div>
                <div class="menu-price-large">Rp {{ number_format($menu['price'],0,',','.') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection