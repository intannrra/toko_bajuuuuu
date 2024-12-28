@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-success">Pembayaran Berhasil!</h1>
            <p>Terima kasih, pesanan Anda telah berhasil diproses.</p>
        </div>

        <!-- Detail Transaksi -->
        <div class="mt-4">
            <h4><strong>Detail Transaksi</strong></h4>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nomor Pesanan</th>
                        <td>{{ $transaction->id }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Pengiriman</th>
                        <td>{{ $transaction->address }}</td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                    </tr>
                    <tr>
                        <th>Opsi Pengiriman</th>
                        <td>{{ strtoupper($transaction->shipping_option) }}</td>
                    </tr>
                    <tr>
                        <th>Total Pembayaran</th>
                        <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Detail Produk -->
        <div class="mt-4">
            <h4><strong>Detail Produk</strong></h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $detail)
                        <tr>
                            <td>{{ $detail->product->title }}</td>
                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
        </div>
    </div>
@endsection
