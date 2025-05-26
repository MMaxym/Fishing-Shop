<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryBalancerController;
use App\Http\Controllers\User\CategoryPilkerController;
use App\Http\Controllers\User\CategoryTailSpinnerController;
use App\Http\Controllers\User\CheckoutPageController;
use App\Http\Controllers\User\FavoriteProductController;
use App\Http\Controllers\User\HeaderUserController;
use App\Http\Controllers\User\MainUserController;
use App\Http\Controllers\User\NewProductController;
use App\Http\Controllers\User\NovaPoshtaController;
use App\Http\Controllers\User\OrderHistoryController;
use App\Http\Controllers\User\ProductDetailsController;
use App\Http\Controllers\User\SaleProductController;
use App\Http\Controllers\User\SearchProductController;
use App\Http\Controllers\User\ShoppingCartController;
use App\Http\Middleware\CheckAge;
use App\Http\Middleware\CheckName;
use Illuminate\Support\Facades\Route;


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
    Route::get('/users/excelExport', [UserController::class, 'excelExport'])->name('admin.users.excelExport');
    Route::get('/users/export/pdf', [UserController::class, 'pdfExport'])->name('pdf.export');
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
    Route::get('/products/export/pdf', [ProductController::class, 'pdfExport'])->name('pdf.export.product');
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
    Route::get('/orders/excelExport', [OrderController::class, 'excelExport'])->name('admin.orders.excelExport');
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
    Route::get('/orders/{orderId}/export-products-pdf', [OrderController::class, 'pdfExportProductsInOrder'])->name('admin.orders.exportProductsPdf');
    Route::get('/orders/export/pdf', [OrderController::class, 'pdfExport'])->name('pdf.export.orders');
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
    Route::get('/about', [MainUserController::class, 'showAbout'])->name('user.about');
    Route::get('/discount', [MainUserController::class, 'showDiscount'])->name('user.discount');
    Route::get('/delivery', [MainUserController::class, 'showDelivery'])->name('user.delivery');
    Route::get('/editProfile', [HeaderUserController::class, 'editProfile'])->name('user.editProfile');
    Route::put('/{user}', [HeaderUserController::class, 'userUpdate'])->name('user.update');
    Route::get('/categoryBalancers', [CategoryBalancerController::class, 'index'])->name('user.categoryBalancers');
    Route::get('/categoryPilkers', [CategoryPilkerController::class, 'index'])->name('user.categoryPilkers');
    Route::get('/categoryTailSpinners', [CategoryTailSpinnerController::class, 'index'])->name('user.categoryTailSpinners');
    Route::get('/newProducts', [NewProductController::class, 'index'])->name('user.newProducts');
    Route::get('/saleProducts', [SaleProductController::class, 'index'])->name('user.saleProducts');
    Route::get('/orderHistory', [OrderHistoryController::class, 'index'])->name('user.orderHistory');
    Route::get('/shoppingCart', [ShoppingCartController::class, 'index'])->name('user.shoppingCart');
    Route::get('/checkoutPage', [CheckoutPageController::class, 'index'])->name('user.checkoutPage');
    Route::post('/confirmOrder', [CheckoutPageController::class, 'confirmOrder'])->name('user.confirmOrder');
    Route::post('/deliveryCost', [CheckoutPageController::class, 'deliveryCost'])->name('user.deliveryCost');
    Route::get('/showNewProducts', [MainUserController::class, 'showNewProducts'])->name('user.showNewProducts');
    Route::get('/showDiscountProducts', [MainUserController::class, 'showDiscountProducts'])->name('user.showDiscountProducts');
    Route::get('/searchProduct', [SearchProductController::class, 'index'])->name('user.searchProduct');
    Route::get('/search', [HeaderUserController::class, 'search'])->name('search');

    Route::get('/product/{id}', [ProductDetailsController ::class, 'showDetails'])->name('product.showDetails');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/favorite-products/toggle/{product}', [FavoriteProductController::class, 'toggle']);
    Route::get('/favoriteProducts', [FavoriteProductController::class, 'favoriteProducts'])->name('user.favoriteProducts');


    Route::get('/cart/session', [CheckoutPageController::class, 'getCartFromSession']);
    Route::get('/order/{order}/pay', [CheckoutPageController::class, 'pay'])->name('user.pay');

    Route::post('/liqpay/callback', [CheckoutPageController::class, 'callback'])->name('liqpay.callback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/liqpay/result', function () { return view('payment.result'); })->name('liqpay.result');
});


Route::get('/api/novaposhta/cities', [NovaPoshtaController::class, 'getCities']);
Route::get('/api/novaposhta/warehouses/{cityRef}', [NovaPoshtaController::class, 'getWarehouses']);
Route::get('/api/novaposhta/delivery-cost/{cityRecipientRef}', [NovaPoshtaController::class, 'getDeliveryCost']);
