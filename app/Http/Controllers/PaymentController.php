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

    public function reorder($orderId)
{
    // 1. Ambil detail pesanan lama
    $oldOrder = Order::with('orderDetails')->findOrFail($orderId);

    // 2. Siapkan data untuk Checkout
    // Anda bisa mengarahkan ke halaman checkout dan menyimpan data di Session
    // atau memprosesnya kembali seperti checkoutInstan
    
    session(['reorder_data' => $oldOrder]);
    
    return redirect()->route('index.blade'); 
} 
    /**
     * Method baru untuk menangani Checkout Instan / Langsung dari detail produk
     */
    public function checkoutInstan(Request $request, $productId)
    {
        try {
            // Ambil data produk berdasarkan $productId dari database (asumsi tabel Anda bernama 'products')
          $product = DB::table('products')->where('ProductID', $id)->first();

            if (!$product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            // Atur kuantitas (default 1 jika tidak dikirim dari form)
            $quantity = $request->input('quantity', 1);
            $hargaProduk = $product->Harga ?? $product->price ?? 0; // Sesuaikan dengan nama kolom harga Anda
            $subtotal = $hargaProduk * $quantity;
            
            // Hitung pajak jika ada (misal 10%)
            $pajak = (int)($subtotal * 0.1); 
            $totalHarga = $subtotal + $pajak;

            return DB::transaction(function () use ($product, $quantity, $hargaProduk, $subtotal, $pajak, $totalHarga) {
                
                // ── 1. Buat Order ──────────────────────────────────────────
                $orderCode = 'NGK-INSTAN-' . now()->format('YmdHis') . '-' . auth()->id();

                $order = Order::create([
                    'pelanggan'    => auth()->user()->name ?? 'Guest',
                    'UserID'       => auth()->id(),
                    'TotalHarga'   => $totalHarga,
                    'StatusOrder'  => 'pending',
                    'order_code'   => $orderCode,
                    'CompanyCode'  => 'CMP001',
                    'Status'       => 1,
                    'IsDeleted'    => 0,
                    'TanggalOrder' => now(),
                    'CreatedDate'  => now(),
                    'CreatedBy'    => auth()->user()->name ?? 'Guest',
                ]);

                // Buat detail item pesanan
                OrderDetail::create([
                    'OrderID'   => $order->OrderID,
                    'ProductID' => (int) $product->ProductID,
                    'Qty'       => (int) $quantity,
                    'Harga'     => (int) $hargaProduk,
                    'Subtotal'  => (int) $subtotal,
                ]);

                // ── 2. Setup Midtrans ──────────────────────────────────────
                \Midtrans\Config::$serverKey    = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                \Midtrans\Config::$isSanitized  = true;
                \Midtrans\Config::$is3ds        = true;

                // ── 3. Buat item detail untuk Midtrans ─────────────────────
                $itemDetails = [
                    [
                        'id'       => (string) $product->ProductID,
                        'price'    => (int) $hargaProduk,
                        'quantity' => (int) $quantity,
                        'name'     => substr($product->NamaProduk ?? $product->name, 0, 50),
                    ]
                ];

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
                        'gross_amount' => (int) $totalHarga,
                    ],
                    'item_details' => $itemDetails,
                    'customer_details' => [
                        'first_name' => auth()->user()->name ?? 'Guest',
                        'email'      => auth()->user()->email ?? 'guest@nongki.id',
                    ],
                ];

                // ── 5. Ambil Snap Token ────────────────────────────────────
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                Log::info('Instant Snap token created', [
                    'order_id'   => $order->OrderID,
                    'order_code' => $orderCode,
                    'snap_token' => $snapToken,
                ]);

                // Jika request meminta JSON (via AJAX)
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success'    => true,
                        'snap_token' => $snapToken,
                        'order_id'   => $order->OrderID,
                        'order_code' => $orderCode,
                    ]);
                }

                // Jika diakses via link/form submit biasa, oper token ke view checkout
                return view('checkout.instant', [
                    'snap_token' => $snapToken,
                    'order' => $order
                ]);
            });

        } catch (\Exception $e) {
            Log::error('Error checkoutInstan: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses checkout.');
        }
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
                'StatusOrder'  => 'pending', 
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
                    'name'     => substr($item['name'], 0, 50), 
                ];
            }

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

            try {
                \Midtrans\Config::$serverKey    = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

                $status = \Midtrans\Transaction::status($order->order_code);
                $transactionStatus = $status->transaction_status ?? 'pending';
                
                $paymentType = $status->payment_type ?? null;

                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    if ($order->StatusOrder !== 'paid') {
                        $order->update([
                            'StatusOrder'    => 'paid',
                            'payment_method' => $paymentType
                        ]);
                        $this->reduceStock($order->OrderID);
                    }
                } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                    $order->update(['StatusOrder' => 'cancel']);
                }

                return response()->json([
                    'success'            => true,
                    'transaction_status' => $transactionStatus,
                    'status_order'       => $order->fresh()->StatusOrder,
                ]);

            } catch (\Exception $midtransErr) {
                Log::warning('Midtrans status check failed: ' . $midtransErr->getMessage());
                $dbStatus = strtolower($order->StatusOrder);
                return response()->json([
                    'success'            => true,
                    'transaction_status' => $dbStatus === 'paid' ? 'settlement' : 'pending',
                    'status_order'       => $order->StatusOrder,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error checkStatus: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

            $notification = new \Midtrans\Notification();
            $transactionStatus = $notification->transaction_status;
            $orderCode = $notification->order_id;
            $paymentType = $notification->payment_type;

            $order = Order::where('order_code', $orderCode)->first();

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
            }

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($order->StatusOrder !== 'paid') {
                    $order->update([
                        'StatusOrder'    => 'paid',
                        'payment_method' => $paymentType
                    ]);
                    $this->reduceStock($order->OrderID);
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                $order->update(['StatusOrder' => 'cancel']);
            }

            return response()->json(['success' => true, 'message' => 'Notification processed']);

        } catch (\Exception $e) {
            Log::error('Webhook Midtrans Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function orderSuccess($orderId)
    {
        $order = Order::with(['orderDetails.product'])
                      ->where('order_code', $orderId)
                      ->orWhere('OrderID', $orderId)
                      ->first();

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        return view('payment.success', compact('order'));
    }

    private function reduceStock($orderId)
    {
        \Log::info("Fungsi reduceStock terpanggil untuk Order ID: " . $orderId);

        try {
            DB::transaction(function () use ($orderId) {
                $details = DB::table('order_details')->where('OrderID', $orderId)->get();
                \Log::info("Jumlah item ditemukan di order_details: " . $details->count());
                
                foreach ($details as $detail) {
                    $recipes = DB::table('menu_material')
                                 ->where('ProductID', $detail->ProductID)
                                 ->get();
                                 
                    \Log::info("Menu ProductID {$detail->ProductID} butuh {$recipes->count()} bahan baku.");

                    foreach ($recipes as $recipe) {
                        $jumlahPotong = $recipe->QuantityNeeded * $detail->Qty;
                        
                        $affected = DB::table('materials')
                            ->where('MaterialID', $recipe->MaterialID)
                            ->decrement('Stock', $jumlahPotong);
                            
                        \Log::info("Bahan MaterialID {$recipe->MaterialID} dipotong sebanyak {$jumlahPotong}. Status baris terpengaruh: " . $affected);
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::error('Gagal memotong stok otomatis: ' . $e->getMessage());
        }
    }
}