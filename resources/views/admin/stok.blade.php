@extends('layouts.admin')

@section('title', 'Manajemen Stok Baku — NONGKI')

@push('styles')
<style>
    /* CLEANUP & CONSISTENCY */
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    :root {
        --bg-main: #000000;
        --bg-panel: #111111;
        --gold: #d4af37;
        --gold-dim: rgba(212, 175, 55, 0.1); 
        --bronze: #a87b4f; /* Coklat Manajemen Pengguna */
        --text-main: #f8f9fa;
        --text-muted: #a0a0a0;
        --border-color: #2a2a2a;
    }

    body { background-color: var(--bg-main); color: var(--text-main); }

    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* STATS SUMMARY (COMPACT) */
    .stok-summary-container { display: flex; gap: 1rem; margin-bottom: 1.5rem; }
    
    .btn-add-stok {
        background: var(--gold); color: #000; border: none; padding: 0 1.5rem; 
        border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s;
        display: flex; align-items: center; gap: 8px; font-size: 0.8rem; height: 40px;
    }
    .btn-add-stok:hover { transform: translateY(-2px); background: #f1c40f; box-shadow: 0 5px 15px var(--gold-dim); }

    .stok-mini-card {
        background: var(--bg-panel); border: 1px solid var(--border-color);
        padding: 0.8rem 1rem; border-radius: 12px; display: flex; align-items: center; gap: 0.8rem; flex: 1;
    }
    .stok-mini-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; background: rgba(255,255,255,0.03); }

    /* TABLE SECTION */
    .inventory-panel { 
        background: var(--bg-panel); border: 1px solid var(--border-color); 
        border-radius: 16px; padding: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    
    .inventory-header h3 { font-size: 1.1rem; color: var(--gold); margin: 0; font-weight: 700; }

    .nongki-table th { 
        padding: 10px; text-align: left; font-size: 0.65rem; 
        text-transform: uppercase; color: var(--gold) !important; letter-spacing: 1.2px;
        border-bottom: 2px solid var(--border-color);
    }
    .nongki-table td { padding: 10px; border-bottom: 1px solid var(--border-color); vertical-align: middle; color: var(--text-main) !important; font-size: 0.8rem; }
    
    /* ACTION ICONS (BRONZE & CIRCLE OUTLINED) */
    .action-btns { display: flex; gap: 8px; justify-content: center; }
    .btn-table-action {
        width: 32px; height: 32px; border-radius: 50%; 
        cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; justify-content: center; 
        border: 1px solid var(--border-color); 
        background: transparent; color: var(--bronze); 
        font-size: 0.75rem;
    }
    .btn-edit-stok:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }
    .btn-delete-stok:hover { border-color: #ff4757; color: #ff4757; background: rgba(255,71,87,0.05); }

    .stok-bar-bg { background: rgba(255,255,255,0.03); height: 4px; width: 70px; border-radius: 10px; margin-top: 5px; overflow: hidden; }
    .stok-bar-fill { height: 100%; border-radius: 10px; }

    .badge-stok { padding: 3px 8px; border-radius: 5px; font-size: 8px; font-weight: 800; text-transform: uppercase; border: 1px solid; }
    .status-aman { color: #5DCAA5; border-color: rgba(93, 202, 165, 0.2); background: rgba(93, 202, 165, 0.05); }
    .status-kritis { color: #F44336; border-color: rgba(244, 67, 54, 0.2); background: rgba(244, 67, 54, 0.05); }

    /* AUDIT LOG LENGKAP */
    .audit-box { font-size: 0.7rem; color: var(--text-main); line-height: 1.4; }
    .audit-box span { color: var(--gold); font-weight: 600; }
    .audit-box .user-log { margin-top: 4px; display: flex; align-items: center; gap: 4px; color: var(--text-main); font-weight: 700; font-size: 0.75rem; }
    .audit-box .user-log i { color: var(--gold); font-size: 0.65rem; }

    /* MODAL */
    .modal-content {
        background: #0a0a0a; margin: 5% auto; padding: 25px; border: 1px solid var(--gold);
        width: 100%; max-width: 380px; border-radius: 16px; color: #fff;
    }
    .nongki-input {
        width: 100%; background: #000; border: 1px solid var(--border-color);
        color: white; padding: 10px; border-radius: 8px; outline: none; margin-top: 4px; font-size: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div style="margin-bottom: 1.2rem;">
        <h1 style="font-size: 1.6rem; color: var(--gold); margin: 0; font-weight: 700;">Inventory Bahan Baku</h1>
        <p style="color: var(--text-muted); font-size: 0.8rem;">Kontrol logistik NONGKI dengan Audit Log lengkap.</p>
    </div>

    <div class="stok-summary-container">
        <button class="btn-add-stok" id="triggerTambahStok">
            <i class="fa-solid fa-plus-circle"></i> Tambah Bahan
        </button>

        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="color: #5DCAA5;"><i class="fa-solid fa-check"></i></div>
            <div><div style="font-size: 0.55rem; color: var(--text-muted); text-transform: uppercase;">Aman</div><div style="font-size: 0.85rem; font-weight: 800;">{{ $Stok->where('stok_sekarang', '>', 20)->count() }} Items</div></div>
        </div>
        
        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="color: #F44336;"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div><div style="font-size: 0.55rem; color: var(--text-muted); text-transform: uppercase;">Kritis</div><div style="font-size: 0.85rem; font-weight: 800;">{{ $Stok->where('stok_sekarang', '<=', 10)->count() }} Items</div></div>
        </div>
    </div>

    <div class="inventory-panel">
        <div class="inventory-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
            <h3>Daftar Inventaris</h3>
            <span style="font-size: 0.65rem; color: var(--text-muted); background: rgba(255,255,255,0.03); padding: 3px 10px; border-radius: 8px;">{{ $Stok->count() }} Bahan</span>
        </div>

        <div style="overflow-x: auto;">
            <table class="nongki-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 80px;">Aksi</th>
                        <th>Info Bahan</th>
                        <th>Kapasitas</th>
                        <th style="width: 80px;">Satuan</th>
                        <th>Status</th>
                        <th style="width: 170px;">Audit Log </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Stok as $s)
                    <tr>
                        <td>
                            <div class="action-btns">
                                <button class="btn-table-action btn-edit-stok" 
                                    data-id="{{ $s->id }}" data-nama="{{ $s->nama_bahan }}"
                                    data-satuan="{{ $s->satuan }}" data-supplier="{{ $s->supplier }}"
                                    data-sekarang="{{ $s->stok_sekarang }}" data-maks="{{ $s->stok_maksimal }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button" class="btn-table-action btn-delete-stok" onclick="confirmDelete('{{ $s->id }}', '{{ $s->nama_bahan }}')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <form id="delete-form-{{ $s->id }}" action="{{ route('admin.stok.destroy', $s->id) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $s->nama_bahan }}</div>
                            <div style="font-size: 0.65rem; color: var(--gold); margin-top: 1px;">
                                <i class="fa-solid fa-truck-ramp-box" style="margin-right: 3px;"></i> 
                                {{ $s->supplier }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 800; font-size: 0.85rem;">{{ $s->stok_sekarang }} / {{ $s->stok_maksimal }}</div>
                            @php 
                                $persen = ($s->stok_maksimal > 0) ? ($s->stok_sekarang / $s->stok_maksimal) * 100 : 0;
                                $color = $persen > 50 ? '#5DCAA5' : ($persen > 20 ? '#FF9800' : '#F44336');
                            @endphp
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: {{ $persen }}%; background: {{ $color }};"></div></div>
                        </td>
                        <td style="text-transform: uppercase; font-weight: 600; font-size: 0.75rem;">{{ $s->satuan }}</td>
                        <td><span class="badge-stok {{ $persen > 20 ? 'status-aman' : 'status-kritis' }}">{{ $persen > 20 ? 'Tersedia' : 'Kritis' }}</span></td>
                        <td>
                            <div class="audit-box">
                                {{-- LOGIC TANGGAL ANTI STRIP --}}
                                <div><span>Created:</span> {{ 
                                    $s->CreatedDate ? \Carbon\Carbon::parse($s->CreatedDate)->format('d/m/y H:i') : 
                                    ($s->created_at ? $s->created_at->format('d/m/y H:i') : '-') 
                                }}</div>
                                <div><span>Updated:</span> {{ 
                                    $s->LastUpdatedDate ? \Carbon\Carbon::parse($s->LastUpdatedDate)->format('d/m/y H:i') : 
                                    ($s->updated_at ? $s->updated_at->format('d/m/y H:i') : '-') 
                                }}</div>
                                <div class="user-log">
                                    <i class="fa-solid fa-user-pen"></i> {{ $s->LastUpdatedBy ?? 'System' }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalStok" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index: 9999; backdrop-filter: blur(4px);">
    <div class="modal-content">
        <h2 id="modalTitle" style="color:var(--gold); margin:0 0 20px 0; font-size:1.2rem; font-weight: 700;">Tambah Bahan</h2>
        <form id="formStok" action="{{ route('admin.stok.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>
            <div style="margin-bottom:12px;">
                <label style="color:var(--gold); font-size:0.65rem; font-weight: bold; text-transform: uppercase;">Nama Bahan Baku</label>
                <input type="text" name="nama_bahan" id="in_nama" required class="nongki-input">
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.65rem; font-weight: bold;">STOK SKRG</label>
                    <input type="number" name="stok_sekarang" id="in_sekarang" required class="nongki-input">
                </div>
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.65rem; font-weight: bold;">STOK MAKS</label>
                    <input type="number" name="stok_maksimal" id="in_maks" required class="nongki-input">
                </div>
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.65rem; font-weight: bold;">SATUAN</label>
                    <input type="text" name="satuan" id="in_satuan" required class="nongki-input" placeholder="kg/lt">
                </div>
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.65rem; font-weight: bold;">SUPPLIER</label>
                    <input type="text" name="supplier" id="in_supplier" required class="nongki-input">
                </div>
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" style="flex:2; background:var(--gold); color:#000; border:none; padding:12px; border-radius:8px; cursor:pointer; font-weight:800; font-size: 0.75rem;">SIMPAN DATA</button>
                <button type="button" onclick="closeModal()" style="flex:1; background:transparent; border:1px solid var(--border-color); color:#fff; border-radius:8px; font-size: 0.75rem;">BATAL</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modal = document.getElementById('modalStok');
    const form = document.getElementById('formStok');

    document.getElementById('triggerTambahStok').onclick = () => {
        document.getElementById('modalTitle').innerText = "Tambah Bahan Baku";
        form.action = "{{ route('admin.stok.store') }}";
        document.getElementById('methodField').innerHTML = "";
        form.reset();
        modal.style.display = "block";
    };

    document.querySelectorAll('.btn-edit-stok').forEach(btn => {
        btn.onclick = function() {
            const d = this.dataset;
            document.getElementById('modalTitle').innerText = "Edit Stok Bahan";
            form.action = `/admin/stok/${d.id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('in_nama').value = d.nama;
            document.getElementById('in_sekarang').value = d.sekarang;
            document.getElementById('in_maks').value = d.maks;
            document.getElementById('in_satuan').value = d.satuan;
            document.getElementById('in_supplier').value = d.supplier;
            modal.style.display = "block";
        };
    });

    function closeModal() { modal.style.display = "none"; }
    window.onclick = (e) => { if(e.target == modal) closeModal(); }

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Bahan?', text: name, icon: 'warning',
            showCancelButton: true, background: '#0a0a0a', color: '#fff',
            confirmButtonColor: '#ff4757', confirmButtonText: 'Ya, Hapus!',
            cancelButtonColor: '#2a2a2a', cancelButtonText: 'Batal'
        }).then((res) => { if (res.isConfirmed) document.getElementById('delete-form-'+id).submit(); });
    }

    @if(session('success'))
        Swal.fire({ title: 'Selesai!', text: "{{ session('success') }}", icon: 'success', background: '#0a0a0a', color: '#fff', confirmButtonColor: '#d4af37' });
    @endif
</script>
@endpush