@extends('layouts.admin')

@section('title', 'Manajemen Menu — NONGKI')

@push('styles')
<style>
    /* Global Variables */
    :root {
        --gold: #D4AF37;
        --dark: #0A0A0A;
        --dark-2: #141414;
        --border: rgba(212, 175, 55, 0.2);
        --cream: #F5F5DC;
        --text-muted-c: #A0A0A0;
    }

    .no-spinner::-webkit-inner-spin-button, 
    .no-spinner::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    .no-spinner { -moz-appearance: textfield; }

    .nongki-table tbody tr {
        transition: all 0.3s ease;
    }
    .nongki-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.03);
    }

    .cat-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-KOPI { background: rgba(212, 175, 55, 0.1); color: var(--gold); border: 1px solid var(--border); }
    .badge-MAKANAN { background: rgba(52, 211, 153, 0.1); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.2); }
    .badge-NON-KOPI { background: rgba(96, 165, 250, 0.1); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.2); }

    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    .menu-management-container { padding: 5px; }

    .menu-action-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        margin: 25px 0;
        background: rgba(255, 255, 255, 0.02);
        padding: 15px 25px;
        border-radius: 16px;
        border: 1px solid var(--border);
    }

    .btn-add-menu {
        background: var(--gold);
        color: var(--dark);
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add-menu:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); }

    .menu-panel {
        background: var(--dark-2);
        border-radius: 24px;
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .nongki-table {
        width: 100%;
        border-collapse: collapse;
        color: var(--cream);
    }

    .nongki-table th {
        background: rgba(212, 175, 55, 0.05);
        color: var(--gold);
        text-align: left;
        padding: 18px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }

    .nongki-table td {
        padding: 20px 25px;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
    }

    .menu-img-preview {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid var(--border);
        background: #1a1a1a;
    }

    .action-btns { display: flex; gap: 8px; }
    .btn-table-action {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: rgba(255,255,255,0.03);
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-edit:hover { background: #3b82f6; border-color: #3b82f6; }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; }
</style>
@endpush

@section('content')
@php
    // 1. Ambil data langsung dari tabel products
    $menus = \Illuminate\Support\Facades\DB::table('products')->where('IsDeleted', 0)->get();

    // 2. Helper Kategori (Karna di DB products belum ada kolom kategori)
    function getCategory($name) {
        $name = strtolower($name);
        $kopi = ['americano', 'coffee', 'macchiato', 'latte', 'aren', 'pandan'];
        $makanan = ['macaroni', 'katsu', 'crispy', 'fries', 'noodles', 'noodle'];
        
        foreach($kopi as $k) { if(strpos($name, $k) !== false) return 'kopi'; }
        foreach($makanan as $m) { if(strpos($name, $m) !== false) return 'makanan'; }
        return 'non-kopi';
    }
@endphp

<div class="menu-management-container fade-in-up">
    <div class="dashboard-header">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">Menu Inventory</h1>
        <p style="color: var(--text-muted-c);">Atur total koleksi produk aktif di NONGKI.</p>
    </div>

    <div class="menu-action-bar">
        <button class="btn-add-menu" id="triggerTambah">
            <i class="fa-solid fa-plus-circle"></i> Tambah Produk Baru
        </button>
        <div style="color: var(--text-muted-c); font-size: 0.85rem; border-left: 1px solid var(--border); padding-left: 1.5rem;">
            Total: <strong>{{ $products->count() }} Produk</strong>
            Total: <strong>{{ count($menus) }} Produk</strong>
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
                    @foreach($menus as $menu)
                    <tr>
                        <td>
                            <div class="action-btns">
                                {{-- Tombol Edit dengan Data Attributes --}}
                                <button class="btn-table-action btn-edit" 
                                    data-id="{{ $p->ProductID }}"
                                    data-nama="{{ $p->NamaKopi }}"
                                    data-harga="{{ $p->Harga }}"
                                    data-kategori="{{ $p->Category }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                
                                <form action="{{ route('admin.menu.destroy', $p->ProductID) }}" method="POST" onsubmit="return confirm('Hapus menu {{ $p->NamaKopi }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        <td>
                            @if($p->image && file_exists(public_path('images/products/' . $p->image)))
                                <img src="{{ asset('images/products/' . $p->image) }}" class="menu-img-preview" alt="img">
                            @else
                                <div class="menu-img-preview" style="display:flex; align-items:center; justify-content:center; font-size:10px; color:var(--border); background: rgba(255,255,255,0.05);">
                                    No Img
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream); font-size: 1rem; text-transform: capitalize;">{{ $p->NamaKopi }}</div>
                            <div style="font-size: 0.7rem; color: var(--gold); opacity: 0.8;">#PROD-{{ str_pad($p->ProductID, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                            <span class="cat-badge badge-{{ $p->Category ?? 'KOPI' }}">
                                {{ $p->Category ?? 'KOPI' }}
                            </span>
                        </td>
                        <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($p->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted-c); padding: 3rem;">Belum ada data menu di database.</td>
                            <img src="{{ asset('images/products/' . $menu->image) }}" class="menu-img-preview" onerror="this.src='https://placehold.co/100x100?text=Menu'">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream); font-size: 1rem;">{{ $menu->NamaKopi }}</div>
                            <div style="font-size: 0.7rem; color: var(--gold);">#PROD-{{ str_pad($menu->id ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td><span class="cat-badge badge-kopi">{{ getCategory($menu->NamaKopi) }}</span></td>
                        <td style="font-weight: 800; color: var(--gold);">Rp {{ number_format($menu->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal (Satu Modal untuk Tambah & Edit) -->
<div id="modalMenu" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.85); backdrop-filter: blur(5px); z-index: 9999;">
    <div style="background:var(--dark-2); margin:5% auto; padding:2.5rem; border:1px solid var(--gold); border-radius:24px; width:450px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h2 id="modalTitle" style="color:var(--gold); font-family:'Cormorant Garamond', serif; margin:0; font-size:1.8rem;">Tambah Menu Baru</h2>
            <button type="button" id="closeBtn" style="background:none; border:none; color:var(--text-muted-c); font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <form id="menuForm" action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div> {{-- Tempat Inject @method('PUT') --}}

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Nama Menu</label>
                <input type="text" name="NamaKopi" id="in_nama" required placeholder="Contoh: Espresso Matcha" style="width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); color:white; padding:12px; border-radius:12px; outline:none;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Harga (Rp)</label>
                <input type="number" name="Harga" id="in_harga" required placeholder="15000" class="no-spinner" style="width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); color:white; padding:12px; border-radius:12px; outline:none;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Kategori</label>
                <select name="Category" id="in_kategori" style="width:100%; background:var(--dark); border:1px solid var(--border); color:white; padding:12px; border-radius:12px; outline:none;">
                    <option value="KOPI">KOPI</option>
                    <option value="NON-KOPI">NON-KOPI</option>
                    <option value="MAKANAN">MAKANAN</option>
                </select>
            </div>

            <div style="margin-bottom:2rem;">
                <label style="color:var(--gold); display:block; font-size:0.8rem; text-transform:uppercase; margin-bottom:8px;">Foto Menu</label>
                <input type="file" name="Image" accept="image/*" style="width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--border); color:var(--text-muted-c); padding:12px; border-radius:12px; outline:none;">
                <small style="color: var(--text-muted-c); font-size: 0.7rem; display: block; margin-top: 5px;">*Biarkan kosong jika tidak ingin mengubah gambar</small>
            </div>

            <div style="display:flex; gap:15px;">
                <button type="button" id="cancelBtn" style="flex:1; background:transparent; border:1px solid var(--border); color:var(--text-muted-c); padding:12px; border-radius:12px; cursor:pointer;">Batal</button>
                <button type="submit" id="submitBtn" style="flex:2; background:var(--gold); color:var(--dark); border:none; padding:12px; border-radius:12px; cursor:pointer; font-weight:800;">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalMenu');
        const form = document.getElementById('menuForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        
        const btnTambah = document.getElementById('triggerTambah');
        const closeBtn = document.getElementById('closeBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        // Handler Tambah
        btnTambah.onclick = () => {
            modalTitle.innerText = "Tambah Menu Baru";
            form.action = "{{ route('admin.menu.store') }}";
            methodField.innerHTML = "";
            form.reset();
            modal.style.display = "block";
        };

        // Handler Edit
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.onclick = function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const harga = this.getAttribute('data-harga');
                const kategori = this.getAttribute('data-kategori');

                modalTitle.innerText = "Edit Menu NONGKI";
                form.action = `/admin/menu/${id}`; 
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                document.getElementById('in_nama').value = nama;
                document.getElementById('in_harga').value = harga;
                document.getElementById('in_kategori').value = kategori;
                
                modal.style.display = "block";
            };
        });

        const closeModal = () => modal.style.display = "none";
        closeBtn.onclick = closeModal;
        cancelBtn.onclick = closeModal;
        window.onclick = (e) => { if (e.target == modal) closeModal(); }
    });
</script>
@endpush