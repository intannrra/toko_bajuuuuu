<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - Hj. Mariam</title>

    <!-- Stylesheets -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

        /* Cart styles */
        .cart-container {
            position: fixed;
            top: 60px; /* Posisi di bawah navbar */
            right: 10px;
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            display: none; /* Awalnya tersembunyi */
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
        }
        .cart-toggle-btn {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }
        .cart-toggle-btn .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            padding: 2px 6px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="/">Toko Hj. Mariam</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/home">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="pesanans">Produk</a></li>

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.login') }}">Log In</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.register') }}">Register</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.show', Auth::id()) }}">Profile</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest

                <!-- Cart Toggle Button -->
                <li class="nav-item">
                    <button class="cart-toggle-btn" id="cart-toggle">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cart-count">0</span>
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Cart Section -->
    <div class="cart-container" id="cart-container">
        <h5>Keranjang Belanja</h5>
        <div id="cart-items"></div>
        <button class="btn btn-success btn-block mt-3" onclick="checkout()">Checkout</button>
    </div>

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
                            <button class="btn btn-dark" onclick="addToCart('{{ $product->id }}', '{{ $product->title }}', '{{ $product->price }}')">
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

    function saveCartToLocalStorage() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function loadCartFromLocalStorage() {
        const storedCart = localStorage.getItem('cart');
        if (storedCart) {
            cart = JSON.parse(storedCart);
            renderCart();
        }
    }

    function addToCart(id, title, price) {
        const product = { id, title, price: parseInt(price) };
        cart.push(product);
        saveCartToLocalStorage();
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        saveCartToLocalStorage();
        renderCart();
    }

    function renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        cartItemsContainer.innerHTML = '';
        cart.forEach(item => {
            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <span>${item.title} - Rp ${item.price.toLocaleString()}</span>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart('${item.id}')">Hapus</button>
                </div>
            `;
        });
        cartCount.textContent = cart.length;
    }

    function checkout() {
        console.log('Checkout:', cart);
        window.location.href = "{{ route('cart.index') }}";
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCartFromLocalStorage();

        const cartToggle = document.getElementById('cart-toggle');
        const cartContainer = document.getElementById('cart-container');

        cartToggle.addEventListener('click', () => {
            if (cartContainer.style.display === 'none' || cartContainer.style.display === '') {
                cartContainer.style.display = 'block';
            } else {
                cartContainer.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>
