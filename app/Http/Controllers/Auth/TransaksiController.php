<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'total'        => 'required|numeric|min:0',
            'cart'         => 'required|array|min:1',
            'cart.*.id'    => 'required|integer',
            'cart.*.qty'   => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $waktuSekarang = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

            // Generate order_code unik (wajib karena UNIQUE constraint)
            $orderCode = 'NGK-' . strtoupper(uniqid());

            // 1. Simpan ke tabel 'orders' — sesuai kolom DB asli
            $orderId = DB::table('orders')->insertGetId([
                'pelanggan'       => 'Pelanggan POS',
                'UserID'          => auth()->id() ?? 1,
                'PaymentMethodID' => 1,           // ID metode pembayaran Tunai
                'order_code'      => $orderCode,
                'TotalHarga'      => $request->total,
                'StatusOrder'     => 'Selesai',
                'TanggalOrder'    => $waktuSekarang,
                'CreatedDate'     => $waktuSekarang,
                'Status'          => 1,
                'IsDeleted'       => 0,
                'created_at'      => $waktuSekarang,
                'updated_at'      => $waktuSekarang,
            ]);

            // 2. Simpan ke tabel 'order_details'
            foreach ($request->cart as $item) {
                $subtotal = $item['price'] * $item['qty'];

                DB::table('order_details')->insert([
                    'OrderID'     => $orderId,
                    'ProductID'   => $item['id'],
                    'Qty'         => $item['qty'],
                    'Harga'       => $item['price'],
                    'Subtotal'    => $subtotal,
                    'Status'      => 1,
                    'IsDeleted'   => 0,
                    'CreatedDate' => $waktuSekarang,
                ]);

                // 3. Kurangi stok produk
                DB::table('products')
                    ->where('ProductID', $item['id'])
                    ->decrement('Stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => 'Transaksi sukses dicatat!',
                'order_id'   => $orderId,
                'order_code' => $orderCode,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}