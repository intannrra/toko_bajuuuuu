<?php

namespace App\Http\Controllers;

use App\Models\Product; // pastikan ini ada jika Anda menggunakan model Product
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data produk dari database
        $products = Product::all();

        // Kirim data produk ke view 'homes.home'
        return view('homes.home', compact('products'));
    }
}
