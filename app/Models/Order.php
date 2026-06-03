<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'OrderID'; 
    public $timestamps = false; // Karena kamu tidak pakai created_at/updated_at bawaan

    protected $fillable = [
        'pelanggan', 'UserID', 'PaymentMethodID', 'order_code',
        'TotalHarga', 'StatusOrder', 'TanggalOrder', 'CompanyCode',
        'Status', 'IsDeleted', 'CreatedBy', 'CreatedDate',
        'LastUpdatedBy', 'LastUpdatedDate',
    ];

    protected $casts = [
        'UserID' => 'integer',
        'PaymentMethodID' => 'integer',
        'TotalHarga' => 'integer',
        'Status' => 'integer',
        'IsDeleted' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function orderDetails() {
    return $this->hasMany(OrderDetail::class, 'OrderID', 'OrderID');
}

    public function payment()
    {
        return $this->hasOne(Payment::class, 'OrderID');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('TanggalOrder', today());
    }

    public function scopePending($query)
    {
        return $query->where('StatusOrder', 'Pending');
    }
}