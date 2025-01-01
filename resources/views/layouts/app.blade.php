<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - Hj. Mariam</title>

    <!-- Stylesheets -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
    .navbar {
        background-color: #5A9EC1;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1030; /* Agar navbar berada di atas elemen lain */
    }
    .navbar-brand, .navbar-nav .nav-link {
        color: #ffffff !important;
        font-weight: bold;
    }
    .navbar-brand:hover, .navbar-nav .nav-link:hover {
        color: #F8C471 !important;
        text-decoration: underline;
    }
    .navbar-toggler-icon {
        color: #ffffff;
    }
    main {
        padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
        padding-bottom: 40px;
    }
    footer {
        background-color: #2C3E50;
    }
    footer p {
        margin: 0;
    }
    .btn-primary-custom {
        background-color: #5A9EC1;
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: #4B7C99;
        transform: scale(1.05);
    }
</style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="/">Toko Hj. Mariam</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fas fa-bars"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/home">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="/pesanans">Produk</a></li>

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
            </ul>
        </div>
    </nav>

    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024 Toko Baju Hj. Mariam - All Rights Reserved.</p>
            <p>Follow us on:
                <a href="#" target="_blank" class="text-light ml-2"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank" class="text-light ml-2"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" class="text-light ml-2"><i class="fab fa-twitter"></i></a>
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
