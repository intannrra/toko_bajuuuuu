<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.environment') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Menangani webhook dari Midtrans
    public function handleWebhook(Request $request)
    {
        // Mendapatkan notifikasi dari Midtrans
        $notif = new Notification();
        
        // Data transaksi dari Midtrans
        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        // Anda bisa menyimpan status transaksi ke database atau melakukan log
        Log::info("Order ID: $orderId - Status Transaksi: $transactionStatus");

        // Proses berdasarkan status transaksi
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                // Pembayaran berhasil dan tidak fraud
                // Update status transaksi menjadi sukses
                Log::info("Pembayaran berhasil: $orderId");
            } else {
                // Pembayaran gagal atau terindikasi fraud
                Log::info("Pembayaran gagal atau fraud terdeteksi: $orderId");
            }
        } elseif ($transactionStatus == 'settlement') {
            // Pembayaran berhasil
            Log::info("Pembayaran selesai: $orderId");
        } elseif ($transactionStatus == 'pending') {
            // Pembayaran tertunda
            Log::info("Pembayaran tertunda: $orderId");
        } elseif ($transactionStatus == 'deny') {
            // Pembayaran ditolak
            Log::info("Pembayaran ditolak: $orderId");
        } elseif ($transactionStatus == 'expire') {
            // Pembayaran kadaluarsa
            Log::info("Pembayaran kadaluarsa: $orderId");
        } elseif ($transactionStatus == 'cancel') {
            // Pembayaran dibatalkan
            Log::info("Pembayaran dibatalkan: $orderId");
        }

        return response()->json(['status' => 'success']);
    }
}
