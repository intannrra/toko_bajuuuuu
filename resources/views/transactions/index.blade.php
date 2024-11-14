<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style untuk Sidebar */
        #sidebar {
            height: 100vh;
            width: 250px;
            background-color: #6482AD;
            padding-top: 20px;
            position: fixed;
        }
        #sidebar .nav-link {
            color: #ffffff;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        #sidebar .nav-link:hover {
            background-color: #7FA1C3;
        }
        /* Style untuk konten */
        #content {
            margin-left: 250px;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        /* Style untuk tabel */
        .rounded-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-header {
            background-color: #7FA1C3;
            color: #fff;
        }
        /* Style untuk informasi toko */
        .store-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar">
            <nav class="nav flex-column">
                <a class="nav-link" href="dashboard">Dashboard</a>
                <a class="nav-link" href="/">Beranda</a>
                <a class="nav-link" href="products">Produk</a> <!-- Link ke halaman produk -->
                <a class="nav-link" href="transactions">Transaksi</a>
                <a class="nav-link" href="logouts">Logout</a>
            </nav>
        </div>

        <!-- Konten Utama -->
        <div id="content" class="container mt-5">
            <h2>Daftar Pesanan</h2>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered rounded-table mt-4">
                <thead class="table-header">
                    <tr>
                        <th>ID</th>
                        <th>Alamat Pengiriman</th>
                        <th>Jasa Pengiriman</th>
                        <th>Metode Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->address }}</td>
                            <td>{{ $transaction->shipping_service }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
