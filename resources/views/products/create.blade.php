<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Tambah Produk</title>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      margin-top: 20px;
    }
    .form-control:invalid {
      border-color: #dc3545;
    }
    .form-control:valid {
      border-color: #28a745;
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
        <a class="nav-link" href="products"><i class="fas fa-box"></i> Produk</a>
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
            <div class="card shadow">
              <div class="card-body">
                <h4 class="card-title text-center">Tambah Produk</h4>

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

                <!-- Form untuk menambah produk -->
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" novalidate>
                @csrf  <!-- Token CSRF wajib untuk keamanan Laravel -->

                  <!-- Input gambar -->
                  <div class="mb-3">
                    <label for="image" class="form-label">Upload Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    <div class="invalid-feedback">Harap unggah gambar produk.</div>
                  </div>

                  <!-- Input nama barang -->
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="title" id="floatingNamaBarang" placeholder="Nama Barang" value="{{ old('title') }}" required>
                    <label for="floatingNamaBarang">Nama Barang</label>
                    <div class="invalid-feedback">Nama barang wajib diisi.</div>
                  </div>

                  <!-- Input ukuran -->
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="size" id="floatingUkuran" placeholder="Ukuran" value="{{ old('size') }}" required>
                    <label for="floatingUkuran">Ukuran</label>
                    <div class="invalid-feedback">Ukuran wajib diisi.</div>
                  </div>

                  <!-- Input harga -->
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="price" id="floatingHarga" placeholder="Harga" value="{{ old('price') }}" required>
                    <label for="floatingHarga">Harga (Rp)</label>
                    <div class="invalid-feedback">Harga wajib diisi.</div>
                  </div>

                  <!-- Input stok -->
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="stock" id="floatingStok" placeholder="Stok" value="{{ old('stock') }}" required>
                    <label for="floatingStok">Stok</label>
                    <div class="invalid-feedback">Stok wajib diisi.</div>
                  </div>

                  <!-- Input deskripsi -->
                  <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" id="floatingTextarea" placeholder="Deskripsi Produk" required>{{ old('description') }}</textarea>
                    <label for="floatingTextarea">Deskripsi Produk</label>
                    <div class="invalid-feedback">Deskripsi wajib diisi.</div>
                  </div>

                  <!-- Tombol submit dan reset -->
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    <button type="reset" class="btn btn-warning">Reset Formulir</button>
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
    // Disable form submission if there are invalid fields
    (function () {
      'use strict';
      var forms = document.querySelectorAll('form');

      Array.prototype.slice.call(forms)
        .forEach(function (form) {
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
