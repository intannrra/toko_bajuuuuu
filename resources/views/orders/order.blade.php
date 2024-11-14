<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Pesanan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Alamat</th>
                    <th>Jasa Pengirim</th>
                    <th>Metode Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->shipping_service }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><a href="{{ route('orders.detail', $order->id) }}" class="btn btn-primary">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
