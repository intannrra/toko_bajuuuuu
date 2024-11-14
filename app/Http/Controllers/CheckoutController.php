<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    // Method untuk menampilkan form checkout
    public function showCheckoutForm()
    {
        return view('trans.checkout'); // Pastikan nama view sesuai dengan struktur folder Anda
    }

    // Method untuk memproses checkout
    public function process(Request $request)
    {
        // Validasi form
        $request->validate([
            'address' => 'required|string|max:255',
            'shipping_service' => 'required|string',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Simpan file bukti pembayaran jika bukan Midtrans
        $filename = null;
        if ($request->hasFile('payment_proof') && $request->payment_method !== 'midtrans') {
            $file = $request->file('payment_proof');
            $filename = $file->hashName();
            $file->storeAs('public/payment_proofs', $filename);
        }

        // Simpan data transaksi ke dalam tabel `transactions`
        $transaction = new Transaction();
        $transaction->user_id = auth()->id(); // Id user yang melakukan checkout
        $transaction->address = $request->address;
        $transaction->shipping_service = $request->shipping_service;
        $transaction->payment_method = $request->payment_method;
        $transaction->payment_proof = $filename; // Nama file bukti pembayaran
        $transaction->status = 'pending'; // Status awal transaksi
        $transaction->total_price = $request->total_price; // Pastikan `total_price` tersedia di request

        $transaction->save(); // Simpan transaksi

        // Proses Midtrans jika metode pembayaran menggunakan Midtrans
        if ($request->payment_method === 'midtrans') {
            return $this->processMidtransPayment($transaction);
        }

        return redirect()->route('pesanans.index')->with('success', 'Checkout berhasil, bukti pembayaran berhasil diunggah!');
    }

    // Method untuk memproses pembayaran Midtrans
    public function processMidtransPayment($transaction)
    {
        // Contoh proses Midtrans API
        // Setelah mendapatkan `snapToken`, simpan token ke dalam database atau lakukan pengaturan yang diperlukan
        $transaction->status = 'completed'; // Ubah status transaksi jika pembayaran berhasil
        $transaction->save();

        return redirect()->route('pesanans.index')->with('success', 'Pembayaran Midtrans berhasil!');
    }
}
