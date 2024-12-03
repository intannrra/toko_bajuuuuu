<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Menampilkan form checkout
    public function showCheckoutForm()
    {
        return view('trans.checkout');  // Pastikan Anda punya view 'checkout.form'
    }

    // Fungsi untuk memproses data form
    public function process(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'address' => 'required|string',
            'shipping_service' => 'required|string',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|file|mimes:jpg,png,jpeg,pdf',
        ]);

        // Menyimpan bukti pembayaran jika ada file yang di-upload
        if ($request->hasFile('payment_proof')) {
            // Menyimpan file ke storage dan mendapatkan path
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $paymentProofPath;
        }

        // Arahkan ke halaman success dan kirim data yang sudah divalidasi
        return redirect()->route('checkout.success')->with('data', $validated);
    }

    // Fungsi untuk menampilkan halaman sukses setelah checkout
    public function success()
    {
        $data = session('data');
        if ($data === null) {
            return redirect()->route('checkout')->withErrors('No data found');

        }
        return view('transactions.index', compact('data'));
    }
}
