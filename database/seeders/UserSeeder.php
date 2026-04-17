<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'Nama' => 'Admin NONGKI',
                'Email' => 'admin@nongki.com',
                'Password' => Hash::make('password'),
                'Role' => 'admin',
                'google_id' => null,
                'avatar' => null,
                'Status' => 1,
                'IsDeleted' => 0,
                'CreatedDate' => Carbon::now(),
                'LastUpdatedDate' => Carbon::now(),
            ],
            [
                'Nama' => 'Kasir NONGKI',
                'Email' => 'kasir@nongki.com',
                'Password' => Hash::make('password'),
                'Role' => 'kasir',
                'google_id' => null,
                'avatar' => null,
                'Status' => 1,
                'IsDeleted' => 0,
                'CreatedDate' => Carbon::now(),
                'LastUpdatedDate' => Carbon::now(),
            ],
            [
                'Nama' => 'Pelanggan Setia',
                'Email' => 'user@nongki.com',
                'Password' => Hash::make('password'),
                'Role' => 'user',   // 🟡 middleware memakai 'user'
                'google_id' => null,
                'avatar' => null,
                'Status' => 1,
                'IsDeleted' => 0,
                'CreatedDate' => Carbon::now(),
                'LastUpdatedDate' => Carbon::now(),
            ],
        ]);
    }
}