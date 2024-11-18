<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Style untuk Sidebar */
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
      padding: 30px;
      background-color: #f8f9fa;
      min-height: 100vh;
    }

    /* Style untuk konten */
    h3 {
      color: #333;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #2980b9;
      border-color: #2980b9;
    }

    /* Style untuk tabel */
    .rounded-table {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-header {
      background-color: #34495e;
      color: #ffffff;
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

    /* Animasi hover untuk tombol aksi */
    .btn-sm {
      transition: transform 0.2s;
    }

    .btn-sm:hover {
      transform: scale(1.05);
    }

    /* Style untuk gambar produk */
    .product-image {
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
      <h3>Daftar Produk</h3>

      <div class="container mt-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
          <i class="fas fa-plus"></i> Tambah Produk
        </a>

        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped rounded-table">
            <thead class="table-header text-center">
              <tr>
                <th scope="col">Gambar</th>
                <th scope="col">Nama</th>
                <th scope="col">Ukuran</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Id</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @forelse ($products as $product)
              <tr>
                <td><img src="{{ asset('storage/products/'.$product->image) }}" alt="Gambar Produk" class="product-image" style="width: 100px; height: 100px; object-fit: cover;"></td>
                <td>{{$product->title}}</td>
                <td>{{$product->size}}</td>
                <td class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{$product->stock}}</td>
                <td>{{$product->id}}</td>
                <td>
                  <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-eye"></i> Lihat
                  </a>
                  <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">Data Belum Tersedia</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Link Bootstrap JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <!-- Optional: Include Font Awesome for icons -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
