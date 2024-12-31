@extends('layouts.app')

@section('content')
<style>
    /* Efek gambar agak gelap */
    .carousel-item img {
        filter: brightness(50%); /* Mengurangi kecerahan gambar */
    }

    /* Tombol navigasi buletan warna gelap */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.7); /* Warna gelap transparan */
        border-radius: 50%; /* Membuat bentuk buletan */
        padding: 10px;
    }

    /* Tombol Belanja Sekarang warna orange */
    .btn-shop-now {
        background-color: #ff6600; /* Warna orange */
        color: #fff; /* Teks putih */
        border: none; /* Hapus border */
        font-weight: bold;
    }

    .btn-shop-now:hover {
        background-color: #e65c00; /* Warna orange lebih gelap saat dihover */
        color: #fff;
    }

    /* Custom title styling */
    .custom-title {
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Efek bayangan teks */
    }
</style>

<div class="container-fluid">
    <div id="main-banner" class="carousel slide" data-ride="carousel">
        <!-- Indikator -->
        <ol class="carousel-indicators">
            <li data-target="#main-banner" data-slide-to="0" class="active"></li>
            <li data-target="#main-banner" data-slide-to="1"></li>
            <li data-target="#main-banner" data-slide-to="2"></li>
        </ol>

        <!-- Slide Carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('toko_bajuu.jpg') }}" class="d-block w-100" alt="New Catalog">
                <div class="carousel-caption">
                    <h1 class="display-4 text-uppercase font-weight-bold custom-title">The New Catalog Is Here</h1>
                    <p><a class="btn btn-shop-now btn-lg mt-3" href="pesanans">Belanja Sekarang!</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('depan toko baju.jpg') }}" class="d-block w-100" alt="Fashion Collection">
                <div class="carousel-caption">
                    <h1 class="display-4 text-uppercase font-weight-bold custom-title">Trendy & Stylish</h1>
                    <p><a class="btn btn-shop-now btn-lg mt-3" href="pesanans">Belanja Sekarang!</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('depan toko baju 2.jpg') }}" class="d-block w-100" alt="New Arrivals">
                <div class="carousel-caption">
                    <h1 class="display-4 text-uppercase font-weight-bold custom-title">New Arrivals</h1>
                    <p><a class="btn btn-shop-now btn-lg mt-3" href="pesanans">Belanja Sekarang!</a></p>
                </div>
            </div>
        </div>

        <!-- Tombol navigasi -->
        <a class="carousel-control-prev" href="#main-banner" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#main-banner" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="container my-5">
    <div class="row text-center">
        <!-- Kolom 1 -->
        <div class="col-md-3 mb-4">
            <div class="position-relative">
                <img src="{{ asset('phasmina.jpg') }}" class="img-fluid rounded img-uniform" alt="Back to Black">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Hijab Phasmina
                </h3>
            </div>
        </div>
        <!-- Kolom 2 -->
        <div class="col-md-3 mb-4">
            <div class="position-relative">
                <img src="{{ asset('celana jeans.jpeg') }}" class="img-fluid rounded img-uniform" alt="Carry the Day">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Celana Jeans
                </h3>
            </div>
        </div>
        <!-- Kolom 3 -->
        <div class="col-md-3 mb-4">
            <div class="position-relative">
                <img src="{{ asset('jaket.jpg') }}" class="img-fluid rounded img-uniform" alt="Look & Feel Great">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Jaket Jeans
                </h3>
            </div>
        </div>
        <!-- Kolom 4 -->
        <div class="col-md-3 mb-4">
            <div class="position-relative">
                <img src="{{ asset('data.jpeg.webp') }}" class="img-fluid rounded img-uniform" alt="Fashion Meet Function">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Baju Muslim
                </h3>
            </div>
        </div>
    </div>

    <!-- Baris Kedua -->
    <div class="row text-center">
        <!-- Kolom 1 -->
        <div class="col-md-6 mb-4">
            <div class="position-relative">
                <img src="{{ asset('celana kulot.webp') }}" class="img-fluid rounded img-uniform" alt="Sandals">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Celana Kulot
                </h3>
            </div>
        </div>
        <!-- Kolom 2 -->
        <div class="col-md-6 mb-4">
            <div class="position-relative">
                <img src="{{ asset('hijab.jpeg') }}" class="img-fluid rounded img-uniform" alt="Tops & Bottoms">
                <h3 class="text-uppercase text-white position-absolute" style="bottom: 20px; left: 20px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);">
                    Hijab Segiempat
                </h3>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <h3 class="text-center font-weight-bold">
        Temukan Tren Fashion Terbaru Hanya di Toko Baju Hj.Mariam
    </h3>
    <p class="text-center">
        Toko Baju Hj.Mariam selalu mengikuti perkembangan dunia fashion untuk menghadirkan tren terbaru yang sesuai dengan gaya hidup Anda.
        Koleksi kami mencakup berbagai pilihan outfit mulai dari <strong>pakaian kasual</strong>, <strong>formal</strong>, hingga <strong>sportwear</strong> yang dapat
        Anda pilih sesuai kebutuhan dengan kualitas terbaik.
    </p>
    <p class="text-center">
        Kami memastikan setiap produk yang tersedia di Toko Baju ini adalah <em>original</em> dan berkualitas tinggi. Dengan fitur <strong>pencarian canggih</strong>
        dan <strong>navigasi mudah</strong>, Anda dapat menemukan fashion item favorit hanya dalam hitungan menit. Nikmati juga <strong>promo eksklusif</strong> dan
        <strong>diskon besar-besaran</strong> setiap bulannya untuk memaksimalkan pengalaman belanja online Anda.
    </p>

    <h3 class="text-center font-weight-bold mt-5">
        Belanja Nyaman dan Aman
    </h3>
    <p class="text-center">
        Dengan sistem pembayaran yang aman dan pilihan metode pembayaran seperti kartu kredit, transfer bank, dan e-wallet kami
        memberikan kemudahan bagi setiap pelanggan. Selain itu, kami menawarkan <strong>pengembalian gratis selama 30 hari</strong>
        jika produk tidak sesuai dengan harapan Anda. Belanja fashion kini jadi lebih menyenangkan dan tanpa risiko!
    </p>
    <p class="text-center">
        Yuk, temukan gaya terbaik Anda dan jadikan Toko Baju kami sebagai destinasi utama belanja fashion online di Indonesia. Selamat berbelanja!
    </p>
</div>
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Teks di kiri -->
        <div class="col-md-6 text-center text-md-start">
            <h1 class="display-4 fw-bold" style="font-family: 'Brush Script MT', cursive;">Toko Baju Hj.Mariam</h1>
        </div>
        <!-- Gambar di kanan -->
        <div class="col-md-6">
            <img src="{{ asset('baju.jpeg') }}" class="img-fluid rounded" alt="Berrybenka Store">
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Gambar di kiri -->
        <div class="col-md-6">
            <img src="{{ asset('Fashion.jpg') }}" class="img-fluid rounded" alt="Berrybenka Store">
        </div>
        <!-- Teks di kanan -->
        <div class="col-md-6 text-center text-md-start">
            <h1 class="display-4 fw-bold" style="font-family: 'Brush Script MT', cursive;">Belanja Online Mudah</h1>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center">
        <!-- Teks di kiri -->
        <div class="col-md-6 text-center text-md-start">
            <h1 class="display-4 fw-bold" style="font-family: 'Brush Script MT', cursive;">Kualitas Terbaik, Aman dan Terpercaya</h1>
        </div>
        <!-- Gambar di kanan -->
        <div class="col-md-6">
            <img src="{{ asset('aplikasi.jpg') }}" class="img-fluid rounded" alt="Berrybenka Store">
        </div>
    </div>
</div>
<div class="container">
    <h5 class="fw-bold mt-4">TIPS BELANJA DI TOKO BAJU ONLINE</h5>
    <p class="text-justify">
        Toko baju adalah surga bagi Anda yang suka dan memiliki passion dengan fesyen. Namun, jangan sampai kebablasan, lapar mata akan baju wanita dan pakaian pria tidak pernah ada habisnya jika diikuti terus menerus. Berikut ini adalah beberapa tips belanja yang bisa dicoba:
    </p>

    <h6 class="fw-bold mt-4">1. Tentukan model yang disukai</h6>
    <p class="text-justify">
        Hal pertama yang bisa dilakukan agar tetap terkontrol saat belanja pakaian modern di toko baju adalah menentukan terlebih dahulu model yang ingin dibeli. Dengan begini, Anda akan fokus pada item tertentu yang sesuai dengan preferensi. Jika belanja tanpa rencana, pilihan baju hanya akan mengikuti hasrat belanja sehingga berpotensi membuang uang percuma.
    </p>

    <h6 class="fw-bold mt-4">2. Cek isi lemari</h6>
    <p class="text-justify">
        Sebelum berangkat ke toko, cek dulu isi lemari. Apakah model yang diinginkan sudah sempat dimiliki sebelumnya? Jika sudah, ada baiknya Anda pikirkan lagi untuk membeli model yang serupa karena bisa jadi nanti akan merasa bosan. Akhirnya, baju baru tersebut tidak akan terpakai lagi.
    </p>

    <h6 class="fw-bold mt-4">3. Cek isi dompet</h6>
    <p class="text-justify">
        Ketiga, dan yang paling penting, adalah cek isi dompet. Meskipun ada item terbaru dengan model paling bagus yang disukai, namun tidak ada uang untuk membayar maka akan percuma saja. Dan jangan sampai agenda belanja ini mengganggu keuangan dan operasional.
    </p>
</div>

<style>
    .text-justify {
        text-align: justify;
    }
</style>

<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row text-md-left">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Toko Baju Hj. Mariam</h5>
                <p>Sebagai Pusat Fashion Online, kami menciptakan berbagai kemungkinan gaya tanpa batas dengan memperluas jangkauan produk dari produk internasional hingga produk lokal dambaan.</p>
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Tentang Kami</h5>
                <p>Jl. Pasar Parabola</p>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr><td>hjmariam@gmail.com</td></tr>
                    <tr><td>+62 857-5478-0855</td></tr>
                </table>
            </div>
        </div>
    </div>
</footer>
@endsection


