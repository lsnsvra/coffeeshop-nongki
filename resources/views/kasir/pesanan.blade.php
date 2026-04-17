@extends('layouts.kasir')

@section('title', 'Pesanan Masuk — NONGKI Kasir')

@section('content')
<div class="pos-left">
    <h3 style="font-family: 'Cormorant Garamond', serif;">Pesanan Masuk (Dapur)</h3>
    <div style="margin-top:20px;">
        <div style="background:var(--dark-3); border:1px solid var(--border); border-radius:12px; padding:16px; margin-bottom:12px;">
            <div style="display:flex; justify-content:space-between;"><span>#NGK-0245</span><span style="color:var(--gold);">Rp 85.000</span></div>
            <div style="margin-top:8px;">Americano (2x), Croissant</div>
            <button style="margin-top:12px; background:var(--gold); color:#000; border:none; padding:8px 16px; border-radius:6px;">Selesai</button>
        </div>
    </div>
</div>
<div class="pos-right">
    <h4>Detail Pesanan</h4>
    <p style="color:var(--text-muted);">Klik pesanan untuk melihat detail</p>
</div>
@endsection