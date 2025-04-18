<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\MechanicApiController;
use App\Http\Controllers\ServiceTypeApiController;
use App\Http\Controllers\ServiceRequestApiController;
use App\Http\Controllers\EmergencyRequestApiController;
use App\Http\Controllers\ReviewApiController;

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

        Route::delete('/service-request/delete/{serviceRequest}', [ServiceRequestApiController::class, 'destroy'])->name('mechanic.service-request.delete');

        Route::post('/emergency-request/store', [EmergencyRequestApiController::class, 'store'])->name('customer.emergency-request.store');

        Route::post('/review/store/{serviceRequest}', [ReviewApiController::class, 'store']);

        Route::put('/review/update/{review}', [ReviewApiController::class, 'update']);
    });
});

Route::prefix('mechanic')->group(function () {
    Route::get('/index', [MechanicApiController::class, 'index'])->name('mechanic.index');

    Route::middleware('guest:mechanic')->group(function () {
        Route::post('/register/store', [MechanicApiController::class, 'store'])->name('mechanic.register.store');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/profile/edit/{mechanic}', [MechanicApiController::class, 'update'])->name('mechanic.profile.update');

        Route::put('/service-request/update/{serviceRequest}', [ServiceRequestApiController::class, 'update'])->name('mechanic.service-request.update');
        Route::post('/service-request/accept/{serviceRequest}', [ServiceRequestApiController::class, 'accept'])->name('mechanic.service-request.accept');
        Route::post('/service-request/decline/{serviceRequest}', [ServiceRequestApiController::class, 'decline'])->name('mechanic.service-request.decline');

        Route::post('/service-type/store', [ServiceTypeApiController::class, 'store'])->name('mechanic.service-type.store');
        Route::put('/service-type/update/{serviceType}', [ServiceTypeApiController::class, 'update'])->name('mechanic.service-type.update');
        Route::delete('/service-type/delete/{serviceType}', [ServiceTypeApiController::class, 'destroy'])->name('mechanic.service-type.delete');

        Route::post('/emergency-request/accept/{emergencyRequest}', [EmergencyRequestApiController::class, 'accept'])->name('customer.emergency-request.accept');
        Route::post('/emergency-request/decline/{emergencyRequest}', [EmergencyRequestApiController::class, 'decline'])->name('customer.emergency-request.decline');

        Route::put('/emergency-request/update/{emergencyRequest}', [EmergencyRequestApiController::class, 'update'])->name('customer.emergency-request.update');

        Route::delete('/emergency-request/delete/{emergencyRequest}', [EmergencyRequestApiController::class, 'destroy']);
    });
});
