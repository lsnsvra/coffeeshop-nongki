@extends('layouts.admin')

@section('title', 'Manajemen Menu — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI & FLOW ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== LAYOUT SPACING ========== */
    .menu-management-container { padding: 5px; }
    .dashboard-header { margin-bottom: 2rem; }

    /* ========== ACTION BAR ========== */
    .menu-action-bar { 
        display: flex; gap: 1.5rem; margin-bottom: 2.5rem; 
        align-items: center; justify-content: flex-start;
        background: rgba(255, 255, 255, 0.02);
        padding: 15px 25px; border-radius: 16px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .btn-add-menu {
        background: var(--gold); color: var(--dark); border: none; 
        padding: 12px 28px; border-radius: 12px; font-weight: 700; 
        cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px;
    }
    .btn-add-menu:hover { background: #e6c147; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(201,168,76,0.3); }

    /* ========== PREMIUM TABLE ========== */
    .menu-panel { 
        background: var(--dark-2); border: 1px solid rgba(212, 175, 55, 0.2); 
        border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .nongki-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .nongki-table th { 
        padding: 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; 
        color: var(--text-muted-c); letter-spacing: 1.5px; border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .nongki-table td { 
        padding: 1.2rem 1rem; border-top: 1px solid rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.02); color: var(--cream-dim); vertical-align: middle; 
    }
    .nongki-table td:first-child { border-left: 1px solid rgba(255,255,255,0.02); border-radius: 12px 0 0 12px; }
    .nongki-table td:last-child { border-right: 1px solid rgba(255,255,255,0.02); border-radius: 0 12px 12px 0; }
    .nongki-table tbody tr { transition: all 0.3s ease; }
    .nongki-table tbody tr:hover td { background: rgba(255,255,255,0.03); }

    .menu-img-preview { width: 50px; height: 50px; border-radius: 10px; object-fit: cover; border: 1px solid rgba(201,168,76,0.2); }

    /* ========== AKSI ========== */
    .action-col { width: 100px; text-align: center; }
    .action-btns { display: flex; gap: 8px; justify-content: center; }
    .btn-table-action {
        width: 34px; height: 34px; border-radius: 8px; display: flex;
        align-items: center; justify-content: center; font-size: 0.85rem;
        cursor: pointer; transition: 0.3s; border: 1px solid rgba(255,255,255,0.05);
    }
    .btn-edit { background: rgba(201,168,76,0.1); color: var(--gold); }
    .btn-edit:hover { background: var(--gold); color: var(--dark); }
    .btn-delete { background: rgba(224, 82, 82, 0.1); color: #e05252; }
    .btn-delete:hover { background: #e05252; color: white; }

    .cat-badge { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .badge-KOPI { background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.2); }
    .badge-MAKANAN { background: rgba(52, 211, 153, 0.1); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-NON-KOPI { background: rgba(96, 165, 250, 0.1); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.2); }

    /* ========== MODALS (TAMBAH/EDIT & ALERT) ========== */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.3s ease;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: var(--dark-2); border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 24px;
        padding: 2.5rem; width: 90%; max-width: 450px;
        transform: translateY(20px) scale(0.95); transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }
    
    .modal-icon-danger { 
        width: 65px; height: 65px; margin: 0 auto 1.5rem; border-radius: 50%; display: flex; 
        align-items: center; justify-content: center; font-size: 1.6rem;
        background: rgba(224,82,82,0.1); color: #e05252; border: 1px solid rgba(224,82,82,0.3);
    }
    .modal-btn-group { display: flex; gap: 10px; margin-top: 2rem; }
    .modal-btn { flex: 1; padding: 0.8rem; border-radius: 12px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s; }
    .modal-btn-cancel { background: rgba(255,255,255,0.05); color: #f0ece3; border: 1px solid rgba(255,255,255,0.1); }
    .modal-btn-cancel:hover { background: rgba(255,255,255,0.1); }
    .modal-btn-danger { background: #e05252; color: #fff; }
    .modal-btn-danger:hover { background: #c53030; }

    .form-input {
        width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(212,175,55,0.2); 
        color: white; padding: 12px; border-radius: 12px; outline: none;
    }
</style>
@endpush

@section('content')
@php
    // 1. Ambil data langsung dari tabel products
    $menus = \Illuminate\Support\Facades\DB::table('products')->where('IsDeleted', 0)->get();

    // 2. Helper Kategori (Aman dari error Cannot Redeclare)
    if (!function_exists('getCategory')) {
        function getCategory($name) {
            $name = strtolower($name);
            $kopi = ['americano', 'coffee', 'macchiato', 'latte', 'aren', 'pandan'];
            $makanan = ['macaroni', 'katsu', 'crispy', 'fries', 'noodles', 'noodle'];
            
            foreach($kopi as $k) { if(strpos($name, $k) !== false) return 'kopi'; }
            foreach($makanan as $m) { if(strpos($name, $m) !== false) return 'makanan'; }
            return 'non-kopi';
        }
    }
@endphp

<div class="menu-management-container fade-in-up">
    <div class="dashboard-header">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Menu Inventory</h1>
        <p style="color: var(--text-muted-c);">Atur total koleksi produk aktif di NONGKI.</p>
    </div>

    {{-- ACTION BAR --}}
    <div class="menu-action-bar">
        <button class="btn-add-menu" id="triggerTambah">
            <i class="fa-solid fa-plus-circle"></i> Tambah Produk Baru
        </button>
        <div style="color: var(--text-muted-c); font-size: 0.85rem; border-left: 1px solid rgba(212,175,55,0.2); padding-left: 1.5rem;">
            Total: <strong>{{ count($menus) }} Produk</strong>
        </div>
    </div>

    {{-- TABLE PANEL --}}
    <div class="menu-panel">
        <div style="overflow-x: auto;">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th class="action-col">Aksi</th>
                        <th>Preview</th>
                        <th>Informasi Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td class="action-col">
                            <div class="action-btns">
                                {{-- Tombol Edit --}}
                                <button type="button" class="btn-table-action btn-edit" 
                                    data-id="{{ $menu->id ?? ($menu->ProductID ?? '') }}"
                                    data-nama="{{ $menu->NamaKopi }}"
                                    data-harga="{{ $menu->Harga }}"
                                    data-kategori="{{ $menu->Category ?? getCategory($menu->NamaKopi) }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                
                                {{-- Tombol Delete (Panggil Custom Alert) --}}
                                @php $deleteUrl = url('/admin/menu/destroy/' . ($menu->id ?? ($menu->ProductID ?? ''))); @endphp
                                <button type="button" class="btn-table-action btn-delete" onclick="showDeleteAlert('{{ $deleteUrl }}', '{{ addslashes($menu->NamaKopi) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            @if(isset($menu->image) && file_exists(public_path('images/products/' . $menu->image)))
                                <img src="{{ asset('images/products/' . $menu->image) }}" class="menu-img-preview" alt="img">
                            @else
                                <div class="menu-img-preview" style="display:flex; align-items:center; justify-content:center; font-size:10px; color:rgba(212,175,55,0.2); background: rgba(255,255,255,0.05);">No Img</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream); font-size: 1rem;">{{ $menu->NamaKopi }}</div>
                            <div style="font-size: 0.7rem; color: var(--gold);">#PROD-{{ str_pad($menu->id ?? ($menu->ProductID ?? $loop->iteration), 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                            @php $kat = strtoupper($menu->Category ?? getCategory($menu->NamaKopi)); @endphp
                            <span class="cat-badge badge-{{ $kat }}">{{ $kat }}</span>
                        </td>
                        <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($menu->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted-c); padding: 3rem;">Belum ada menu yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="nongki-modal-overlay" id="modalMenu">
    <div class="nongki-modal-box">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h2 id="modalTitle" style="color:var(--gold); font-family:'Cormorant Garamond', serif; margin:0; font-size:1.8rem;">Tambah Menu</h2>
            <button type="button" id="closeFormBtn" style="background:none; border:none; color:var(--text-muted-c); font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <form id="menuForm" action="{{ url('/admin/menu/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>

            <div style="margin-bottom:1.5rem; text-align: left;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Nama Menu</label>
                <input type="text" name="NamaKopi" id="in_nama" required class="form-input" placeholder="Contoh: Espresso Matcha">
            </div>

            <div style="margin-bottom:1.5rem; text-align: left;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Harga (Rp)</label>
                <input type="number" name="Harga" id="in_harga" required class="form-input" placeholder="15000">
            </div>

            <div style="margin-bottom:1.5rem; text-align: left;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Kategori</label>
                <select name="Category" id="in_kategori" class="form-input" style="background:var(--dark);">
                    <option value="KOPI">KOPI</option>
                    <option value="NON-KOPI">NON-KOPI</option>
                    <option value="MAKANAN">MAKANAN</option>
                </select>
            </div>

            <div style="margin-bottom:2rem; text-align: left;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Foto Menu</label>
                <input type="file" name="Image" accept="image/*" class="form-input" style="color:var(--text-muted-c);">
            </div>

            <div style="display:flex; gap:15px;">
                <button type="button" id="cancelFormBtn" style="flex:1; background:transparent; border:1px solid rgba(212,175,55,0.2); color:var(--text-muted-c); padding:12px; border-radius:12px; cursor:pointer;">Batal</button>
                <button type="submit" style="flex:2; background:var(--gold); color:var(--dark); border:none; padding:12px; border-radius:12px; cursor:pointer; font-weight:800;">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<div class="nongki-modal-overlay" id="deleteAlertModal">
    <div class="nongki-modal-box" style="text-align: center;">
        <div class="modal-icon-danger"><i class="fa-solid fa-exclamation-triangle"></i></div>
        <h3 style="color: #f0ece3; margin-bottom: 0.8rem; font-weight: 700; font-size: 1.3rem;">Hapus Produk?</h3>
        <p style="color: rgba(240, 236, 227, 0.7); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus <strong id="deleteMenuName" style="color: var(--gold);"></strong> dari inventaris?
        </p>
        
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-btn-group">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeDeleteAlert()">Batal</button>
                <button type="submit" class="modal-btn modal-btn-danger">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formModal = document.getElementById('modalMenu');
        const deleteModal = document.getElementById('deleteAlertModal');
        const form = document.getElementById('menuForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        // Buka form tambah
        document.getElementById('triggerTambah').onclick = () => {
            modalTitle.innerText = "Tambah Menu Baru";
            form.action = "{{ url('/admin/menu/store') }}";
            methodField.innerHTML = "";
            form.reset();
            formModal.classList.add('active');
        };

        // Buka form edit
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.onclick = function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const harga = this.getAttribute('data-harga');
                const kategori = this.getAttribute('data-kategori');

                modalTitle.innerText = "Edit Menu NONGKI";
                form.action = `/admin/menu/update/${id}`; 
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                document.getElementById('in_nama').value = nama;
                document.getElementById('in_harga').value = harga;
                
                const catDropdown = document.getElementById('in_kategori');
                if(kategori) {
                    const option = Array.from(catDropdown.options).find(opt => opt.value.toUpperCase() === kategori.toUpperCase());
                    if(option) option.selected = true;
                }
                formModal.classList.add('active');
            };
        });

        // Tutup modal
        const closeForm = () => formModal.classList.remove('active');
        document.getElementById('closeFormBtn').onclick = closeForm;
        document.getElementById('cancelFormBtn').onclick = closeForm;

        // Klik di luar untuk menutup
        window.onclick = (e) => { 
            if (e.target == formModal) closeForm(); 
            if (e.target == deleteModal) closeDeleteAlert();
        }
    });

    // Custom Alert Delete
    function showDeleteAlert(actionUrl, menuName) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteMenuName').innerText = menuName;
        document.getElementById('deleteAlertModal').classList.add('active');
    }

    function closeDeleteAlert() {
        document.getElementById('deleteAlertModal').classList.remove('active');
    }
</script>
@endpush