<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Sidebar styles */
        #sidebar {
            height: 100vh;
            width: 250px;
            background-color: #2c3e50;
            padding-top: 20px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
            border-right: 1px solid #d3d3d3;
            transition: width 0.3s;
        }

        #sidebar .nav-link {
            color: #ffffff;
            font-size: 1.1rem;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        }

        #sidebar .nav-link i {
            margin-right: 12px;
        }

        #sidebar .nav-link:hover {
            background-color: #34495e;
            color: #e9ecef;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        .product-image {
            width: 100%;
            max-width: 200px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .card-body {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar">
            <nav class="nav flex-column">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link" href="/home">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a class="nav-link" href="products">
                    <i class="fas fa-box"></i> Produk
                </a>
                <a class="nav-link" href="transactions">
                    <i class="fas fa-money-check-alt"></i> Transaksi
                </a>
                <a class="nav-link" href="logouts">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Content -->
        <div id="content" class="w-100">
            <div class="container mt-3">
                <h4 class="text-center mt-3">Detail Produk</h4>
                <div class="card mx-auto" style="max-width: 400px;">
                    <img src="{{ asset('storage/products/'.$product->image) }}" alt="Gambar Produk" class="product-image mx-auto mt-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">Ukuran: {{ $product->size }}</p>
                        <p class="card-text">Deskripsi: {{ $product->description }}</p>
                        <p class="card-text text-success fw-bold">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
