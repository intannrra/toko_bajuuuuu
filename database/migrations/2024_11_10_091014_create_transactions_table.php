<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Halaman Checkout
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.']);
        }

        // Simpan Transaksi
        $transaction = Transaction::create([
            'transaction_code' => 'TRX' . time(),
            'transaction_date' => Carbon::now(),
            'total_price' => array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart)),
            'address' => $request->address,
            'shipping' => $request->shipping,
            'payment' => $request->payment,
        ]);

        // Simpan Detail Transaksi
        foreach ($cart as $productId => $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Kurangi stok produk
            $product = Product::find($productId);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        // Hapus keranjang dari session
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'redirect' => route('transactions.index'),
        ]);
    }

    /**
     * Halaman Riwayat Transaksi
     */
    public function index()
    {
        $transactions = Transaction::with('details.product')->orderBy('transaction_date', 'desc')->get();

        return view('transactions.index', compact('transactions'));
    }
}

?>
