<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'ProductID'; // Sesuai DB lu
    public $timestamps = false; // Karena kita pake CreatedDate & LastUpdatedDate manual

    protected $fillable = [
        'NamaKopi', 
        'Ukuran', 
        'Harga', 
        'Category', // Di DB lu pake 'Category', bukan 'Kategori'
        'Stok', 
        'image', 
        'CompanyCode', 
        'Status', 
        'IsDeleted', 
        'CreatedBy', 
        'CreatedDate', 
        'LastUpdatedBy', 
        'LastUpdatedDate'
    ];

    public function materials()
    {
        // Hapus withTimestamps, masukin semua nama kolom ekstra ke withPivot
        return $this->belongsToMany(Material::class, 'menu_material', 'ProductID', 'MaterialID')
                    ->withPivot('QuantityNeeded', 'CreatedDate', 'LastUpdatedDate'); 
    }
}