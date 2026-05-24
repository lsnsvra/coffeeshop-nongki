<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'DetailID'; // Sudah benar sesuai HeidiSQL
    public $timestamps = false;

    protected $fillable = [
        'OrderID',
        'ProductID',
        'Qty',
        'Harga',      // Tipe INT di database
        'Subtotal',   // Tipe INT di database
        'CompanyCode',
        'Status',
        'IsDeleted',
        'CreatedBy',
        'CreatedDate',
        'LastUpdatedBy',
        'LastUpdatedDate',
    ];

    protected $casts = [
        'Qty' => 'integer',
        'Harga' => 'integer',    // 🔥 Ubah dari decimal ke integer
        'Subtotal' => 'integer', // 🔥 Ubah dari decimal ke integer
        'Status' => 'integer',
        'IsDeleted' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}