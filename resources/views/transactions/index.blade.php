<!-- resources/views/checkout/success.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
</head>
<body>
    <h1>Checkout Berhasil!</h1>
    <p>Alamat Pengiriman: {{ $data['address'] }}</p>
    <p>Jasa Pengiriman: {{ $data['shipping_service'] }}</p>
    <p>Metode Pembayaran: {{ $data['payment_method'] }}</p>

    @if ($data['payment_proof'])
        <p>Payment Proof: {{ $data['payment_proof']->getClientOriginalName() }}</p>
    @endif
</body>
</html>
