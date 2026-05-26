<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function create(Request $request)
    {
        Log::info('Data Checkout diterima:', $request->all());

        return DB::transaction(function () use ($request) {

            // ── 1. Buat Order ──────────────────────────────────────────
            $orderCode = 'NGK-' . now()->format('YmdHis') . '-' . auth()->id();

            $order = Order::create([
                'pelanggan'    => auth()->user()->name ?? 'Guest',
                'UserID'       => auth()->id(),
                'TotalHarga'   => (int) $request->total,
                'StatusOrder'  => 'Pending',
                'order_code'   => $orderCode,
                'CompanyCode'  => 'CMP001',
                'Status'       => 1,
                'IsDeleted'    => 0,
                'TanggalOrder' => now(),
                'CreatedDate'  => now(),
                'CreatedBy'    => auth()->user()->name ?? 'Guest',
            ]);

            foreach ($request->items as $item) {
                OrderDetail::create([
                    'OrderID'   => $order->OrderID,
                    'ProductID' => (int) $item['id'],
                    'Qty'       => (int) $item['quantity'],
                    'Harga'     => (int) $item['price'],
                    'Subtotal'  => (int) ($item['price'] * $item['quantity']),
                ]);
            }

            // ── 2. Setup Midtrans ──────────────────────────────────────
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            // ── 3. Buat item detail untuk Midtrans ─────────────────────
            $itemDetails = [];
            foreach ($request->items as $item) {
                $itemDetails[] = [
                    'id'       => (string) $item['id'],
                    'price'    => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name'     => substr($item['name'], 0, 50), // max 50 char
                ];
            }

            // Tambahkan pajak sebagai item terpisah supaya total cocok
            $subtotal = array_sum(array_map(
                fn($i) => (int)$i['price'] * (int)$i['quantity'],
                $request->items
            ));
            $pajak = (int) $request->total - $subtotal;
            if ($pajak > 0) {
                $itemDetails[] = [
                    'id'       => 'TAX',
                    'price'    => $pajak,
                    'quantity' => 1,
                    'name'     => 'Pajak (10%)',
                ];
            }

            // ── 4. Parameter Snap ──────────────────────────────────────
            $params = [
                'transaction_details' => [
                    'order_id'     => $orderCode,
                    'gross_amount' => (int) $request->total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => auth()->user()->name ?? 'Guest',
                    'email'      => auth()->user()->email ?? 'guest@nongki.id',
                ],
            ];

            // ── 5. Ambil Snap Token ────────────────────────────────────
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Log::info('Snap token created', [
                'order_id'   => $order->OrderID,
                'order_code' => $orderCode,
                'snap_token' => $snapToken,
            ]);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $order->OrderID,
                'order_code' => $orderCode,
            ]);
        });
    }

    public function checkStatus($orderId)
    {
        try {
            $order = Order::where('OrderID', $orderId)
                          ->orWhere('order_code', $orderId)
                          ->first();

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // Cek status ke Midtrans langsung
            try {
                \Midtrans\Config::$serverKey    = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

                $status = \Midtrans\Transaction::status($order->order_code);
                $transactionStatus = $status->transaction_status ?? 'pending';

                // Update status order di DB kalau sudah bayar
                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    if ($order->StatusOrder !== 'SUCCESS') {
                        $order->update(['StatusOrder' => 'SUCCESS']);
                        $this->reduceStock($order->OrderID);
                    }
                } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                    $order->update(['StatusOrder' => strtoupper($transactionStatus)]);
                }

                return response()->json([
                    'success'            => true,
                    'transaction_status' => $transactionStatus,
                    'status_order'       => $order->fresh()->StatusOrder,
                ]);

            } catch (\Exception $midtransErr) {
                // Kalau Midtrans error, fallback ke status di DB
                Log::warning('Midtrans status check failed: ' . $midtransErr->getMessage());
                $dbStatus = strtolower($order->StatusOrder);
                return response()->json([
                    'success'            => true,
                    'transaction_status' => $dbStatus === 'success' ? 'settlement' : 'pending',
                    'status_order'       => $order->StatusOrder,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error checkStatus: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    // ── Kurangi stok bahan baku setelah bayar ─────────────────────────
    private function reduceStock($orderId)
    {
        if (session()->has('stok_reduced_' . $orderId)) return;

        try {
            DB::transaction(function () use ($orderId) {
                $details = OrderDetail::where('OrderID', $orderId)->get();
                foreach ($details as $detail) {
                    $recipes = DB::table('menu_material')
                                 ->where('ProductID', $detail->ProductID)
                                 ->get();
                    foreach ($recipes as $recipe) {
                        DB::table('materials')
                            ->where('MaterialID', $recipe->MaterialID)
                            ->decrement('Stock', $recipe->QuantityNeeded * $detail->Qty);
                    }
                }
            });
            session()->put('stok_reduced_' . $orderId, true);
        } catch (\Exception $e) {
            Log::error('reduceStock error: ' . $e->getMessage());
        }
    }
}