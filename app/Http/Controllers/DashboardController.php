<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data transaksi dengan relasi user dan products
        $transactions = Transaction::with(['user', 'products'])->get();

        // Menambahkan title dan description untuk view
        $data = [
            'title' => 'Dashboard',
            'description' => 'Selamat datang',
        ];

        // Mengembalikan view dengan data transaksi dan data tambahan
        return view('dashboard.dashboard', compact('transactions', 'data'));
    }
}
