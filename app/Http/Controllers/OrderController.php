<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // ... fungsi riwayat Anda tetap ada ...
  public function riwayat()
{
    $userID = auth()->user()->UserID; // Ambil ID user yang sedang login

    // Ambil data pesanan, urutkan dari yang paling baru (DESC)
    $orders = DB::table('orders')
        ->where('UserID', $userID)
        ->where('Status', 1)
        ->orderBy('TanggalOrder', 'desc') // ✨ Memastikan urutan paling baru di atas
        ->get();

    // Sesuai dengan letak file blade kamu (jika langsung di folder views)
    return view('orders.riwayat-pesanan', compact('orders')); 
    
    // NOTE: Jika file tersebut kamu masukkan ke dalam folder khusus (misal folder 'order'), 
    // ubah menjadi: return view('order.riwayat-pesanan', compact('orders'));
}

    /**
     * Fungsi untuk memproses pembayaran dan mengurangi stok otomatis
     */
    public function prosesPembayaranSukses($orderId)
{
    // Cek dulu, apakah stok sudah dikurangi oleh PaymentController (via session atau status database)?
    // Jika Anda ingin menjadikannya tombol manual pembaruan oleh admin:
    DB::beginTransaction();

    try {
        $order = Order::where('OrderID', $orderId)->first();
        
        if ($order && $order->StatusOrder === 'paid') {
            return back()->with('info', 'Pesanan ini sudah dibayar dan stok sudah terpotong otomatis.');
        }

        $orderItems = DB::table('order_details')->where('OrderID', $orderId)->get();

        foreach ($orderItems as $item) {
            $product = Product::with('materials')->findOrFail($item->ProductID);

            foreach ($product->materials as $material) {
                $jumlahKurang = $material->pivot->QuantityNeeded * $item->Qty;

                Material::where('MaterialID', $material->MaterialID)
                        ->decrement('Stock', $jumlahKurang);
            }
        }

        // Update status order menjadi paid
        Order::where('OrderID', $orderId)->update(['StatusOrder' => 'paid']);

        DB::commit();
        return back()->with('success', 'Pembayaran manual sukses, stok telah diperbarui.');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Gagal update stok Manual Order #$orderId: " . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan sistem.');
    }
}

}