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

    #content {
      margin-left: 250px;
      padding: 20px;
    }

    /* Style untuk konten */
    h1 {
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
      color: #7FA1C3;
    }

    /* Style untuk informasi toko */
    .store-info {
      background-color: #e9ecef; /* Warna latar belakang yang lebih menarik */
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan untuk efek 3D */
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

    <!-- Content -->
    <div id="content" class="w-100">
      <h3>Daftar Produk</h3>

      <div class="container mt-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
          <i class="fas fa-plus"></i> Tambah Produk
        </a>

        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped rounded-table">
            <thead class="table-dark text-center">
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
                <td><img src="{{ asset('storage/products/'.$product->image) }}" alt="Gambar Produk" class="product-image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;"></td>
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
