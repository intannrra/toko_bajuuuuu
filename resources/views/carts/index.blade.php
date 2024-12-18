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
                    @foreach($cart as $id => $item)
                        <tr>
                            <!-- Kolom Gambar & Produk -->
                            <td>
                                <img src="{{ asset('storage/products/'.$item['image']) }}"
                                     alt="{{ $item['title'] }}"
                                     width="50"
                                     class="rounded">
                            </td>

                            <!-- Kolom Harga -->
                            <td>
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </td>

                            <!-- Kolom Jumlah dengan tombol + dan - -->
                            <td>
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary btn-sm"
                                            type="button"
                                            onclick="updateQuantity({{ $id }}, -1)">-</button>
                                    <input type="text"
                                           id="quantity-{{ $id }}"
                                           value="{{ $item['quantity'] }}"
                                           class="form-control text-center"
                                           readonly>
                                    <button class="btn btn-outline-secondary btn-sm"
                                            type="button"
                                            onclick="updateQuantity({{ $id }}, 1)">+</button>
                                </div>
                            </td>

                            <!-- Kolom Subtotal -->
                            <td>
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                    <!-- Total Section -->
                    <tr>
                        <td colspan="3" class="text-end"><strong>Subtotal Produk:</strong></td>
                        <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Pembayaran -->
            <div class="text-end bg-light p-3 rounded">
            <h4><strong>Total Pembayaran:</strong> Rp {{ number_format($total) }}</h4>
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
                    <input type="text" id="address" name="address"
                           class="form-control"
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
                    <label for="shipping_option" class="form-label">Metode Pembayaran</label>
                    <select id="shipping_option" name="shipping_option" class="form-select" required>
                        <option value="" disabled selected>Pilih Metode Pengiriman</option>
                        <option value="transfer">Transfer</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>

                <!-- Unggah Bukti Pembayaran -->
                <div class="mb-3">
                    <label for="payment_proof" class="form-label">Unggah Bukti Pembayaran</label>
                    <input type="file" id="payment_proof" name="payment_proof"
                           class="form-control" required>
                </div>

                <!-- Pesan -->
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan</label>
                    <textarea id="message" name="message"
                              class="form-control"
                              placeholder="Silahkan tinggalkan pesan"></textarea>
                </div>

                <!-- Tombol Checkout -->
                <button type="submit" class="btn btn-danger w-100">
                    <strong>Buat Pesanan</strong>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateQuantity(id, change) {
        const input = document.getElementById(quantity-${id});
        let quantity = parseInt(input.value) + change;

        if (quantity < 1) {
            quantity = 1; // Tidak boleh kurang dari 1
        }

        input.value = quantity;
        // Tambahkan AJAX/Fetch jika ingin update quantity di server tanpa reload
    }
</script>
@endsection
