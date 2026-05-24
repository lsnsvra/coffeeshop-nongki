@extends('layouts.admin')

@section('title', 'Atur Komposisi Resep — NONGKI')

@push('styles')
<style>
    /* ========== LUXURY PALETTE (KONSISTEN DF94B9) ========== */
    :root {
        --bg-main: #000000;
        --bg-panel: #111111;
        --gold: #d4af37;
        --gold-dim: rgba(212, 175, 55, 0.1); 
        --bronze: #a87b4f; /* Coklat Manajemen Pengguna */
        --text-main: #f8f9fa;
        --text-muted: #a0a0a0;
        --border-color: #2a2a2a;
        --danger: #ff4757;
    }

    body { background-color: var(--bg-main); color: var(--text-main); }
    .fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== HEADER MENU CARD ========== */
    .menu-info-card {
        background: var(--bg-panel);
        border: 1px solid var(--gold);
        border-radius: 16px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.05);
    }
    .menu-info-card img {
        width: 70px; height: 70px; border-radius: 10px; object-fit: cover;
        border: 2px solid var(--gold);
    }
    .menu-info-card h1 { font-size: 1.8rem; margin: 0; color: #fff; font-weight: 800; }
    .menu-badge { background: var(--gold-dim); color: var(--gold); padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }

    /* ========== PANEL LAYOUT ========== */
    .resep-grid { display: grid; grid-template-columns: 380px 1fr; gap: 1.5rem; align-items: start; }
    .resep-panel { 
        background: var(--bg-panel); border: 1px solid var(--border-color); 
        border-radius: 16px; padding: 22px; box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }
    .panel-title { font-size: 1.1rem; color: var(--gold); margin: 0 0 1.5rem 0; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px; }

    /* ========== FORM ELEMENTS ========== */
    .nongki-label { color: var(--gold); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px; }
    .nongki-input, .nongki-select {
        width: 100%; background: #000; border: 1px solid var(--border-color);
        color: white; padding: 12px; border-radius: 10px; outline: none; font-size: 0.85rem; transition: 0.3s;
    }
    .nongki-input:focus, .nongki-select:focus { border-color: var(--gold); }

    .btn-submit-resep {
        background: var(--gold); color: #000; border: none; padding: 12px; 
        border-radius: 10px; font-weight: 800; cursor: pointer; transition: 0.3s;
        width: 100%; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 10px;
    }
    .btn-submit-resep:hover { transform: translateY(-2px); background: #f1c40f; }

    /* ========== TABLE COMPOSITION ========== */
    .resep-table { width: 100%; border-collapse: collapse; }
    .resep-table th { padding: 12px; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: var(--gold); border-bottom: 2px solid var(--border-color); }
    .resep-table td { padding: 14px 12px; border-bottom: 1px solid var(--border-color); font-size: 0.9rem; }

    .btn-delete-item {
        width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--border-color);
        background: transparent; color: var(--bronze); display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: 0.3s;
    }
    .btn-delete-item:hover { border-color: var(--danger); color: var(--danger); background: rgba(255, 71, 87, 0.05); }

    .btn-back {
        color: var(--text-muted); text-decoration: none; font-size: 0.85rem; border: 1px solid var(--border-color);
        padding: 8px 16px; border-radius: 10px; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-back:hover { border-color: var(--gold); color: var(--gold); }
</style>
@endpush

@section('content')
<div class="fade-in">
    {{-- MENU HEADER CARD --}}
    <div class="menu-info-card">
        <div>
            @if($product->image)
                <img src="{{ asset('images/products/' . $product->image) }}" alt="Menu Image">
            @else
                <div style="width: 70px; height: 70px; background: #000; border-radius: 10px; display:flex; align-items:center; justify-content:center; border: 2px solid var(--gold);"><i class="fa-solid fa-mug-hot" style="color:var(--gold); font-size: 1.5rem;"></i></div>
            @endif
        </div>
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h1 style="font-family: 'Cormorant Garamond', serif;">{{ $product->NamaKopi }}</h1>
                <span class="menu-badge">{{ $product->Category }}</span>
            </div>
            <p style="color: var(--text-muted); margin: 4px 0 0 0; font-size: 0.9rem;">ID Menu: #{{ $product->ProductID }} | Harga Jual: <strong style="color: var(--gold);">Rp {{ number_format($product->Harga, 0, ',', '.') }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.menu') }}" class="btn-back"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
        </div>
    </div>

    <div class="resep-grid">
        {{-- FORM INPUT (LEFT) --}}
        <div class="resep-panel">
            <h3 class="panel-title"><i class="fa-solid fa-flask"></i> Tambah Komposisi</h3>
            <form action="{{ route('admin.resep.store', $product->ProductID) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label class="nongki-label">Pilih Bahan Baku</label>
                    <select name="MaterialID" class="nongki-select" required>
                        <option value="" disabled selected>-- Cari Bahan di Stok --</option>
                        @foreach($materials as $m)
                            <option value="{{ $m->id ?? $m->MaterialID }}">{{ $m->nama_bahan ?? $m->NamaMaterial }} ({{ $m->satuan ?? $m->Unit }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="nongki-label">Takaran Dibutuhkan</label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="number" step="0.01" name="QuantityNeeded" class="nongki-input" placeholder="0.00" required>
                        <span style="font-size: 0.8rem; color: var(--gold); font-weight: 700; white-space: nowrap;">Gram / Ml</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit-resep"><i class="fa-solid fa-plus-circle"></i> Simpan ke Resep</button>
            </form>
        </div>

        {{-- LIST TABLE (RIGHT) --}}
        <div class="resep-panel">
            <h3 class="panel-title"><i class="fa-solid fa-list-check"></i> Rincian Bahan / BOM</h3>
            <div style="overflow-x: auto;">
                <table class="resep-table">
                    <thead>
                        <tr>
                            <th>Bahan Baku</th>
                            <th>Takaran / Porsi</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->materials as $ing)
                        <tr>
                            <td style="font-weight: 700; color: #fff;">{{ $ing->nama_bahan ?? $ing->NamaMaterial }}</td>
                            <td><span style="color: var(--gold); font-weight: 800; font-size: 1.1rem;">{{ $ing->pivot->QuantityNeeded }}</span> <small style="color: var(--text-muted);">{{ $ing->satuan ?? $ing->Unit }}</small></td>
                            <td style="text-align: center;">
                                <form action="{{ route('admin.resep.destroy', [$product->ProductID, $ing->id ?? $ing->MaterialID]) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-delete-item" onclick="confirmDelete(this)"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 50px; color: var(--text-muted);">
                                <i class="fa-solid fa-circle-exclamation" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                Belum ada racikan resep untuk menu ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert Konfirmasi Hapus
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus dari resep?',
            text: "Bahan ini tidak akan digunakan lagi dalam komposisi menu.",
            icon: 'warning',
            showCancelButton: true,
            background: '#0a0a0a', color: '#fff',
            confirmButtonColor: '#ff4757', cancelButtonColor: '#2a2a2a',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
            border: '1px solid #d4af37'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    }

    // SweetAlert Notifikasi Sukses/Error
    @if(session('success'))
        Swal.fire({
            title: 'Sempurna!', text: "{{ session('success') }}", icon: 'success',
            background: '#0a0a0a', color: '#fff', confirmButtonColor: '#d4af37', timer: 3000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Ups!', text: "{{ session('error') }}", icon: 'error',
            background: '#0a0a0a', color: '#fff', confirmButtonColor: '#d4af37'
        });
    @endif
</script>
@endpush