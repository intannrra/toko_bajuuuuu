@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Transaksi</h1>

    @foreach($transactions as $transaction)
        <div class="card mb-4">
            <div class="card-body">
                <h5>Transaksi #{{ $transaction->id }}</h5>
                <p>Alamat: {{ $transaction->address }}</p>
                <p>Metode Pengiriman: {{ $transaction->shipping_method }}</p>
                <p>Metode Pembayaran: {{ $transaction->payment_method }}</p>
                <p>Total Harga: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                <h6>Detail Item:</h6>
                <ul>
                    @foreach($transaction->items as $item)
                        <li>{{ $item->product_title }} - {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
