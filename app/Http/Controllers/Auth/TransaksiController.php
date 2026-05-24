<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function simpanTransaksi(Request $request)
    {
        // 1. Ambil data produk secara dinamis (Default ke ProductID 2 / Hazelnut jika kosong)
        $productId = $request->input('product_id', 2); 
        $product = DB::table('products')->where('ProductID', $productId)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan!');
        }

        // Mulai Database Transaction agar aman jika ada salah satu proses gagal
        DB::beginTransaction();
        try {
            // 2. Simpan ke tabel 'orders' sesuai struktur persis di HeidiSQL
            $orderId = DB::table('orders')->insertGetId([
                'pelanggan'     => Auth::user()->name ?? 'Gilang Ramadhan',
                'UserID'        => Auth::id() ?? 1,
                'PaymentMethod' => (int) $request->input('payment_method_id', 1), // Pastikan bertipe INT murni
                'order_code'    => 'NGK-' . strtoupper(uniqid()),
                'TotalHarga'    => $product->Harga,
                'StatusOrder'   => 'Pending',
                'TanggalOrder'  => now(),
                'CompanyCode'   => 'NGK', // 🌟 WAJIB: Sesuai data di HeidiSQL kamu
                'Status'        => 1,
                'IsDeleted'     => 0,
                'CreatedBy'     => Auth::user()->name ?? 'Pelanggan',
                'created_at'    => now()
            ]);

            // 3. Simpan rincian ke tabel 'order_details' sesuai kolom di HeidiSQL
            DB::table('order_details')->insert([
                'OrderID'     => $orderId,
                'ProductID'   => $product->ProductID,
                'Qty'         => 1,
                'Harga'       => $product->Harga,
                'Subtotal'    => $product->Harga,
                'CompanyCode' => 'NGK', // 🌟 WAJIB: Sesuai data di HeidiSQL kamu
                'Status'      => 1,
                'IsDeleted'   => 0,
                'CreatedBy'   => Auth::user()->name ?? 'Pelanggan',
                'CreatedDate' => now(), // 🌟 WAJIB: Mengisi kolom DATETIME di tabel detail
                'created_at'  => now()
            ]);

            // 4. OTOMATIS KURANGI STOK BAHAN BAKU DI TABEL 'stok'
            // Jika kategori produk adalah 'KOPI', potong stok biji kopi (ID: 1)
            if (strtoupper($product->Category) == 'KOPI') {
                DB::table('stok')
                    ->where('id', 1) // ID 1 merujuk ke baris bahan baku utama kopi di tabel stok kamu
                    ->decrement('stok_sekarang', 1);
            } else {
                // Jika NON-KOPI, potong stok rasa/susu (ID: 2)
                DB::table('stok')
                    ->where('id', 2)
                    ->decrement('stok_sekarang', 1);
            }

            DB::commit();
            
            // Alihkan langsung ke route sukses bawaan aplikasi kamu
            return redirect()->route('order.success')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Jika masih ada kendala, dia akan melempar pesan error aslinya agar mudah dilacak
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}