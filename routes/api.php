<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\ServiceRequestApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthApiController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::middleware('auth:sanctum')->post('/logout', 'logout')->name('logout');
});


Route::prefix('customer')->group(function () {
    Route::get('/all', [CustomerApiController::class, 'index'])->name('customer.all');

    Route::middleware('guest:customer')->group(function () {
        Route::post('/register/store', [CustomerApiController::class, 'store'])->name('customer.register.store');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/profile/edit/{customer}', [CustomerApiController::class, 'update'])->name('customer.profile.update');

        Route::post('/service-request/store', [ServiceRequestApiController::class, 'store'])->name('customer.service-request.store');
    });
});
