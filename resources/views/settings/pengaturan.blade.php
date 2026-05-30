{{-- resources/views/settings/pengaturan.blade.php (pengaturan acc) --}}
@extends('layouts.app')

@section('title', 'Pengaturan Akun — NONGKI')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* ========== TAMBAHAN UNTUK LIGHT MODE ========== */
    [data-theme="light"] .page-title,
    [data-theme="light"] .breadcrumb-modern .current,
    [data-theme="light"] .settings-header,
    [data-theme="light"] .setting-label,
    [data-theme="light"] #modalTitle {
        color: var(--cream) !important; /* Teks utama jadi coklat gelap elegan */
    }

    [data-theme="light"] .page-subtitle,
    [data-theme="light"] .breadcrumb-modern .separator,
    [data-theme="light"] .setting-desc,
    [data-theme="light"] #modalMessage {
        color: var(--text-muted-c) !important; /* Teks sekunder jadi abu-abu */
    }

    [data-theme="light"] .settings-card {
        background: #FFFFFF !important; /* Kartu pengaturan jadi putih */
        border-color: var(--border) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
    }
    [data-theme="light"] .settings-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        border-color: var(--gold) !important;
    }

    [data-theme="light"] .settings-header {
        background: var(--dark-3) !important; /* Header kartu jadi sedikit krem terang */
        border-bottom-color: var(--dark-4) !important;
    }

    [data-theme="light"] .setting-item {
        border-bottom-color: var(--dark-4) !important;
    }
    [data-theme="light"] .setting-item:hover {
        background: rgba(0,0,0,0.02) !important;
    }

    /* Toggle Switch Light Mode */
    [data-theme="light"] .toggle-slider {
        background-color: var(--dark-4) !important;
        border-color: var(--border) !important;
    }
    [data-theme="light"] .toggle-slider:before {
        background-color: #FFFFFF !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
    }
    [data-theme="light"] input:checked + .toggle-slider {
        background-color: var(--gold) !important;
        border-color: var(--gold) !important;
    }
    [data-theme="light"] input:checked + .toggle-slider:before {
        background-color: #FFFFFF !important;
    }

    /* Version Badge */
    [data-theme="light"] .version-badge {
        background: rgba(201, 168, 76, 0.1) !important;
        color: #A6832A !important;
        border-color: rgba(201, 168, 76, 0.2) !important;
    }

    /* Modal Light Mode */
    [data-theme="light"] .nongki-modal-overlay {
        background: rgba(255,255,255,0.8) !important;
    }
    [data-theme="light"] .nongki-modal-box {
        background: #FFFFFF !important;
        border-color: var(--border) !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
    }
    [data-theme="light"] .modal-btn-cancel {
        background: var(--dark-3) !important;
        color: var(--cream) !important;
        border-color: var(--border) !important;
    }
    [data-theme="light"] .modal-btn-cancel:hover {
        background: var(--dark-4) !important;
    }
    
    /* Warna tombol emas di mode terang supaya lebih jelas */
    [data-theme="light"] .btn-outline-gold {
        color: #A6832A !important;
        border-color: #A6832A !important;
    }
    [data-theme="light"] .btn-outline-gold:hover {
        background: rgba(201, 168, 76, 0.1) !important;
    }
    /* ============================================== */

    /* 1. ANIMASI & LAYOUT DASAR */
    .settings-container { max-width: 900px; margin: 0 auto; animation: fadeIn 0.6s ease-out; padding-bottom: 3rem; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* 2. HEADER ELEGAN & MODERN */
    .page-header { margin-bottom: 3rem; position: relative; }
    
    .breadcrumb-modern {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(201, 168, 76, 0.1); 
        border: 1px solid rgba(201, 168, 76, 0.2);
        padding: 6px 16px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; 
        letter-spacing: 1px; margin-bottom: 1.2rem;
    }
    .breadcrumb-modern a { 
        color: var(--gold); text-decoration: none; display: flex; 
        align-items: center; gap: 6px; transition: all 0.3s ease; 
    }
    .breadcrumb-modern a:hover { color: var(--gold-light); transform: translateX(-2px); }
    .breadcrumb-modern .separator { color: rgba(240, 236, 227, 0.3); font-size: 0.7rem; }
    .breadcrumb-modern .current { color: #f0ece3; }
    
    .page-title { 
        font-size: 2.4rem; color: #f0ece3; margin-bottom: 0.4rem; 
        font-weight: 800; letter-spacing: -0.5px;
    }
    .page-subtitle { font-size: 0.95rem; color: rgba(240, 236, 227, 0.6); margin: 0; }

    /* 3. SETTINGS CARD PREMIUM */
    .settings-card {
        background: linear-gradient(145deg, var(--dark-2) 0%, rgba(20, 19, 17, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 24px;
        margin-bottom: 2rem; overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15); transition: all 0.3s ease;
    }
    .settings-card:hover { border-color: rgba(201, 168, 76, 0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.25); }

    .settings-header {
        padding: 1.5rem 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 1.15rem; font-weight: 700; color: #f0ece3;
        display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.1);
    }
    .settings-header i { color: var(--gold); background: rgba(201, 168, 76, 0.1); padding: 8px; border-radius: 8px; font-size: 1rem; }

    .setting-item {
        display: flex; justify-content: flex-start; align-items: center; gap: 1.5rem;
        padding: 1.5rem 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        transition: background 0.3s ease;
    }
    .setting-item:hover { background: rgba(255, 255, 255, 0.02); }
    .setting-item:last-child { border-bottom: none; }

    /* PERBAIKAN: Area diperlebar agar tombol tidak terjepit */
    .setting-action { flex: 0 0 160px; display: flex; justify-content: flex-start; }

    .setting-info { flex: 1; text-align: left; }
    .setting-label { font-weight: 600; font-size: 1rem; color: #f0ece3; margin-bottom: 4px; }
    .setting-desc { font-size: 0.8rem; color: rgba(240, 236, 227, 0.5); line-height: 1.4; }

    /* 4. PREMIUM TOGGLE SWITCH */
    .toggle-switch { position: relative; display: inline-block; width: 50px; height: 28px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background-color: rgba(255, 255, 255, 0.1); border-radius: 30px;
        transition: .4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .toggle-slider:before {
        position: absolute; content: ""; height: 20px; width: 20px;
        left: 4px; bottom: 3px; background-color: #f0ece3; border-radius: 50%;
        transition: .4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }
    input:checked + .toggle-slider { background-color: var(--gold); border-color: var(--gold); }
    input:checked + .toggle-slider:before { transform: translateX(20px); background-color: #000; }

    /* 5. BUTTONS & BADGES */
    .btn-setting {
        padding: 0.6rem 1.5rem; border-radius: 12px; font-weight: 600; font-size: 0.85rem;
        cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 6px;
        white-space: nowrap; /* PERBAIKAN: Mencegah teks di dalam tombol turun jadi 2 baris */
    }
    .btn-outline-gold {
        background: transparent; border: 1px solid var(--gold); color: var(--gold);
    }
    .btn-outline-gold:hover { background: rgba(201, 168, 76, 0.1); transform: translateY(-2px); }
    
    .btn-danger-outline {
        background: transparent; border: 1px solid rgba(224, 82, 82, 0.4); color: #e05252;
    }
    .btn-danger-outline:hover { background: rgba(224, 82, 82, 0.1); border-color: #e05252; transform: translateY(-2px); }

    .version-badge {
        background: rgba(255,255,255,0.05); padding: 6px 14px; border-radius: 8px;
        font-family: monospace; font-size: 0.85rem; color: var(--gold); border: 1px solid rgba(255,255,255,0.08);
    }

    /* 6. NONGKI MODAL OVERLAY */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.3s ease;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: var(--dark-2); border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 24px;
        padding: 2.5rem; width: 90%; max-width: 400px; text-align: center;
        transform: translateY(20px) scale(0.95); transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }
    .modal-icon { width: 65px; height: 65px; margin: 0 auto 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
    .modal-icon.warning { background: rgba(255,193,7,0.1); color: #ffc107; border: 1px solid rgba(255,193,7,0.3); }
    .modal-icon.danger { background: rgba(224,82,82,0.1); color: #e05252; border: 1px solid rgba(224,82,82,0.3); }
    
    .modal-btn-group { display: flex; gap: 10px; margin-top: 2rem; }
    .modal-btn { flex: 1; padding: 0.8rem; border-radius: 12px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s; }
    .modal-btn-cancel { background: rgba(255,255,255,0.05); color: #f0ece3; border: 1px solid rgba(255,255,255,0.1); }
    .modal-btn-cancel:hover { background: rgba(255,255,255,0.1); }
    .modal-btn-confirm { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: #000; }
    .modal-btn-danger { background: #e05252; color: #fff; }

    @media (max-width: 768px) {
        .setting-item { flex-direction: column-reverse; align-items: flex-start; gap: 1rem; }
        .setting-action { flex: auto; }
    }
</style>
@endpush

@section('content')
<div class="settings-container">
    <div class="page-header">
        <div class="breadcrumb-modern">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right separator"></i>
            <span class="current">Pengaturan</span>
        </div>
        <h1 class="page-title">Keamanan & Sistem</h1>
        <p class="page-subtitle">Kelola akses kredensial dan informasi sistem akun NONGKI Anda.</p>
    </div>

    <div class="settings-card">
        <div class="settings-header">
            <i class="fas fa-shield-alt"></i> Perlindungan Akun
        </div>
        <div class="settings-body">
            <div class="setting-item">
                <div class="setting-action">
                    <button class="btn-setting btn-outline-gold" onclick="showNongkiModal('Fitur Terkunci', 'Fitur pengubahan kata sandi saat ini sedang dalam pemeliharaan sistem. Silakan coba lagi nanti.', 'warning', false)">
                        <i class="fas fa-key"></i> Ubah Sandi
                    </button>
                </div>
                <div class="setting-info">
                    <div class="setting-label">Ubah Kata Sandi</div>
                    <div class="setting-desc">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun dari akses tidak sah.</div>
                </div>
            </div>
            
            <div class="setting-item">
                <div class="setting-action">
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="setting-info">
                    <div class="setting-label">Verifikasi Dua Langkah (2FA)</div>
                    <div class="setting-desc">Tambahkan lapisan keamanan ekstra. Kami akan meminta kode verifikasi saat Anda login.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="settings-card">
        <div class="settings-header">
            <i class="fas fa-server"></i> Sistem & Data
        </div>
        <div class="settings-body">
            <div class="setting-item">
                <div class="setting-action">
                    <span class="version-badge">v1.2.0-stable</span>
                </div>
                <div class="setting-info">
                    <div class="setting-label">Versi Aplikasi</div>
                    <div class="setting-desc">Platform Web NONGKI Coffee Shop System</div>
                </div>
            </div>
            
            <div class="setting-item" style="border-left: 3px solid #e05252;">
                <div class="setting-action">
                    <button class="btn-setting btn-danger-outline" onclick="showNongkiModal('Hapus Akun Permanen?', 'Apakah Anda benar-benar yakin? Semua data pesanan dan poin akan hilang dan tidak dapat dipulihkan.', 'danger', true)">
                        <i class="fas fa-trash-alt"></i> Hapus Akun
                    </button>
                </div>
                <div class="setting-info">
                    <div class="setting-label" style="color: #e05252;">Hapus Akun Permanen</div>
                    <div class="setting-desc">Tindakan ini akan menghapus seluruh data Anda, termasuk riwayat pesanan dan poin loyalitas secara permanen.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="nongki-modal-overlay" id="nongkiModal">
    <div class="nongki-modal-box">
        <div id="modalIcon" class="modal-icon"></div>
        <h3 id="modalTitle" style="color: #f0ece3; margin-bottom: 0.8rem; font-weight: 700; font-size: 1.3rem;"></h3>
        <p id="modalMessage" style="color: rgba(240, 236, 227, 0.7); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6;"></p>
        
        <div class="modal-btn-group">
            <button class="modal-btn modal-btn-cancel" onclick="closeNongkiModal()">Batal</button>
            <button id="modalConfirmBtn" class="modal-btn modal-btn-confirm" style="display: none;">Lanjutkan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showNongkiModal(title, message, type, isDanger) {
        const modal = document.getElementById('nongkiModal');
        const iconContainer = document.getElementById('modalIcon');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('modalMessage').innerText = message;
        
        if(type === 'danger') {
            iconContainer.className = 'modal-icon danger';
            iconContainer.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            confirmBtn.className = 'modal-btn modal-btn-danger';
            confirmBtn.innerText = 'Ya, Hapus';
        } else {
            iconContainer.className = 'modal-icon warning';
            iconContainer.innerHTML = '<i class="fas fa-info-circle"></i>';
            confirmBtn.className = 'modal-btn modal-btn-confirm';
            confirmBtn.innerText = 'Mengerti';
        }

        if(isDanger) {
            confirmBtn.style.display = 'block';
            confirmBtn.onclick = function() {
                closeNongkiModal();
                setTimeout(() => alert('Simulasi: Akun berhasil dihapus.'), 300);
            };
        } else {
            confirmBtn.style.display = 'none';
        }
        
        modal.classList.add('active');
    }

    function closeNongkiModal() {
        document.getElementById('nongkiModal').classList.remove('active');
    }
</script>
@endpush