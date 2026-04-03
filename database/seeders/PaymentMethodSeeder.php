<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('payment_methods')->insert([
        ['NamaMetode' => 'QRIS', 'IsDeleted' => 0],
        ['NamaMetode' => 'Dana', 'IsDeleted' => 0],
        ['NamaMetode' => 'Mandiri', 'IsDeleted' => 0],
        ['NamaMetode' => 'Cash', 'IsDeleted' => 0],
    ]);
}
}
