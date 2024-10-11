<?php

use App\Http\Middleware\CheckAge;
use App\Http\Middleware\CheckName;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleAuthController;



Route::get('/', function () {
    return view('user.main');
});

Route::get('/', [MainUserController::class, 'index'])->name('user.main');


Route::get('/lab1', [LabController::class, 'index']);
Route::get('/about', [LabController::class, 'about']);
Route::get('/contact', [LabController::class, 'contact']);
Route::get('/hobbies', [LabController::class, 'hobbies']);

Route::get('/about', [LabController::class, 'about'])->middleware(CheckAge::class);
Route::get('/hobbies', [LabController::class, 'hobbies'])->middleware(CheckName::class);


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('/{order}/products', [AdminController::class, 'showProducts'])->name('admin.orders.products');
});


Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');
});


Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::get('/products/filter', [ProductController::class, 'filter'])->name('admin.products.filter');
    Route::get('/products/export', [ProductController::class, 'export'])->name('admin.products.export');
});


Route::prefix('admin/products/{product}')->group(function () {
    Route::get('/images/add', [ProductImageController::class, 'create'])->name('admin.products.images.add');
    Route::post('/images', [ProductImageController::class, 'store'])->name('admin.products.images.store');
    Route::get('/images/edit', [ProductImageController::class, 'edit'])->name('admin.products.images.edit');
    Route::put('/images/{image}', [ProductImageController::class, 'update'])->name('admin.products.images.update');
    Route::delete('/images/{image}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
});


Route::prefix('admin')->group(function () {
    Route::get('/discounts', [DiscountController::class, 'index'])->name('admin.discounts.index');
    Route::get('/discounts/create', [DiscountController::class, 'create'])->name('admin.discounts.create');
    Route::post('/discounts', [DiscountController::class, 'store'])->name('admin.discounts.store');
    Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('admin.discounts.edit');
    Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('admin.discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');
    Route::get('/discounts/search', [DiscountController::class, 'search'])->name('admin.discounts.search');
    Route::get('/discounts/filter', [DiscountController::class, 'filter'])->name('admin.discounts.filter');
});


Route::prefix('admin')->group(function () {
    Route::get('/orders/filter', [OrderController::class, 'filter'])->name('admin.orders.filter');
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/orders/search', [OrderController::class, 'search'])->name('admin.orders.search');
    Route::get('/orders/{order}/products', [OrderController::class, 'showProducts'])->name('admin.orders.products');
});






Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');



Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');


Route::prefix('user/')->group(function () {
    Route::get('/main', [MainUserController::class, 'index'])->name('user.main');
});





//ЦЕ МАЄ БУТИ В ФАЙЛІ Karnel.php, АЛЕ В МЕНЕ НЕМАЄ ТАКОГО ФАЙЛУ
//protected $routeMiddleware = [
//    // Інші middleware
//    'guest' => \App\Http\Middleware\GuestMiddleware::class,
//    'user' => \App\Http\Middleware\UserMiddleware::class,
//    'admin' => \App\Http\Middleware\AdminMiddleware::class,
//];


//Route::prefix('admin')->middleware('admin')->group(function () {
//    Route::get('/', [AdminController::class, 'index'])->name('admin.admin');
//    Route::get('/{order}/products', [AdminController::class, 'showProducts'])->name('admin.orders.products');
//
//    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
//    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
//    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
//    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
//    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
//    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
//    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
//    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');
//
//    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
//    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
//    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
//    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
//    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
//    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
//    Route::get('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
//    Route::get('/products/filter', [ProductController::class, 'filter'])->name('admin.products.filter');
//    Route::get('/products/export', [ProductController::class, 'export'])->name('admin.products.export');
//
//    Route::prefix('products/{product}')->group(function () {
//        Route::get('/images/add', [ProductImageController::class, 'create'])->name('admin.products.images.add');
//        Route::post('/images', [ProductImageController::class, 'store'])->name('admin.products.images.store');
//        Route::get('/images/edit', [ProductImageController::class, 'edit'])->name('admin.products.images.edit');
//        Route::put('/images/{image}', [ProductImageController::class, 'update'])->name('admin.products.images.update');
//        Route::delete('/images/{image}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
//    });
//
//    Route::get('/discounts', [DiscountController::class, 'index'])->name('admin.discounts.index');
//    Route::get('/discounts/create', [DiscountController::class, 'create'])->name('admin.discounts.create');
//    Route::post('/discounts', [DiscountController::class, 'store'])->name('admin.discounts.store');
//    Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('admin.discounts.edit');
//    Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('admin.discounts.update');
//    Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');
//    Route::get('/discounts/search', [DiscountController::class, 'search'])->name('admin.discounts.search');
//    Route::get('/discounts/filter', [DiscountController::class, 'filter'])->name('admin.discounts.filter');
//
//    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
//    Route::get('/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
//    Route::post('/orders', [OrderController::class, 'store'])->name('admin.orders.store');
//    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
//    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
//    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
//    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
//    Route::get('/orders/search', [OrderController::class, 'search'])->name('admin.orders.search');
//    Route::get('/orders/{order}/products', [OrderController::class, 'showProducts'])->name('admin.orders.products');
//    Route::get('/orders/filter', [OrderController::class, 'filter'])->name('admin.orders.filter');
//});
//
//Route::prefix('user')->middleware('user')->group(function () {
//    Route::get('/main', [MainUserController::class, 'index'])->name('user.main');
//});
//
//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [AuthController::class, 'login']);
//Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
//Route::post('/register', [AuthController::class, 'register']);
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//
//Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
//Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
//Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
//
//Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
//Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
//


