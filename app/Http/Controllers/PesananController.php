<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Product; // Asumsi Anda memiliki model Product
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Menampilkan halaman pesanan dan produk
    public function index()
    {
        // Mengambil semua produk dari model Product
        $products = Product::all();


        // Mengirim data produk dan pesanan ke view 'pesanan'
        return view('pesanans.index', compact('products'));
    }

    // Fungsi untuk menambahkan produk ke dalam pesanan
    public function addToPesanan(Request $request)
    {
        // Validasi input
        $request->validate([
            'pesanan_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'pesanan_color' => 'nullable|string',
            'pesanan_image' => 'required|string' // Asumsikan link gambar produk dari front-end
        ]);

        // Buat pesanan baru
        Pesanan::create([
            'pesanan_name' => $request->pesanan_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'pesanan_color' => $request->pesanan_color,
            'pesanan_image' => $request->pesanan_image
        ]);

        // Redirect atau response JSON (untuk Ajax request)
        return back()->with('success', 'Produk berhasil ditambahkan ke pesanan!');
    }

    // Fungsi untuk menghapus produk dari pesanan
    public function destroy($id)
    {
        // Mencari pesanan berdasarkan id dan menghapusnya
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        // Redirect atau response JSON (untuk Ajax request)
        return back()->with('success', 'Pesanan berhasil dihapus!');
    }

    // Fungsi checkout pesanan
    public function checkout()
    {
        // Logika untuk checkout pesanan (misalnya, konfirmasi pesanan, pembayaran, dll.)

        // Setelah checkout, pesanan dapat dihapus atau statusnya bisa diubah
        Pesanan::truncate(); // Menghapus semua data pesanan setelah checkout

        // Redirect atau response JSON
        return back()->with('success', 'Checkout berhasil!');
    }
}
