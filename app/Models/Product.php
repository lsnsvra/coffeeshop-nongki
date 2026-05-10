<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Nama tabel di HeidiSQL kamu
    protected $primaryKey = 'ProductID'; // Primary key kamu bukan 'id' tapi 'ProductID'
    
    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'NamaKopi', 
        'Harga', 
        'Category', 
        'Ukuran', 
        'Stok', 
        'Image', 
        'IsDeleted', 
        'Status'
    ];
    
    public $timestamps = false; // Karena di HeidiSQL kamu pakai CreatedDate manual
}