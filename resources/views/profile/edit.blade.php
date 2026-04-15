{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya — NONGKI')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .profile-container { max-width: 1200px; margin: 0 auto; }
    .profile-header {
        background: linear-gradient(135deg, var(--dark-2) 0%, var(--dark-3) 100%);
        border-radius: 24px; padding: 2rem; margin-bottom: 2rem;
        position: relative; overflow: hidden; border: 1px solid var(--border);
    }
    .profile-header::before {
        content: ''; position: absolute; top: -50%; right: -20%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .profile-avatar-wrapper { position: relative; display: inline-block; }
    .profile-avatar {
        width: 120px; height: 120px; border-radius: 50%; object-fit: cover;
        border: 4px solid var(--gold); box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 2.5rem; color: var(--dark);
        position: relative;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .avatar-fallback {
        width: 100%; height: 100%; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--dark); font-weight: 700; font-size: 2.5rem;
    }
    .avatar-upload-btn {
        position: absolute; bottom: 5px; right: 5px; background: var(--gold);
        border-radius: 50%; width: 34px; height: 34px; display: flex;
        align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.2s; border: 2px solid var(--dark-2); color: #000;
    }
    .avatar-upload-btn:hover { background: var(--gold-light); transform: scale(1.05); }
    .profile-name { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; margin: 0.5rem 0 0.25rem; }
    .profile-email { color: var(--text-muted-c); margin-bottom: 1rem; }
    .profile-stats { display: flex; gap: 1.5rem; margin-top: 1rem; flex-wrap: wrap; }
    .stat-card {
        background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); border-radius: 20px;
        padding: 0.5rem 1.2rem; text-align: center; min-width: 100px; border: 1px solid var(--border);
    }
    .stat-number { font-size: 1.6rem; font-weight: 700; color: var(--gold); font-family: 'Playfair Display', serif; }
    .stat-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted-c); }
    .profile-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.8rem; }
    .profile-card {
        background: var(--dark-2); border: 1px solid var(--border); border-radius: 24px;
        padding: 1.8rem; transition: all 0.3s;
    }
    .profile-card:hover { border-color: var(--gold-dim); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
    .card-title {
        font-size: 1.2rem; font-weight: 600; margin-bottom: 1.5rem; display: flex;
        align-items: center; gap: 0.6rem; color: var(--gold);
        border-left: 3px solid var(--gold); padding-left: 0.8rem;
    }
    .form-group { margin-bottom: 1.2rem; }
    .form-label {
        display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
        color: var(--text-muted-c); margin-bottom: 0.4rem; letter-spacing: 0.5px;
    }
    .form-control {
        width: 100%; padding: 0.8rem 1rem; background: var(--dark-3);
        border: 1px solid var(--border); border-radius: 14px; color: var(--cream);
        font-size: 0.9rem; transition: all 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px var(--gold-dim); }
    .btn-gold {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border: none; padding: 0.7rem 1.8rem; border-radius: 40px; font-weight: 600;
        color: #000; cursor: pointer; transition: all 0.2s; display: inline-flex;
        align-items: center; gap: 8px;
    }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(201,168,76,0.4); }
    .btn-outline-gold {
        background: transparent; border: 1px solid var(--gold); padding: 0.7rem 1.5rem;
        border-radius: 40px; color: var(--gold); font-weight: 500; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-outline-gold:hover { background: var(--gold-dim); }
    .btn-danger { border-color: #e05252; color: #e05252; }
    .btn-danger:hover { background: rgba(224,82,82,0.1); }
    .activity-list { list-style: none; padding: 0; margin: 0; }
    .activity-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.8rem 0; border-bottom: 1px solid var(--border);
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-icon { width: 30px; color: var(--gold); }
    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
        .profile-stats { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <!-- Header Profil dengan Avatar -->
    <div class="profile-header">
        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
            <div class="profile-avatar-wrapper">
                @php
                    $user = Auth::user();
                    $avatar = $user->avatar;
                    
                    if ($avatar && (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://'))) {
                        $avatarUrl = preg_replace('/=s\d+-c/', '=s256-c', $avatar);
                    } elseif ($avatar) {
                        $avatarUrl = asset('storage/' . $avatar);
                    } else {
                        $avatarUrl = null;
                    }
                    
                    $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                @endphp
                
                <div class="profile-avatar" id="avatarContainer">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="Avatar" id="avatarPreview" 
                             onerror="this.onerror=null; this.style.display='none'; document.getElementById('avatarFallback').style.display='flex';">
                        <div id="avatarFallback" class="avatar-fallback" style="display: none;">{{ $initials }}</div>
                    @else
                        <div id="avatarFallback" class="avatar-fallback">{{ $initials }}</div>
                    @endif
                </div>
                
                <label for="avatarUpload" class="avatar-upload-btn">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="avatarUpload" style="display: none;" accept="image/*">
            </div>
            <div style="flex:1">
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <div class="profile-stats">
                    <div class="stat-card"><div class="stat-number">87</div><div class="stat-label">Pesanan</div></div>
                    <div class="stat-card"><div class="stat-number">Rp 4,2jt</div><div class="stat-label">Total Belanja</div></div>
                    <div class="stat-card"><div class="stat-number">142</div><div class="stat-label">Poin Reward</div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Form -->
    <div class="profile-grid">
        <!-- Informasi Pribadi -->
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-user-edit"></i> Informasi Pribadi</div>
            <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+62 812 3456 7890">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-control">
                        <option value="">Pilih</option>
                        <option value="Laki-laki" {{ ($user->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ ($user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-gold"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Ubah Password -->
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-lock"></i> Keamanan Akun</div>
            <form id="passwordForm" method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-gold"><i class="fas fa-key"></i> Update Password</button>
                </div>
            </form>
        </div>

        <!-- Hapus Akun -->
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-trash-alt"></i> Hapus Akun</div>
            <p style="font-size: 0.85rem; color: var(--text-muted-c); margin-bottom: 1rem;">Setelah akun dihapus, semua data Anda akan hilang secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
            <button class="btn-outline-gold btn-danger" id="deleteAccountBtn"><i class="fas fa-exclamation-triangle"></i> Hapus Akun Saya</button>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="profile-card">
            <div class="card-title"><i class="fas fa-history"></i> Aktivitas Terbaru</div>
            <ul class="activity-list">
                <li class="activity-item">
                    <span><i class="fas fa-shopping-cart activity-icon"></i> Pesanan #NGK-0241</span>
                    <span style="font-size: 0.75rem;">3 April 2026</span>
                </li>
                <li class="activity-item">
                    <span><i class="fas fa-heart activity-icon"></i> Menambahkan Caramel Latte ke favorit</span>
                    <span style="font-size: 0.75rem;">2 April 2026</span>
                </li>
                <li class="activity-item">
                    <span><i class="fas fa-edit activity-icon"></i> Memperbarui profil</span>
                    <span style="font-size: 0.75rem;">1 April 2026</span>
                </li>
                <li class="activity-item">
                    <span><i class="fas fa-trophy activity-icon"></i> Mendapatkan poin reward 50</span>
                    <span style="font-size: 0.75rem;">30 Maret 2026</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatarUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const container = document.getElementById('avatarContainer');
                const fallback = document.getElementById('avatarFallback');
                const existingImg = document.getElementById('avatarPreview');
                
                if (existingImg) {
                    existingImg.src = event.target.result;
                    existingImg.style.display = 'block';
                    fallback.style.display = 'none';
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = event.target.result;
                    newImg.id = 'avatarPreview';
                    newImg.alt = 'Avatar';
                    newImg.style.width = '100%';
                    newImg.style.height = '100%';
                    newImg.style.objectFit = 'cover';
                    newImg.style.borderRadius = '50%';
                    newImg.onerror = function() {
                        this.style.display = 'none';
                        document.getElementById('avatarFallback').style.display = 'flex';
                    };
                    container.innerHTML = '';
                    container.appendChild(newImg);
                    container.appendChild(fallback);
                    fallback.style.display = 'none';
                }
                
                alert('Upload avatar: Demo. Implementasi backend belum tersedia.');
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('deleteAccountBtn')?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang secara permanen.')) {
            alert('Fitur hapus akun (demo). Silakan implementasi backend.');
        }
    });
</script>
@endpush