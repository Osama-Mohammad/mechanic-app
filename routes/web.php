<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MechanicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginPage']);
Route::post('/', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('auth')->group(function () {
    Route::get('/register/create', [AuthController::class, 'RegisterPage']);
    Route::post('/register/store', [AuthController::class, 'RegisterStore']);
});

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/register/create', [AdminController::class, 'RegisterPage']);
    Route::post('/register/store', [AdminController::class, 'RegisterStore']);

    Route::get('/login', [AdminController::class, 'loginPage']);
    Route::get('/login', [AdminController::class, 'login']);
});


Route::prefix('customer')->middleware('guest:customer')->group(function () {
    Route::get('/register/create', [CustomerController::class, 'create']);
    Route::post('/register/store', [CustomerController::class, 'store']);

    Route::get('/profile/{id}', [CustomerController::class, 'ProfilePage']);
    Route::get('/profile/edit/{id}', [CustomerController::class, 'EditProfile']);
    Route::patch('/profile/edit/{id}', [CustomerController::class, 'UpdateProfile']);
});

Route::prefix('mechanic')->middleware('guest:mechanic')->group(function () {
    Route::get('/register/create', [MechanicController::class, 'RegisterPage']);
    Route::post('/register/store', [MechanicController::class, 'RegisterStore']);

    Route::get('/login', [MechanicController::class, 'loginPage']);
    Route::get('/login', [MechanicController::class, 'login']);
});
