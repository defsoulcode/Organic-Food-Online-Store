<?php

use Illuminate\Support\Facades\Route;
use App\Models\ReviewRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DistributController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BestSellerController;
use App\Http\Controllers\AdminOrdersController;
use App\Http\Controllers\AdminReviewsController;
use App\Http\Controllers\HomeCategoriesController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\UserProfilePasswordController;
use App\Http\Controllers\AdminProfilePasswordController;
use App\Http\Controllers\CustomerOrderHistroyController;


// root to app routes
Route::get('/', function () {
    return redirect('/login');
});
//routes admin dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('admin');

// routes login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// routes register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// routes product
Route::resource('product', ProductController::class)->middleware('admin');
// Categories routes from admin
Route::resource('categories', CategoryController::class)->middleware('admin');
Route::get('/admin/dashboard/categories/checkSlug', [CategoryController::class, 'checkSlug'])->middleware('admin');
// Distribut routes from admin
Route::resource('distribut', DistributController::class)->middleware('admin');
Route::get('/admin/dashboard/distribut/checkSlug', [DistributController::class, 'checkSlug'])->middleware('admin');
Route::get('/admin/dashboard/distribut/{distribut:slug}', [DistributController::class, 'show'])->middleware('admin');
//Customer routes from admin
Route::resource('customer', CustomerController::class)->middleware('admin');
//Comments routes from admin
Route::resource('admin-reviews', AdminReviewsController::class)->middleware('admin');
Route::resource('admin-orders', AdminOrdersController::class)->middleware('admin');

// profile & change password routes from admin
Route::group([
    'prefix' => 'change',
    'middleware' => 'admin'
], function () {
    // change admin profile & password
    Route::get('profile/{id}', [AdminProfilePasswordController::class, 'index'])->name('profile-admin');
    Route::put('profile/{id}', [AdminProfilePasswordController::class, 'update'])->name('profile-admin.update');
    Route::get('profile/password/{id}', [AdminProfilePasswordController::class, 'password'])->name('password-admin');
    Route::put('profile/password/{id}', [AdminProfilePasswordController::class, 'changePassword'])->name('password-admin.change');
});

// profile & change password routes from customer
Route::group([
    'prefix' => 'user-change',
    'middleware' => 'auth'
], function () {
    // change customer profile & password
    Route::get('profile/{id}', [UserProfilePasswordController::class, 'index'])->name('profile-user');
    Route::put('profile/{id}', [UserProfilePasswordController::class, 'update'])->name('profile-user.update');
    Route::get('profile/password/{id}', [UserProfilePasswordController::class, 'password'])->name('password-user');
    Route::put('profile/password/{id}', [UserProfilePasswordController::class, 'changePassword'])->name('password-user.change');
});

// routes home 
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home/info/{id}', [HomeController::class, 'info'])->name('home.info')->middleware('auth');
Route::get('/home/rating/{id}', [HomeController::class, 'reviewRating'])->name('home.rating')->middleware('auth');

// Review Rating 
Route::post('/review', [HomeController::class, 'reviewRating'])->name('review')->middleware('auth');

// Best-Seller
Route::any('/best-seller', [BestSellerController::class, 'bestSellerProducts'])->name('best-seller.products')->middleware('auth');

// routes about
Route::get('/about', function() {
    return view('pages.about');
})->middleware('auth');
// routes contact us
Route::get('/contact', function() {
    return view('pages.contact');
})->middleware('auth');

// routes term & cond
Route::get('/term', function() {
    return view('pages.term');
})->middleware('auth');

// routes categories in client
Route::get('/home-categories', [HomeCategoriesController::class, 'index'])->middleware('auth');

// routes Cart in client
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::post('/cart-store', [CartController::class, 'store'])->name('cart.store')->middleware('auth');
Route::post('/cart-update/{id}', [CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::post('/cart-remove/{id}', [CartController::class, 'remove'])->name('cart.remove')->middleware('auth');

// routes checkout in client
Route::get('/city/{id}', [CheckoutController::class, 'getCity'])->name('city')->middleware('auth');
Route::get('/destination={city_destination}&weight={weight}&courier={courier}', [CheckoutController::class, 'getOngkir'])->middleware('auth');
Route::get('/checkout/create', [CheckoutController::class, 'create'])->name('checkout.create')->middleware('auth');
Route::any('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/checkout/pembayaran', [CheckoutController::class, 'pembayaran'])->name('checkout.pembayaran')->middleware('auth');
Route::post('/checkout/pembayaran', [CheckoutController::class, 'konfirmasiPembayaran'])->name('checkout.konfirmasi_pembayaran')->middleware('auth');
Route::resource('customer_order_history', CustomerOrderHistroyController::class)->middleware('auth');