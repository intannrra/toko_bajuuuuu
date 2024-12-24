@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Checkout</h2>

        {{-- Menampilkan pesan sukses atau error --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Checkout --}}
        <form id="checkoutForm" method="POST">
            @csrf

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="total">Total</label>
                <input type="number" id="total" name="total" class="form-control" value="100000" required>
            </div>

            <button type="button" id="payButton" class="btn btn-primary">Bayar Sekarang</button>
        </form>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script>
        document.getElementById('payButton').addEventListener('click', function() {
            const form = document.getElementById('checkoutForm');
            const formData = new FormData(form);

            fetch('{{ route('checkout.process') }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // Redirect to the success page after successful payment
                            window.location.href = "{{ route('checkout.success') }}?order_id=" + result.order_id;
                        },
                        onPending: function(result) {
                            alert("Pembayaran masih pending");
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal");
                        }
                    });
                } else {
                    alert("Gagal mendapatkan Snap token");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
@endsection