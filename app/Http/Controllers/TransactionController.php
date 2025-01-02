<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cart;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $address_id = $request->input('address');
        $shipping_method = $request->input('shipping');
        $payment_method = $request->input('payment');
        $total_amount = session('cart_total');

        // Simpan transaksi
        $transaction = Transaction::create([
            'address_id' => $address_id,
            'shipping_method' => $shipping_method,
            'payment_method' => $payment_method,
            'total_amount' => $total_amount
        ]);

        // Pindahkan produk dari keranjang ke riwayat transaksi
        $cart = session('cart');
        foreach ($cart as $item) {
            $transaction->products()->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        // Hapus keranjang belanja setelah checkout
        session()->forget('cart');

        return response()->json(['success' => true]);
    }

    public function index()
    {
        // Ambil semua transaksi
        $transactions = Transaction::all();

        return view('transactions.index', compact('transactions'));
    }

    public function tpk()
    {
        // Ambil data transaksi yang sama seperti di halaman index
    $transactions = Transaction::with('products')->get();

        // Kirim data transaksi ke view
        return view('transactions.tpk', compact('transactions'));
    }


}
