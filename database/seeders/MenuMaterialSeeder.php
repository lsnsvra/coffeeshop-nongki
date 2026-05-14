<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuMaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_material')->insert([
            // Americano
            ['ProductID' => 1, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 1, 'MaterialID' => 11, 'QuantityNeeded' => 200],
            ['ProductID' => 1, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Hazelnut Coffee
            ['ProductID' => 2, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 2, 'MaterialID' => 2, 'QuantityNeeded' => 180],
            ['ProductID' => 2, 'MaterialID' => 6, 'QuantityNeeded' => 25],
            ['ProductID' => 2, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Matcha Latte
            ['ProductID' => 3, 'MaterialID' => 3, 'QuantityNeeded' => 15],
            ['ProductID' => 3, 'MaterialID' => 2, 'QuantityNeeded' => 200],
            ['ProductID' => 3, 'MaterialID' => 27, 'QuantityNeeded' => 10],
            ['ProductID' => 3, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Vanilla Latte
            ['ProductID' => 4, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 4, 'MaterialID' => 2, 'QuantityNeeded' => 180],
            ['ProductID' => 4, 'MaterialID' => 5, 'QuantityNeeded' => 25],
            ['ProductID' => 4, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Macchiato
            ['ProductID' => 5, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 5, 'MaterialID' => 2, 'QuantityNeeded' => 120],
            ['ProductID' => 5, 'MaterialID' => 5, 'QuantityNeeded' => 10],
            ['ProductID' => 5, 'MaterialID' => 12, 'QuantityNeeded' => 60],

            // Chocolate
            ['ProductID' => 6, 'MaterialID' => 4, 'QuantityNeeded' => 20],
            ['ProductID' => 6, 'MaterialID' => 2, 'QuantityNeeded' => 200],
            ['ProductID' => 6, 'MaterialID' => 27, 'QuantityNeeded' => 10],
            ['ProductID' => 6, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Chocolate Avocado
            ['ProductID' => 7, 'MaterialID' => 4, 'QuantityNeeded' => 15],
            ['ProductID' => 7, 'MaterialID' => 9, 'QuantityNeeded' => 100],
            ['ProductID' => 7, 'MaterialID' => 2, 'QuantityNeeded' => 150],
            ['ProductID' => 7, 'MaterialID' => 27, 'QuantityNeeded' => 10],

            // Coffee Milk Aren
            ['ProductID' => 8, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 8, 'MaterialID' => 2, 'QuantityNeeded' => 180],
            ['ProductID' => 8, 'MaterialID' => 8, 'QuantityNeeded' => 30],
            ['ProductID' => 8, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Coffee Milk Pandan
            ['ProductID' => 9, 'MaterialID' => 1, 'QuantityNeeded' => 18],
            ['ProductID' => 9, 'MaterialID' => 2, 'QuantityNeeded' => 180],
            ['ProductID' => 9, 'MaterialID' => 7, 'QuantityNeeded' => 25],
            ['ProductID' => 9, 'MaterialID' => 12, 'QuantityNeeded' => 80],

            // Mango Smoothie
            ['ProductID' => 10, 'MaterialID' => 10, 'QuantityNeeded' => 120],
            ['ProductID' => 10, 'MaterialID' => 11, 'QuantityNeeded' => 100],
            ['ProductID' => 10, 'MaterialID' => 27, 'QuantityNeeded' => 10],
            ['ProductID' => 10, 'MaterialID' => 12, 'QuantityNeeded' => 100],

            // French Fries
            ['ProductID' => 11, 'MaterialID' => 19, 'QuantityNeeded' => 150],
            ['ProductID' => 11, 'MaterialID' => 24, 'QuantityNeeded' => 200],
            ['ProductID' => 11, 'MaterialID' => 25, 'QuantityNeeded' => 3],

            // Enoki Crispy
            ['ProductID' => 12, 'MaterialID' => 20, 'QuantityNeeded' => 100],
            ['ProductID' => 12, 'MaterialID' => 15, 'QuantityNeeded' => 50],
            ['ProductID' => 12, 'MaterialID' => 24, 'QuantityNeeded' => 200],
            ['ProductID' => 12, 'MaterialID' => 25, 'QuantityNeeded' => 2],

            // Noodles
            ['ProductID' => 13, 'MaterialID' => 18, 'QuantityNeeded' => 1],
            ['ProductID' => 13, 'MaterialID' => 21, 'QuantityNeeded' => 1],
            ['ProductID' => 13, 'MaterialID' => 11, 'QuantityNeeded' => 400],
            ['ProductID' => 13, 'MaterialID' => 30, 'QuantityNeeded' => 5],

            // Chicken Katsu Curry
            ['ProductID' => 14, 'MaterialID' => 13, 'QuantityNeeded' => 150],
            ['ProductID' => 14, 'MaterialID' => 14, 'QuantityNeeded' => 30],
            ['ProductID' => 14, 'MaterialID' => 16, 'QuantityNeeded' => 40],
            ['ProductID' => 14, 'MaterialID' => 21, 'QuantityNeeded' => 1],
            ['ProductID' => 14, 'MaterialID' => 29, 'QuantityNeeded' => 10],

            // Baked Macaroni
            ['ProductID' => 15, 'MaterialID' => 17, 'QuantityNeeded' => 100],
            ['ProductID' => 15, 'MaterialID' => 22, 'QuantityNeeded' => 50],
            ['ProductID' => 15, 'MaterialID' => 2, 'QuantityNeeded' => 100],
            ['ProductID' => 15, 'MaterialID' => 23, 'QuantityNeeded' => 20],
        ]);
    }
}