@extends('layouts.admin')

@section('title', 'Manajemen Menu — NONGKI')

@push('styles')
<style>
    :root {
        --gold: #D4AF37;
        --dark: #0A0A0A;
        --dark-2: #141414;
        --border: rgba(212, 175, 55, 0.2);
        --cream: #F5F5DC;
        --text-muted-c: #A0A0A0;
    }

    /* Animasi & Layout */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    .menu-management-container { padding: 5px; }

    .menu-action-bar {
        display: flex; align-items: center; gap: 20px; margin: 25px 0;
        background: rgba(255, 255, 255, 0.02); padding: 15px 25px;
        border-radius: 16px; border: 1px solid var(--border);
    }

    .btn-add-menu {
        background: var(--gold); color: var(--dark); border: none;
        padding: 10px 20px; border-radius: 12px; font-weight: 700;
        cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px;
    }
    .btn-add-menu:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); }

    /* Premium Table */
    .menu-panel {
        background: var(--dark-2); border-radius: 24px;
        border: 1px solid var(--border); overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .nongki-table { width: 100%; border-collapse: collapse; color: var(--cream); }
    .nongki-table th {
        background: rgba(212, 175, 55, 0.05); color: var(--gold);
        text-align: left; padding: 18px 25px; font-size: 0.75rem;
        text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--border);
    }
    .nongki-table td { padding: 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
    .nongki-table tbody tr:hover { background: rgba(212, 175, 55, 0.03); }

    .menu-img-preview { width: 55px; height: 55px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border); background: #1a1a1a; }

    /* Action Buttons */
    .action-btns { display: flex; gap: 8px; }
    .btn-table-action {
        width: 35px; height: 35px; border-radius: 10px; border: 1px solid var(--border);
        background: rgba(255,255,255,0.03); color: white; cursor: pointer; transition: 0.3s;
    }
    .btn-edit:hover { background: #3b82f6; border-color: #3b82f6; }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; }

    /* Badges */
    .cat-badge { padding: 4px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
    .badge-KOPI { background: rgba(212, 175, 55, 0.1); color: var(--gold); border: 1px solid var(--border); }
    .badge-MAKANAN { background: rgba(52, 211, 153, 0.1); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-NON-KOPI { background: rgba(96, 165, 250, 0.1); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.2); }

    /* Premium Modal Styles */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.3s ease;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: var(--dark-2); border: 1px solid var(--border); border-radius: 24px;
        padding: 2.5rem; width: 90%; max-width: 450px;
        transform: translateY(20px) scale(0.95); transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }

    .modal-icon-danger { 
        width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        background: rgba(224,82,82,0.1); color: #e05252; border: 1px solid rgba(224,82,82,0.3);
    }
</style>
@endpush

@section('content')
<div class="menu-management-container fade-in-up">
    <div class="dashboard-header">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Menu Inventory</h1>
        <p style="color: var(--text-muted-c);">Atur koleksi produk aktif di NONGKI.</p>
    </div>

    <div class="menu-action-bar">
        <button class="btn-add-menu" id="triggerTambah">
            <i class="fa-solid fa-plus-circle"></i> Tambah Produk Baru
        </button>
        <div style="color: var(--text-muted-c); font-size: 0.85rem; border-left: 1px solid var(--border); padding-left: 1.5rem;">
            Total: <strong>{{ $products->count() }} Produk</strong>
        </div>
    </div>

    <div class="menu-panel">
        <div style="overflow-x: auto;">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Aksi</th>
                        <th style="width: 80px;">Preview</th>
                        <th>Informasi Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>
                            <div class="action-btns">
                                <button class="btn-table-action btn-edit" 
                                    data-id="{{ $p->ProductID }}"
                                    data-nama="{{ $p->NamaKopi }}"
                                    data-harga="{{ $p->Harga }}"
                                    data-kategori="{{ $p->Category }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" class="btn-table-action btn-delete" 
                                    onclick="confirmNongkiDelete('{{ $p->ProductID }}', '{{ addslashes($p->NamaKopi) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <img src="{{ asset('images/products/' . ($p->image ?? 'default.jpg')) }}" class="menu-img-preview" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream);">{{ $p->NamaKopi }}</div>
                            <div style="font-size: 0.7rem; color: var(--gold);">#PROD-{{ str_pad($p->ProductID, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td><span class="cat-badge badge-{{ $p->Category ?? 'KOPI' }}">{{ $p->Category ?? 'KOPI' }}</span></td>
                        <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($p->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center; padding: 3rem;">Belum ada data menu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalMenu" class="nongki-modal-overlay">
    <div class="nongki-modal-box">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h2 id="modalTitle" style="color:var(--gold); font-family:'Cormorant Garamond', serif; margin:0;">Tambah Menu</h2>
            <button type="button" id="closeBtn" style="background:none; border:none; color:var(--text-muted-c); font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        <form id="menuForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            <div style="margin-bottom:1.2rem;">
                <label style="color:var(--gold); font-size:0.8rem; display:block; margin-bottom:5px;">NAMA MENU</label>
                <input type="text" name="NamaKopi" id="in_nama" required style="width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); color:white; padding:10px; border-radius:10px;">
            </div>
            <div style="margin-bottom:1.2rem;">
                <label style="color:var(--gold); font-size:0.8rem; display:block; margin-bottom:5px;">HARGA (RP)</label>
                <input type="number" name="Harga" id="in_harga" required style="width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); color:white; padding:10px; border-radius:10px;">
            </div>
            <div style="margin-bottom:1.2rem;">
                <label style="color:var(--gold); font-size:0.8rem; display:block; margin-bottom:5px;">KATEGORI</label>
                <select name="Category" id="in_kategori" style="width:100%; background:var(--dark); border:1px solid var(--border); color:white; padding:10px; border-radius:10px;">
                    <option value="KOPI">KOPI</option>
                    <option value="NON-KOPI">NON-KOPI</option>
                    <option value="MAKANAN">MAKANAN</option>
                </select>
            </div>
            <div style="margin-bottom:2rem;">
                <label style="color:var(--gold); font-size:0.8rem; display:block; margin-bottom:5px;">FOTO PRODUK</label>
                <input type="file" name="Image" style="color:var(--text-muted-c); font-size:0.8rem;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" id="cancelBtn" style="flex:1; background:transparent; border:1px solid var(--border); color:var(--text-muted-c); padding:12px; border-radius:12px; cursor:pointer;">Batal</button>
                <button type="submit" style="flex:2; background:var(--gold); color:var(--dark); border:none; padding:12px; border-radius:12px; font-weight:800; cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteAlertModal" class="nongki-modal-overlay">
    <div class="nongki-modal-box" style="max-width:380px; text-align:center;">
        <div class="modal-icon-danger"><i class="fa-solid fa-trash-can"></i></div>
        <h3 style="color:var(--cream); margin-bottom:10px;">Hapus Menu?</h3>
        <p style="color:var(--text-muted-c); font-size:0.9rem; margin-bottom:2rem;">Yakin ingin menghapus <strong id="deleteMenuName" style="color:var(--gold);"></strong>?</p>
        <form id="finalDeleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div style="display:flex; gap:10px;">
                <button type="button" onclick="closeDeleteModal()" style="flex:1; background:rgba(255,255,255,0.05); color:white; border:none; padding:12px; border-radius:10px; cursor:pointer;">Batal</button>
                <button type="submit" style="flex:1; background:#e05252; color:white; border:none; padding:12px; border-radius:10px; font-weight:700; cursor:pointer;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmNongkiDelete(id, name) {
        const modal = document.getElementById('deleteAlertModal');
        document.getElementById('finalDeleteForm').action = `/admin/menu/destroy/${id}`;
        document.getElementById('deleteMenuName').innerText = name;
        modal.classList.add('active');
    }
    function closeDeleteModal() { document.getElementById('deleteAlertModal').classList.remove('active'); }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalMenu');
        const form = document.getElementById('menuForm');
        
        document.getElementById('triggerTambah').onclick = () => {
            document.getElementById('modalTitle').innerText = "Tambah Menu Baru";
            form.action = "{{ route('admin.menu.store') }}";
            document.getElementById('methodField').innerHTML = "";
            form.reset();
            modal.classList.add('active');
        };

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.onclick = function() {
                const id = this.dataset.id;
                document.getElementById('modalTitle').innerText = "Edit Menu NONGKI";
                form.action = `/admin/menu/update/${id}`; 
                document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                document.getElementById('in_nama').value = this.dataset.nama;
                document.getElementById('in_harga').value = this.dataset.harga;
                document.getElementById('in_kategori').value = this.dataset.kategori;
                modal.classList.add('active');
            };
        });

        document.getElementById('closeBtn').onclick = () => modal.classList.remove('active');
        document.getElementById('cancelBtn').onclick = () => modal.classList.remove('active');
        window.onclick = (e) => { 
            if (e.target.classList.contains('nongki-modal-overlay')) {
                e.target.classList.remove('active');
            }
        };
    });
</script>
@endpush