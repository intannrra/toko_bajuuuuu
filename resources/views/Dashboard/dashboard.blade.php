<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Style untuk Sidebar */
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

    h1 {
      color: #333;
    }

    .table-container {
      margin-top: 30px;
    }
    
    .card {
      margin-bottom: 30px;
    }

    .card-header {
      background-color: #2c3e50;
      color: white;
    }

    .card-body {
      background-color: #ecf0f1;
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
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </nav>
    </div>

    <!-- Content -->
    <div id="content" class="w-100">
      <h1>Selamat Datang di Dashboard Admin</h1>
      <p>This is your main dashboard content. You can add charts, data tables, or any other information here.</p>

      <!-- Grafik Transaksi -->
      <div class="card">
        <div class="card-header">
          Grafik Jumlah Transaksi
        </div>
        <div class="card-body">
          <canvas id="transaksiChart" width="400" height="200"></canvas>
        </div>
      </div>

      <!-- Tabel Transaksi -->
      <div class="table-container">
        <div class="card">
          <div class="card-header">
            Daftar Transaksi
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Tanggal</th>
                  <th>Total Transaksi</th>
                  <th>Status</th>
                  <th>Nama Pengguna</th>
                  <th>Produk</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transactions as $transaction)
                <tr>
                  <td>{{ $transaction->id }}</td>
                  <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}</td>
                  <td>{{ number_format($transaction->total_price, 2) }}</td>
                  <td>{{ $transaction->status }}</td>
                  <td>{{ $transaction->user->name }}</td>
                  <td>
                    @foreach($transaction->products as $product)
                      <p>{{ $product->name }} ({{ $product->pivot->quantity }} x {{ number_format($product->pivot->price, 2) }})</p>
                    @endforeach
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script untuk Grafik Chart.js -->
  <script>
    // Memproses data untuk Chart.js
    var data = @json($transactions);

    var tanggal = data.map(item => item.created_at);
    var totalTransaksi = data.map(item => item.total_price);

    var ctx = document.getElementById('transaksiChart').getContext('2d');
    var transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: tanggal,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: totalTransaksi,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false,
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  </script>

  <!-- Link Bootstrap JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <!-- Optional: Include Font Awesome for icons -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
