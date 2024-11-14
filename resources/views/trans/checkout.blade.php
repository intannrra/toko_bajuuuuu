<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    h1 {
      color: #333;
    }

    .form-container {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      font-weight: bold;
    }
  </style>
  <!-- Link Midtrans Snap JS -->
  <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
</head>
<body>

  <div class="container mt-5">
    <h3>Checkout</h3>

    <div class="form-container">
      <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Form Alamat Pengiriman -->
        <div class="mb-3">
          <label for="address" class="form-label">Alamat Pengiriman</label>
          <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>

        <!-- Pilih Jasa Pengirim -->
        <div class="mb-3">
          <label for="shipping_service" class="form-label">Jasa Pengirim</label>
          <select class="form-select" id="shipping_service" name="shipping_service" required>
            <option value="" disabled selected>Pilih Jasa Pengirim</option>
            <option value="jnt">JNT</option>
            <option value="jne">JNE</option>
          </select>
        </div>

        <!-- Pilih Metode Pembayaran -->
        <div class="mb-3">
          <label for="payment_method" class="form-label">Metode Pembayaran</label>
          <select class="form-select" id="payment_method" name="payment_method" required>
            <option value="" disabled selected>Pilih Metode Pembayaran</option>
            <option value="transfer_bank">Transfer Bank</option>
            <option value="ewallet">E-Wallet</option>
            <option value="midtrans">Midtrans (Kartu Kredit/Debit)</option>
          </select>
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div class="mb-3" id="payment_proof_container" style="display: none;">
          <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
          <input type="file" class="form-control" id="payment_proof" name="payment_proof">
        </div>

        <!-- Tombol Checkout -->
        <button type="submit" class="btn btn-success" id="checkout-button">Checkout</button>
        <a href="{{ route('pesanans.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>

  <!-- Link Bootstrap JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <script>
    document.getElementById('payment_method').addEventListener('change', function() {
      const paymentMethod = this.value;
      const paymentProofContainer = document.getElementById('payment_proof_container');

      if (paymentMethod === 'midtrans') {
        paymentProofContainer.style.display = 'none'; // Sembunyikan upload bukti pembayaran untuk Midtrans
        processMidtransPayment(); // Proses pembayaran Midtrans
      } else {
        paymentProofContainer.style.display = 'block'; // Tampilkan upload bukti pembayaran untuk metode lain
      }
    });

    function processMidtransPayment() {
      const totalPrice = 100000; // Ganti dengan total harga yang sesuai
      fetch('/api/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ total_price: totalPrice })
      })
      .then(response => response.json())
      .then(data => {
        if (data.snapToken) {
          snap.pay(data.snapToken, {
            onSuccess: function(result) {
              // Kirim data ke server untuk menyimpan status transaksi
              console.log('Pembayaran sukses', result);
              // Anda bisa redirect atau melakukan tindakan lain
            },
            onPending: function(result) {
              console.log('Pembayaran tertunda', result);
            },
            onError: function(result) {
              console.log('Pembayaran gagal', result);
            }
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  </script>
</body>
</html>
