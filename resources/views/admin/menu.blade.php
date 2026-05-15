@extends('layouts.admin')

@section('title', 'Menu Inventory — NONGKI')

@push('styles')
<style>
    /* ========== LUXURY THEME UI ========== */
    .menu-container { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .nongki-panel { 
        background: #0f0f0f; 
        border: 1px solid rgba(201, 168, 76, 0.2); 
        border-radius: 15px; 
        padding: 25px; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }

    .table-luxury { width: 100%; border-collapse: collapse; color: #fff; margin-top: 20px; }
    .table-luxury th { 
        color: var(--gold); font-size: 0.75rem; text-transform: uppercase; 
        letter-spacing: 1.5px; padding: 15px; border-bottom: 2px solid #222; text-align: left;
    }
    .table-luxury td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }

    .img-preview { 
        width: 60px; height: 60px; object-fit: cover; border-radius: 10px; 
        border: 1px solid var(--gold); box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .badge-cat {
        background: rgba(201, 168, 76, 0.1); color: var(--gold);
        border: 1px solid rgba(201, 168, 76, 0.3); padding: 5px 12px;
        border-radius: 6px; font-size: 0.65rem; font-weight: 700;
    }

    .btn-nongki {
        background: var(--gold); color: #000; border: none; padding: 10px 20px;
        border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s;
    }
    .btn-nongki:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(201, 168, 76, 0.4); }

    .btn-icon {
        background: rgba(255,255,255,0.05); color: #fff; border: 1px solid #333;
        width: 35px; height: 35px; border-radius: 8px; cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .btn-icon:hover { border-color: var(--gold); color: var(--gold); background: rgba(201, 168, 76, 0.1); }

    .modal-nongki {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.85); backdrop-filter: blur(5px);
    }
    .modal-content {
        background: #1a1a1a; margin: 5% auto; padding: 30px; border: 1px solid var(--gold);
        width: 450px; border-radius: 20px; color: #fff; position: relative;
    }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.8rem; color: var(--gold); margin-bottom: 8px; }
    .form-control {
        width: 100%; background: #000; border: 1px solid #333; padding: 12px;
        border-radius: 10px; color: #fff; outline: none;
    }
    .form-control:focus { border-color: var(--gold); }
</style>
@endpush

@section('content')
<div class="menu-container">
    <div style="margin-bottom: 30px;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; color: var(--gold); margin: 0;">Menu Inventory</h1>
        <p style="color: #888;">Atur koleksi produk aktif di NONGKI.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(201,168,76,0.1); border: 1px solid var(--gold); color: var(--gold); padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="nongki-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <button class="btn-nongki" onclick="openModal('add')">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </button>
            <span style="color: #666; font-size: 0.85rem;">Total: {{ $products->count() }} Produk</span>
        </div>

        <table class="table-luxury">
            <thead>
                <tr>
                    <th style="width: 100px;">Aksi</th>
                    <th style="width: 100px;">Preview</th>
                    <th>Informasi Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="btn-icon" onclick="editProduct({{ json_encode($p) }})">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                            <form action="{{ route('admin.menu.destroy', $p->ProductID) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                    <td>
                        @if($p->Gambar)
                            <img src="{{ asset('storage/'.$p->Gambar) }}" class="img-preview">
                        @else
                            <div class="img-preview" style="display: flex; align-items: center; justify-content: center; background: #222;">
                                <i class="fa-solid fa-image" style="color: #444;"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1rem;">{{ $p->NamaProduk }}</div>
                        <div style="font-size: 0.7rem; color: var(--gold); letter-spacing: 1px;">#PROD-{{ $p->ProductID }}</div>
                    </td>
                    <td><span class="badge-cat">{{ $p->Kategori }}</span></td>
                    <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($p->Harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ========== MODAL FORM ========== -->
<div id="productModal" class="modal-nongki">
    <div class="modal-content">
        <h2 id="modalTitle" style="color: var(--gold); font-family: 'Cormorant Garamond', serif; margin-top: 0;">Tambah Produk</h2>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="NamaProduk" id="formNama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="Kategori" id="formKategori" class="form-control" required>
                    <option value="KOPI">KOPI</option>
                    <option value="NON-KOPI">NON-KOPI</option>
                    <option value="MAKANAN">MAKANAN</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="Harga" id="formHarga" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="Gambar" class="form-control">
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn-nongki" style="flex: 1;">Simpan Produk</button>
                <button type="button" class="btn-icon" style="width: auto; padding: 0 20px;" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('productModal');
    const form = document.getElementById('productForm');

    function openModal(type) {
        form.reset();
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
        form.action = "{{ route('admin.menu.store') }}";
        modal.style.display = 'block';
    }

    function editProduct(data) {
        document.getElementById('modalTitle').innerText = 'Edit Produk';
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        
        // Menggunakan URL dinamis yang lebih aman
        let updateUrl = "{{ route('admin.menu.update', ':id') }}";
        form.action = updateUrl.replace(':id', data.ProductID);
        
        document.getElementById('formNama').value = data.NamaProduk;
        document.getElementById('formKategori').value = data.Kategori;
        document.getElementById('formHarga').value = data.Harga;
        modal.style.display = 'block';
    }

    function closeModal() { modal.style.display = 'none'; }
    window.onclick = (event) => { if (event.target == modal) closeModal(); }
</script>
@endsection
