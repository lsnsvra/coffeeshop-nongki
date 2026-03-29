@extends('layouts.app')

@section('title', 'Menu Kopi — NONGKI')

@section('content')

{{-- Hero --}}
<div style="background:linear-gradient(135deg,var(--brown-800) 0%,var(--brown-600) 100%);border-radius:var(--radius-xl);padding:2.5rem 2rem;margin-bottom:2rem;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-20px;top:-20px;width:180px;height:180px;background:rgba(255,255,255,.05);border-radius:50%;"></div>
    <div style="position:absolute;right:60px;bottom:-40px;width:120px;height:120px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
    <div style="position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.1);border-radius:50px;padding:.3rem .9rem;margin-bottom:1rem;">
            <i class="bi bi-cup-hot-fill" style="color:var(--brown-200);font-size:.8rem;"></i>
            <span style="color:var(--brown-100);font-size:.78rem;font-weight:600;letter-spacing:.05em;">MENU HARI INI</span>
        </div>
        <h1 style="font-family:'Playfair Display',serif;color:#fff;font-size:2rem;font-weight:800;margin-bottom:.5rem;">Kopi Nongki ☕</h1>
        <p style="color:rgba(255,255,255,.65);font-size:.95rem;margin:0;">Temukan kopi favoritmu dan nikmati momen nongkrong</p>
    </div>
</div>

{{-- Filter & Search --}}
<div style="display:flex;gap:1rem;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;">

    {{-- Search --}}
    <div style="position:relative;flex:1;min-width:220px;">
        <i class="bi bi-search" style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--text-soft);"></i>
        <input type="text" placeholder="Cari kopi..." class="form-control-custom" style="padding-left:2.5rem;">
    </div>

    {{-- Category Pills --}}
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        @php
        $categories = ['Semua', 'Espresso', 'Latte', 'Matcha', 'Non-Coffee'];
        $active = 'Semua';
        @endphp
        @foreach($categories as $cat)
        <button style="
            padding:.4rem 1rem;
            border-radius:50px;
            border:1.5px solid {{ $cat === $active ? 'var(--brown-600)' : 'rgba(28,15,8,.12)' }};
            background:{{ $cat === $active ? 'var(--brown-700)' : '#fff' }};
            color:{{ $cat === $active ? '#fff' : 'var(--text-mid)' }};
            font-size:.8rem;
            font-weight:600;
            cursor:pointer;
            font-family:'DM Sans',sans-serif;
            transition:all .18s;
        ">{{ $cat }}</button>
        @endforeach
    </div>

</div>

{{-- Product Grid --}}
@php
$products = [
    ['Cappuccino',    22000, 'Espresso dengan steamed milk dan foam yang lembut.', 'Latte',    40],
    ['Latte',         24000, 'Espresso dengan susu hangat yang creamy dan nikmat.', 'Latte',   35],
    ['Espresso',      15000, 'Kopi espresso murni yang kuat dan pekat.',            'Espresso', 50],
    ['Americano',     18000, 'Espresso dengan tambahan air panas yang menyegarkan.','Espresso', 45],
    ['Matcha Latte',  28000, 'Matcha premium dengan susu segar yang creamy.',       'Matcha',  30],
    ['Flat White',    25000, 'Espresso dengan microfoam susu yang halus.',          'Latte',   35],
    ['Red Velvet',    27000, 'Minuman red velvet yang manis dan creamy.',           'Non-Coffee',20],
    ['Coklat Panas',  20000, 'Coklat panas yang kaya dan lembut.',                 'Non-Coffee',25],
];
@endphp

<div class="row g-3">
    @foreach($products as $i => $p)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100" style="transition:transform .2s,box-shadow .2s;cursor:pointer;"
             onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-lg)'"
             onmouseleave="this.style.transform='';this.style.boxShadow=''">

            {{-- Product Image Placeholder --}}
            <div style="height:160px;background:linear-gradient(135deg,var(--brown-{{ $i % 2 === 0 ? '700' : '600' }}) 0%,var(--brown-{{ $i % 2 === 0 ? '500' : '400' }}) 100%);display:flex;align-items:center;justify-content:center;position:relative;">
                <i class="bi bi-cup-hot-fill" style="font-size:4rem;color:rgba(255,255,255,.3);"></i>
                {{-- Category Badge --}}
                <span style="position:absolute;top:.7rem;left:.7rem;background:rgba(0,0,0,.3);color:rgba(255,255,255,.9);font-size:.65rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;backdrop-filter:blur(4px);">
                    {{ $p[3] }}
                </span>
                {{-- Stock --}}
                @if($p[4] < 10)
                <span style="position:absolute;top:.7rem;right:.7rem;background:#C0392B;color:#fff;font-size:.65rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;">
                    Hampir habis!
                </span>
                @endif
            </div>

            <div class="card-body" style="padding:1rem;">
                <h6 style="font-family:'DM Sans',sans-serif;font-weight:700;font-size:.9rem;margin-bottom:.3rem;color:var(--text-dark);">{{ $p[0] }}</h6>
                <p style="font-size:.75rem;color:var(--text-soft);margin-bottom:.75rem;line-height:1.5;">{{ Str::limit($p[1+1], 55) }}</p>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;">
                    <span style="font-family:'Playfair Display',serif;font-weight:700;color:var(--brown-700);font-size:1.05rem;">
                        Rp {{ number_format($p[1], 0, ',', '.') }}
                    </span>
                    <span style="font-size:.72rem;color:var(--text-soft);">Stok: {{ $p[4] }}</span>
                </div>
                <div style="display:flex;gap:.5rem;">
                    <button class="btn-outline-custom" style="flex:1;padding:.4rem;font-size:.78rem;justify-content:center;">
                        <i class="bi bi-eye"></i> Detail
                    </button>
                    <button class="btn-primary-custom" style="padding:.4rem .7rem;font-size:.85rem;">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination dummy --}}
<div style="display:flex;justify-content:center;align-items:center;gap:.4rem;margin-top:2rem;">
    <button class="btn-ghost" disabled><i class="bi bi-chevron-left"></i></button>
    @foreach([1,2,3] as $p)
    <button style="
        width:36px;height:36px;
        border-radius:var(--radius-sm);
        border:1.5px solid {{ $p === 1 ? 'var(--brown-600)' : 'rgba(28,15,8,.12)' }};
        background:{{ $p === 1 ? 'var(--brown-700)' : '#fff' }};
        color:{{ $p === 1 ? '#fff' : 'var(--text-mid)' }};
        font-size:.85rem;font-weight:700;cursor:pointer;
        font-family:'DM Sans',sans-serif;
    ">{{ $p }}</button>
    @endforeach
    <button class="btn-ghost"><i class="bi bi-chevron-right"></i></button>
</div>

@endsection
