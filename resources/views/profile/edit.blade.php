{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya — NONGKI')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* 1. LAYOUT & ANIMATION */
    .profile-container { max-width: 1050px; margin: 0 auto; animation: fadeIn 0.6s ease-out; padding-bottom: 3rem; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* 2. PREMIUM HEADER (Diperbaiki agar lebih terang dan rapi) */
    .profile-header {
        background: linear-gradient(145deg, var(--dark-2) 0%, rgba(20, 19, 17, 0.9) 100%);
        border-radius: 24px; padding: 3rem; margin-bottom: 2.5rem;
        position: relative; overflow: hidden; 
        border: 1px solid rgba(201, 168, 76, 0.2); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    .profile-header::before { 
        content: ''; position: absolute; top: -50px; left: -50px; width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 70%); pointer-events: none;
    }

    /* 3. AVATAR STYLING */
    .profile-avatar-wrapper { position: relative; margin-right: 1.5rem; }
    .profile-avatar {
        width: 130px; height: 130px; border-radius: 50%; 
        border: 3px solid var(--gold); padding: 4px; 
        background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;
        box-shadow: 0 12px 30px rgba(0,0,0,0.5), inset 0 0 20px rgba(201,168,76,0.2);
    }
    .profile-avatar-inner {
        width: 100%; height: 100%; border-radius: 50%; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
    }
    .profile-avatar-inner img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-fallback { color: var(--dark); font-weight: 800; font-size: 2.8rem; }
    
    .avatar-upload-btn {
        position: absolute; bottom: 5px; right: 0; background: var(--gold);
        border-radius: 50%; width: 38px; height: 38px; display: flex;
        align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.3s ease; border: 4px solid var(--dark-2); color: var(--dark); z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .avatar-upload-btn:hover { background: var(--gold-light); transform: scale(1.15) rotate(10deg); }

    /* 4. STATS CARD (Diperbaiki: Warna teks dan background contrast) */
    .profile-stats { display: flex; gap: 1.2rem; margin-top: 1.8rem; flex-wrap: wrap; }
    .stat-card {
        background: rgba(255, 255, 255, 0.04); /* Background kotak sedikit lebih terang */
        border-radius: 16px; padding: 1rem 1.8rem; 
        border: 1px solid rgba(201, 168, 76, 0.2);
        backdrop-filter: blur(10px); transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); border-color: rgba(201, 168, 76, 0.5); background: rgba(255, 255, 255, 0.06); }
    .stat-number { font-size: 1.6rem; font-weight: 700; color: var(--gold); line-height: 1.2; margin-bottom: 4px; }
    /* Warna tulisan label di-set ke HEX terang agar tidak nyaru */
    .stat-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #d1cbbd; font-weight: 600; }

    /* 5. FORM CARDS (Tetap Aman) */
    .profile-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .profile-card {
        background: var(--dark-2); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px;
        padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .card-title {
        font-size: 1.2rem; font-weight: 600; margin-bottom: 2rem; display: flex;
        align-items: center; gap: 0.8rem; color: #f0ece3;
    }
    .card-title i { color: var(--gold); background: rgba(201, 168, 76, 0.1); padding: 8px; border-radius: 8px; font-size: 1rem; }

    /* 6. INPUT STYLING DENGAN ICON INSIDE (Tetap Aman) */
    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
        color: rgba(240, 236, 227, 0.5); margin-bottom: 0.8rem; letter-spacing: 1px;
    }
    .input-wrapper { position: relative; display: flex; align-items: center; }
    .input-icon {
        position: absolute; left: 1.2rem; color: rgba(240, 236, 227, 0.4); font-size: 1rem;
        transition: color 0.3s;
    }
    .form-control {
        width: 100%; padding: 1rem 1rem 1rem 3rem; 
        background: rgba(0, 0, 0, 0.25); 
        border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; 
        color: #f0ece3 !important; font-size: 0.95rem; transition: all 0.3s;
    }
    .form-control:focus { outline: none; border-color: var(--gold); background: rgba(0, 0, 0, 0.4); box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.1); }
    .form-control:focus + .input-icon, .input-wrapper:focus-within .input-icon { color: var(--gold); }
    .form-control::placeholder { color: rgba(240, 236, 227, 0.2); }

    /* 7. BUTTONS (Tetap Aman) */
    .btn-nongki {
        padding: 1rem 2rem; border-radius: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;
        display: inline-flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer;
        transition: all 0.3s ease; border: none; font-size: 0.85rem; width: 100%;
    }
    .btn-gold { 
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); 
        color: #000; box-shadow: 0 8px 20px rgba(201,168,76,0.2);
    }
    .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(201,168,76,0.35); }

    /* 8. NONGKI MODAL OVERLAY (Tetap Aman) */
    .nongki-modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center; z-index: 10000;
        opacity: 0; pointer-events: none; transition: 0.3s ease;
    }
    .nongki-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .nongki-modal-box {
        background: var(--dark-2); border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 24px;
        padding: 3rem 2.5rem; width: 90%; max-width: 400px; text-align: center;
        transform: translateY(20px) scale(0.95); transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }
    .nongki-modal-overlay.active .nongki-modal-box { transform: translateY(0) scale(1); }
    .modal-icon { width: 70px; height: 70px; margin: 0 auto 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .modal-icon.success { background: rgba(39,174,96,0.1); color: #27ae60; border: 1px solid rgba(39,174,96,0.3); }
    .modal-icon.warning { background: rgba(255,193,7,0.1); color: #ffc107; border: 1px solid rgba(255,193,7,0.3); }
    
    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
        .profile-header > div { flex-direction: column; text-align: center; }
        .profile-stats { justify-content: center; }
        .profile-avatar-wrapper { margin-right: 0; margin-bottom: 1rem; }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
            <div class="profile-avatar-wrapper">
                @php
                    $user = Auth::user();
                    $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                    $avatarUrl = $user->avatar ? (str_starts_with($user->avatar, 'http') ? preg_replace('/=s\d+-c/', '=s256-c', $user->avatar) : asset('storage/' . $user->avatar)) : null;
                @endphp
                
                <div class="profile-avatar">
                    <div class="profile-avatar-inner" id="avatarContainer">
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Avatar" id="avatarPreview">
                        @else
                            <div class="avatar-fallback">{{ $initials }}</div>
                        @endif
                    </div>
                </div>
                
                <label for="avatarUpload" class="avatar-upload-btn">
                    <i class="fas fa-camera" style="font-size: 0.9rem;"></i>
                </label>
                <input type="file" id="avatarUpload" style="display: none;" accept="image/*">
            </div>

            <!-- DETAIL INFO HEADER (DIPERBAIKI) -->
            <div style="flex:1;">
                <div style="display: inline-block; font-size: 0.65rem; color: #1a1814; background: var(--gold); padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem; font-weight: 700;">
                    <i class="fas fa-crown" style="margin-right: 4px;"></i> Pelanggan Setia
                </div>
                <div style="font-size: 2.2rem; font-weight: 700; margin: 0 0 0.5rem 0; color: #f0ece3; letter-spacing: -0.5px;">{{ $user->name }}</div>
                
                <!-- FIX BAGIAN EMAIL: Warna terang & Fallback jika kosong -->
                <div style="color: #d1cbbd; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-envelope" style="color: var(--gold);"></i> 
                    <span>{{ $user->email ?? 'Belum ada email' }}</span>
                </div>
                
                <!-- FIX BAGIAN STATS: Tulisan dan padding lebih rapi -->
                <div class="profile-stats">
                    <div class="stat-card">
                        <div class="stat-number">87</div>
                        <div class="stat-label">Total Pesanan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">Rp 4.2jt</div>
                        <div class="stat-label">Total Belanja</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">142</div>
                        <div class="stat-label">Poin Reward</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM CARDS TETAP AMAN -->
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-user-edit"></i> Informasi Data Diri</div>
            <form id="profileForm">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Aktif</label>
                    <div class="input-wrapper">
                        <i class="fas fa-at input-icon"></i>
                        <input type="email" class="form-control" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="input-wrapper">
                        <i class="fab fa-whatsapp input-icon"></i>
                        <input type="tel" class="form-control" value="{{ $user->phone ?? '+62 812 3456 7890' }}" placeholder="+62 8xx">
                    </div>
                </div>
                <div style="margin-top: 2.5rem;">
                    <button type="button" class="btn-nongki btn-gold" onclick="showNongkiModal('Profil Disimpan', 'Data pribadi Anda telah berhasil diperbarui dalam sistem.', 'success')">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="profile-card">
            <div class="card-title"><i class="fas fa-lock"></i> Keamanan Akun</div>
            <div class="form-group">
                <label class="form-label">Sandi Saat Ini</label>
                <div class="input-wrapper">
                    <i class="fas fa-key input-icon"></i>
                    <input type="password" class="form-control" placeholder="Masukkan sandi lama">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Sandi Baru</label>
                <div class="input-wrapper">
                    <i class="fas fa-shield-alt input-icon"></i>
                    <input type="password" class="form-control" placeholder="Ketik sandi baru">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Sandi Baru</label>
                <div class="input-wrapper">
                    <i class="fas fa-check-circle input-icon"></i>
                    <input type="password" class="form-control" placeholder="Ulangi sandi baru">
                </div>
            </div>
            <div style="margin-top: 2.5rem;">
                <button type="button" class="btn-nongki btn-gold" style="background: transparent; border: 2px solid var(--gold); color: var(--gold); box-shadow: none;" onclick="showNongkiModal('Sandi Diubah', 'Keamanan akun Anda telah ditingkatkan dengan sandi baru.', 'success')">
                    Perbarui Kata Sandi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- NONGKI CUSTOM MODAL (Tetap Aman) -->
<div class="nongki-modal-overlay" id="nongkiModal">
    <div class="nongki-modal-box">
        <div id="modalIcon" class="modal-icon"></div>
        <h3 id="modalTitle" style="color: #f0ece3; margin-bottom: 0.8rem; font-weight: 700; font-size: 1.4rem;"></h3>
        <p id="modalMessage" style="color: rgba(240, 236, 227, 0.7); font-size: 0.95rem; margin-bottom: 2.5rem; line-height: 1.6;"></p>
        <button class="btn-nongki btn-gold" onclick="closeNongkiModal()">Oke, Mengerti</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showNongkiModal(title, message, type) {
        const modal = document.getElementById('nongkiModal');
        const iconContainer = document.getElementById('modalIcon');
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('modalMessage').innerText = message;
        
        if(type === 'success') {
            iconContainer.className = 'modal-icon success';
            iconContainer.innerHTML = '<i class="fas fa-check"></i>';
        } else {
            iconContainer.className = 'modal-icon warning';
            iconContainer.innerHTML = '<i class="fas fa-exclamation"></i>';
        }
        modal.classList.add('active');
    }

    function closeNongkiModal() {
        document.getElementById('nongkiModal').classList.remove('active');
    }

    document.getElementById('avatarUpload').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatarContainer').innerHTML = `<img src="${event.target.result}" id="avatarPreview">`;
                showNongkiModal('Foto Profil', 'Avatar baru Anda berhasil diunggah dan diperbarui.', 'success');
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush