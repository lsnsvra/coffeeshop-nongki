@extends('layouts.app')

@section('title', 'Pengaturan Akun — NONGKI')

@push('styles')
<style>
    .settings-section {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 16px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .settings-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
    }
    .settings-body {
        padding: 1.5rem;
    }
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border);
    }
    .setting-item:last-child {
        border-bottom: none;
    }
    .setting-label {
        font-weight: 500;
    }
    .setting-desc {
        font-size: 0.75rem;
        color: var(--text-muted-c);
        margin-top: 2px;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 24px;
        transition: 0.3s;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 2px;
        background-color: var(--text-muted-c);
        border-radius: 50%;
        transition: 0.3s;
    }
    input:checked + .toggle-slider {
        background-color: var(--gold);
    }
    input:checked + .toggle-slider:before {
        transform: translateX(20px);
        background-color: #000;
    }
    .btn-setting {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 6px 14px;
        color: var(--cream-dim);
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-setting:hover {
        border-color: var(--gold);
        color: var(--gold);
    }
    .btn-danger {
        border-color: var(--red);
        color: var(--red);
    }
    .btn-danger:hover {
        background: rgba(224,82,82,0.1);
    }

    /* Perbaikan breadcrumb */
    .page-breadcrumb a {
        color: var(--gold);
        text-decoration: none;
    }
    .page-breadcrumb a:hover {
        text-decoration: underline;
    }
    .page-breadcrumb {
        color: var(--text-muted-c);
    }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title" style="font-family:'Cormorant Garamond',serif; font-size: 2rem;">Pengaturan</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a> &raquo; Pengaturan Akun   
        </div>
    </div>
</div>

<div class="settings-section">
    <div class="settings-header">Preferensi Notifikasi</div>
    <div class="settings-body">
        <div class="setting-item">
            <div>
                <div class="setting-label">Email Promosi</div>
                <div class="setting-desc">Terima penawaran dan menu terbaru via email</div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>
        <div class="setting-item">
            <div>
                <div class="setting-label">Notifikasi Pesanan</div>
                <div class="setting-desc">Update status pesanan via notifikasi browser</div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>
</div>

<div class="settings-section">
    <div class="settings-header">Keamanan</div>
    <div class="settings-body">
        <div class="setting-item">
            <div>
                <div class="setting-label">Ubah Password</div>
                <div class="setting-desc">Ganti password akun Anda</div>
            </div>
            <button class="btn-setting" onclick="alert('Fitur ubah password (demo)')">Ubah</button>
        </div>
        <div class="setting-item">
            <div>
                <div class="setting-label">Verifikasi Dua Langkah (2FA)</div>
                <div class="setting-desc">Tambah lapisan keamanan akun</div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox">
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>
</div>

<div class="settings-section">
    <div class="settings-header">Preferensi Tampilan</div>
    <div class="settings-body">
        <div class="setting-item">
            <div>
                <div class="setting-label">Mode Gelap</div>
                <div class="setting-desc">Tampilan tema gelap (aktif secara default)</div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked disabled>
                <span class="toggle-slider" style="opacity:0.6"></span>
            </label>
        </div>
    </div>
</div>

<div class="settings-section">
    <div class="settings-header">Tentang Aplikasi</div>
    <div class="settings-body">
        <div class="setting-item">
            <span>Versi Aplikasi</span>
            <span>1.0.0</span>
        </div>
        <div class="setting-item">
            <span>Kebijakan Privasi</span>
            <button class="btn-setting" onclick="alert('Kebijakan privasi (demo)')">Lihat</button>
        </div>
        <div class="setting-item">
            <span>Hapus Akun</span>
            <button class="btn-setting btn-danger" onclick="if(confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')) alert('Akun dihapus (demo)')">Hapus</button>
        </div>
    </div>
</div>
@endsection