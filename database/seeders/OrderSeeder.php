<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::inRandomOrder()->limit(5)->get();
        $products = Product::inRandomOrder()->limit(10)->get();

        foreach ($users as $user) {
            // Create 5 orders per user
            for ($i = 0; $i < 5; $i++) {
                $total = rand(20000, 100000);
                $status = rand(0, 2) ? 'paid' : 'pending';
                
                $order = Order::create([
'UserID' => $user->id,
                    'order_code' => 'ORD-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6)),
                    'TotalHarga' => $total,
                    'StatusOrder' => $status,
                    'payment_method' => rand(0, 1) ? 'QRIS' : 'Cash',
                    'created_at' => Carbon::now()->subDays(rand(0, 30))->addHours(rand(0, 23))
                ]);

                // 2-4 order details
                $itemCount = rand(2, 4);
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $qty = rand(1, 3);
                    $subtotal = $product->price * $qty;
                    
                    OrderDetail::create([
'OrderID' => $order->id,
                        'ProductID' => $product->ProductID,
                        'Qty' => $qty,
                        'Harga' => $product->price,
                        'Subtotal' => $subtotal
                    ]);

                    // Update product sales_count
                    $product->increment('sales_count', $qty);
                }

                // Payment
                Payment::create([
'OrderID' => $order->id,
                    'Jumlah' => $total,
                    'Metode' => $order->payment_method,
                    'StatusPembayaran' => $status === 'paid' ? 'completed' : 'pending',
                ]);
            }
        }
    }
}