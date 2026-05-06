@extends('layouts.admin')

@section('title', 'Manajemen Stok — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== STATS SUMMARY STOK ========== */
    .stok-summary-container { 
        display: flex; 
        gap: 1.5rem; 
        margin-bottom: 2rem; 
        align-items: stretch;
    }
    
    .btn-add-stok {
        background: var(--gold); 
        color: var(--dark); 
        border: none; 
        padding: 0 2rem; 
        border-radius: 16px; 
        font-weight: 700; 
        cursor: pointer; 
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }
    .btn-add-stok:hover { 
        background: var(--gold-light); 
        transform: translateY(-3px); 
        box-shadow: 0 5px 15px rgba(201, 168, 76, 0.3);
    }

    .stok-mini-card {
        background: var(--dark-2); 
        border: 1px solid var(--border);
        padding: 1.2rem; 
        border-radius: 16px; 
        display: flex; 
        align-items: center; 
        gap: 1rem;
        flex: 1;
    }
    .stok-mini-icon { 
        width: 40px; height: 40px; border-radius: 10px; 
        display: flex; align-items: center; justify-content: center; 
        font-size: 1.1rem; 
    }

    /* ========== TABLE PREMIUM ========== */
    .inventory-panel { background: var(--dark-2); border: 1px solid var(--border); border-radius: 20px; padding: 1.5rem; }
    .inventory-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    
    .nongki-table th { 
        padding: 1rem 0.8rem; text-align: left; font-size: 0.75rem; 
        text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }
    .nongki-table td { padding: 1.2rem 0.8rem; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
    
    .stok-bar-bg { background: var(--dark-4); height: 6px; width: 100px; border-radius: 10px; margin-top: 6px; overflow: hidden; }
    .stok-bar-fill { height: 100%; border-radius: 10px; }

    /* AKSI DI KIRI */
    .action-col { width: 80px; text-align: center; }
    .btn-edit-stok {
        background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.3);
        width: 34px; height: 34px; border-radius: 8px; cursor: pointer; transition: 0.3s;
    }
    .btn-edit-stok:hover { background: var(--gold); color: var(--dark); }

    .badge-stok { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .status-aman { background: rgba(93, 202, 165, 0.1); color: #5DCAA5; border: 1px solid rgba(93, 202, 165, 0.2); }
    .status-rendah { background: rgba(255, 152, 0, 0.1); color: #FF9800; border: 1px solid rgba(255, 152, 0, 0.2); }
    .status-kritis { background: rgba(244, 67, 54, 0.1); color: #F44336; border: 1px solid rgba(244, 67, 54, 0.2); }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: var(--gold); margin: 0;">Manajemen Stok</h1>
        <p style="color: var(--cream-dim);">Kontrol ketersediaan bahan baku kopi secara akurat.</p>
    </div>

    {{-- RINGKASAN STOK --}}
    <div class="stok-summary-container">
        <button class="btn-add-stok">
            <i class="fa-solid fa-plus"></i> Tambah Bahan Baru
        </button>

        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="background: rgba(93, 202, 165, 0.1); color: #5DCAA5;"><i class="fa-solid fa-box"></i></div>
            <div><div style="font-size: 0.7rem; color: var(--text-muted-c);">Bahan Aman</div><div style="font-size: 1.1rem; font-weight: 700;">18 Item</div></div>
        </div>
        
        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="background: rgba(244, 67, 54, 0.1); color: #F44336;"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div><div style="font-size: 0.7rem; color: var(--text-muted-c);">Hampir Habis</div><div style="font-size: 1.1rem; font-weight: 700;">3 Item</div></div>
        </div>
    </div>

    {{-- PANEL DAFTAR BAHAN --}}
    <div class="inventory-panel">
        <div class="inventory-header">
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; color: var(--cream); margin: 0;">Daftar Inventaris</h3>
            <div style="font-size: 0.8rem; color: var(--text-muted-c);">Update terakhir: Hari ini, 22:15 WIB</div>
        </div>

        <div style="overflow-x: auto;">
            <table class="nongki-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="action-col">Aksi</th>
                        <th>Nama Bahan</th>
                        <th>Kapasitas Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="action-col">
                            <button class="btn-edit-stok" title="Edit Stok"><i class="fa-solid fa-pen-to-square"></i></button>
                        </td>
                        <td><div style="font-weight: 600; color: var(--cream);">Biji Kopi Arabika</div><div style="font-size: 0.75rem; color: var(--text-muted-c);">Supplier: Java Roots</div></td>
                        <td>
                            <div style="font-weight: 700; color: var(--gold);">25 / 50</div>
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: 50%; background: #5DCAA5;"></div></div>
                        </td>
                        <td>kg</td>
                        <td><span class="badge-stok status-aman">Aman</span></td>
                    </tr>
                    <tr>
                        <td class="action-col">
                            <button class="btn-edit-stok" title="Edit Stok"><i class="fa-solid fa-pen-to-square"></i></button>
                        </td>
                        <td><div style="font-weight: 600; color: var(--cream);">Susu Segar</div><div style="font-size: 0.75rem; color: var(--text-muted-c);">Supplier: Greenfields</div></td>
                        <td>
                            <div style="font-weight: 700; color: var(--gold);">12 / 60</div>
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: 20%; background: #FF9800;"></div></div>
                        </td>
                        <td>liter</td>
                        <td><span class="badge-stok status-rendah">Rendah</span></td>
                    </tr>
                    <tr>
                        <td class="action-col">
                            <button class="btn-edit-stok" title="Edit Stok"><i class="fa-solid fa-pen-to-square"></i></button>
                        </td>
                        <td><div style="font-weight: 600; color: var(--cream);">Gula Aren</div><div style="font-size: 0.75rem; color: var(--text-muted-c);">Supplier: Lokal Farmer</div></td>
                        <td>
                            <div style="font-weight: 700; color: var(--gold);">8 / 100</div>
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: 8%; background: #F44336;"></div></div>
                        </td>
                        <td>kg</td>
                        <td><span class="badge-stok status-kritis">Kritis</span></td>
                    </tr>
                    <tr>
                        <td class="action-col">
                            <button class="btn-edit-stok" title="Edit Stok"><i class="fa-solid fa-pen-to-square"></i></button>
                        </td>
                        <td><div style="font-weight: 600; color: var(--cream);">Sirup Hazelnut</div><div style="font-size: 0.75rem; color: var(--text-muted-c);">Supplier: Monin Official</div></td>
                        <td>
                            <div style="font-weight: 700; color: var(--gold);">5 / 20</div>
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: 25%; background: #FF9800;"></div></div>
                        </td>
                        <td>botol</td>
                        <td><span class="badge-stok status-rendah">Rendah</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection