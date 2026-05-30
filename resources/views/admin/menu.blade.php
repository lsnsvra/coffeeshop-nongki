@extends('layouts.admin')

@section('title', 'Menu Inventory — NONGKI')

@push('styles')
<style>

    /* ==========================================
   MENU INVENTORY LIGHT MODE PREMIUM
========================================== */

[data-theme="light"]{
    --bg-panel:#FFFFFF;
    --text-main:#2F241B;
    --text-muted:#6B7280;
    --border-color:#E8E2D8;
}

/* PAGE */

[data-theme="light"] .menu-container{
    color:#2F241B !important;
}

/* PANEL */

[data-theme="light"] .nongki-panel{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.05) !important;
}

/* TABLE */

[data-theme="light"] .table-luxury{
    color:#2F241B !important;
}

[data-theme="light"] .table-luxury th{
    color:#B8860B !important;
    border-bottom:1px solid #ECE7DD !important;
}

[data-theme="light"] .table-luxury td{
    color:#2F241B !important;
    border-bottom:1px solid #F1ECE3 !important;
}

[data-theme="light"] .table-luxury tbody tr:hover{
    background:#FAF8F4 !important;
}

/* NAMA PRODUK */

[data-theme="light"] .table-luxury td div{
    color:#2F241B !important;
}

/* HARGA */

[data-theme="light"] .table-luxury td[style*="font-weight: 900"]{
    color:#2F241B !important;
}

/* USER LOG */

[data-theme="light"] .timestamp-box{
    color:#6B7280 !important;
}

[data-theme="light"] .timestamp-box div{
    color:#6B7280 !important;
}

[data-theme="light"] .timestamp-box div:last-child{
    color:#2F241B !important;
    border-top:1px solid #ECE7DD !important;
}

/* IMAGE */

[data-theme="light"] .img-preview{
    border:1px solid #E8E2D8 !important;
    background:#F8F6F2 !important;
}

/* BUTTON */

[data-theme="light"] .btn-icon{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
}

[data-theme="light"] .btn-icon:hover{
    border-color:#D4A437 !important;
}

[data-theme="light"] .btn-nongki{
    background:linear-gradient(
        135deg,
        #D4A437,
        #E6C147
    ) !important;

    color:#FFFFFF !important;
}

/* MODAL */

[data-theme="light"] .modal-content{
    background:#FFFFFF !important;
    color:#2F241B !important;
    border:1px solid #E8E2D8 !important;
}

[data-theme="light"] .form-control{
    background:#FFFFFF !important;
    color:#2F241B !important;
    border:1px solid #E8E2D8 !important;
}

[data-theme="light"] .form-control:focus{
    border-color:#D4A437 !important;
    box-shadow:0 0 0 3px rgba(212,164,55,.12);
}

    /* ========== LUXURY THEME UI - NONGKI OFFICIAL ========== */
    :root {
        --gold: #d4af37;
        --gold-dim: rgba(212, 175, 55, 0.15);
        --bg-panel: #0f0f0f;
        --text-main: #f8f9fa;
        --text-muted: #a0a0a0;
        --border-color: #2a2a2a;
    }

    .menu-container { animation: fadeIn 0.6s ease-out; color: var(--text-main); }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    .nongki-panel { 
        background: var(--bg-panel); 
        border: 1px solid var(--gold-dim); 
        border-radius: 20px; 
        padding: 30px; 
        box-shadow: 0 25px 50px rgba(0,0,0,0.7);
    }

    .table-luxury { width: 100%; border-collapse: collapse; margin-top: 20px; color: var(--text-main) !important; }
    .table-luxury th { 
        color: var(--gold) !important; font-size: 0.8rem; text-transform: uppercase; 
        letter-spacing: 1.5px; padding: 18px 15px; border-bottom: 2px solid var(--border-color); text-align: left;
    }
    .table-luxury td { padding: 18px 15px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }

    .img-preview { 
        width: 70px; height: 70px; object-fit: cover; border-radius: 14px; 
        border: 1px solid var(--gold); box-shadow: 0 5px 15px rgba(0,0,0,0.5); background: #222;
    }

    /* Styling Badge Kategori */
    .badge-cat {
        background: var(--gold-dim); color: var(--gold);
        border: 1px solid rgba(212, 175, 55, 0.3); padding: 6px 14px;
        border-radius: 10px; font-size: 0.7rem; font-weight: 800; letter-spacing: 1px;
        text-transform: uppercase;
    }

    .btn-nongki {
        background: var(--gold); color: #000; border: none; padding: 12px 24px;
        border-radius: 10px; font-weight: 800; cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-nongki:hover { transform: translateY(-3px); background: #f1c40f; }

    .btn-icon {
        background: rgba(255,255,255,0.03); color: var(--text-muted); border: 1px solid var(--border-color);
        width: 38px; height: 38px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
    }
    .btn-icon:hover { border-color: var(--gold); color: var(--gold); }

    .timestamp-box { font-size: 0.75rem; color: var(--text-muted); line-height: 1.6; }
    
    .modal-nongki {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.9); backdrop-filter: blur(10px);
    }
    .modal-content {
        background: #151515; margin: 5% auto; padding: 40px; border: 1px solid var(--gold);
        width: 100%; max-width: 480px; border-radius: 25px; color: var(--text-main);
    }
    .form-control {
        width: 100%; background: #000; border: 1px solid var(--border-color); padding: 14px;
        border-radius: 12px; color: #fff; outline: none; margin-top: 5px;

    }
    .form-control:focus { border-color: var(--gold); }
</style>
@endpush

@section('content')
<div class="menu-container">

    <div style="margin-bottom: 40px;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 3.2rem; color: var(--gold); margin: 0; font-weight: 700;">Menu Inventory</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Manajemen koleksi produk kopi, non-kopi, dan makanan.</p>
    </div>

    <div class="nongki-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <button class="btn-nongki" onclick="openModal()">
                <i class="fa-solid fa-plus"></i> Tambah Menu Baru
            </button>
            <span style="color: var(--text-muted);">
                Total: <strong style="color: var(--gold);">{{ $products->count() }}</strong> Items
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-luxury">
                <thead>
                    <tr>
                        <th style="width: 100px;">Aksi</th>
                        <th style="width: 100px;">Preview</th>
                        <th>Info Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Riwayat Log</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <button class="btn-icon" onclick="editProduct({{ json_encode($p) }})" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button class="btn-icon delete" style="color:#ff4757" onclick="confirmDelete('{{ $p->ProductID }}', '{{ addslashes($p->NamaKopi) }}')" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $p->ProductID }}" action="{{ route('admin.menu.destroy', $p->ProductID) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                        <td>
                            @if($p->image)
                                <img src="{{ asset('images/products/' . $p->image) }}" class="img-preview" onerror="this.src='{{ asset('storage/'.$p->image) }}'">
                            @else
                                <div class="img-preview" style="display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-image" style="color:#444"></i></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700; font-size: 1.1rem;">{{ $p->NamaKopi }}</div>
                            <div style="font-size: 0.75rem; color: var(--gold);">#ID-{{ $p->ProductID }}</div>
                        </td>
                        <td>
                            {{-- BERHASIL: Menampilkan Kategori sesuai Database --}}
                            <span class="badge-cat">{{ $p->Category ?? 'LAINNYA' }}</span>
                        </td>
                        <td style="font-weight: 900; color: var(--text-main); font-size: 1.1rem;">
                            Rp {{ number_format($p->Harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="timestamp-box">
                                <div><span style="color:var(--gold)">Created:</span> {{ $p->CreatedDate ? \Carbon\Carbon::parse($p->CreatedDate)->format('d/m/y H:i') : '-' }}</div>
                                <div><span style="color:var(--gold)">Updated:</span> {{ $p->LastUpdatedDate ? \Carbon\Carbon::parse($p->LastUpdatedDate)->format('d/m/y H:i') : '-' }}</div>
                                <div style="color: #fff; font-weight: bold; margin-top: 4px; border-top: 1px solid #333; padding-top: 4px;">
                                    <i class="fa-solid fa-user-pen" style="font-size: 0.65rem; color: var(--gold);"></i> 
                                    {{ $p->LastUpdatedBy ?? 'System' }}
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

<div id="productModal" class="modal-nongki">
    <div class="modal-content">
        <h2 id="modalTitle" style="color: var(--gold); font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; margin-top: 0; margin-bottom: 30px;">Tambah Produk</h2>

        <form id="productForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            

            <div style="margin-bottom: 20px;">
                <label style="color: var(--gold); font-size: 0.85rem; font-weight: 700;">Nama Kopi / Menu</label>
                <input type="text" name="NamaKopi" id="formNama" class="form-control" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--gold); font-size: 0.85rem; font-weight: 700;">Kategori</label>
                <select name="Category" id="formKategori" class="form-control" required>

                    <option value="KOPI">KOPI</option>
                    <option value="NON-KOPI">NON-KOPI</option>
                    <option value="MAKANAN">MAKANAN</option>
                </select>
            </div>


            <div style="margin-bottom: 20px;">
                <label style="color: var(--gold); font-size: 0.85rem; font-weight: 700;">Harga (Rp)</label>
                <input type="number" name="Harga" id="formHarga" class="form-control" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--gold); font-size: 0.85rem; font-weight: 700;">Upload Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div style="margin-top: 35px; display: flex; gap: 15px;">
                <button type="button" class="btn-icon" style="width: auto; padding: 0 25px; color: #fff;" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-nongki" style="flex: 1; justify-content: center;">Simpan Data</button>

            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const modal = document.getElementById('productModal');
    const form = document.getElementById('productForm');


    function openModal() {
        form.reset();
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('modalTitle').innerText = 'Tambah Produk';
        form.action = "{{ route('admin.menu.store') }}";
        modal.style.display = 'block';
    }

    function editProduct(data) {
        document.getElementById('modalTitle').innerText = 'Edit Produk';
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        let url = "{{ route('admin.menu.update', ':id') }}";
        form.action = url.replace(':id', data.ProductID);
        document.getElementById('formNama').value = data.NamaKopi;
        document.getElementById('formKategori').value = data.Category;
        document.getElementById('formHarga').value = data.Harga;
        modal.style.display = 'block';
    }

    function closeModal() { modal.style.display = 'none'; }
    window.onclick = (e) => { if(e.target == modal) closeModal(); }

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Menu?',
            html: `Yakin ingin menghapus <b>${name}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            background: '#151515', color: '#fff',
            confirmButtonColor: '#ff4757', cancelButtonColor: '#2a2a2a',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
        }).then((res) => { if (res.isConfirmed) document.getElementById('delete-form-' + id).submit(); });
    }

    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success',
            background: '#151515', color: '#fff', confirmButtonColor: '#d4af37'
        });
    @endif
</script>
@endsection