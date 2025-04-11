<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;


Route::get('/',[AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register',[AuthController::class, 'registrationForm']);

Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware'=>'auth'], function() {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create',[ProductController::class, 'create']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

//bag o
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);

Route::get('/email/verify/{id}', [EmailVerificationController::class, 'verify'])
    ->name('verification.validate')
    ->middleware('signed');

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);


