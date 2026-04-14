<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Nama',
        'Email',
        'google_id',
        'Password',
        'Role',
        'Status',
        'IsDeleted',
        'CreatedDate',
        'LastUpdatedDate',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $casts = [
        'CreatedDate' => 'datetime',
        'LastUpdatedDate' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    public function getNameAttribute()
    {
        return $this->Nama;
    }
}