<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - Hj. Mariam</title>

    <!-- Stylesheets -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Navbar styling */
        .navbar {
            background-color: #5A9EC1;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: bold;
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #F8C471 !important;
        }
        .navbar-toggler-icon {
            color: #ffffff;
        }

        /* Content styling */
        main {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        /* Footer styling */
        footer {
            background-color: #2C3E50;
        }
        footer p {
            margin: 0;
        }

        /* Custom button styling for primary actions */
        .btn-primary-custom {
            background-color: #5A9EC1;
            color: #ffffff;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #4B7C99;
            color: #ffffff;
            transform: scale(1.05);
        }

        /* Additional product card and cart styling */
        body {
            background-color: #f8f9fa;
        }
        .product-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .cart-container {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        .cart-item:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Toko Hj. Mariam</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="pesanans">Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pesanan</a></li>

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.login') }}">Log In</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.register') }}">Register</a></li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Content Section -->
    <main>
        <div id="content" class="container">
            <h3>Produk yang Tersedia</h3>
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-3">
                        <div class="product-card text-center">
                            <img src="{{ asset('storage/products/'.$product->image) }}" class="img-fluid" alt="{{ $product->title }}">
                            <h5 class="mt-2">{{ $product->title }}</h5>
                            <p class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <button class="btn btn-dark" onclick="addToCart({{ $product->id }}, '{{ $product->title }}', '{{ $product->price }}')">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Data Produk Tidak Tersedia</p>
                    </div>
                @endforelse
            </div>

            <!-- Keranjang Belanja -->
            <h3>Keranjang Belanja</h3>
            <div class="cart-container">
                <div id="cart-items"></div>
                <div class="text-end mt-3">
                    <strong>Total: Rp <span id="total-price">0</span></strong>
                </div>
                <button class="btn btn-success mt-3" onclick="checkout()">Checkout</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024 Clothing Store. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let cart = [];

        function addToCart(id, title, price) {
            const product = { id, title, price: parseInt(price) };
            cart.push(product);
            renderCart();
        }

        function renderCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            const totalPriceContainer = document.getElementById('total-price');
            cartItemsContainer.innerHTML = '';
            let totalPrice = 0;

            cart.forEach(item => {
                totalPrice += item.price;

                cartItemsContainer.innerHTML += `
                    <div class="cart-item">
                        <span class="item-info">${item.title} - Rp ${item.price.toLocaleString()}</span>
                        <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Hapus</button>
                    </div>
                `;
            });

            totalPriceContainer.textContent = totalPrice.toLocaleString();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function checkout() {
            window.location.href = "{{ route('trans.checkout') }}";
        }
    </script>
</body>
</html>
