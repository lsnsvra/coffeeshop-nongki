@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@push('styles')
<style>

/* ==========================================
   LAPORAN PENJUALAN LIGHT MODE PREMIUM
========================================== */

[data-theme="light"] .page-header h1{
    color:#C9A84C !important;
}

[data-theme="light"] .page-header p{
    color:#6B7280 !important;
}

/* FILTER BAR */

[data-theme="light"] .filter-bar{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.05);
}

[data-theme="light"] .filter-bar-label{
    color:#8A7C6B !important;
}

[data-theme="light"] .form-nongki{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    color:#2F241B !important;
}

[data-theme="light"] .form-nongki:focus{
    border-color:#D4A437 !important;
    box-shadow:0 0 0 3px rgba(212,164,55,.12);
}

/* BUTTON */

[data-theme="light"] .btn-outline-nongki{
    background:#FFFFFF !important;
    border:1px solid #D4A437 !important;
    color:#D4A437 !important;
}

[data-theme="light"] .btn-outline-nongki:hover{
    background:#FFF7E8 !important;
}

[data-theme="light"] .btn-nongki{
    background:linear-gradient(
        135deg,
        #D4A437,
        #E6C147
    ) !important;

    color:#FFFFFF !important;
}

/* CARD */

[data-theme="light"] .report-card{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.05);
}

[data-theme="light"] .report-card:hover{
    border-color:#D4A437 !important;
}

[data-theme="light"] .report-card .icon{
    background:rgba(212,164,55,.12) !important;
    color:#D4A437 !important;
}

[data-theme="light"] .report-card .label{
    color:#8A7C6B !important;
}

[data-theme="light"] .report-card .value{
    color:#2F241B !important;
}

/* TABLE */

[data-theme="light"] .table-container{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.05);
}

[data-theme="light"] .table-header{
    border-bottom:1px solid #ECE7DD !important;
}

[data-theme="light"] .table-header h4{
    color:#2F241B !important;
}

[data-theme="light"] .table-badge{
    background:#FFF7E8 !important;
    border:1px solid #F2DE9A !important;
    color:#D4A437 !important;
}

[data-theme="light"] .nongki-table thead tr{
    background:#FAF8F4 !important;
}

[data-theme="light"] .nongki-table th{
    color:#8A7C6B !important;
    border-bottom:1px solid #ECE7DD !important;
}

[data-theme="light"] .nongki-table td{
    color:#4B5563 !important;
    border-bottom:1px solid #F2ECE2 !important;
}

[data-theme="light"] .nongki-table tbody tr:hover{
    background:#FAF8F4 !important;
}

[data-theme="light"] .order-id{
    color:#D4A437 !important;
}

[data-theme="light"] .amount{
    color:#2F241B !important;
}

/* EMPTY STATE */

[data-theme="light"] .empty-state{
    color:#8A7C6B !important;
}

    /* ========== CSS VARIABLES ========== */
    :root {
        --gold: #C9A84C;
        --gold-light: #E8C96A;
        --gold-dim: rgba(201, 168, 76, 0.35);
        --dark-bg: #0F0C07;
        --card-bg: rgba(26, 21, 9, 0.65);
        --border-gold: rgba(201, 168, 76, 0.15);
        --text-primary: rgba(245, 237, 216, 0.92);
        --text-muted: rgba(245, 237, 216, 0.4);
    }

    /* ========== PAGE HEADER ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 28px;
    }
    .page-header h1 {
        color: var(--gold);
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        margin: 0;
    }
    .page-header p {
        color: var(--text-muted);
        margin: 6px 0 0;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* ========== FILTER BAR ========== */
    .filter-bar {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-gold);
        border-radius: 20px;
        padding: 18px 28px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .filter-bar-label {
        color: var(--text-muted);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        white-space: nowrap;
        margin-right: 4px;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
    .filter-separator {
        color: var(--gold-dim);
        font-size: 0.9rem;
    }
    .form-nongki {
        background: rgba(201, 168, 76, 0.06);
        border: 1px solid var(--border-gold);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        min-width: 150px;
    }
    .form-nongki:focus {
        border-color: var(--gold-dim);
        background: rgba(201, 168, 76, 0.1);
    }
    .form-nongki::-webkit-calendar-picker-indicator {
        filter: invert(0.7) sepia(1) saturate(3) hue-rotate(5deg);
        cursor: pointer;
        opacity: 0.7;
    }
    .filter-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    /* ========== BUTTONS ========== */
    .btn-nongki {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: var(--dark-bg);
        border: none;
        padding: 11px 22px;
        border-radius: 13px;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.5px;
        cursor: pointer;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.2s, transform 0.15s;
    }
    .btn-nongki:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-nongki:active { transform: translateY(0); }

    .btn-outline-nongki {
        background: transparent;
        color: var(--gold);
        border: 1px solid var(--gold-dim);
        padding: 10px 20px;
        border-radius: 13px;
        font-weight: 600;
        font-size: 0.82rem;
        letter-spacing: 0.5px;
        cursor: pointer;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s, border-color 0.2s, transform 0.15s;
    }
    .btn-outline-nongki:hover {
        background: rgba(201, 168, 76, 0.08);
        border-color: var(--gold);
        transform: translateY(-1px);
    }
    .btn-outline-nongki:active { transform: translateY(0); }

    /* ========== STAT CARDS ========== */
    .report-card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }
    @media (max-width: 900px) {
        .report-card-grid { grid-template-columns: 1fr; }
    }
    .report-card {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-gold);
        padding: 26px 28px;
        border-radius: 22px;
        transition: border-color 0.2s, transform 0.2s;
        position: relative;
        overflow: hidden;
    }
    .report-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
    }
    .report-card:hover {
        border-color: var(--gold-dim);
        transform: translateY(-2px);
    }
    .report-card .icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: rgba(201, 168, 76, 0.1);
        border: 1px solid var(--border-gold);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold);
        font-size: 0.9rem;
        margin-bottom: 16px;
    }
    .report-card .label {
        color: var(--text-muted);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 8px;
    }
    .report-card .value {
        color: var(--gold-light);
        font-size: 1.9rem;
        font-weight: 800;
        line-height: 1.1;
    }
    .report-card .value.small {
        font-size: 1.35rem;
    }

    /* ========== TABLE SECTION ========== */
    .table-container {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-gold);
        border-radius: 24px;
        overflow: hidden;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 30px 20px;
        border-bottom: 1px solid var(--border-gold);
    }
    .table-header h4 {
        color: var(--gold-light);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 600;
        margin: 0;
    }
    .table-badge {
        background: rgba(201, 168, 76, 0.1);
        border: 1px solid var(--border-gold);
        color: var(--gold);
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        padding: 5px 12px;
        border-radius: 8px;
        text-transform: uppercase;
    }
    .nongki-table { width: 100%; border-collapse: collapse; }
    .nongki-table thead tr {
        background: rgba(201, 168, 76, 0.04);
    }
    .nongki-table th {
        text-align: left;
        padding: 14px 30px;
        color: var(--gold);
        border-bottom: 1px solid var(--border-gold);
        font-size: 0.68rem;
        letter-spacing: 2.5px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .nongki-table td {
        padding: 16px 30px;
        color: var(--text-primary);
        border-bottom: 1px solid rgba(255,255,255,0.025);
        font-size: 0.875rem;
    }
    .nongki-table tbody tr:last-child td { border-bottom: none; }
    .nongki-table tbody tr {
        transition: background 0.15s;
    }
    .nongki-table tbody tr:hover {
        background: rgba(201, 168, 76, 0.04);
    }
    .order-id {
        font-family: 'Courier New', monospace;
        color: var(--gold);
        font-size: 0.8rem;
        font-weight: 700;
    }
    .amount {
        font-weight: 700;
        color: var(--gold-light);
    }
    .empty-state {
        text-align: center;
        padding: 50px 30px;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

   /* ========== PRINT STYLES (FULL WIDTH OPTIMIZATION) ========== */
    .print-header { display: none; }
    .print-footer { display: none; }

    @media print {
        @page { 
            size: A4; 
            margin: 15mm 15mm 15mm 15mm; /* Memperkecil margin kertas agar area cetak lebih luas */
        }
        
        /* 1. MEMAKSA KONTEN UTAMA MENJADI FULL WIDTH */
        body, .fade-in-up, main, #wrapper, #content, .container, .container-fluid { 
            background: #FFFFFF !important; 
            color: #000000 !important; 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            transform: none !important;
        }

        /* Sembunyikan elemen dashboard yang mengganggu */
        .no-print, .filter-bar, .page-header, .sidebar, .navbar, .btn, .d-none, .table-header {
            display: none !important;
        }

        /* 2. KOP SURAT FORMAL */
        .print-header { 
            display: block !important; 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 3px solid #000000; 
            padding-bottom: 12px; 
            width: 100% !important;
        }
        .print-header h1 { 
            font-family: 'Times New Roman', serif !important;
            font-size: 26pt; 
            font-weight: bold;
            color: #000000 !important; 
            margin: 0; 
            letter-spacing: 2px;
        }
        .print-header p { 
            font-size: 10pt; 
            color: #333333 !important;
            margin: 3px 0; 
        }
        .print-header .report-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            letter-spacing: 1px;
        }

        /* 3. GRID STAT CARDS (Melebar Proporsional) */
        .report-card-grid { 
            display: flex !important; 
            justify-content: space-between; 
            gap: 20px;
            margin: 25px 0; 
            width: 100% !important;
            page-break-inside: avoid;
        }
        .report-card { 
            flex: 1;
            border: 1px solid #CCCCCC !important; 
            border-radius: 8px !important;
            padding: 15px !important; 
            text-align: center; 
            background: #FAFAFA !important; 
        }
        .report-card::before, .report-card .icon { display: none !important; }
        .report-card .label { 
            font-size: 9pt !important; 
            text-transform: uppercase; 
            color: #555555 !important; 
            font-weight: 600; 
            margin-bottom: 6px;
        }
        .report-card .value { 
            font-size: 16pt !important; 
            font-weight: bold; 
            color: #000000 !important; 
        }
        .report-card .value.small { font-size: 13pt !important; }

        /* 4. TABEL FULL WIDTH */
        .table-container, .table-responsive { 
            border: none !important; 
            background: transparent !important;
            box-shadow: none !important;
            margin-top: 20px; 
            width: 100% !important;
        }
        .nongki-table { 
            width: 100% !important; 
            border-collapse: collapse !important; 
        }
        .nongki-table thead tr {
            background: #EAEAEA !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .nongki-table th { 
            color: #000000 !important; 
            border: 1px solid #111111 !important; 
            padding: 12px 10px !important; 
            font-size: 10pt !important; 
            font-weight: bold !important;
            text-transform: uppercase;
        }
        .nongki-table td { 
            border: 1px solid #111111 !important; 
            padding: 10px !important; 
            color: #000000 !important; 
            font-size: 10pt !important;
        }
        
        .order-id { font-family: monospace; color: #000000 !important; font-size: 9.5pt; }
        .amount { color: #000000 !important; font-weight: bold; }
        
        .nongki-table td span {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            color: #000000 !important;
            font-weight: bold !important;
        }

        /* 5. TANDA TANGAN */
        .print-footer {
            display: block !important; 
            margin-top: 50px; 
            text-align: right; 
            font-size: 11pt;
            width: 100% !important;
            page-break-inside: avoid;
        }
        .print-footer p { margin: 2px 0; }
    }
</style>
@endpush

@section('content')
<div class="fade-in-up">

    {{-- ========== PRINT HEADER ========== --}}
    <div class="print-header">
        <h1>NONGKI COFFEE</h1>
        <p>Industrial Estate Area, Bekasi Regency, West Java</p>
        <p class="report-title">Laporan Penjualan Produk</p>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->isoFormat('D MMMM Y') }} — {{ \Carbon\Carbon::parse($end)->isoFormat('D MMMM Y') }}</p>
    </div>

    {{-- ========== PAGE HEADER ========== --}}
    <div class="page-header no-print">
        <div>
            <h1>Laporan Penjualan</h1>
            <p>Data manajemen eksklusif NONGKI</p>
        </div>
    </div>

    
   {{-- ========== FILTER BAR ========== --}}
    <div class="filter-bar no-print">
        <span class="filter-bar-label"><i class="fa-solid fa-calendar-days" style="margin-right:6px;"></i>Periode</span>
        
        {{-- Pastikan method adalah GET dan mengarah ke URL laporan --}}
        <form action="{{ url('admin/laporan') }}" method="GET" class="filter-group">
            <input type="date" name="start" value="{{ $start }}" class="form-nongki">
            <span class="filter-separator">—</span>
            <input type="date" name="end" value="{{ $end }}" class="form-nongki">
            
            <div class="filter-actions">
                {{-- Tombol ini HARUS memiliki type="submit" agar form mengirimkan tanggal yang kamu pilih --}}
                <button type="submit" class="btn-outline-nongki">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter Data
                </button>
                <button type="button" onclick="window.print()" class="btn-nongki">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </button>
            </div>
        </form>
    </div>

    {{-- ========== STAT CARDS ========== --}}
    <div class="report-card-grid">
        <div class="report-card">
            <div class="icon"><i class="fa-solid fa-wallet"></i></div>
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="report-card">
            <div class="icon"><i class="fa-solid fa-receipt"></i></div>
            <div class="label">Volume Pesanan</div>
            <div class="value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="report-card">
            <div class="icon"><i class="fa-solid fa-star"></i></div>
            <div class="label">Produk Terlaris</div>
            <div class="value small">{{ $terlaris->NamaKopi ?? '—' }}</div>
        </div>
    </div>

    {{-- ========== TRANSACTION TABLE ========== --}}
    <div class="table-container">
        <div class="table-header no-print">
            <h4>Log Transaksi Terakhir</h4>
            <span class="table-badge">{{ count($transaksiTerakhir) }} Entri</span>
        </div>
        <div class="table-responsive">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Detail Produk</th>
                        <th>Status</th>
                        <th style="text-align: right;">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerakhir as $t)
                    <tr>
                        {{-- ID Order --}}
                        <td><span class="order-id">#{{ str_pad($t->OrderID, 5, '0', STR_PAD_LEFT) }}</span></td>
                        
                        {{-- Tanggal (SINKRON MENGGUNAKAN TanggalOrder) --}}
                        <td>
                            @if(!empty($t->TanggalOrder))
                                {{ \Carbon\Carbon::parse($t->TanggalOrder)->format('d/m/y H:i') }} WIB
                            @else
                                --
                            @endif
                        </td>
                        
                        {{-- Pembeli --}}
                        <td>{{ $t->nama_pembeli ?? 'Tamu / Kasir' }}</td>
                        
                        {{-- Detail Produk --}}
                        <td>
                            @php
                                $details = DB::table('order_details')
                                    ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
                                    ->where('order_details.OrderID', $t->OrderID)
                                    ->get();
                            @endphp
                            @foreach($details as $item)
                                <div style="font-size: 0.75rem;">• {{ $item->NamaKopi ?? $item->NamaProduct }} ({{ $item->Qty }}x)</div>
                            @endforeach
                        </td>
                        
                        {{-- Status (OTOMATIS MENGUBAH SETTLEMENT/PAID MENJADI LUNAS DENGAN BADGE HIJAU) --}}
                        <td>
                            @php
                                $statusRaw = strtolower($t->StatusOrder ?? '');
                                $isLunas = in_array($statusRaw, ['paid', 'settlement', 'success', 'lunas']);
                            @endphp

                            @if($isLunas)
                                <span style="color: #27AE60; background: rgba(39, 174, 96, 0.1); padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 0.75rem; border: 1px solid rgba(39, 174, 96, 0.2); display: inline-block;">
                                    Lunas
                                </span>
                            @elseif($statusRaw == 'pending')
                                <span style="color: #E2B93B; background: rgba(226, 185, 59, 0.1); padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 0.75rem; border: 1px solid rgba(226, 185, 59, 0.2); display: inline-block;">
                                    Pending
                                </span>
                            @else
                                <span style="color: #E2B93B; background: rgba(226, 185, 59, 0.1); padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 0.75rem; border: 1px solid rgba(226, 185, 59, 0.2); display: inline-block;">
                                    {{ ucfirst($t->StatusOrder) }}
                                </span>
                            @endif
                        </td>
                        
                        {{-- Total Harga --}}
                        <td style="text-align: right;"><span class="amount">Rp {{ number_format($t->TotalHarga, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Tidak ada data transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========== PRINT FOOTER ========== --}}
    <div class="print-footer">
        <p>Bekasi, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px; font-weight: bold; text-decoration: underline;">Administrator NONGKI</p>
        <p>ID: #ADM-{{ Auth::user()->id }}</p>
    </div>

</div>
@endsection