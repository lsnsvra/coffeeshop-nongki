@extends('layouts.admin')

@section('title', 'Laporan Penjualan — NONGKI')

@push('styles')
<style>
    /* ========== PRINT OPTIMIZATION (PDF) ========== */
    @media print {
        .app-sidebar, .app-header, .filter-section, .no-print { display: none !important; }
        .app-main { margin: 0 !important; padding: 20px !important; width: 100% !important; }
        .report-container { background: white !important; color: black !important; padding: 0 !important; }
        .stat-card-report { border: 1px solid #eee !important; background: white !important; }
        .table-wrapper { border: 1px solid #eee !important; }
        .text-gold { color: #856404 !important; }
        .bar { background: #C9A84C !important; -webkit-print-color-adjust: exact; }
    }

    /* ========== THEME ADJUSTMENT ========== */
    .filter-section {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 16px; padding: 1.2rem 1.5rem; margin-bottom: 2rem;
        display: flex; align-items: center; justify-content: space-between; 
    }
    
    /* Tombol PDF di Kiri */
    .btn-pdf-left {
        background: transparent; border: 1px solid var(--gold); 
        color: var(--gold); padding: 10px 20px; border-radius: 10px;
        font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;
        transition: 0.3s;
    }
    .btn-pdf-left:hover { background: var(--gold); color: var(--dark); }

    /* Filter Kalender di Kanan */
    .filter-controls-right { display: flex; align-items: center; gap: 1rem; }
    
    .date-input-group { 
        display: flex; align-items: center; gap: 12px; 
        background: var(--dark-3); padding: 8px 16px; 
        border-radius: 12px; border: 1px solid var(--border); 
    }
    
    .date-input-group input { 
        background: transparent; border: none; color: var(--cream); 
        font-size: 0.9rem; outline: none; color-scheme: dark;
    }

    .btn-apply {
        background: var(--gold); color: var(--dark); 
        border: none; padding: 10px 24px; border-radius: 10px;
        font-weight: 700; cursor: pointer; transition: 0.3s;
    }
    .btn-apply:hover { background: var(--gold-light); transform: translateY(-2px); }

    /* ========== STATS & TABLE ========== */
    .report-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem; }
    .stat-card-report { background: var(--dark-2); border: 1px solid var(--border); padding: 1.5rem; border-radius: 16px; }
    .table-wrapper { background: var(--dark-2); border: 1px solid var(--border); border-radius: 20px; padding: 1.5rem; }
    
    /* Kolom Aksi Tabel (Kiri) */
    .action-col { width: 80px; text-align: center; }
    .btn-print-mini {
        background: var(--gold-dim); color: var(--gold); border: 1px solid var(--border);
        width: 34px; height: 34px; border-radius: 8px; cursor: pointer; transition: 0.3s;
    }
    .btn-print-mini:hover { background: var(--gold); color: var(--dark); }

    .bar-container { height: 180px; display: flex; align-items: flex-end; gap: 10px; padding-top: 20px; }
    .bar { flex: 1; border-radius: 4px 4px 0 0; background: linear-gradient(to top, var(--gold), var(--gold-light)); opacity: 0.8; }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div class="page-header no-print" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; color: var(--gold);">Laporan Penjualan</h1>
        <p style="color: var(--text-muted-c);">Monitor performa bisnis NONGKI Coffee dalam satu genggaman.</p>
    </div>

    {{-- FILTER SECTION --}}
    <div class="filter-section no-print">
        {{-- KIRI: Export PDF --}}
        <button onclick="window.print()" class="btn-pdf-left">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </button>

        {{-- KANAN: Kalender & Terapkan --}}
        <div class="filter-controls-right">
            <div class="date-input-group">
                <i class="fa-solid fa-calendar-day" style="color: var(--gold);"></i>
                <input type="date" value="2026-04-01">
                <span style="color: var(--border);">—</span>
                <input type="date" value="2026-04-16">
            </div>
            <button class="btn-apply">Terapkan</button>
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="report-stats">
        <div class="stat-card-report">
            <div style="font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1px;">Total Omzet</div>
            <div style="font-size: 1.6rem; font-weight: 700; color: var(--cream); margin: 5px 0;">Rp 4.200.000</div>
            <div style="color: #5DCAA5; font-size: 0.75rem; font-weight: 600;"><i class="fa-solid fa-arrow-up"></i> 12.5%</div>
        </div>
        <div class="stat-card-report">
            <div style="font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1px;">Transaksi</div>
            <div style="font-size: 1.6rem; font-weight: 700; color: var(--cream); margin: 5px 0;">87</div>
            <div style="color: #5DCAA5; font-size: 0.75rem; font-weight: 600;"><i class="fa-solid fa-check"></i> 5 Order Baru</div>
        </div>
        <div class="stat-card-report">
            <div style="font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1px;">Rata-rata</div>
            <div style="font-size: 1.6rem; font-weight: 700; color: var(--cream); margin: 5px 0;">Rp 48.275</div>
            <div style="color: var(--gold); font-size: 0.75rem; font-weight: 600;">Stabil</div>
        </div>
        <div class="stat-card-report">
            <div style="font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1px;">Terlaris</div>
            <div style="font-size: 1.2rem; font-weight: 700; color: var(--gold-light); margin: 5px 0;">Coffee Milk Aren</div>
            <div style="color: var(--cream-dim); font-size: 0.75rem;">124 Terjual</div>
        </div>
    </div>

    {{-- GRAFIK --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div class="table-wrapper">
            <h4 style="font-size: 1rem; color: var(--cream); margin-bottom: 1rem;">Tren Penjualan</h4>
            <div class="bar-container">
                @php $vals = [40, 65, 45, 85, 95, 75, 90]; @endphp
                @foreach($vals as $v)
                <div class="bar" style="height: {{ $v }}%;"></div>
                @endforeach
            </div>
        </div>
        <div class="table-wrapper">
            <h4 style="font-size: 1rem; color: var(--cream); margin-bottom: 1.5rem;">Kategori</h4>
            @php $cats = ['Kopi' => 70, 'Non-Kopi' => 20, 'Snack' => 10]; @endphp
            @foreach($cats as $n => $p)
            <div style="margin-bottom: 15px;">
                <div style="display:flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 5px;">
                    <span>{{ $n }}</span><span>{{ $p }}%</span>
                </div>
                <div style="height: 6px; background: var(--dark-4); border-radius: 10px;">
                    <div style="width: {{ $p }}%; height: 100%; background: var(--gold); border-radius: 10px;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- TABEL (AKSI TETAP DI KIRI) --}}
    <div class="table-wrapper">
        <h4 style="font-size: 1.1rem; color: var(--cream); margin-bottom: 1.5rem;">Detail Transaksi Terakhir</h4>
        <div style="overflow-x: auto;">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th class="action-col no-print">Aksi</th>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $rows = [
                            ['#NGK-0245', 'Sarah A.', 'Rp 85.000', 'Selesai', '10:30 WIB'],
                            ['#NGK-0244', 'Budi S.', 'Rp 120.000', 'Proses', '09:15 WIB'],
                            ['#NGK-0243', 'Dian P.', 'Rp 65.000', 'Selesai', '08:45 WIB']
                        ];
                    @endphp
                    @foreach($rows as $r)
                    <tr>
                        <td class="action-col no-print">
                            <button class="btn-print-mini" onclick="window.print()" title="Print Nota">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </td>
                        <td class="text-gold">{{ $r[0] }}</td>
                        <td style="color: var(--cream); font-weight: 500;">{{ $r[1] }}</td>
                        <td>{{ $r[2] }}</td>
                        <td><span class="status-badge {{ $r[3] == 'Selesai' ? 'status-done' : 'status-process' }}">{{ $r[3] }}</span></td>
                        <td style="color: var(--text-muted-c);">{{ $r[4] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection