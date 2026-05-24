@extends('layouts.admin')

@section('title', 'Manajemen Stok Baku — NONGKI')

@push('styles')
<style>
    /* ========== CLEANUP & CONSISTENCY ========== */
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    :root {
        --bg-main: #000000;
        --bg-panel: #111111;
        --gold: #d4af37;
        --gold-dim: rgba(212, 175, 55, 0.1); 
        --bronze: #a87b4f;
        --text-main: #f8f9fa;
        --text-muted: #a0a0a0;
        --border-color: #2a2a2a;
    }

    body { background-color: var(--bg-main); color: var(--text-main); }

    /* ========== ANIMATIONS ========== */
    .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== STATS SUMMARY ========== */
    .stok-summary-container { display: flex; gap: 1rem; margin-bottom: 1.8rem; align-items: stretch; }
    
    .btn-add-stok {
        background: var(--gold); color: #000; border: none; padding: 0 1.5rem; 
        border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem;
    }
    .btn-add-stok:hover { transform: translateY(-3px); background: #f1c40f; box-shadow: 0 8px 20px var(--gold-dim); }

    .btn-resep-stok {
        background: transparent; color: var(--gold); border: 1px solid var(--gold); padding: 0 1.5rem; 
        border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem;
    }
    .btn-resep-stok:hover { background: var(--gold-dim); transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.5); }

    .stok-mini-card {
        background: var(--bg-panel); border: 1px solid var(--border-color);
        padding: 0.8rem 1.2rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem; flex: 1;
        transition: border-color 0.3s;
    }
    .stok-mini-card:hover { border-color: rgba(255,255,255,0.1); }
    .stok-mini-icon { width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; background: rgba(255,255,255,0.03); }

    /* ========== TABLE SECTION ========== */
    .inventory-panel { 
        background: var(--bg-panel); border: 1px solid var(--border-color); 
        border-radius: 16px; padding: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.6);
    }
    
    .inventory-header h3 { font-size: 1.2rem; color: var(--gold); margin: 0; font-weight: 700; letter-spacing: 0.5px; }

    .nongki-table th { 
        padding: 12px; text-align: left; font-size: 0.7rem; 
        text-transform: uppercase; color: var(--gold) !important; letter-spacing: 1.5px;
        border-bottom: 2px solid var(--border-color);
    }
    .nongki-table td { padding: 14px 12px; border-bottom: 1px solid var(--border-color); vertical-align: middle; color: var(--text-main) !important; font-size: 0.85rem; transition: background 0.3s; }
    .nongki-table tbody tr:hover td { background: rgba(212, 175, 55, 0.02); }
    
    /* ========== ACTION ICONS ========== */
    .action-btns { display: flex; gap: 10px; justify-content: center; }
    .btn-table-action {
        width: 34px; height: 34px; border-radius: 50%; 
        cursor: pointer; transition: all 0.3s ease;
        display: inline-flex; align-items: center; justify-content: center; 
        border: 1px solid var(--border-color); 
        background: transparent; color: var(--bronze); 
        font-size: 0.8rem;
    }
    .btn-edit-stok:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); transform: scale(1.1); }
    .btn-delete-stok:hover { border-color: #ff4757; color: #ff4757; background: rgba(255,71,87,0.1); transform: scale(1.1); }

    /* ========== PROGRESS BARS & BADGES ========== */
    .stok-bar-bg { background: rgba(255,255,255,0.05); height: 5px; width: 80px; border-radius: 10px; margin-top: 6px; overflow: hidden; }
    .stok-bar-fill { height: 100%; border-radius: 10px; transition: width 1s ease-in-out; }

    .badge-stok { padding: 4px 10px; border-radius: 6px; font-size: 9px; font-weight: 800; text-transform: uppercase; border: 1px solid; letter-spacing: 0.5px; }
    .status-aman { color: #5DCAA5; border-color: rgba(93, 202, 165, 0.2); background: rgba(93, 202, 165, 0.05); }
    .status-kritis { color: #F44336; border-color: rgba(244, 67, 54, 0.2); background: rgba(244, 67, 54, 0.05); }

    /* ========== AUDIT LOG ========== */
    .audit-box { font-size: 0.72rem; color: var(--text-muted); line-height: 1.5; }
    .audit-box span { color: var(--gold); font-weight: 600; display: inline-block; width: 55px; }
    .audit-box .user-log { margin-top: 5px; display: flex; align-items: center; gap: 5px; color: var(--text-main); font-weight: 700; font-size: 0.75rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 5px; }
    .audit-box .user-log i { color: var(--gold); font-size: 0.65rem; }

    /* ========== MODALS ========== */
    .modal-overlay { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; backdrop-filter: blur(5px); animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .modal-content {
        background: #0a0a0a; margin: 4% auto; padding: 30px; border: 1px solid var(--border-color);
        width: 100%; max-width: 420px; border-radius: 20px; color: #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.9);
        position: relative; animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

    .nongki-input {
        width: 100%; background: #000; border: 1px solid var(--border-color);
        color: white; padding: 12px 15px; border-radius: 10px; outline: none; margin-top: 6px; font-size: 0.85rem; transition: border-color 0.3s, box-shadow 0.3s;
    }
    .nongki-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px var(--gold-dim); }

    .menu-list-item {
        display: flex; justify-content: space-between; align-items: center; background: #000; 
        border: 1px solid var(--border-color); padding: 15px; border-radius: 12px; margin-bottom: 10px; transition: all 0.3s ease;
    }
    .menu-list-item:hover { border-color: var(--gold); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.8rem; color: var(--gold); margin: 0; font-weight: 800; font-family: 'Cormorant Garamond', serif;">Inventory Bahan Baku</h1>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px;">Kontrol logistik dan konfigurasi resep NONGKI.</p>
    </div>

    {{-- STATS & ACTIONS --}}
    <div class="stok-summary-container">
        <button class="btn-add-stok" id="triggerTambahStok">
            <i class="fa-solid fa-plus-circle"></i> Tambah Bahan
        </button>
        
        <button class="btn-resep-stok" onclick="openResepModal()">
            <i class="fa-solid fa-book-open"></i> Atur Resep Menu
        </button>

        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="color: #5DCAA5;"><i class="fa-solid fa-check"></i></div>
            <div>
                <div style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Stok Aman</div>
                <div style="font-size: 1rem; font-weight: 800;">{{ $Stok->where('Stock', '>', 20)->count() }} Items</div>
            </div>
        </div>
        
        <div class="stok-mini-card">
            <div class="stok-mini-icon" style="color: #F44336;"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div>
                <div style="font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Stok Kritis</div>
                <div style="font-size: 1rem; font-weight: 800;">{{ $Stok->where('Stock', '<=', 10)->count() }} Items</div>
            </div>
        </div>
    </div>

    {{-- INVENTORY TABLE --}}
    <div class="inventory-panel">
        <div class="inventory-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
            <h3>Daftar Inventaris Gudang</h3>
            <span style="font-size: 0.7rem; color: var(--gold); background: var(--gold-dim); padding: 5px 12px; border-radius: 8px; font-weight: 700;">Total: {{ $Stok->count() }} Bahan</span>
        </div>

        <div style="overflow-x: auto;">
            <table class="nongki-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 90px;">Aksi</th>
                        <th>Informasi Bahan</th>
                        <th style="width: 120px;">Kapasitas Stok</th>
                        <th style="width: 100px;">Satuan</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 200px;">Audit Log</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Stok as $s)
                    <tr>
                        <td>
                            <div class="action-btns">
                                <button class="btn-table-action btn-edit-stok" 
                                    data-id="{{ $s->MaterialID }}" 
                                    data-nama="{{ $s->NamaMaterial }}"
                                    data-sekarang="{{ $s->Stock }}" 
                                    data-satuan="{{ $s->Unit }}"
                                    title="Edit Bahan">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button type="button" class="btn-table-action btn-delete-stok" onclick="confirmDelete('{{ $s->MaterialID }}', '{{ $s->NamaMaterial }}')" title="Hapus Bahan">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <form id="delete-form-{{ $s->MaterialID }}" action="{{ route('admin.stok.destroy', $s->MaterialID) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: #fff; font-size: 0.95rem; letter-spacing: 0.3px;">{{ $s->NamaMaterial }}</div>
                            <div style="font-size: 0.65rem; color: var(--gold); margin-top: 3px; text-transform: uppercase;">ID: #{{ $s->MaterialID }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 800; font-size: 1rem; color: #fff;">{{ $s->Stock }}</div>
                            @php 
                                $persen = min(($s->Stock / 50) * 100, 100); // Visual scaling
                                $color = $s->Stock > 20 ? '#5DCAA5' : ($s->Stock > 10 ? '#FF9800' : '#F44336');
                            @endphp
                            <div class="stok-bar-bg"><div class="stok-bar-fill" style="width: {{ $persen }}%; background: {{ $color }};"></div></div>
                        </td>
                        <td style="text-transform: uppercase; font-weight: 700; font-size: 0.8rem; color: var(--gold) !important;">{{ $s->Unit }}</td>
                        <td><span class="badge-stok {{ $s->Stock > 10 ? 'status-aman' : 'status-kritis' }}">{{ $s->Stock > 10 ? 'Tersedia' : 'Kritis' }}</span></td>
                        <td>
                            <div class="audit-box">
                                <div><span>Created</span>: {{ $s->CreatedDate ? \Carbon\Carbon::parse($s->CreatedDate)->format('d M Y, H:i') : '-' }}</div>
                                <div><span>Updated</span>: {{ $s->LastUpdatedDate ? \Carbon\Carbon::parse($s->LastUpdatedDate)->format('d M Y, H:i') : '-' }}</div>
                                <div class="user-log">
                                    <i class="fa-solid fa-user-pen"></i> {{ $s->LastUpdatedBy ?? 'System' }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($Stok->isEmpty())
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-solid fa-box-open" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.3;"></i>
                            Belum ada bahan baku di gudang.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH/EDIT BAHAN --}}
<div id="modalStok" class="modal-overlay">
    <div class="modal-content">
        <h2 id="modalTitle" style="color:var(--gold); margin:0 0 25px 0; font-size:1.4rem; font-weight: 800; font-family: 'Cormorant Garamond', serif;">Tambah Bahan Baru</h2>
        <form id="formStok" action="{{ route('admin.stok.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>
            
            <div style="margin-bottom:18px;">
                <label style="color:var(--gold); font-size:0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Nama Bahan Baku</label>
                <input type="text" name="nama_bahan" id="in_nama" required class="nongki-input" placeholder="Contoh: Biji Kopi Arabika">
            </div>
            
            <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Jumlah Stok</label>
                    <input type="number" step="0.01" name="stok_sekarang" id="in_sekarang" required class="nongki-input" placeholder="0">
                </div>
                <div style="flex: 1;">
                    <label style="color:var(--gold); font-size:0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Satuan</label>
                    <input type="text" name="satuan" id="in_satuan" required class="nongki-input" placeholder="gram / liter">
                </div>
            </div>
            
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="closeModal()" style="flex:1; background:transparent; border:1px solid var(--border-color); color:#fff; border-radius:10px; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='var(--border-color)'" onmouseout="this.style.background='transparent'">Batal</button>
                <button type="submit" style="flex:2; background:var(--gold); color:#000; border:none; padding:14px; border-radius:10px; cursor:pointer; font-weight:800; font-size: 0.85rem; transition: 0.3s;" onmouseover="this.style.background='#f1c40f'" onmouseout="this.style.background='var(--gold)'"><i class="fa-solid fa-floppy-disk" style="margin-right: 5px;"></i> Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PILIH MENU UNTUK RESEP --}}
<div id="modalResep" class="modal-overlay">
    <div class="modal-content" style="max-width: 550px;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
            <div>
                <h2 style="color:var(--gold); margin:0; font-size:1.5rem; font-weight: 800; font-family: 'Cormorant Garamond', serif;">Konfigurasi Resep</h2>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">Pilih menu untuk mengatur komposisi / BOM.</div>
            </div>
            <button type="button" onclick="closeResepModal()" style="background:none; border:none; color:var(--text-muted); font-size:2rem; cursor:pointer; line-height: 1; transition: 0.3s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-muted)'">&times;</button>
        </div>
        
        <div style="max-height: 55vh; overflow-y: auto; padding-right: 10px;">
            @if(isset($Products) && $Products->count() > 0)
                @foreach($Products as $p)
                <div class="menu-list-item">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        @if($p->image)
                            <img src="{{ asset('images/products/' . $p->image) }}" alt="img" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; justify-content: center; align-items: center; border: 1px solid var(--border-color);"><i class="fa-solid fa-mug-hot" style="color: var(--gold);"></i></div>
                        @endif
                        <div>
                            <div style="font-weight: 800; color: #fff; font-size: 1rem;">{{ $p->NamaKopi }}</div>
                            <div style="font-size: 0.75rem; color: var(--gold); margin-top: 3px; font-weight: 600;">{{ $p->Category }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.resep.index', $p->ProductID) }}" style="background: var(--gold-dim); color: var(--gold); border: 1px solid var(--gold); padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 800; font-size: 0.75rem; transition: 0.3s;" onmouseover="this.style.background='var(--gold)'; this.style.color='#000';" onmouseout="this.style.background='var(--gold-dim)'; this.style.color='var(--gold)';">
                        <i class="fa-solid fa-gears" style="margin-right: 5px;"></i> Atur Resep
                    </a>
                </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                    Belum ada data Menu. Tambahkan menu terlebih dahulu.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Elements
    const modalStok = document.getElementById('modalStok');
    const modalResep = document.getElementById('modalResep');
    const formStok = document.getElementById('formStok');

    // Tambah Bahan
    document.getElementById('triggerTambahStok').onclick = () => {
        document.getElementById('modalTitle').innerText = "Tambah Bahan Baru";
        formStok.action = "{{ route('admin.stok.store') }}";
        document.getElementById('methodField').innerHTML = "";
        formStok.reset();
        modalStok.style.display = "block";
    };

    // Edit Bahan
    document.querySelectorAll('.btn-edit-stok').forEach(btn => {
        btn.onclick = function() {
            const d = this.dataset;
            document.getElementById('modalTitle').innerText = "Update Stok Bahan";
            formStok.action = `/admin/stok/${d.id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('in_nama').value = d.nama;
            document.getElementById('in_sekarang').value = d.sekarang;
            document.getElementById('in_satuan').value = d.satuan;
            
            modalStok.style.display = "block";
        };
    });

    // Modals Control
    function closeModal() { modalStok.style.display = "none"; }
    function openResepModal() { modalResep.style.display = "block"; }
    function closeResepModal() { modalResep.style.display = "none"; }
    
    window.onclick = (e) => { 
        if(e.target == modalStok) closeModal(); 
        if(e.target == modalResep) closeResepModal();
    }

    // SweetAlert Konfirmasi Hapus
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Bahan Gudang?',
            html: `Yakin ingin menghapus <b>${name}</b>?<br><span style="font-size:0.8rem;color:#ff4757;">Bahan ini juga akan hilang dari daftar komposisi resep.</span>`,
            icon: 'warning',
            showCancelButton: true,
            background: '#0a0a0a', color: '#fff',
            confirmButtonColor: '#ff4757', cancelButtonColor: '#2a2a2a',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
            border: '1px solid #2a2a2a'
        }).then((res) => { 
            if (res.isConfirmed) document.getElementById('delete-form-'+id).submit(); 
        });
    }

    // SweetAlert Success
    @if(session('success'))
        Swal.fire({ 
            title: 'Berhasil!', 
            text: "{{ session('success') }}", 
            icon: 'success', 
            background: '#0a0a0a', color: '#fff', 
            confirmButtonColor: '#d4af37',
            iconColor: '#d4af37',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush