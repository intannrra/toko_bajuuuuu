<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Midtrans;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set Midtrans config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PROD');
        Config::$isSanitized = true;
    }

    // Method untuk mendapatkan Snap Token
    public function getToken(Request $request)
    {
        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => 100000, // Total amount
        ];

        $item_details = [
            [
                'id' => 'item1',
                'price' => 100000,
                'quantity' => 1,
                'name' => "Sample Product",
            ],
        ];

        $customer_details = [
            'first_name'    => "Budi",
            'last_name'     => "Santoso",
            'email'         => "budi@example.com",
            'phone'         => "081234567890",
        ];

        $transaction_data = [
            'payment_type'     => 'credit_card',
            'transaction_details' => $transaction_details,
            'item_details'      => $item_details,
            'customer_details'  => $customer_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction_data);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // Method untuk menangani callback dari Midtrans
    public function callback(Request $request)
    {
        $notif = new Notification();

        // Mendapatkan status transaksi
        $transaction_status = $notif->transaction_status;
        $order_id = $notif->order_id;
        $gross_amount = $notif->gross_amount;

        // Logika untuk memproses status pembayaran
        if ($transaction_status == 'settlement') {
            // Pembayaran berhasil, perbarui status pesanan
            // Misalnya: Order::where('order_id', $order_id)->update(['status' => 'paid']);
        } elseif ($transaction_status == 'pending') {
            // Pembayaran sedang menunggu
            // Update status pesanan menjadi 'pending'
        } elseif ($transaction_status == 'cancel') {
            // Pembayaran gagal
            // Perbarui status pesanan menjadi 'cancelled'
        }

        // Kirim respons untuk Midtrans agar tidak melakukan pengiriman lebih lanjut
        return response()->json(['status' => 'success']);
    }
}
