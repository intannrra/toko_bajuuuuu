<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set Midtrans config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PROD');
        Config::$isSanitized = true;
        Config::$isProduction = env('MIDTRANS_IS_PROD', false);

    }

    public function index()
    {
        return view('checkout');  // Halaman form checkout
    }

    public function process(Request $request)
    {
        // Data transaksi
        $transaction_details = [
            'order_id' => uniqid(),  // Membuat order_id unik
            'gross_amount' => $request->total,  // Total transaksi dari form
        ];

        // Rincian produk yang dibeli
        $item_details = [
            [
                'id' => 'item1',
                'price' => $request->total,
                'quantity' => 1,
                'name' => "Sample Product",
            ],
        ];

        // Data pelanggan yang mengisi form checkout
        $customer_details = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
        ];

        // Data transaksi lengkap
        $transaction_data = [
            'payment_type'     => 'credit_card',  // Tipe pembayaran (misalnya, kartu kredit)
            'transaction_details' => $transaction_details,
            'item_details'      => $item_details,
            'customer_details'  => $customer_details,
        ];

        try {
            // Mengambil Snap token dari Midtrans
            $snapToken = Snap::getSnapToken($transaction_data);

            // Mengembalikan Snap token dalam format JSON
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            // Menangani error jika gagal
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
        // Halaman sukses setelah pembayaran berhasil
        return view('checkout-success', ['order_id' => $request->order_id]);
    }
}
