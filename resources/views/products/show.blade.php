<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Detail Produk</title>
    <style>
        .product-image {
            width: 150px;  /* Ubah lebar gambar sesuai kebutuhan */
            height: auto;  /* Tinggi otomatis agar proporsional */
            object-fit: cover; /* Agar gambar tidak terdistorsi */
        }
        #sidebar {
      height: 100vh;
      width: 250px;
      background-color: #2c3e50;
      padding-top: 20px;
      position: fixed;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15); /* Tambahkan bayangan */
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
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Efek shadow pada hover */
    }

        #content {
            margin-left: 250px;
            padding: 20px;
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
        <a class="nav-link" href="/">
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
                <div class="card">
                    <img src="{{ asset('storage/products/'.$product->image) }}" alt="Gambar Produk" class="product-image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">Ukuran: {{ $product->size }}</p>
                        <p class="card-text">Deskripsi: {{ $product->description }}</p>
                        <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="card-text">Stok: {{ $product->stock }}</p>
                        <p class="card-text">Id: {{ $product->id }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
