<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'OrderID',
        'Jumlah',
        'Metode',
        'StatusPembayaran',
        'CompanyCode',
    ];

    protected $casts = [
        'Jumlah' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }

    public function scopeCompleted($query)
    {
        return $query->where('StatusPembayaran', 'completed');
    }
}