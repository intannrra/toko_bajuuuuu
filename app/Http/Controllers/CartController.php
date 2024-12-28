<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class CartController extends Controller
{
    // Menampilkan keranjang
    public function index()
    {
        // Mengambil data keranjang berdasarkan user yang login dan mengikutkan relasi produk
        $cart = Cart::where('user_id', Auth::id())->with('product')->get();

        // Menghitung total harga produk dalam keranjang
        $totalPrice = $cart->sum(fn($item) => $item->product->price * $item->quantity);

        // Mengirim data ke view 'carts.index'
        return view('carts.index', compact('cart', 'totalPrice'));
    }

    // Menambahkan item ke keranjang
    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Mencari produk berdasarkan ID
        $product = Product::findOrFail($request->product_id);

        // Mencari keranjang berdasarkan user dan produk, atau membuat entri baru jika belum ada
        $cart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'quantity' => 1,
                'price' => $product->price,
            ]
        );

        // Menambah jumlah produk dalam keranjang
        $cart->quantity += $request->quantity;
        $cart->save();

        // Redirect ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Menghapus item dari keranjang
    public function remove(Request $request)
    {
        // Validasi input
        $request->validate(['product_id' => 'required']);

        // Menghapus produk dari keranjang berdasarkan user dan produk
        Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        // Redirect ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Proses checkout

    public function checkout(Request $request)
    {
        // Validasi data input
        $request->validate([
            'address' => 'required|string',
            'shipping_option' => 'required|string',
            'payment_method' => 'required|string|in:transfer,e-wallet',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->withErrors('Keranjang belanja Anda kosong.');
        }

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Simpan transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'shipping_option' => $request->shipping_option,
            'message' => $request->message,
        ]);

        // Simpan detail transaksi
        foreach ($cartItems as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data untuk Snap Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->title,
                ];
            })->toArray(),
        ];

        // Pilihan pembayaran
        if ($request->payment_method === 'transfer') {
            $params['enabled_payments'] = ['bank_transfer'];
        } elseif ($request->payment_method === 'e-wallet') {
            $params['enabled_payments'] = ['gopay', 'shopeepay'];
        }

        // Generate Snap token
        $snapToken = Snap::getSnapToken($params);

        // Hapus keranjang setelah checkout
        Cart::where('user_id', $user->id)->delete();
        $transactionId = $transaction->id;
        // Redirect ke halaman Midtrans
        return view('payment.index', compact('snapToken','transactionId'));
    }
    public function paymentSuccess($transactionId)
    {
        $transaction = Transaction::with('details.product')->findOrFail($transactionId);

        return view('payment.success', compact('transaction'));
    }


    // Membuat pembayaran dengan Midtrans
    public function createPayment(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Mendapatkan transaksi berdasarkan ID yang dikirimkan
        $transaction = Transaction::findOrFail($request->transaction_id);

        // Menyiapkan data transaksi untuk Midtrans
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name, // Mengambil nama user yang login
                'email' => Auth::user()->email, // Mengambil email user yang login
            ],
        ]);

        // Mengembalikan Snap Token dalam format JSON
        return response()->json(['snap_token' => $snapToken]);
    }
}
