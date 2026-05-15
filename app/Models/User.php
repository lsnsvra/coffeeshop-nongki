<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $incrementing = true;
    public $timestamps = false; // Karena kita pakai kolom custom (CreatedDate)

    protected $fillable = [
        'Nama',
        'email',
        'google_id',
        'avatar',
        'Password',
        'phone_number',
        'Role',
        'Status',
        'IsDeleted',
        'CreatedBy',     
        'CreatedDate',    
        'LastUpdatedBy',  
        'LastUpdatedDate',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $casts = [
        'CreatedDate' => 'datetime',
        'LastUpdatedDate' => 'datetime',
    ];

    /**
     * Logic Otomatis: Mengisi Nama Pembuat/Pengubah
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            // Coba ambil dari kolom 'Nama', jika gagal ambil 'name', jika gagal baru 'System'
            $model->LastUpdatedBy = auth()->user()->Nama ?? auth()->user()->name ?? 'System';
            $model->LastUpdatedDate = now();
        });
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    public function getNameAttribute()
    {
        return $this->Nama;
    }
}