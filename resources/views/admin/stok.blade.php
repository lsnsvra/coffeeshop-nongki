@extends('layouts.admin')

@section('title', 'Manajemen Stok — NONGKI')

@push('styles')
<style>
  
    /* Menghilangkan tombol naik-turun di Chrome, Safari, Edge, dan Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Menghilangkan tombol naik-turun di Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

   
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
        background: #e5be4a; 
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
    
    .stok-bar-bg { background: rgba(255,255,255,0.05); height: 6px; width: 100px; border-radius: 10px; margin-top: 6px; overflow: hidden; }
    .stok-bar-fill { height: 100%; border-radius: 10px; transition: 0.5s; }

    /* AKSI */
    .action-btns { display: flex; gap: 8px; justify-content: center; }
    .btn-table-action {
        width: 34px; height: 34px; border-radius: 8px; cursor: pointer; transition: 0.3s;
        display: flex; align-items: center; justify-content: center; border: 1px solid rgba(201, 168, 76, 0.3);
        background: rgba(201, 168, 76, 0.1); color: var(--gold);
    }
    .btn-edit-stok:hover { background: var(--gold); color: var(--dark); }
    .btn-delete-stok:hover { background: #F44336; color: white; border-color: #F44336; }

    .badge-stok { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .status-aman { background: rgba(93, 202, 165, 0.1); color: #5DCAA5; border: 1px solid rgba(93, 202, 165, 0.2); }
    .status-rendah { background: rgba(255, 152, 0, 0.1); color: #FF9800; border: 1px solid rgba(255, 152, 0, 0.2); }
    .status-kritis { background: rgba(244, 67, 54, 0.1); color: #F44336; border: 1px solid rgba(244, 67, 54, 0.2); }

    /* FORM MODAL STYLE */
    .nongki-input {
        width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border);
        color: white; padding: 12px; border-radius: 12px; outline: none; margin-top: 5px;
    }
    .nongki-input:focus { border-color: var(--gold); box-shadow: 0 0 10px rgba(212, 175, 55, 0.1); }
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
        <button class="btn-add-stok" id="triggerTambahStok">
            <i class="fa-solid fa-plus"></i> Tambah Bahan Baru
        </button>

        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="background: rgba(93, 202, 165, 0.1); color: #5DCAA5;"><i class="fa-solid fa-box"></i></div>
            <div><div style="font-size: 0.7rem; color: var(--text-muted-c);">Bahan Aman</div><div style="font-size: 1.1rem; font-weight: 700;">{{ $Stok->where('stok_sekarang', '>', 20)->count() }} Item</div></div>
        </div>
        
        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="background: rgba(244, 67, 54, 0.1); color: #F44336;"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div><div style="font-size: 0.7rem; color: var(--text-muted-c);">Hampir Habis</div><div style="font-size: 1.1rem; font-weight: 700;">{{ $Stok->where('stok_sekarang', '<=', 10)->count() }} Item</div></div>
        </div>
    </div>


    {{-- PANEL DAFTAR BAHAN --}}
    <div class="inventory-panel">
        <div class="inventory-header">
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; color: var(--cream); margin: 0;">Daftar Inventaris</h3>
            <div style="font-size: 0.8rem; color: var(--text-muted-c);">Update terakhir: {{ now()->format('H:i') }} WIB</div>
        </div>

        <div style="overflow-x: auto;">
            <table class="nongki-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 100px; text-align: center;">Aksi</th>
                        <th>Nama Bahan</th>
                        <th>Kapasitas Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Stok as $s)
                    <tr>
                        <td>
                            <div class="action-btns">
                                <button class="btn-table-action btn-edit-stok" 
                                    data-id="{{ $s->id }}"
                                    data-nama="{{ $s->nama_bahan }}"
                                    data-satuan="{{ $s->satuan }}"
                                    data-supplier="{{ $s->supplier }}"
                                    data-sekarang="{{ $s->stok_sekarang }}"
                                    data-maks="{{ $s->stok_maksimal }}"
                                    title="Edit Stok">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <form action="{{ route('admin.stok.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus data stok {{ $s->nama_bahan }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table-action btn-delete-stok" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--cream);">{{ $s->nama_bahan }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted-c);">Supplier: {{ $s->supplier }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--gold);">{{ $s->stok_sekarang }} / {{ $s->stok_maksimal }}</div>
                            @php 
                                $persen = ($s->stok_sekarang / $s->stok_maksimal) * 100;
                                $color = $persen > 50 ? '#5DCAA5' : ($persen > 20 ? '#FF9800' : '#F44336');
                                $statusClass = $persen > 50 ? 'status-aman' : ($persen > 20 ? 'status-rendah' : 'status-kritis');
                                $statusLabel = $persen > 50 ? 'Aman' : ($persen > 20 ? 'Rendah' : 'Kritis');
                            @endphp
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: {{ $persen }}%; background: {{ $color }};"></div></div>
                        </td>
                        <td>{{ $s->satuan }}</td>
                        <td><span class="badge-stok {{ $statusClass }}">{{ $statusLabel }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DINAMIS -->
<div id="modalStok" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.85); backdrop-filter: blur(5px); z-index: 9999;">
    <div style="background:var(--dark-2); margin:5% auto; padding:2.5rem; border:1px solid var(--gold); border-radius:24px; width:450px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h2 id="modalTitle" style="color:var(--gold); font-family:'Cormorant Garamond', serif; margin:0; font-size:1.8rem;">Tambah Bahan</h2>
            <button type="button" id="closeBtn" style="background:none; border:none; color:var(--text-muted-c); font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <form id="formStok" action="{{ route('admin.stok.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>

            <div style="margin-bottom:1.2rem;">
                <label style="color:var(--gold); font-size:0.75rem; text-transform:uppercase;">Nama Bahan Baku</label>
                <input type="text" name="nama_bahan" id="in_nama" required class="nongki-input" placeholder="Contoh: Biji Kopi Arabika">
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.75rem; text-transform:uppercase;">Stok Saat Ini</label>
                    <input type="number" name="stok_sekarang" id="in_sekarang" required class="nongki-input" placeholder="0">
                </div>
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.75rem; text-transform:uppercase;">Kapasitas Maks</label>
                    <input type="number" name="stok_maksimal" id="in_maks" required class="nongki-input" placeholder="100">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 1.2rem;">
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.75rem; text-transform:uppercase;">Satuan</label>
                    <input type="text" name="satuan" id="in_satuan" required class="nongki-input" placeholder="kg / liter">
                </div>
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.75rem; text-transform:uppercase;">Supplier</label>
                    <input type="text" name="supplier" id="in_supplier" required class="nongki-input" placeholder="Nama PT/Vendor">
                </div>
            </div>

            <div style="display:flex; gap:15px; margin-top: 2rem;">
                <button type="button" id="cancelBtn" style="flex:1; background:transparent; border:1px solid var(--border); color:var(--text-muted-c); padding:12px; border-radius:12px; cursor:pointer;">Batal</button>
                <button type="submit" style="flex:2; background:var(--gold); color:var(--dark); border:none; padding:12px; border-radius:12px; cursor:pointer; font-weight:800;">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalStok');
        const form = document.getElementById('formStok');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        
        // Trigger Tambah
        document.getElementById('triggerTambahStok').onclick = () => {
            modalTitle.innerText = "Tambah Bahan Baru";
            form.action = "{{ route('admin.stok.store') }}";
            methodField.innerHTML = "";
            form.reset();
            modal.style.display = "block";
        };

        // Trigger Edit
        document.querySelectorAll('.btn-edit-stok').forEach(btn => {
            btn.onclick = function() {
                const d = this.dataset;
                modalTitle.innerText = "Edit Inventaris";
                form.action = `/admin/stok/${d.id}`;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                document.getElementById('in_nama').value = d.nama;
                document.getElementById('in_sekarang').value = d.sekarang;
                document.getElementById('in_maks').value = d.maks;
                document.getElementById('in_satuan').value = d.satuan;
                document.getElementById('in_supplier').value = d.supplier;
                
                modal.style.display = "block";
            };
        });

        const close = () => modal.style.display = "none";
        document.getElementById('closeBtn').onclick = close;
        document.getElementById('cancelBtn').onclick = close;
        window.onclick = (e) => { if(e.target == modal) close(); }
    });
</script>
@endpush