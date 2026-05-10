@extends('layouts.kasir')

@section('title', 'Pesanan Masuk — NONGKI Kasir')

@push('styles')
<style>
    /* ========== ANIMASI ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ========== GRID & CARD LAYOUT ========== */
    .order-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .order-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .order-card:hover {
        transform: translateY(-5px);
        border-color: rgba(201, 168, 76, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25), 0 0 15px rgba(201,168,76,0.05);
    }

    /* ========== CARD HEADER ========== */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px dashed rgba(255,255,255,0.05);
        padding-bottom: 1.2rem;
        margin-bottom: 1.2rem;
    }
    .order-id {
        color: var(--gold);
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .table-badge {
        display: inline-block;
        background: rgba(255,255,255,0.05);
        color: var(--cream);
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .time-badge {
        color: #e05252; /* Merah agar dapur tahu sudah berapa lama */
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(224, 82, 82, 0.1);
        padding: 6px 12px;
        border-radius: 8px;
    }

    /* ========== ORDER ITEMS (BODY) ========== */
    .order-body { flex-grow: 1; }
    
    .order-items {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .order-items li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--cream-dim);
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.02);
        font-size: 1.05rem;
    }
    .order-items li:last-child { border-bottom: none; }
    
    .item-qty {
        color: var(--gold);
        font-weight: 800;
        background: rgba(201, 168, 76, 0.1);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .order-note {
        background: rgba(255,255,255,0.02);
        border-left: 3px solid var(--gold);
        padding: 10px 12px;
        margin-top: 15px;
        border-radius: 0 8px 8px 0;
        font-size: 0.85rem;
        color: var(--text-muted-c);
        font-style: italic;
    }

    /* ========== CARD FOOTER (AKSI DI KIRI) ========== */
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 2px dashed rgba(255,255,255,0.05);
        padding-top: 1.2rem;
        margin-top: 1.5rem;
    }

    /* AKSI KIRI */
    .action-left {
        display: flex;
        gap: 10px;
    }
    .btn-status-done {
        background: var(--gold);
        color: var(--dark);
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-status-done:hover {
        background: var(--gold-light);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(201,168,76,0.3);
    }
    
    .btn-print {
        background: transparent;
        color: var(--gold);
        border: 1px solid rgba(201, 168, 76, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-print:hover { background: rgba(201, 168, 76, 0.1); border-color: var(--gold); }

    .total-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--cream);
    }
</style>
@endpush

@section('content')
<div class="page-header fade-in-up" style="margin-bottom: 2rem;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Kitchen Display</h1>
    <p style="color: var(--text-muted-c);">Monitor pesanan masuk dan selesaikan orderan pelanggan.</p>
</div>

<div class="order-grid">
    @php
        // Data Dummy untuk simulasi UI
        $orders = [
            ['id' => '0245', 'meja' => '04', 'waktu' => 5, 'total' => '85.000', 'items' => ['Americano' => 2, 'Croissant' => 1], 'note' => 'Americano jangan terlalu manis.'],
            ['id' => '0246', 'meja' => '12', 'waktu' => 8, 'total' => '115.000', 'items' => ['Matcha Latte' => 1, 'Chicken Katsu Curry' => 1, 'French Fries' => 1], 'note' => 'Katsu pedas, pisah sausnya.'],
            ['id' => '0247', 'meja' => 'Takeaway', 'waktu' => 12, '