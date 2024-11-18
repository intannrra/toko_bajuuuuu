<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Produk</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      margin-top: 20px;
      border-radius: 15px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }
    .card:hover {
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
    }

    .product-image {
      max-width: 100px;
      max-height: 100px;
      border-radius: 8px;
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

    .btn-primary, .btn-secondary {
      padding: 10px 20px;
      border-radius: 8px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover, .btn-secondary:hover {
      background-color: #7FA1C3;
      transform: scale(1.05);
    }

    .btn-secondary {
      color: #fff;
      background-color: #6c757d;
      border-color: #6c757d;
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
      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="card shadow-lg">
              <div class="card-body">
                <h4 class="card-title text-center">Edit Produk</h4>

                <!-- Tampilkan error jika ada -->
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <!-- Form untuk mengedit produk -->
                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data" novalidate>
                  @csrf
                  @method('PUT')

                  <!-- Input gambar -->
                  <div class="mb-3">
                    <label for="image" class="form-label">Upload Gambar Baru</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                  </div>

                  <!-- Tampilkan gambar lama jika ada -->
                  @if($product->image)
                    <div class="mb-3">
                      <label>Gambar Saat Ini:</label>
                      <img src="{{ asset('storage/products/'.$product->image) }}" alt="Gambar Produk" class="product-image">
                    </div>
                  @endif

                  <!-- Input nama barang -->
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="title" id="floatingNamaBarang" placeholder="Nama Barang" value="{{ old('title', $product->title) }}" required>
                    <label for="floatingNamaBarang">Nama Barang</label>
                  </div>

                  <!-- Input ukuran -->
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="size" id="floatingUkuran" placeholder="Ukuran" value="{{ old('size', $product->size) }}" required>
                    <label for="floatingUkuran">Ukuran</label>
                  </div>

                  <!-- Input harga -->
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="price" id="floatingHarga" placeholder="Harga" value="{{ old('price', $product->price) }}" required>
                    <label for="floatingHarga">Harga (Rp)</label>
                  </div>

                  <!-- Input stok -->
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="stock" id="floatingStok" placeholder="Stok" value="{{ old('stock', $product->stock) }}" required>
                    <label for="floatingStok">Stok</label>
                  </div>

                  <!-- Input deskripsi -->
                  <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" id="floatingTextarea" placeholder="Deskripsi Produk" required>{{ old('description', $product->description) }}</textarea>
                    <label for="floatingTextarea">Deskripsi Produk</label>
                  </div>

                  <!-- Tombol submit dan batal -->
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- JavaScript for form validation -->
  <script>
    (function () {
      'use strict';
      var forms = document.querySelectorAll('form');

      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>
</html>
