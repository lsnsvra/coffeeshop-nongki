@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — NONGKI')

@push('styles')
<style>
    /* ========== ANIMASI ========== */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

    /* ========== ACTION BAR (LEFT ALIGNED) ========== */
    .user-action-bar { 
        display: flex; 
        gap: 1.5rem; 
        margin-bottom: 2.5rem; 
        align-items: center; 
    }
    
    .btn-add-user {
        background: var(--gold); color: var(--dark); border: none; 
        padding: 12px 28px; border-radius: 12px; font-weight: 700; 
        cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px;
    }
    .btn-add-user:hover { 
        background: var(--gold-light); transform: translateY(-3px); 
        box-shadow: 0 8px 20px rgba(201,168,76,0.3); 
    }

    /* ========== TABLE PANEL ========== */
    .user-panel { 
        background: var(--dark-2); border: 1px solid var(--border); 
        border-radius: 20px; padding: 2rem; 
    }
    
    .nongki-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .nongki-table th { 
        padding: 1rem; text-align: left; font-size: 0.7rem; 
        text-transform: uppercase; color: var(--text-muted-c); letter-spacing: 1.5px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .nongki-table td { 
        padding: 1.2rem 1rem; vertical-align: middle; 
        background: rgba(255, 255, 255, 0.01);
        border-top: 1px solid rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.02);
    }
    
    .nongki-table td:first-child { border-left: 1px solid rgba(255,255,255,0.02); border-radius: 12px 0 0 12px; }
    .nongki-table td:last-child { border-right: 1px solid rgba(255,255,255,0.02); border-radius: 0 12px 12px 0; }

    .avatar-circle {
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--dark-4); border: 1px solid var(--gold);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: var(--gold); font-size: 0.85rem;
    }

    .action-col { width: 100px; text-align: center; }
    .btn-edit-user {
        background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.3);
        width: 34px; height: 34px; border-radius: 8px; cursor: pointer; transition: 0.3s;
    }
    .btn-edit-user:hover { background: var(--gold); color: var(--dark); }

    .badge-role { padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
    .role-admin { background: rgba(201, 168, 76, 0.1); color: var(--gold); border: 1px solid rgba(201, 168, 76, 0.2); }
    .role-kasir { background: rgba(76, 175, 80, 0.1); color: #8bc34a; border: 1px solid rgba(76, 175, 80, 0.2); }
    .status-active { color: #8bc34a; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; }
    .status-active::before { content: ''; width: 8px; height: 8px; background: #8bc34a; border-radius: 50%; box-shadow: 0 0 8px #8bc34a; }
</style>
@endpush

@section('content')
<div class="report-container fade-in-up">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; color: var(--gold); margin: 0;">User Management</h1>
        <p style="color: var(--text-muted-c);">Atur hak akses dan profil tim NONGKI Coffee.</p>
    </div>

    <div class="user-action-bar">
        <button class="btn-add-user">
            <i class="fa-solid fa-user-plus"></i> Tambah Pengguna Baru
        </button>
        <div style="color: var(--text-muted-c); font-size: 0.85rem; border-left: 1px solid var(--border); padding-left: 1.5rem;">
            {{-- Tulisan diperbaiki agar tidak ganda --}}
            Total Terdaftar: <strong>{{ $totalUsers ?? count($users) }} Akun</strong>
        </div>
    </div>

    <div class="user-panel">
        <div style="overflow-x: auto;">
            <table class="nongki-table">
                <thead>
                    <tr>
                        <th class="action-col">Aksi</th>
                        <th style="width: 60px;">Profil</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat Email</th>
                        <th>Level Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users ?? [] as $user)
                    <tr class="fade-in-up">
                        <td class="action-col">
                            <button class="btn-edit-user" title="Edit Profil"><i class="fa-solid fa-user-gear"></i></button>
                        </td>
                        <td>
                            <div class="avatar-circle">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--cream);">{{ $user->Nama }}</div>

                            {{-- Logika Terakhir Online --}}
                            <div style="font-size: 0.7rem; color: var(--gold); display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-clock" style="font-size: 0.6rem;"></i>
                                
                                @if($user->LastUpdatedDate)
                                    @php
                                        // Kita bandingkan waktu sekarang dengan data di database
                                        $lastSeen = \Carbon\Carbon::parse($user->LastUpdatedDate);
                                        $isOnline = $lastSeen->diffInMinutes(now()) < 5; 
                                    @endphp
                                    
                                    @if($isOnline)
                                        <span style="color: #8bc34a; font-weight: bold;">Sedang Online</span>
                                    @else
                                        {{-- DiffForHumans akan otomatis jadi: "2 minutes ago", "1 hour ago", dsb --}}
                                        Aktif {{ $lastSeen->diffForHumans() }}
                                    @endif
                                @else
                                    <span style="color: var(--text-muted-c);">Belum pernah aktif</span>
                                @endif
                            </div>
                        </td>
                        <td style="color: var(--cream-dim);">{{ $user->Email }}</td>
                        <td>
                            {{-- LOGIKA ROLE DENGAN PROTEKSI CASE SENSITIVE --}}
                            @php $role = strtolower(trim($user->Role)); @endphp

                            @if($role == 'admin')
                                <span class="badge-role role-admin">Admin</span>
                            @elseif($role == 'kasir')
                                <span class="badge-role role-kasir">Kasir</span>
                            @else
                                <span class="badge-role" style="background: rgba(255,255,255,0.05); color: var(--cream-dim);">Pelanggan</span>
                            @endif
                        </td>
                      <td>
                            @php 
                            $isAktif = (int) $user->Status === 1; 
                        @endphp

                        @if($isAktif)
                            <span class="status-active">Aktif</span>
                        @else
                            <span class="status-active" style="color: #ff4d4d;">
                                <i class="fa-solid fa-circle" style="font-size: 8px; color: #ff4d4d; box-shadow: 0 0 8px #ff4d4d;"></i> 
                                Non-Aktif
                            </span>
                            <style>
                                /* Menghilangkan dot hijau bawaan CSS Asep kalau statusnya merah */
                                span.status-active[style*="ff4d4d"]::before { display: none; }
                            </style>
                        @endif
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection