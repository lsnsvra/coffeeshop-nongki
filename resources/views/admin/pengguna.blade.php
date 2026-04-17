@extends('layouts.admin')

@section('title', 'Manajemen Pengguna — NONGKI')

@section('content')
<div class="page-header">
    <h1>Manajemen Pengguna</h1>
    <p>Kelola akun admin, kasir, dan pelanggan.</p>
</div>

<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
    <table style="width: 100%; border-collapse: collapse; color: var(--cream-dim); font-size: 14px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border);">
                <th style="padding: 12px 8px; text-align: left;">Nama</th>
                <th style="padding: 12px 8px; text-align: left;">Email</th>
                <th style="padding: 12px 8px; text-align: left;">Role</th>
                <th style="padding: 12px 8px; text-align: left;">Status</th>
                <th style="padding: 12px 8px; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Asep Suhaedi</td><td>asep@nongki.id</td><td><span style="color: var(--gold);">Admin</span></td><td><span style="color: #8bc34a;">Aktif</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
            <tr><td>Siti Aminah</td><td>siti@nongki.id</td><td><span style="color: #4CAF50;">Kasir</span></td><td><span style="color: #8bc34a;">Aktif</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
            <tr><td>Budi Santoso</td><td>budi@email.com</td><td>Pelanggan</td><td><span style="color: #8bc34a;">Aktif</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
        </tbody>
    </table>
</div>
@endsection