@extends('layouts.app')

@section('title', 'Profil Saya - NONGKI')

@push('styles')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .profile-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2rem;
    }
    /* Sidebar kiri */
    .profile-sidebar {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        position: sticky;
        top: 90px;
        height: fit-content;
    }
    .avatar-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }
    .avatar {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: #1a1a14;
        border: 3px solid var(--gold-dim);
        margin: 0 auto;
    }
    .avatar-edit-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--gold);
    }
    .avatar-edit-btn:hover {
        background: var(--gold);
        color: #000;
    }
    .profile-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 600;
        margin: 0.5rem 0 0.25rem;
    }
    .profile-email {
        font-size: 0.85rem;
        color: var(--text-muted-c);
        margin-bottom: 1rem;
    }
    .member-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(201,168,76,0.12);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 30px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 1.5rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem;
        text-align: center;
    }
    .stat-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--gold);
    }
    .stat-label {
        font-size: 0.7rem;
        color: var(--text-muted-c);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-sidebar {
        width: 100%;
        background: var(--gold);
        border: none;
        border-radius: 40px;
        padding: 10px;
        font-weight: 600;
        color: #1a1a14;
        transition: all 0.2s;
        margin-top: 0.5rem;
    }
    .btn-sidebar-outline {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-muted-c);
        width: 100%;
        border-radius: 40px;
        padding: 10px;
        margin-top: 0.5rem;
        transition: all 0.2s;
    }
    .btn-sidebar-outline:hover {
        border-color: var(--gold);
        color: var(--gold);
    }
    /* Right section */
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .form-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .form-card-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
        font-size: 1.1rem;
    }
    .form-card-body {
        padding: 1.5rem;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .form-group.full-width {
        grid-column: span 2;
    }
    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted-c);
        letter-spacing: 0.5px;
    }
    .form-input, .form-select {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.7rem 1rem;
        color: var(--cream);
        font-family: 'DM Sans', sans-serif;
        transition: all 0.2s;
        outline: none;
    }
    .form-input:focus, .form-select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 2px rgba(201,168,76,0.2);
    }
    .btn-primary {
        background: var(--gold);
        border: none;
        border-radius: 12px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        color: #1a1a14;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background: var(--gold-light);
        transform: translateY(-1px);
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.7rem 1.5rem;
        color: var(--text-muted-c);
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        border-color: var(--gold);
        color: var(--gold);
    }
    .btn-danger {
        background: transparent;
        border: 1px solid #e05252;
        color: #e05252;
    }
    .btn-danger:hover {
        background: rgba(224,82,82,0.1);
        border-color: #e05252;
        color: #e05252;
    }
    .divider {
        height: 1px;
        background: var(--border);
        margin: 1rem 0;
    }
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .profile-sidebar {
            position: static;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <!-- Page Header -->
    <div class="page-header" style="margin-bottom: 2rem;">
        <div>
            <h1 class="page-title" style="font-family: 'Cormorant Garamond', serif; font-size: 2rem;">Profil Saya</h1>
            <div class="page-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a> · Profil
            </div>
        </div>
    </div>

    @auth
    @php
        $user = Auth::user();
        // Data dummy untuk statistik (nanti bisa diambil dari database)
        $totalOrders = 87;
        $totalSpent = 4200000;
        $favoritesCount = 6;
        $points = 142;
        $memberLevel = 'Gold';
    @endphp
    <div class="profile-grid">
        <!-- SIDEBAR KIRI -->
        <aside class="profile-sidebar">
            <div class="avatar-wrapper">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="avatar-edit-btn" onclick="alert('Fitur edit foto akan segera hadir')">
                    ✏️
                </div>
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="member-badge">
                ⭐ Member {{ $memberLevel }}
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalOrders }}</div>
                    <div class="stat-label">Pesanan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">Rp {{ number_format($totalSpent / 1000000, 1) }}jt</div>
                    <div class="stat-label">Belanja</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $favoritesCount }}</div>
                    <div class="stat-label">Favorit</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $points }}</div>
                    <div class="stat-label">Poin</div>
                </div>
            </div>
            <button class="btn-sidebar" onclick="alert('Fitur edit profil cepat')">✏️ Edit Profil</button>
            <button class="btn-sidebar-outline" onclick="alert('Fitur riwayat poin')">🎁 Tukar Poin</button>
        </aside>

        <!-- KANAN: FORM -->
        <div class="profile-main">
            <!-- Form Informasi Pribadi -->
            <div class="form-card">
                <div class="form-card-header">Informasi Pribadi</div>
                <div class="form-card-body">
                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-input" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-input" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+62 812 3456 7890">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-input" name="birthdate" value="{{ old('birthdate', $user->birthdate ?? '') }}">
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label">Alamat (opsional)</label>
                                <textarea class="form-input" name="address" rows="2" placeholder="Jl. Contoh No. 123, Kota">{{ old('address', $user->address ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                            <button type="button" class="btn-outline" onclick="resetForm()">Batal</button>
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Ubah Password -->
            <div class="form-card">
                <div class="form-card-header">Keamanan Akun</div>
                <div class="form-card-body">
                    <form id="passwordForm" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-input" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-input" name="password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-input" name="password_confirmation" required>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
                            <button type="submit" class="btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hapus Akun -->
            <div class="form-card">
                <div class="form-card-header">Hapus Akun</div>
                <div class="form-card-body">
                    <p style="color: var(--text-muted-c); margin-bottom: 1rem;">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus permanen.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-primary btn-danger" style="background: transparent; border-color: #e05252; color: #e05252;">Hapus Akun Saya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card-nongki" style="text-align: center; padding: 3rem;">
        <h3>Anda belum login</h3>
        <p style="margin: 1rem 0;">Silakan login untuk mengakses profil Anda.</p>
        <a href="{{ route('login') }}" class="btn-gold">Login Sekarang</a>
    </div>
    @endauth
</div>
@endsection

@push('scripts')
<script>
    function resetForm() {
        // Reset form profile ke nilai awal (refresh halaman atau reload data)
        window.location.reload();
    }
    // Tambahkan validasi sederhana jika diperlukan
    document.getElementById('profileForm')?.addEventListener('submit', function(e) {
        // Optional: client-side validation
    });
</script>
@endpush