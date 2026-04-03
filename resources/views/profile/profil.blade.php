@extends('layouts.app')

@section('title', 'Profil Saya — NONGKI')

@push('styles')
<style>
    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    .profile-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        position: sticky;
        top: 88px;
    }

    .avatar-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .avatar-big {
        width: 88px;
        height: 88px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dim));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a14;
        border: 3px solid var(--gold-dim);
    }

    .avatar-edit {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 26px;
        height: 26px;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
    }

    .profile-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        font-size: 0.8rem;
        color: var(--text-muted-c);
        margin-bottom: 0.5rem;
    }

    .member-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(201,168,76,0.12);
        border: 1px solid var(--gold-dim);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stat-box {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0.75rem;
    }

    .stat-num {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--gold);
        font-family: 'Cormorant Garamond', serif;
    }

    .stat-label {
        font-size: 0.7rem;
        color: var(--text-muted-c);
        margin-top: 2px;
    }

    .btn-edit-profile {
        width: 100%;
        background: var(--gold);
        border: none;
        border-radius: 10px;
        padding: 10px;
        color: #1a1a14;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-edit-profile:hover {
        background: var(--gold-light);
    }

    .form-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .form-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
    }

    .form-card-body {
        padding: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted-c);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 14px;
        color: var(--cream);
        font-size: 0.85rem;
        outline: none;
    }

    .form-input:focus {
        border-color: var(--gold);
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-save {
        background: var(--gold);
        border: none;
        border-radius: 10px;
        padding: 8px 20px;
        color: #1a1a14;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save:hover {
        background: var(--gold-light);
    }

    .btn-cancel {
        background: none;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 8px 20px;
        color: var(--text-muted-c);
        cursor: pointer;
    }

    .btn-cancel:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    @media (max-width: 768px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
        .profile-card {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title" style="font-family:'Cormorant Garamond',serif; font-size: 2rem;">Profil Saya</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a> · Profil
        </div>
    </div>
</div>

<div class="profile-layout">
    <!-- LEFT CARD -->
    <div class="profile-card">
        <div class="avatar-wrap">
            <div class="avatar-big">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="avatar-edit">✏</div>
        </div>
        <div class="profile-name">{{ Auth::user()->name ?? 'Pelanggan' }}</div>
        <div class="profile-email">{{ Auth::user()->email ?? 'email@example.com' }}</div>
        <div class="member-badge">⭐ Member Gold</div>
        <div class="profile-stats">
            <div class="stat-box">
                <div class="stat-num">87</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">6</div>
                <div class="stat-label">Favorit</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">Rp 4,2jt</div>
                <div class="stat-label">Total Belanja</div>
            </div>
            <div class="stat-box">
                <div class="stat-num">142</div>
                <div class="stat-label">Poin Reward</div>
            </div>
        </div>
        <button class="btn-edit-profile" onclick="alert('Fitur edit foto sedang dalam pengembangan')">✏ Edit Foto</button>
    </div>

    <!-- RIGHT FORMS -->
    <div>
        <div class="form-card">
            <div class="form-card-header">Informasi Pribadi</div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Nama Lengkap</label>
                        <input class="form-input" type="text" value="{{ Auth::user()->name ?? '' }}" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Email</label>
                        <input class="form-input" type="email" value="{{ Auth::user()->email ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input class="form-input" type="tel" placeholder="+62 8xx xxxx xxxx">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input class="form-input" type="date">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-save" onclick="alert('Informasi tersimpan (demo)')">Simpan Perubahan</button>
                    <button class="btn-cancel">Batal</button>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">Ubah Password</div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Password Lama</label>
                        <input class="form-input" type="password" placeholder="Masukkan password lama">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input class="form-input" type="password" placeholder="Password baru">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input class="form-input" type="password" placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-save" onclick="alert('Password diubah (demo)')">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection