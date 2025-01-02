@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Transaksi</h1>
        <a href="{{ route('transactions.tpk') }}" class="btn btn-success">
            <i class="fas fa-calculator"></i> Hitung TPK
        </a>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-4">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    @foreach($transactions as $transaction)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Transaksi #{{ $transaction->id }}</strong>
            </div>
            <div class="card-body">
                <p><strong>Alamat:</strong> {{ $transaction->address }}</p>
                <p><strong>Metode Pengiriman:</strong> {{ $transaction->shipping_option }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $transaction->payment_method }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>

                <h6 class="mt-3"><strong>Detail Item:</strong></h6>
                <ul>
                    @foreach($transaction->products as $product)
                        <li>{{ $product->title }} - {{ $product->pivot->quantity }} x Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection

