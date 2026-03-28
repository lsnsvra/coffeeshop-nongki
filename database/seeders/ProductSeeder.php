<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('products')->insert([
        [
            'NamaKopi' => 'Americano',
            'Ukuran' => 250,
            'Harga' => 15000,
            'Stok' => 50,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now()
        ],
        [
            'NamaKopi' => 'Latte',
            'Ukuran' => 300,
            'Harga' => 20000,
            'Stok' => 40,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now()
        ]
    ]);
}
}
