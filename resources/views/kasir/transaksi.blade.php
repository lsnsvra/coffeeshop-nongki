@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi — NONGKI Kasir')

@push('styles')
<style>
    /* ========== ANIMASI ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ========== TABLE WRAPPER PREMIUM ========== */
    .table-wrapper {
        background: var(--dark-2);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--border);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow-x: auto;
    }
    
    .nongki-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        min-width: 800px;
        margin-top: -12px;
    }
    
    .nongki-table th {
        text-align: left;
        padding: 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted-c);
        letter-spacing: 1.5px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    /* ========== ROW STYLING (SPASI LEGA) ========== */
    .nongki-table td {
        padding: 1.2rem 1rem;
        background: rgba(255, 255, 255, 0.01);
        border-top: 1px solid rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.02);
        color: var(--cream-dim);
        vertical-align: middle;
        transition: 0.3s ease;
    }
    
    .nongki-table td:first-child { border-left: 1px solid rgba(255,255,255,0.02); border-radius: 12px 0 0 12px; }
    .nongki-table td:last-child { border-right: 1px solid rgba(255,255,255,0.02); border-radius: 0 12px 12px 0; }

    .nongki-table tbody tr:hover td { background: rgba(255,255,255,0.03); color: var(--cream); }
    .nongki-table tbody tr:hover { transform: translateY(-2px); }

    /* ========== AKSI DI KIRI MUTLAK ========== */
    .action-col { width: 90px; text-align: center; }
    .action-btns { display: flex; gap: 8px; justify-content: center; }
    
    .btn-print-struk {
        width: 38px; height: 38px; border-radius: 10px; display: flex;
        align-items: center; justify-content: center; font-size: 1rem;
        cursor: pointer; transition: 0.3s; 
        background: rgba(201,168,76,0.1); color: var(--gold); 
        border: 1px solid rgba(201,168,76,0.2);
    }
    .btn-print-struk:hover { background: var(--gold); color: var(--dark); transform: scale(1.1); }

    /* ========== BADGES & TYPOGRAPHY ========== */
    .trx-id { font-weight: 800; color: var(--gold); font-size: 1.05rem; letter-spacing: 1px; }
    .trx-total { font-weight: 700; color: var(--cream); font-size: 1.1rem; }
    
    .badge-status {
        padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; 
        font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .status-selesai { background: rgba(93, 202, 165, 0.1); color: #5DCAA5; border: 1px solid rgba(93, 202, 165, 0.2); }
    .status-diproses { background: rgba(255, 152, 0, 0.1); color: #FF9800; border: 1px solid rgba(255, 152, 0, 0.2); }
    
    .badge-method { background: var(--dark-4); color: var(--text-muted-c); padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="page-header fade-in-up" style="margin-bottom: 2rem;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Riwayat Transaksi</h1>
    <p style="color: var(--text-muted-c);">Monitor seluruh aktivitas pembayaran pelanggan hari ini.</p>
</div>

<div class="table-wrapper fade-in-up">
    <table class="nongki-table">
        <thead>
            <tr>
                <th class="action-col">Aksi</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Total Tagihan</th>
                <th>Metode Bayar</th>
                <th>Waktu Order</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Dummy Data Tambahan Biar Tabel Lebih Hidup
                $transactions = [
                    ['#TRX-005', 'Dian P.', 65000, 'QRIS', '11:05 WIB', 'selesai'],
                    ['#TRX-004', 'Andi R.', 45000, 'GoPay', '10:50 WIB', 'selesai'],
                    ['#TRX-003', 'Guest', 28000, 'Tunai', '10:42 WIB', 'selesai'],
                    ['#TRX-002', 'Budi S.', 120000, 'Tunai', '09:15 WIB', 'diproses'],
                    ['#TRX-001', 'Sarah A.', 85000, 'QRIS', '08:30 WIB', 'selesai']
                ];
            @endphp

            @foreach($transactions as $trx)
            <tr>
                {{-- KOLOM AKSI (CETAK STRUK) MUTLAK DI KIRI --}}
                <td class="action-col">
                    <div class="action-btns">
                        <button class="btn-print-struk" title="Cetak Ulang Struk" onclick="alert('Mencetak struk {{ $trx[0] }}')">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                </td>
                
                {{-- DETAIL TRANSAKSI --}}
                <td><span class="trx-id">{{ $trx[0] }}</span></td>
                <td style="font-weight: 600;">{{ $trx[1] }}</td>
                <td class="trx-total">Rp {{ number_format($trx[2], 0, ',', '.') }}</td>
                <td><span class="badge-method"><i class="fa-solid fa-wallet" style="margin-right: 4px;"></i> {{ $trx[3] }}</span></td>
                <td style="color: var(--text-muted-c);"><i class="fa-regular fa-clock" style="margin-right: 4px;"></i> {{ $trx[4] }}</td>
                <td>
                    <span class="badge-status status-{{ strtolower($trx[5]) }}">
                        {{ ucfirst($trx[5]) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection