<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'NamaMaterial' => 'Biji Kopi Arabica',
                'Unit' => 'gram',
                'Stock' => 5000,
            ],
            [
                'NamaMaterial' => 'Susu Fresh Milk',
                'Unit' => 'ml',
                'Stock' => 10000,
            ],
            [
                'NamaMaterial' => 'Matcha Powder',
                'Unit' => 'gram',
                'Stock' => 1500,
            ],
            [
                'NamaMaterial' => 'Bubuk Coklat',
                'Unit' => 'gram',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Sirup Vanilla',
                'Unit' => 'ml',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Sirup Hazelnut',
                'Unit' => 'ml',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Sirup Pandan',
                'Unit' => 'ml',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Gula Aren Cair',
                'Unit' => 'ml',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Alpukat',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Mango Puree',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Air Mineral',
                'Unit' => 'ml',
                'Stock' => 20000,
            ],
            [
                'NamaMaterial' => 'Es Batu',
                'Unit' => 'gram',
                'Stock' => 10000,
            ],
            [
                'NamaMaterial' => 'Ayam Fillet',
                'Unit' => 'gram',
                'Stock' => 5000,
            ],
            [
                'NamaMaterial' => 'Tepung Terigu',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Tepung Crispy',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Tepung Roti',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Macaroni',
                'Unit' => 'gram',
                'Stock' => 3000,
            ],
            [
                'NamaMaterial' => 'Mie Instan',
                'Unit' => 'pcs',
                'Stock' => 50,
            ],
            [
                'NamaMaterial' => 'Kentang Beku',
                'Unit' => 'gram',
                'Stock' => 5000,
            ],
            [
                'NamaMaterial' => 'Jamur Enoki',
                'Unit' => 'gram',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Telur',
                'Unit' => 'pcs',
                'Stock' => 30,
            ],
            [
                'NamaMaterial' => 'Keju Mozzarella',
                'Unit' => 'gram',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Butter',
                'Unit' => 'gram',
                'Stock' => 1000,
            ],
            [
                'NamaMaterial' => 'Minyak Goreng',
                'Unit' => 'ml',
                'Stock' => 5000,
            ],
            [
                'NamaMaterial' => 'Garam',
                'Unit' => 'gram',
                'Stock' => 1000,
            ],
            [
                'NamaMaterial' => 'Lada / Merica',
                'Unit' => 'gram',
                'Stock' => 500,
            ],
            [
                'NamaMaterial' => 'Gula Pasir',
                'Unit' => 'gram',
                'Stock' => 2000,
            ],
            [
                'NamaMaterial' => 'Kaldu Bubuk / Penyedap',
                'Unit' => 'gram',
                'Stock' => 500,
            ],
            [
                'NamaMaterial' => 'Curry Powder / Bumbu Kari',
                'Unit' => 'gram',
                'Stock' => 1000,
            ],
            [
                'NamaMaterial' => 'Bawang Putih',
                'Unit' => 'gram',
                'Stock' => 1000,
            ],
            [
                'NamaMaterial' => 'Saus / Bumbu Tambahan',
                'Unit' => 'ml',
                'Stock' => 1500,
            ],
        ]);
    }
}