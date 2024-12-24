@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Keranjang Belanja -->
            <div class="col-md-8">
                <h3 class="mb-4"><strong>Keranjang Belanja</strong></h3>
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <!-- Kolom Gambar & Produk -->
                                <td>
                                    <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                        alt="{{ $item->product->title }}" width="50" class="rounded">
                                </td>

                                <!-- Kolom Harga -->
                                <td>
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </td>

                                <!-- Kolom Jumlah dengan tombol + dan - -->
                                <td>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            onclick="updateQuantity({{ $id }}, -1)">-</button>
                                            <input type="text" id="quantity-{{ $id }}" 
                                            value="{{ $item->quantity }}" 
                                            class="form-control text-center" 
                                            readonly 
                                            data-max-stock="{{ $item->product->stock }}">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
                                            onclick="updateQuantity({{ $id }}, 1)">+</button>
                                    </div>
                                </td>

                                <!-- Kolom Subtotal -->
                                <td id="subtotal-{{ $id }}">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total Section -->
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal Produk:</strong></td>
                            <td>Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Total Pembayaran -->
                <div class="text-end bg-light p-3 rounded">
                    <h4><strong>Total Pembayaran:</strong> <span id="totalPrice">Rp {{ number_format($totalPrice) }}</span>
                    </h4>
                </div>

            </div>

            <!-- Info Pembayaran -->
            <div class="col-md-4">
                <h3><strong>Info Pembayaran</strong></h3>
                <form action="{{ route('cart.checkout') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Alamat Pengiriman -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Pengiriman</label>
                        <input type="text" id="address" name="address" class="form-control"
                            placeholder="Masukkan Alamat" required>
                    </div>

                    <!-- Opsi Pengiriman -->
                    <div class="mb-3">
                        <label for="shipping_option" class="form-label">Opsi Pengiriman</label>
                        <select id="shipping_option" name="shipping_option" class="form-select" required>
                            <option value="" disabled selected>Pilih Opsi Pengiriman</option>
                            <option value="jne">JNE</option>
                            <option value="jnt">J&T</option>
                        </select>
                    </div>

                    <!-- Tipe Pembayaran -->
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" class="form-select" required>
                            <option value="" disabled selected>Pilih Metode Pembayaran</option>
                            <option value="transfer">Transfer</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>

                    <!-- Pesan -->
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea id="message" name="message" class="form-control" placeholder="Silahkan tinggalkan pesan"></textarea>
                    </div>

                    <!-- Tombol Checkout -->
                    <button type="submit" class="btn btn-danger w-100">
                        <strong>Buat Pesanan</strong>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updateQuantity(id, change) {
            const input = document.getElementById(`quantity-${id}`);
            const maxStock = parseInt(input.dataset.maxStock, 10); // Stok maksimum
            let quantity = parseInt(input.value, 10) + change;

            // Validasi kuantitas
            if (quantity < 1) {
                quantity = 1; // Minimal 1
            } else if (quantity > maxStock) {
                quantity = maxStock; // Maksimal stok
            }

            // Perbarui input field
            input.value = quantity;

            // Kirim data ke server menggunakan fetch
            fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        quantity
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Perbarui subtotal dan total pembayaran
                        document.getElementById(`subtotal-${id}`).innerText = `Rp ${data.subtotal.toLocaleString()}`;
                        document.getElementById('totalPrice').innerText = `Rp ${data.totalPrice.toLocaleString()}`;
                    } else {
                        alert(data.error || 'Gagal memperbarui keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan, silakan coba lagi.');
                });
        }
    </script>
@endsection
