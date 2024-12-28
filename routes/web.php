<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    PesananController,
    DashboardController,
    CheckoutController,
    AuthController,
    TransactionController,
    ProfilController,
    PaymentController,
    CartController,
    MidtransController,
};

Route::get('/', function(){
    return redirect()->route('homes.home'); 
});
// Route untuk halaman home
Route::get('/home', [HomeController::class, 'index'])->name('homes.home');

// Rute untuk autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.process');
});

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route untuk fitur utama yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::resource('/products', ProductController::class);
    Route::resource('/pesanans', PesananController::class);
    Route::resource('/transactions', TransactionController::class);
    
    // Route untuk Checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.index'); // Menampilkan form checkout
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process'); // Memproses checkout
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success'); // Halaman sukses checkout
});

// Route dengan RoleMiddleware untuk Admin
Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Route dengan RoleMiddleware untuk User
Route::middleware([RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
    Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
});

// Route untuk Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Proses checkout dari keranjang
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

// Route untuk halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('cart.index');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/payment/{transaction_id}', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/success/{transactionId}', [CartController::class, 'paymentSuccess'])->name('payment.success');

// Route untuk transaksi
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::post('/midtrans-webhook', [PaymentController::class, 'handleWebhook']);
Route::get('/payment', [MidtransController::class, 'getToken']);
Route::post('/payment/callback', [MidtransController::class, 'callback']);
// Untuk mendapatkan Snap Token
Route::post('/payment/get-token', [MidtransController::class, 'getToken']);

// Untuk menerima callback dari Midtrans
Route::post('/payment/callback', [MidtransController::class, 'callback']);