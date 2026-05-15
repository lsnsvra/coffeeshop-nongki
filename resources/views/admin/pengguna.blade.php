@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — NONGKI')

@push('styles')
<style>
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

    /* Memastikan teks tabel tetap tegas dan putih */
    .nongki-table { width: 100%; border-collapse: collapse; color: #ffffff; }
    .nongki-table th { 
        text-align: left; padding: 15px; color: var(--gold); 
        font-size: 0.9rem; text-transform: uppercase; border-bottom: 2px solid var(--border);
    }
    .nongki-table td { padding: 18px 15px; border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }

    /* ========== AUDIT TRAIL STYLE (LENGKAP) ========== */
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

   
   /* ========== LUXURY ROLE DESIGN (GLOW & GRADIENT) ========== */
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
    
    /* ADMIN: Deep Red Gradient with Glow */
    .bg-admin { 
        background: linear-gradient(135deg, #ff4d4d 0%, #b30000 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 0 15px rgba(255, 77, 77, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* KASIR: Gold/Yellow Gradient with Deep Contrast */
    .bg-kasir { 
        background: linear-gradient(135deg, #ffeb3b 0%, #fbc02d 100%) !important;
        color: #000000 !important;
        box-shadow: 0 0 15px rgba(255, 235, 59, 0.4);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* PELANGGAN: Emerald Green Gradient */
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
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; color: var(--gold); margin: 0;">User Management</h1>
        <p style="color: var(--text-muted-c); font-size: 1rem;">Otoritas akun dan jejak audit sistem NONGKI.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(139, 195, 74, 0.2); border: 1px solid #8bc34a; color: #8bc34a; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

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
                                <select name="Role" onchange="this.form.submit()" class="role-select-custom">
                                    <option value="ADMIN" {{ strtoupper($user->Role) == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                    <option value="KASIR" {{ strtoupper($user->Role) == 'KASIR' ? 'selected' : '' }}>Kasir</option>
                                    <option value="PELANGGAN" {{ strtoupper($user->Role) == 'PELANGGAN' ? 'selected' : '' }}>Pelanggan</option>
                                </select>
                            </form>
                            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 10px 0;"></div>
                            <form action="{{ route('admin.user.toggle-status', $user->UserID) }}" method="POST">
                                @csrf
                                <button type="submit" style="width: 100%; background: none; border: none; color: white; padding: 10px 15px; text-align: left; cursor: pointer; font-size: 0.8rem;">
                                    <i class="fa-solid fa-power-off"></i> {{ (int)$user->Status === 1 ? 'Non-Aktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.user.destroy', $user->UserID) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="width: 100%; background: none; border: none; color: #ff4d4d; padding: 10px 15px; text-align: left; cursor: pointer; font-size: 0.8rem;">
                                    <i class="fa-solid fa-trash"></i> Hapus Akun
                                </button>
                            </form>
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
                            // Ambil role dan jadikan huruf besar semua untuk pengecekan
                            $userRole = strtoupper($user->Role);
                            
                            // Tentukan class berdasarkan role
                            $colorClass = 'role-pelanggan-bg'; // Default hijau
                            if ($userRole == 'ADMIN') {
                                $colorClass = 'role-admin-bg';
                            } elseif ($userRole == 'KASIR') {
                                $colorClass = 'role-kasir-bg';
                            }
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

<script>
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
</script>
@endsection