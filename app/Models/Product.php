<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Nama tabel di HeidiSQL kamu
    protected $primaryKey = 'ProductID'; // Primary key kamu
    
    public $timestamps = false; // Karena kita pakai CreatedDate & LastUpdatedDate manual

    // Daftar kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'NamaProduk', // Sesuaikan dengan <input name="NamaProduk"> di form
        'Harga', 
        'Kategori', // Samakan dengan Controller/Database
        'Gambar', 
        'Status',
        'IsDeleted',
        
        // ========== 4 AUDIT TRAIL ==========
        'CreatedBy',        // Siapa yang buat 
        'CreatedDate',      // Tanggal buat
        'LastUpdatedBy',    // Siapa yang terakhir edit
        'LastUpdatedDate'   // Tanggal terakhir edit
    ];
}