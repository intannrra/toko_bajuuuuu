@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Perhitungan TPK</h1>

    <!-- Tabel Produk Terlaris -->
    <div class="card">
        <div class="card-header">
            Produk Terlaris
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Inisialisasi array untuk menghitung total penjualan produk
                        $productSales = [];

                        foreach ($transactions as $transaction) {
                            foreach ($transaction->products as $product) {
                                // Hitung berdasarkan ID produk
                                if (!isset($productSales[$product->id])) {
                                    $productSales[$product->id] = [
                                        'name' => $product->title,
                                        'total_sold' => 0,
                                    ];
                                }

                                // Tambahkan jumlah penjualan
                                $productSales[$product->id]['total_sold'] += $product->pivot->quantity;
                            }
                        }

                        // Urutkan data berdasarkan total penjualan (descending)
                        $productSales = collect($productSales)->sortByDesc('total_sold')->take(5); // Top 5 produk
                    @endphp

                    @forelse($productSales as $index => $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['total_sold'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data produk terjual</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('transactions.index') }}" class="btn btn-success mt-4">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Transaksi
    </a>
</div>
@endsection

