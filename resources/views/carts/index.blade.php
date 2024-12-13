@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Keranjang Belanja</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(empty($cart))
        <p>Keranjang belanja kosong.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                <tr>
                    <td>
                        <img src="{{ asset('storage/products/'.$item['image']) }}" alt="{{ $item['title'] }}" width="50">
                        {{ $item['title'] }}
                    </td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right font-weight-bold">Total</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Form untuk Alamat Pengiriman -->
        <div class="form-group">
            <label for="address">Pilih Alamat Pengiriman:</label>
            <select id="address" name="address" class="form-control">
                <option value="1">Jl. Raya No. 1, Jakarta</option>
                <option value="2">Jl. Merdeka No. 23, Surabaya</option>
                <option value="3">Jl. Sudirman No. 45, Bandung</option>
            </select>
        </div>

        <!-- Form untuk Jasa Pengiriman -->
        <div class="form-group">
            <label for="shipping">Pilih Jasa Pengiriman:</label>
            <select id="shipping" name="shipping" class="form-control">
                <option value="jne">JNE</option>
                <option value="jnt">J&T</option>
                <option value="pickup">Ambil di Toko</option>
            </select>
        </div>

        <!-- Form untuk Metode Pembayaran -->
        <div class="form-group">
            <label for="payment">Pilih Metode Pembayaran:</label>
            <select id="payment" name="payment" class="form-control">
                <option value="wallet">E-Wallet</option>
                <option value="bank_transfer">Transfer Bank</option>

            </select>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm">
        <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm" enctype="multipart/form-data">
    @csrf
    <!-- Input bukti pembayaran -->
    <div class="form-group">
        <label for="payment_proof">Unggah Bukti Pembayaran:</label>
        <input type="file" id="payment_proof" name="payment_proof" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Checkout</button>
</form>

    @endif
</div>

@section('scripts')
<script type="text/javascript">
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let address = document.getElementById('address').value;
    let shipping = document.getElementById('shipping').value;
    let payment = document.getElementById('payment').value;

    fetch("{{ route('cart.checkout') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            address: address,
            shipping: shipping,
            payment: payment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "{{ route('transactions.index') }}";
        } else {
            alert('Terjadi kesalahan saat memproses checkout.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

        });
    });
</script>
@endsection
@endsection
