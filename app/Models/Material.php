<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'MaterialID';
    public $timestamps = false;

    protected $fillable = [
        'NamaMaterial', 
        'Unit', 
        'Stock', 
        'Status', 
        'IsDeleted', 
        'CreatedDate', 
        'LastUpdatedDate',
        'LastUpdatedBy'
    ];  

    // Relasi balik ke Produk
    public function products()
    {
        return $this->belongsToMany(Product::class, 'menu_material', 'MaterialID', 'ProductID')
                    ->withPivot('QuantityNeeded')
                    ->withTimestamps('CreatedDate', 'LastUpdatedDate');
    }
}