<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembayaran</title>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body>
    <h1>Halaman Pembayaran</h1>

    <!-- Tampilkan informasi transaksi -->
    <p>Total Pembayaran: Rp 100,000</p>

    <!-- Tombol untuk memulai pembayaran -->
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            // Request token pembayaran dari backend
            fetch('/payment/token')
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        // Panggil Midtrans Snap untuk membuka popup pembayaran
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil');
                                console.log(result);
                                // Kirim ke server untuk memproses pembayaran lebih lanjut
                                // Misalnya: update status pesanan di backend
                            },
                            onPending: function(result) {
                                alert('Pembayaran sedang diproses');
                                console.log(result);
                            },
                            onError: function(result) {
                                alert('Terjadi kesalahan dalam pembayaran');
                                console.log(result);
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error getting payment token:', error);
                });
        };
    </script>
</body>
</html>
