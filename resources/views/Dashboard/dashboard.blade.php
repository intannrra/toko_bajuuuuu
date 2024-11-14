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

    h1 {
      color: #333;
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
        <a class="nav-link" href="products">Produk</a>
        <a class="nav-link" href="transactions">Transaksi</a>
        <a class="nav-link" href="logouts">Logout</a>
      </nav>
    </div>

    <!-- Content -->
    <div id="content" class="w-100">
      <h1>Selamat Datang di Dashboard Admin</h1>
      <p>This is your main dashboard content. You can add charts, data tables, or any other information here.</p>

      <!-- Canvas untuk Grafik -->
      <div>
        <canvas id="transaksiChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Script untuk Grafik Chart.js -->
  <script>
    var data = @json($data); // Data transaksi yang diambil dari controller

    // Memproses data untuk Chart.js
    var tanggal = data.map(item => item.tanggal);
    var totalTransaksi = data.map(item => item.total_transaksi);

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
</body>
</html>
