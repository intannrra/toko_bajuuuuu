<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Data untuk dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->total_price, // Total harga
            ],
            'customer_details' => [
                'first_name' => 'Nama Depan',
                'last_name' => 'Nama Belakang',
                'email' => 'email@example.com',
                'phone' => '08123456789',
            ],
        ];

        // Membuat Snap Token pembayaran
        $snapToken = Snap::getSnapToken($params);

        // Kirim token ke tampilan untuk ditampilkan
        return view('checkout.payment', ['snapToken' => $snapToken]);
    }
}
