<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index() {
        return view('checkout.index');
    }
    
  public function create(Request $request)
    {
        // --- PASANG DETEKTIF DI SINI ---
    \Log::info('DEBUG PAYMENT:', [
        'request_total' => $request->total,
        'semua_data' => $request->all()
    ]);
        Log::info('Data Checkout diterima:', $request->all());

        return DB::transaction(function () use ($request) {
                $order = Order::create([
            'pelanggan'       => auth()->user()->name ?? 'Guest',
            'UserID'          => auth()->id(),
            'TotalHarga'      => (int) $request->total,
            'StatusOrder'     => 'Pending',
            'order_code'      => 'INV-' . time(),
            'CompanyCode'     => 'CMP001',
            'Status'          => 1,
            'IsDeleted'       => 0,
            // Pastikan kolom-kolom ini ada jika di database NOT NULL:
            'TanggalOrder'    => now(),
            'CreatedDate'     => now(),
            'CreatedBy'       => auth()->user()->name ?? 'Guest',
        ]);

            foreach ($request->items as $item) {
                OrderDetail::create([
                    'OrderID'   => $order->OrderID,
                    'ProductID' => (int) $item['id'],
                    'Qty'       => (int) $item['quantity'],
                    'Harga'     => (int) $item['price'],
                    'Subtotal'  => (int) ($item['price'] * $item['quantity'])
                ]);
            }

            return response()->json(['success' => true, 'order_id' => $order->OrderID]);
        });
    }

    public function checkStatus($orderId)
    {
        try {
            $order = Order::where('OrderID', $orderId)->first();
            if (!$order) return response()->json(['success' => false], 404);

            if (strtoupper($order->StatusOrder) === 'SUCCESS' && !session()->has('stok_reduced_' . $orderId)) {
                DB::transaction(function () use ($orderId) {
                    $details = OrderDetail::where('OrderID', $orderId)->get();
                    foreach ($details as $detail) {
                        $recipes = DB::table('menu_material')->where('ProductID', $detail->ProductID)->get();
                        foreach ($recipes as $recipe) {
                            // 🔥 PERBAIKAN: Gunakan 'MaterialID' sesuai dengan nama di database kamu
                            DB::table('materials')
                                ->where('MaterialID', $recipe->MaterialID) 
                                ->decrement('Stock', ($recipe->QuantityNeeded * $detail->Qty)); // 🔥 Sesuaikan juga 'QuantityNeeded'
                        }
                    }
                    session()->put('stok_reduced_' . $orderId, true);
                });
            }
            return response()->json(['success' => true, 'status_order' => strtoupper($order->StatusOrder)]);
        } catch (\Exception $e) {
            Log::error("Error status: " . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}