<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Pastikan config ini mengarah ke file config/midtrans.php lo
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function create(Request $request)
    {
        try {
            // DIAGNOSA 1: Cek apakah user login
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Error: Anda belum login!'], 401);
            }

            // DIAGNOSA 2: Cek apakah data items ada
            if (!$request->has('items') || empty($request->items)) {
                return response()->json(['success' => false, 'message' => 'Error: Keranjang kosong di server!'], 400);
            }

            $items  = $request->items;
            $total  = $request->total;
            $method = $request->payment_method;
            $orderCode = 'NGK-' . time() . '-' . auth()->id();

            // DIAGNOSA 3: Tes Simpan ke Database
            // Kita bungkus biar tahu apakah tabel Order-nya bermasalah
            $order = Order::create([
                'UserID'      => auth()->id(),
                'order_code'  => $orderCode,
                'TotalHarga'  => $total,
                'StatusOrder' => 'pending',
                'CompanyCode' => 'NONGKI-01',
            ]);

            // DIAGNOSA 4: Siapkan Payload Midtrans
            $params = [
                'transaction_details' => [
                    'order_id'     => $orderCode,
                    'gross_amount' => (int)$total,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email'      => auth()->user()->email,
                ],
                'item_details' => array_map(function($i) {
                    return [
                        'id'       => $i['id'] ?? 'ITEM',
                        'price'    => (int)$i['price'],
                        'quantity' => (int)$i['quantity'],
                        'name'     => substr($i['name'], 0, 50),
                    ];
                }, $items),
                'enabled_payments' => $this->mapPaymentMethod($method),
            ];

            // DIAGNOSA 5: Tembak ke Midtrans
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $orderCode,
            ]);

        } catch (\Exception $e) {
            // KODE INI BAKAL NGASIH TAU ERROR ASLINYA
            return response()->json([
                'success' => false, 
                'message' => 'BOM MELEDAK DI: ' . $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ], 500);
        }
    }

    public function checkStatus($orderCode) { /* sama seperti sebelumnya */ }
    public function webhook(Request $request) { /* sama seperti sebelumnya */ }

    private function mapPaymentMethod(string $method): array
    {
        return match($method) {
            'qris'          => ['qris', 'gopay', 'shopeepay'],
            'bank_transfer' => ['bca_va', 'bni_va', 'bri_va'],
            'bca_klikpay'   => ['bca_klikpay'],
            default         => ['qris', 'gopay', 'bank_transfer'],
        };
    }
}