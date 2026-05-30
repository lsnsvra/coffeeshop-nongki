@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — NONGKI')

@push('styles')
<style>

/* ==========================================
   USER MANAGEMENT LIGHT MODE PREMIUM
========================================== */

[data-theme="light"] .user-panel{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.05);
}

/* HEADER */

[data-theme="light"] .dashboard-header h1{
    color:#C9A84C !important;
}

[data-theme="light"] .dashboard-header p{
    color:#6B7280 !important;
}

/* TABLE */

[data-theme="light"] .nongki-table{
    color:#2F241B !important;
}

[data-theme="light"] .nongki-table th{
    color:#B8860B !important;
    border-bottom:1px solid #ECE7DD !important;
}

[data-theme="light"] .nongki-table td{
    color:#2F241B !important;
    border-bottom:1px solid #F1ECE3 !important;
}

[data-theme="light"] .nongki-table tbody tr:hover{
    background:#FAF8F4 !important;
}

/* USER NAME */

[data-theme="light"] .main-name{
    color:#2F241B !important;
}

/* EMAIL */

[data-theme="light"] td[style*="#ccc"]{
    color:#6B7280 !important;
}

/* AVATAR */

[data-theme="light"] .avatar-circle{
    background:#F8F3E8 !important;
    border:2px solid #D4A437 !important;
    color:#D4A437 !important;
}

/* AUDIT */

[data-theme="light"] .audit-box{
    background:#FAF8F4 !important;
    color:#6B7280 !important;
    border-left:3px solid #D4A437 !important;
}

[data-theme="light"] .audit-box strong{
    color:#D4A437 !important;
}

/* DROPDOWN */

[data-theme="light"] .nongki-dropdown{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

[data-theme="light"] .role-select-custom{
    background:#FFFFFF !important;
    color:#2F241B !important;
    border:1px solid #E8E2D8 !important;
}

/* MODAL */

[data-theme="light"] .nongki-modal{
    background:#FFFFFF !important;
    border:1px solid #E8E2D8 !important;
}

[data-theme="light"] .nongki-modal h3{
    color:#2F241B !important;
}

[data-theme="light"] .nongki-modal p{
    color:#6B7280 !important;
}

[data-theme="light"] .btn-modal-cancel{
    background:#FFFFFF !important;
    color:#6B7280 !important;
    border:1px solid #E8E2D8 !important;
}

/* TOAST */

[data-theme="light"] .nongki-toast{
    background:#FFFFFF !important;
    border-color:#E8E2D8 !important;
    box-shadow:0 8px 24px rgba(0,0,0,.08);
}

[data-theme="light"] .toast-title{
    color:#2F241B !important;
}

[data-theme="light"] .toast-msg{
    color:#6B7280 !important;
}

    /* ========== LAYOUT & FONT RESET ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    .user-panel { 
        background: var(--dark-2); 
        border: 1px solid var(--border); 
        border-radius: 15px; 
        padding: 1.5rem; 
        margin-top: 1rem;
    }



    .nongki-table { width: 100%; border-collapse: collapse; color: #ffffff; }
    .nongki-table th { 
        text-align: left; padding: 15px; color: var(--gold); 
        font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid var(--border);
    }
    .nongki-table td { padding: 18px 15px; border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }


    /* ========== AUDIT TRAIL STYLE ========== */

    .info-wrapper { display: flex; flex-direction: column; gap: 4px; }
    .main-name { font-weight: 700; color: #ffffff; font-size: 1rem; }
    .audit-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 8px; }
    
    .audit-box {
        font-size: 0.75rem; 
        color: var(--text-muted-c); 
        background: rgba(255,255,255,0.03); 
        padding: 6px 10px; 
        border-radius: 6px;
        border-left: 2px solid var(--gold);
    }
    .audit-box strong { color: var(--gold); display: block; font-size: 0.65rem; text-transform: uppercase; }

    /* ========== DROPDOWN & ROLE ========== */
    .nongki-dropdown {
        display: none; position: absolute; left: 50px; top: 0;
        background: #1a1a1a; border: 1px solid var(--gold);
        border-radius: 12px; width: 200px; z-index: 1000;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5); padding: 10px 0;
    }

    .role-select-custom {
        background: #2a2a2a; color: #ffffff !important; border: 1px solid #444;
        border-radius: 8px; padding: 10px; font-size: 0.85rem; width: 90%; 
        margin: 0 auto; display: block; cursor: pointer;
    }


    /* ========== LUXURY ROLE DESIGN ========== */
    .badge-role {
        padding: 8px 16px; 
        border-radius: 12px; 
        font-size: 0.7rem; 
        font-weight: 900;
        display: inline-block;
        width: 110px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .bg-admin { 
        background: linear-gradient(135deg, #ff4d4d 0%, #b30000 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 0 15px rgba(255, 77, 77, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    

    .bg-kasir { 
        background: linear-gradient(135deg, #ffeb3b 0%, #fbc02d 100%) !important;
        color: #000000 !important;
        box-shadow: 0 0 15px rgba(255, 235, 59, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    

    .bg-pelanggan { 
        background: linear-gradient(135deg, #4caf50 0%, #1b5e20 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 0 15px rgba(76, 175, 80, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);

    }

    .avatar-circle {
        width: 45px; height: 45px; border-radius: 50%; background: var(--dark-4); 
        border: 2px solid var(--gold); display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: var(--gold); font-size: 1rem;
    }

    /* ========== CUSTOM MODAL OVERLAY ========== */
    .nongki-modal-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .nongki-modal-overlay.active {
        opacity: 1; pointer-events: all;
    }

    .nongki-modal {
        background: #111;
        border: 1px solid var(--gold);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        width: 100%; max-width: 400px;
        text-align: center;
        box-shadow: 0 0 60px rgba(201, 168, 76, 0.15);
        transform: translateY(20px) scale(0.97);
        transition: transform 0.25s ease;
        position: relative;
    }
    .nongki-modal-overlay.active .nongki-modal {
        transform: translateY(0) scale(1);
    }

    .nongki-modal .modal-icon {
        width: 64px; height: 64px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 1.2rem;
    }
    .modal-icon.icon-danger {
        background: rgba(255, 77, 77, 0.12);
        border: 1px solid rgba(255, 77, 77, 0.4);
        color: #ff4d4d;
    }
    .modal-icon.icon-success {
        background: rgba(139, 195, 74, 0.12);
        border: 1px solid rgba(139, 195, 74, 0.4);
        color: #8bc34a;
    }
    .modal-icon.icon-warning {
        background: rgba(201, 168, 76, 0.12);
        border: 1px solid rgba(201, 168, 76, 0.4);
        color: var(--gold);
    }

    .nongki-modal h3 {
        color: #fff; font-size: 1.2rem; font-weight: 700;
        margin: 0 0 0.5rem; font-family: 'Cormorant Garamond', serif;
        letter-spacing: 0.5px;
    }
    .nongki-modal p {
        color: #aaa; font-size: 0.875rem; margin: 0 0 1.8rem; line-height: 1.6;
    }
    .nongki-modal p span {
        color: var(--gold); font-weight: 700;
    }

    .modal-actions { display: flex; gap: 10px; justify-content: center; }

    .btn-modal {
        padding: 10px 24px; border-radius: 10px;
        font-size: 0.85rem; font-weight: 700; cursor: pointer;
        border: none; transition: all 0.2s ease; letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .btn-modal-cancel {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.15);
        color: #aaa;
    }
    .btn-modal-cancel:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .btn-modal-danger {
        background: linear-gradient(135deg, #ff4d4d, #b30000);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255,77,77,0.3);
    }
    .btn-modal-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,77,77,0.4); }
    .btn-modal-gold {
        background: linear-gradient(135deg, #c9a84c, #a07830);
        color: #000;
        box-shadow: 0 4px 15px rgba(201,168,76,0.3);
    }
    .btn-modal-gold:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(201,168,76,0.4); }

    /* ========== TOAST NOTIFIKASI ========== */
    .nongki-toast-wrap {
        position: fixed; top: 1.5rem; right: 1.5rem;
        z-index: 99999; display: flex; flex-direction: column; gap: 10px;
        pointer-events: none;
    }
    .nongki-toast {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 20px; border-radius: 14px;
        background: #111; border: 1px solid;
        min-width: 280px; max-width: 380px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        pointer-events: all;
        animation: toastIn 0.35s cubic-bezier(.22,1,.36,1) forwards;
    }
    .nongki-toast.hiding {
        animation: toastOut 0.3s ease forwards;
    }
    @keyframes toastIn {
        from { opacity: 0; transform: translateX(60px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes toastOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(60px); }
    }
    .nongki-toast.toast-success { border-color: rgba(139,195,74,0.5); }
    .nongki-toast.toast-danger  { border-color: rgba(255,77,77,0.5); }
    .nongki-toast.toast-warning { border-color: rgba(201,168,76,0.5); }

    .toast-icon {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1rem;
    }
    .toast-success .toast-icon { background: rgba(139,195,74,0.15); color: #8bc34a; }
    .toast-danger  .toast-icon { background: rgba(255,77,77,0.15);  color: #ff4d4d; }
    .toast-warning .toast-icon { background: rgba(201,168,76,0.15); color: var(--gold); }

    .toast-body { flex: 1; }
    .toast-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin-bottom: 2px; }
    .toast-msg   { color: #999; font-size: 0.78rem; line-height: 1.4; }

    .toast-close {
        background: none; border: none; color: #666;
        cursor: pointer; font-size: 1rem; padding: 0; line-height: 1;
        transition: color 0.2s;
    }
    .toast-close:hover { color: #fff; }

    .toast-progress {
        position: absolute; bottom: 0; left: 0; height: 3px;
        border-radius: 0 0 14px 14px;
        animation: toastProgress 4s linear forwards;
    }
    .toast-success .toast-progress { background: #8bc34a; }
    .toast-danger  .toast-progress { background: #ff4d4d; }
    .toast-warning .toast-progress { background: var(--gold); }
    @keyframes toastProgress { from { width: 100%; } to { width: 0; } }
    .nongki-toast { position: relative; overflow: hidden; }
</style>
@endpush

@section('content')


{{-- ===== TOAST CONTAINER ===== --}}
<div class="nongki-toast-wrap" id="toastWrap"></div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div class="nongki-modal-overlay" id="modalHapus">
    <div class="nongki-modal">
        <div class="modal-icon icon-danger">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3>Hapus Akun Pengguna</h3>
        <p>Anda akan menghapus akun <span id="modalNamaHapus">-</span>. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button class="btn-modal btn-modal-cancel" onclick="tutupModal('modalHapus')">Batal</button>
            <button class="btn-modal btn-modal-danger" id="btnKonfirmasiHapus">
                <i class="fa-solid fa-trash-can"></i> Ya, Hapus
            </button>
        </div>

    </div>
</div>


{{-- ===== MODAL KONFIRMASI TOGGLE STATUS ===== --}}
<div class="nongki-modal-overlay" id="modalToggle">
    <div class="nongki-modal">
        <div class="modal-icon icon-warning">
            <i class="fa-solid fa-power-off"></i>
        </div>
        <h3 id="modalToggleJudul">Ubah Status Akun</h3>
        <p id="modalTogglePesan">Anda akan mengubah status akun <span id="modalNamaToggle">-</span>.</p>
        <div class="modal-actions">
            <button class="btn-modal btn-modal-cancel" onclick="tutupModal('modalToggle')">Batal</button>
            <button class="btn-modal btn-modal-gold" id="btnKonfirmasiToggle">
                <i class="fa-solid fa-power-off"></i> Konfirmasi
            </button>
        </div>
    </div>
</div>

{{-- ===== KONTEN UTAMA ===== --}}
<div class="report-container fade-in-up">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; color: var(--gold); margin: 0;">User Management</h1>
        <p style="color: var(--text-muted-c); font-size: 1rem;">Otoritas akun dan jejak audit sistem NONGKI.</p>
    </div>


    <div class="user-panel">
        <table class="nongki-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">Aksi</th>
                    <th style="width: 80px;">Profil</th>
                    <th>Detail Pengguna & Audit Trail</th>
                    <th>Email</th>
                    <th>Hak Akses</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="fade-in-up">
                    <td style="position: relative; text-align: center;">
                        <button type="button" style="background: rgba(201,168,76,0.1); color: var(--gold); border: 1px solid var(--gold); padding: 8px; border-radius: 8px; cursor: pointer;" onclick="toggleDropdown(event, 'drop-{{ $user->UserID }}')">
                            <i class="fa-solid fa-gear"></i>
                        </button>

                        <div id="drop-{{ $user->UserID }}" class="nongki-dropdown" onclick="event.stopPropagation()">
                            <div style="color: var(--gold); font-size: 0.7rem; padding: 5px 15px; text-transform: uppercase;">Ubah Role</div>
                            <form action="{{ route('admin.user.update-role', $user->UserID) }}" method="POST">
                                @csrf

                                <select name="Role" onchange="konfirmasiUbahRole(this, '{{ addslashes($user->Nama) }}')" class="role-select-custom">

                                    <option value="ADMIN" {{ strtoupper($user->Role) == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                    <option value="KASIR" {{ strtoupper($user->Role) == 'KASIR' ? 'selected' : '' }}>Kasir</option>
                                    <option value="PELANGGAN" {{ strtoupper($user->Role) == 'PELANGGAN' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                            </form>
                            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 10px 0;"></div>


                            {{-- Form toggle status --}}
                            <form id="form-toggle-{{ $user->UserID }}" action="{{ route('admin.user.toggle-status', $user->UserID) }}" method="POST">
                                @csrf
                            </form>
                            <button type="button"
                                onclick="bukaModalToggle('{{ $user->UserID }}', '{{ addslashes($user->Nama) }}', {{ (int)$user->Status }})"
                                style="width: 100%; background: none; border: none; color: white; padding: 10px 15px; text-align: left; cursor: pointer; font-size: 0.8rem;">
                                <i class="fa-solid fa-power-off"></i> {{ (int)$user->Status === 1 ? 'Non-Aktifkan' : 'Aktifkan' }}
                            </button>

                            {{-- Form hapus --}}
                            <form id="form-hapus-{{ $user->UserID }}" action="{{ route('admin.user.destroy', $user->UserID) }}" method="POST">
                                @csrf @method('DELETE')

                            </form>
                            <button type="button"
                                onclick="bukaModalHapus('{{ $user->UserID }}', '{{ addslashes($user->Nama) }}')"
                                style="width: 100%; background: none; border: none; color: #ff4d4d; padding: 10px 15px; text-align: left; cursor: pointer; font-size: 0.8rem;">
                                <i class="fa-solid fa-trash"></i> Hapus Akun
                            </button>
                        </div>
                    </td>

                    <td><div class="avatar-circle">{{ strtoupper(substr($user->Nama, 0, 2)) }}</div></td>

                    <td>
                        <div class="info-wrapper">
                            <span class="main-name">{{ $user->Nama }}</span>
                            <div class="audit-grid">
                                <div class="audit-box">
                                    <strong>Created</strong>
                                    {{ $user->CreatedBy ?? 'System' }}<br>
                                    {{ $user->CreatedDate ? date('d/m/Y H:i', strtotime($user->CreatedDate)) : '-' }}
                                </div>
                                <div class="audit-box">
                                    <strong>Last Update</strong>
                                    {{ $user->LastUpdatedBy ?? '-' }}<br>
                                    {{ $user->LastUpdatedDate ? date('d/m/Y H:i', strtotime($user->LastUpdatedDate)) : '-' }}
                                </div>
                            </div>
                        </div>
                    </td>


                    <td style="color: #ccc;">{{ $user->Email }}</td>

                    <td>
                        @php
                            $userRole = strtoupper($user->Role);
                            $colorClass = 'role-pelanggan-bg';
                            if ($userRole == 'ADMIN') $colorClass = 'role-admin-bg';
                            elseif ($userRole == 'KASIR') $colorClass = 'role-kasir-bg';
                        @endphp

                        <span class="badge-role {{ $colorClass }}">
                            {{ $userRole == 'PELANGGAN' ? 'PELANGGAN' : $userRole }}
                        </span>
                    </td>

                    <td>
                        <span style="font-weight: 700; color: {{ (int)$user->Status === 1 ? '#8bc34a' : '#ff4d4d' }}">
                            {{ (int)$user->Status === 1 ? 'AKTIF' : 'NON-AKTIF' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ===== FLASH SESSION TOAST ===== --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tampilkanToast('success', 'Berhasil', '{{ session('success') }}');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tampilkanToast('danger', 'Gagal', '{{ session('error') }}');
    });
</script>
@endif

<script>
/* ===== DROPDOWN ===== */
function toggleDropdown(event, id) {
    event.stopPropagation();
    document.querySelectorAll('.nongki-dropdown').forEach(el => {
        if (el.id !== id) el.style.display = 'none';
    });
    const drop = document.getElementById(id);
    drop.style.display = drop.style.display === 'block' ? 'none' : 'block';
}
window.onclick = function(event) {
    if (!event.target.closest('.nongki-dropdown')) {
        document.querySelectorAll('.nongki-dropdown').forEach(el => el.style.display = 'none');
    }
};


/* ===== MODAL HELPERS ===== */
function bukaModal(id) {
    const overlay = document.getElementById(id);
    overlay.classList.add('active');
}
function tutupModal(id) {
    const overlay = document.getElementById(id);
    overlay.classList.remove('active');
}

/* ===== MODAL HAPUS ===== */
function bukaModalHapus(userId, nama) {
    document.getElementById('modalNamaHapus').textContent = nama;
    const btn = document.getElementById('btnKonfirmasiHapus');
    btn.onclick = function() {
        tutupModal('modalHapus');
        document.getElementById('form-hapus-' + userId).submit();
    };
    bukaModal('modalHapus');
}

/* ===== MODAL TOGGLE STATUS ===== */
function bukaModalToggle(userId, nama, status) {
    const aktif = parseInt(status) === 1;
    document.getElementById('modalNamaToggle').textContent = nama;
    document.getElementById('modalToggleJudul').textContent = aktif ? 'Non-Aktifkan Akun' : 'Aktifkan Akun';
    document.getElementById('modalTogglePesan').innerHTML = aktif
        ? 'Akun <span>' + nama + '</span> akan dinonaktifkan dan tidak bisa login.'
        : 'Akun <span>' + nama + '</span> akan diaktifkan kembali.';
    const btn = document.getElementById('btnKonfirmasiToggle');
    btn.innerHTML = aktif
        ? '<i class="fa-solid fa-ban"></i> Non-Aktifkan'
        : '<i class="fa-solid fa-check"></i> Aktifkan';
    btn.onclick = function() {
        tutupModal('modalToggle');
        document.getElementById('form-toggle-' + userId).submit();
    };
    bukaModal('modalToggle');
}

/* ===== KONFIRMASI UBAH ROLE ===== */
function konfirmasiUbahRole(selectEl, nama) {
    const roleLabel = selectEl.options[selectEl.selectedIndex].text;
    const form = selectEl.closest('form');
    const prevIndex = [...selectEl.options].findIndex(o => o.defaultSelected);

    // simpan index sebelumnya untuk rollback jika batal
    const originalIndex = prevIndex >= 0 ? prevIndex : 0;

    // buat modal dinamis inline
    const overlay = document.getElementById('modalToggle');
    document.getElementById('modalNamaToggle').textContent = nama;
    document.getElementById('modalToggleJudul').textContent = 'Ubah Hak Akses';
    document.getElementById('modalTogglePesan').innerHTML =
        'Role akun <span>' + nama + '</span> akan diubah menjadi <span>' + roleLabel + '</span>.';
    const btn = document.getElementById('btnKonfirmasiToggle');
    btn.innerHTML = '<i class="fa-solid fa-check"></i> Simpan';
    btn.onclick = function() {
        tutupModal('modalToggle');
        form.submit();
    };

    // Jika batal, kembalikan pilihan semula
    document.querySelector('#modalToggle .btn-modal-cancel').onclick = function() {
        selectEl.selectedIndex = originalIndex;
        tutupModal('modalToggle');
    };

    bukaModal('modalToggle');
}

/* ===== TOAST ===== */
function tampilkanToast(tipe, judul, pesan) {
    const wrap = document.getElementById('toastWrap');
    const icons = { success: 'fa-circle-check', danger: 'fa-circle-xmark', warning: 'fa-triangle-exclamation' };
    const labels = { success: 'Berhasil', danger: 'Gagal', warning: 'Perhatian' };

    const toast = document.createElement('div');
    toast.className = 'nongki-toast toast-' + tipe;
    toast.innerHTML = `
        <div class="toast-icon"><i class="fa-solid ${icons[tipe] || 'fa-bell'}"></i></div>
        <div class="toast-body">
            <div class="toast-title">${judul || labels[tipe]}</div>
            <div class="toast-msg">${pesan}</div>
        </div>
        <button class="toast-close" onclick="tutupToast(this.closest('.nongki-toast'))">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="toast-progress"></div>
    `;
    wrap.appendChild(toast);

    setTimeout(() => tutupToast(toast), 4000);
}

function tutupToast(el) {
    if (!el) return;
    el.classList.add('hiding');
    setTimeout(() => el.remove(), 300);
}

/* ===== TUTUP MODAL KLIK LUAR ===== */
document.querySelectorAll('.nongki-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) tutupModal(this.id);
    });
});

</script>
@endsection