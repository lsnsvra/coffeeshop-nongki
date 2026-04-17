@extends('layouts.admin')

@section('title', 'Manajemen Stok — NONGKI')

@section('content')
<div class="page-header">
    <h1>Manajemen Stok Bahan</h1>
    <p>Pantau dan kelola stok bahan baku kopi NONGKI.</p>
</div>

<div style="background: var(--dark-3); border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 20px;">Daftar Bahan</h3>
        <button style="background: var(--gold); color: #000; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">+ Tambah Bahan</button>
    </div>
    <table style="width: 100%; border-collapse: collapse; color: var(--cream-dim); font-size: 14px;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border); color: rgba(245,237,216,0.5);">
                <th style="padding: 12px 8px; text-align: left;">Nama Bahan</th>
                <th style="padding: 12px 8px; text-align: left;">Stok Saat Ini</th>
                <th style="padding: 12px 8px; text-align: left;">Satuan</th>
                <th style="padding: 12px 8px; text-align: left;">Status</th>
                <th style="padding: 12px 8px; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Biji Kopi Arabika</td><td>25</td><td>kg</td><td><span style="color: #8bc34a;">Aman</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
            <tr><td>Susu Segar</td><td>12</td><td>liter</td><td><span style="color: #ff9800;">Stok Rendah</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
            <tr><td>Gula Aren</td><td>8</td><td>kg</td><td><span style="color: #f44336;">Kritis</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
            <tr><td>Sirup Hazelnut</td><td>5</td><td>botol</td><td><span style="color: #ff9800;">Stok Rendah</span></td><td><a href="#" style="color: var(--gold);">Edit</a></td></tr>
        </tbody>
    </table>
</div>
@endsection