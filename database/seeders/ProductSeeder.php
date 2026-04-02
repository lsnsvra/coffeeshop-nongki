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
            'LastUpdatedDate' => now(),
            'image' => 'americano.jpeg'
        ],
        [
            'NamaKopi' => 'Halzenut Coffee',
            'Ukuran' => 300,
            'Harga' => 22000,
            'Stok' => 40,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'halzenutt_coffe.jpeg'
        ],
        [
            'NamaKopi' => 'Matcha Latte',
            'Ukuran' => 300,
            'Harga' => 23000,
            'Stok' => 35,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'matcha_latte.jpeg'
        ],
        [
            'NamaKopi' => 'Vanilla Latte',
            'Ukuran' => 300,
            'Harga' => 22000,
            'Stok' => 30,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'vanilla_latte.jpeg'
        ],
        [
            'NamaKopi' => 'Macchiato',
            'Ukuran' => 250,
            'Harga' => 20000,
            'Stok' => 30,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'machiatto.jpeg'
        ],
        [
            'NamaKopi' => 'Coffee Milk Aren',
            'Ukuran' => 300,
            'Harga' => 21000,
            'Stok' => 40,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'coffe_milk_aren_sugar.jpeg'
        ],
        [
            'NamaKopi' => 'Coffee Milk Pandan',
            'Ukuran' => 300,
            'Harga' => 21000,
            'Stok' => 35,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'coffe_milk_pandan.jpeg'
        ],
        [
            'NamaKopi' => 'Chocolate Drink',
            'Ukuran' => 300,
            'Harga' => 20000,
            'Stok' => 30,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'chocolate.jpeg'
        ],
        [
            'NamaKopi' => 'Chocolate Avocado',
            'Ukuran' => 300,
            'Harga' => 24000,
            'Stok' => 25,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'chocolate_avocado.jpeg'
        ],
        [
            'NamaKopi' => 'Manggo Smoothie',
            'Ukuran' => 350,
            'Harga' => 23000,
            'Stok' => 25,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'manggo_smoothie.jpeg'
        ],

    
        [
            'NamaKopi' => 'French Fries',
            'Ukuran' => 200,
            'Harga' => 15000,
            'Stok' => 50,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'french_fries.jpeg'
        ],
        [
            'NamaKopi' => 'Baked Macaroni',
            'Ukuran' => 250,
            'Harga' => 20000,
            'Stok' => 30,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'baked_macaroni.jpeg'
        ],
        [
            'NamaKopi' => 'Chicken Katsu Curry',
            'Ukuran' => 300,
            'Harga' => 25000,
            'Stok' => 20,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'chiken_katsu_curry.jpeg'
        ],
        [
            'NamaKopi' => 'Enoki Crispy',
            'Ukuran' => 200,
            'Harga' => 18000,
            'Stok' => 25,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'enoki_crispy.jpeg'
        ],
        [
            'NamaKopi' => 'Noodles',
            'Ukuran' => 300,
            'Harga' => 17000,
            'Stok' => 40,
            'CompanyCode' => 'NGK',
            'Status' => 1,
            'IsDeleted' => 0,
            'CreatedDate' => now(),
            'LastUpdatedDate' => now(),
            'image' => 'noodles.jpeg'
        ],
    ]);
}
}
