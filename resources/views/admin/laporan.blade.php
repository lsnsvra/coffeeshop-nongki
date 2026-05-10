@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@push('styles')
<style>
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

    /* ========== PRINT STYLES ========== */
    .print-header { display: none; }
    .print-footer { display: none; }

    @media print {
        @page { size: A4; margin: 20mm; }

        .no-print,
        .sidebar,
        .btn-logout,
        .sidebar-bottom,
        .sidebar-user { display: none !important; }

        body { background: white !important; color: black !important; font-family: 'Times New Roman', serif; }
        .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; position: static !important; }

        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
        }
        .print-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 28pt; margin: 0; color: #000; }
        .print-header p { margin: 4px 0; font-size: 10pt; color: #333; }
        .print-header .report-title { font-weight: bold; text-transform: uppercase; margin-top: 10px; font-size: 14pt; }

        .report-card-grid {
            grid-template-columns: 1fr 1fr 1fr !important;
            border: 1px solid #000;
            border-radius: 0;
            gap: 0;
        }
        .report-card {
            border: none !important;
            border-right: 1px solid #000 !important;
            background: transparent !important;
            padding: 14px 16px !important;
            border-radius: 0 !important;
            transform: none !important;
        }
        .report-card::before { display: none; }
        .report-card:last-child { border-right: none !important; }
        .report-card .icon { display: none; }
        .report-card .value { color: black !important; font-size: 15pt !important; margin: 0; }
        .report-card .value.small { font-size: 13pt !important; }
        .report-card .label { color: #555 !important; font-size: 9pt !important; margin-bottom: 4px; }

        .table-container { background: transparent !important; border: none !important; border-radius: 0 !important; margin-top: 20px; }
        .table-header { padding: 0 0 10px 0 !important; border-bottom: 2px solid #000 !important; }
        .table-header h4 { color: #000 !important; font-size: 14pt !important; }
        .table-badge { display: none; }

        .nongki-table { border: 1px solid #000 !important; }
        .nongki-table thead tr { background: #eee !important; }
        .nongki-table th { background: #eee !important; color: black !important; border: 1px solid #000 !important; font-size: 9pt !important; padding: 8px 12px !important; }
        .nongki-table td { color: black !important; border: 1px solid #000 !important; padding: 8px 12px !important; font-size: 10pt !important; }
        .order-id { color: #000 !important; }
        .amount { color: #000 !important; font-weight: bold; }

        .print-footer {
            display: block !important;
            margin-top: 50px;
            float: right;
            width: 200px;
            text-align: center;
        }
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

        <form action="" method="GET" class="filter-group">
            <input type="date" name="start" value="{{ $start }}" class="form-nongki">
            <span class="filter-separator">—</span>
            <input type="date" name="end" value="{{ $end }}" class="form-nongki">

            <div class="filter-actions">
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
                        <th>Tanggal &amp; Waktu</th>
                        <th style="text-align: right;">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerakhir as $t)
                    <tr>
                        <td><span class="order-id">#{{ str_pad($t->OrderID, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($t->CreatedDate)->format('d/m/Y H:i') }}</td>
                        <td style="text-align: right;"><span class="amount">Rp {{ number_format($t->TotalHarga ?? $t->total ?? 0, 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="fa-regular fa-folder-open" style="font-size: 1.8rem; margin-bottom: 10px; color: var(--gold-dim); display:block;"></i>
                                Tidak ada data untuk periode ini.
                            </div>
                        </td>
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