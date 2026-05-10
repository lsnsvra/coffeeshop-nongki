<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    // Paksa Laravel untuk menggunakan nama tabel 'Stok' (Case Sensitive)
    protected $table = 'Stok'; 

    // Daftarkan kolom agar bisa diisi lewat form (Mass Assignment)
    protected $fillable = [
        'nama_bahan', 
        'stok_sekarang', 
        'stok_maksimal', 
        'satuan', 
        'supplier'
    ];

    // Matikan timestamps jika di tabel 'Stok' tidak ada kolom created_at & updated_at
    public $timestamps = false; 
}