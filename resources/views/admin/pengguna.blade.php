@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI & DROPDOWN ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    .nongki-dropdown {
        display: none;
        position: absolute;
        left: 50px;
        top: 0;
        background: #1a1a1a;
        border: 1px solid var(--gold);
        border-radius: 12px;
        width: 160px;
        z-index: 1000;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        padding: 8px 0;
        text-align: left;
    }

    .drop-item {
        width: 100%; background: none; border: none; color: var(--cream);
        padding: 10px 15px; display: flex; align-items: center; gap: 10px;
        font-size: 0.8rem; cursor: pointer; transition: 0.2s;
    }
    .drop-item:hover { background: rgba(201,168,76,0.1); color: var(--gold); }
    .drop-divider { height: 1px; background: rgba(201,168,76,0.2); margin: 5px 0; }
    .drop-label { font-size: 0.6rem; color: var(--gold); padding: 5px 15px; text-transform: uppercase; letter-spacing: 1px; }

    .drop-select {
        width: 90%; margin: 0 auto; display: block; background: #2a2a2a;
        color: white; border: 1px solid #444; border-radius: 6px;
        padding: 5px; font-size: 0.75rem;
    }

    /* ========== TABLE STYLE ========== */
    .user-panel { background: var(--dark-2); border: 1px solid var(--border); border-radius: 20px; padding: 2rem; overflow: visible !important; }
    .nongki-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .nongki-table td { padding: 1.2rem 1rem; vertical-align: middle; background: rgba(255, 255, 255, 0.01); border-top: 1px solid rgba(255,255,255,0.02); }
    
    .avatar-circle {
        width: 40px; height: 40px; border-radius: 50%; background: var(--dark-4); 
        border: 1px solid var(--gold); display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: var(--gold); font-size: 0.85rem;
    }

    .btn-edit-user {
        background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.3);
        width: 34px; height: 34px; border-radius: 8px; cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">User Management</h1>
        <p style="color: var(--text-muted-c);">Atur hak akses dan profil tim NONGKI Coffee.</p>
    </div>

    <div class="user-action-bar" style="margin-bottom: 2rem;">
        <div style="color: var(--text-muted-c); font-size: 0.85rem;">
            Total Terdaftar: <strong>{{ count($users) }} Akun</strong>
        </div>
    </div>

    <div class="user-panel">
        <table class="nongki-table">
            <thead>
                <tr>
                    <th style="text-align: center;">Aksi</th>
                    <th>Profil</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="fade-in-up">
                    <td style="position: relative; text-align: center;">
                        <button type="button" class="btn-edit-user" onclick="toggleDropdown(event, 'drop-{{ $user->UserID }}')">
                            <i class="fa-solid fa-user-gear"></i>
                        </button>

                        <div id="drop-{{ $user->UserID }}" class="nongki-dropdown">
                            <form action="{{ route('admin.user.toggle-status', $user->UserID) }}" method="POST">
                                @csrf
                                <button type="submit" class="drop-item">
                                    <i class="fa-solid fa-power-off"></i> {{ (int)$user->Status === 1 ? 'Non-Aktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <div class="drop-divider"></div>
                            <div class="drop-label">Ubah Role:</div>
                            <form action="{{ route('admin.user.update-role', $user->UserID) }}" method="POST">
                                @csrf
                                <select name="Role" onchange="this.form.submit()" class="drop-select">
                                    <option value="ADMIN" {{ $user->Role == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                    <option value="KASIR" {{ $user->Role == 'KASIR' ? 'selected' : '' }}>Kasir</option>
                                    <option value="PELANGGAN" {{ $user->Role == 'PELANGGAN' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                            </form>
                            <div class="drop-divider"></div>
                            <form action="{{ route('admin.user.destroy', $user->UserID) }}" method="POST" onsubmit="return confirm('Hapus {{ $user->Nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="drop-item" style="color: #ff4d4d;"><i class="fa-solid fa-trash"></i> Hapus Akun</button>
                            </form>
                        </div>
                    </td>
                    <td><div class="avatar-circle">{{ strtoupper(substr($user->Nama, 0, 2)) }}</div></td>
                    <td><div style="font-weight:700; color:var(--cream);">{{ $user->Nama }}</div></td>
                    <td style="color:var(--cream-dim);">{{ $user->Email }}</td>
                    <td><span class="badge-role {{ strtolower($user->Role) == 'admin' ? 'role-admin' : 'role-kasir' }}">{{ $user->Role }}</span></td>
                    <td>
                        <span class="status-active" style="color: {{ (int)$user->Status === 1 ? '#8bc34a' : '#ff4d4d' }}">
                            {{ (int)$user->Status === 1 ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleDropdown(event, id) {
    event.stopPropagation();
    document.querySelectorAll('.nongki-dropdown').forEach(el => {
        if (el.id !== id) el.style.display = 'none';
    });
    const drop = document.getElementById(id);
    drop.style.display = drop.style.display === 'block' ? 'none' : 'block';
}
window.onclick = () => document.querySelectorAll('.nongki-dropdown').forEach(el => el.style.display = 'none');
</script>
@endsection