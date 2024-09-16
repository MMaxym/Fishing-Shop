<?php

use App\Http\Middleware\CheckAge;
use App\Http\Middleware\CheckName;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;

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
