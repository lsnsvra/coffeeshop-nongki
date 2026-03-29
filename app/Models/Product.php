<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'ProductID';
    protected $table = 'products';

    protected $fillable = [
        'NamaKopi',
        'Ukuran',
        'Harga',
        'Stok',
        'CompanyCode',
        'Status',
        'IsDeleted',
        'CreatedBy',
        'CreatedDate',
        'LastUpdatedBy',
        'LastUpdatedDate',
        'sales_count',
    ];

    // Accessors for view-friendly names
    public function getNameAttribute()
    {
        return $this->NamaKopi;
    }

    public function getDescriptionAttribute()
    {
        return $this->Ukuran . ' ml';
    }

    public function getPriceAttribute()
    {
        return $this->Harga;
    }

    public function getStockAttribute()
    {
        return $this->Stok;
    }
}