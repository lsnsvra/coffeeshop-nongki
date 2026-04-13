<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'users';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'UserID';

    /**
     * Tipe primary key.
     */
    protected $keyType = 'int';

    /**
     * Apakah primary key auto-increment.
     */
    public $incrementing = true;

    /**
     * Nonaktifkan timestamps default Laravel.
     * Kita akan mengisi CreatedDate dan LastUpdatedDate secara manual.
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi (mass assignable).
     */
    protected $fillable = [
        'Nama',
        'email',
        'google_id',
        'Password',
        'Role',
        'GoogleID',
        'CompanyCode',
        'Status',
        'IsDeleted',
        'CreatedBy',
        'CreatedDate',
        'LastUpdatedBy',
        'LastUpdatedDate',
        'avatar', // TAMBAHKAN INI
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected $casts = [
        'CreatedDate' => 'datetime',
        'LastUpdatedDate' => 'datetime',
        'Status' => 'integer',
        'IsDeleted' => 'integer',
    ];

    /**
     * Menentukan kolom yang digunakan untuk autentikasi (email).
     */
    public function getAuthIdentifierName()
    {
        return 'email'; // Ubah ke 'email' (lowercase) karena di database kolomnya 'email'
    }

    /**
     * Menentukan kolom password.
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Akses untuk nama (mapping dari Nama ke name).
     */
    public function getNameAttribute()
    {
        return $this->Nama;
    }
}