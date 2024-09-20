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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LabController::class, 'main']);
Route::get('/lab1', [LabController::class, 'index']);
Route::get('/about', [LabController::class, 'about']);
Route::get('/contact', [LabController::class, 'contact']);
Route::get('/hobbies', [LabController::class, 'hobbies']);

Route::get('/about', [LabController::class, 'about'])->middleware(CheckAge::class);
Route::get('/hobbies', [LabController::class, 'hobbies'])->middleware(CheckName::class);



Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/admin/users/search', [UserController::class, 'search'])->name('admin.users.search');


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.admin');
});


Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
});

Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');


Route::prefix('admin/products/{product}')->group(function () {
    Route::get('/images/add', [ProductImageController::class, 'create'])->name('admin.products.images.add');
    Route::post('/images', [ProductImageController::class, 'store'])->name('admin.products.images.store');
    Route::get('/images/edit', [ProductImageController::class, 'edit'])->name('admin.products.images.edit');
    Route::put('/images/{images}', [ProductImageController::class, 'update'])->name('admin.products.images.update');
    Route::delete('/images/{images}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
});



Route::prefix('admin')->group(function () {
    Route::get('/discounts', [DiscountController::class, 'index'])->name('admin.discounts.index');
    Route::get('/discounts/create', [DiscountController::class, 'create'])->name('admin.discounts.create'); // Виправлено
    Route::post('/discounts', [DiscountController::class, 'store'])->name('admin.discounts.store');
    Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('admin.discounts.edit');
    Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('admin.discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');
});

Route::get('/admin/discounts/search', [DiscountController::class, 'search'])->name('admin.discounts.search');

