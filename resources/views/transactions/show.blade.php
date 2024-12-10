<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detail Transaksi</h2>

        <table class="table table-bordered mt-4">
            <tr>
                <th class="table-dark">ID Transaksi</th>
                <td>{{ $transaction->id }}</td>
            </tr>
            <tr>
                <th class="table-dark">Alamat Pengiriman</th>
                <td>{{ $transaction->address }}</td>
            </tr>
            <tr>
                <th class="table-dark">Jasa Pengirim</th>
                <td>{{ $transaction->shipping_service }}</td>
            </tr>
            <tr>
                <th class="table-dark">Metode Pembayaran</th>
                <td>{{ $transaction->payment_method }}</td>
            </tr>
            <tr>
                <th class="table-dark">Status</th>
                <td>{{ $transaction->status }}</td>
            </tr>
            @if ($transaction->payment_proof)
                <tr>
                    <th class="table-dark">Bukti Pembayaran</th>
                    <td>
                        <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank">Lihat Bukti Pembayaran</a>
                    </td>
                </tr>
            @endif
        </table>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
