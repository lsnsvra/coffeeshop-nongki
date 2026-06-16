<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Simpan transaksi dari kasir (POS) - bayar tunai langsung.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart'             => 'required|array|min:1',
            'cart.*.id'        => 'required|integer|exists:products,ProductID',
            'cart.*.name'      => 'required|string',
            'cart.*.price'     => 'required|numeric|min:0',
            'cart.*.qty'       => 'required|integer|min:1',
            'subtotal'         => 'required|numeric|min:0',
            'tax'              => 'required|numeric|min:0',
            'total'            => 'required|numeric|min:0',
            'cash_received'    => 'required|numeric|min:0',
            'order_type'       => 'required|in:dinein,takeaway',
        ]);

        if ((float) $validated['cash_received'] < (float) $validated['total']) {
            return response()->json([
                'success' => false,
                'message' => 'Uang yang diterima kurang dari total pembayaran.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Ambil PaymentMethodID untuk "Tunai"
            $paymentMethod = DB::table('payment_methods')
                ->where('NamaMetode', 'Tunai')
                ->where('IsDeleted', 0)
                ->first();

            if (!$paymentMethod) {
                throw new \Exception('Metode pembayaran "Tunai" belum terdaftar di tabel payment_methods.');
            }

            $user      = Auth::user();
            $trxCode   = 'TRX-' . now()->format('ymdHis') . '-' . rand(100, 999);
            $orderType = $validated['order_type'] === 'dinein' ? 'Dine In' : 'Take Away';

            // 1. Insert ke orders
            $orderId = DB::table('orders')->insertGetId([
                'pelanggan'        => "Kasir",
                'UserID'           => $user->UserID ?? null,
                'PaymentMethodID'  => $paymentMethod->PaymentMethodID,
                'order_code'       => $trxCode,
                'TotalHarga'       => $validated['total'],
                'StatusOrder'      => 'paid',
                'TanggalOrder'     => now(),
                'CompanyCode'      => $user->CompanyCode ?? null,
                'Status'           => 1,
                'IsDeleted'        => 0,
                'CreatedBy'        => $user->Nama ?? 'kasir',
                'CreatedDate'      => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // 2. Insert ke order_details + kurangi stok material via resep
            foreach ($validated['cart'] as $item) {

                DB::table('order_details')->insert([
                    'OrderID'     => $orderId,
                    'ProductID'   => $item['id'],
                    'Qty'         => $item['qty'],
                    'Harga'       => $item['price'],
                    'Subtotal'    => $item['price'] * $item['qty'],
                    'Status'      => 1,
                    'IsDeleted'   => 0,
                    'CreatedBy'   => $user->Nama ?? 'kasir',
                    'CreatedDate' => now(),
                ]);

                // Kurangi stok material berdasarkan resep (menu_material)
                $product = Product::with('materials')->find($item['id']);

                if ($product) {
                    foreach ($product->materials as $material) {
                        $needed = $material->pivot->QuantityNeeded * $item['qty'];

                        Material::where('MaterialID', $material->MaterialID)
                            ->decrement('Stock', $needed);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success'  => true,
                'order_id' => $orderId,
                'trx_code' => $trxCode,
                'change'   => $validated['cash_received'] - $validated['total'],
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Transaksi Kasir gagal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Riwayat transaksi untuk halaman kasir.
     */
   public function riwayat()
{
    $transactions = DB::table('orders')
        ->leftJoin('payment_methods', 'orders.PaymentMethodID', '=', 'payment_methods.PaymentMethodID')
        ->where('orders.IsDeleted', 0)
        ->orderByDesc('orders.TanggalOrder')
        ->select(
            'orders.*',
            'payment_methods.NamaMetode'
        )
        ->get();

    return view('kasir.transaksi', compact('transactions'));
}
}