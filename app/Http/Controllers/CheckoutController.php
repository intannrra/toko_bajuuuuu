<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan form checkout.
     */
    public function showCheckoutForm()
    {
        return view('trans.checkout'); // Pastikan view 'trans.checkout' sudah ada
    }

    /**
     * Memproses data form checkout dan menghubungkan ke Midtrans.
     */
    public function process(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'address' => 'required|string',
            'shipping_service' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('SB-Mid-server-C3ThxrhGLPRpmhcy-RvwD8Eg');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        // Data untuk transaksi Midtrans
        $transactionDetails = [
            'order_id' => 'ORDER-' . strtoupper(uniqid()),
            'gross_amount' => $this->calculateTotalAmount($request),
        ];

        $itemDetails = $this->getItemDetails($request);

        $customerDetails = [
            'first_name' => Auth::check() ? Auth::user()->name : 'Guest',
            'email' => Auth::check() ? Auth::user()->email : 'guest@example.com',
            'phone' => $request->phone ?? '08123456789',
            'address' => $validated['address'],
        ];

        $midtransParams = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Buat token pembayaran menggunakan Midtrans Snap
            $snapToken = Snap::getSnapToken($midtransParams);

            // Simpan data ke session untuk ditampilkan nanti
            session(['snap_token' => $snapToken, 'transaction_details' => $transactionDetails]);

            // Redirect ke halaman sukses untuk menampilkan Snap Token
            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            // Log error dan tampilkan pesan ke pengguna
            Log::error('Midtrans error: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman sukses setelah checkout.
     */
    public function success()
    {
        // Ambil data transaksi dari session
        $snapToken = session('snap_token');
        $transactionDetails = session('transaction_details');

        if (!$snapToken || !$transactionDetails) {
            return redirect()->route('checkout')->withErrors('Data transaksi tidak ditemukan.');
        }

        return view('transactions.index', compact('snapToken', 'transactionDetails'));
    }

    /**
     * Menghitung total harga transaksi.
     */
    private function calculateTotalAmount(Request $request)
    {
        // Contoh: Ambil total dari database atau hitung dari data yang dikirim
        return 100000; // Ubah dengan logika perhitungan total
    }

    /**
     * Mendapatkan detail item untuk transaksi.
     */
    private function getItemDetails(Request $request)
    {
        // Contoh: Data barang dari keranjang
        return [
            [
                'id' => 'item1',
                'price' => 100000, // Harga item
                'quantity' => 1,
                'name' => 'Sample Item',
            ],
        ];
    }
}
