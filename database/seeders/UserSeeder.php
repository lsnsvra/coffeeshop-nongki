<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'Nama' => 'Admin Manager',
                'Email' => 'admin@coffeeshop.com',
                'Password' => Hash::make('password'),
                'Role' => 'admin',
                'GoogleID' => null,
                'CompanyCode' => null,
            ],
            [
                'Nama' => 'Manager Nongki',
                'Email' => 'manager@coffeeshop.com',
                'Password' => Hash::make('password'),
                'Role' => 'manager',
                'GoogleID' => null,
                'CompanyCode' => null,
            ],
            [
                'Nama' => 'Kasir 1',
                'Email' => 'kasir@coffeeshop.com',
                'Password' => Hash::make('password'),
                'Role' => 'kasir',
                'GoogleID' => null,
                'CompanyCode' => null,
            ],
            [
                'Nama' => 'Pelanggan Biasa',
                'Email' => 'pelanggan@coffeeshop.com',
                'Password' => Hash::make('password'),
                'Role' => 'pelanggan',
                'GoogleID' => null,
                'CompanyCode' => null,
            ],
        ]);
    }
}