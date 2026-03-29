<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'UserID',
        'order_code',
        'TotalHarga',
        'StatusOrder',
        'payment_method',
        'CompanyCode',
    ];

    protected $casts = [
        'TotalHarga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }



    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scope for today's orders
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope for pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}