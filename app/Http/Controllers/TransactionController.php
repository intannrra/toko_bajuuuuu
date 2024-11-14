<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Proses penyimpanan checkout
    public function processCheckout(Request $request)
    {
        $totalPrice = 0;

        // Pastikan bahwa $request->items adalah array sebelum menjalankan foreach
        if (is_array($request->items)) {
            foreach ($request->items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
        } else {
            // Jika $request->items tidak ada atau bukan array, berikan nilai default
            return redirect()->back()->withErrors('Items tidak ditemukan atau format tidak sesuai.');
        }

        // Simpan data checkout ke database
        $transaction = Transaction::create([
            'address' => $request->address,
            'shipping_service' => $request->shipping_service,
            'payment_method' => $request->payment_method,
            'status' => 'checkout',
            'total_price' => $totalPrice,
        ]);

        // Redirect ke halaman Daftar Pesanan
        return redirect()->route('transactions.index')->with('success', 'Checkout berhasil!');
    }

    // Menampilkan daftar transaksi
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }
}
