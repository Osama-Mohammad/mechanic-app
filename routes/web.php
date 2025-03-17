<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmergencyRequestController;
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

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/profile/{admin}', [AdminController::class, 'ProfilePage'])->name('admin_profilePage');
    Route::get('/profile/edit/{admin}', [AdminController::class, 'EditProfilePage'])->name('admin_EditProfilePage');
    Route::patch('/profile/edit/{admin}', [AdminController::class, 'EditProfile'])->name('admin_EditProfile');
});

Route::prefix('customer')->middleware('guest:customer')->group(function () {
    Route::get('/register/create', [CustomerController::class, 'create']);
    Route::post('/register/store', [CustomerController::class, 'store']);
});

Route::prefix('customer')->middleware('auth:customer')->group(function () {
    Route::get('/profile/{id}', [CustomerController::class, 'ProfilePage']);
    Route::get('/profile/edit/{id}', [CustomerController::class, 'EditProfile']);
    Route::patch('/profile/edit/{id}', [CustomerController::class, 'UpdateProfile']);

    Route::get('/EmergencyRequest/create', [EmergencyRequestController::class, 'index'])->name('EmergencyRequestPage');
    Route::post('/EmergencyRequest/{customer}/store', [EmergencyRequestController::class, 'store'])->name('EmergencyStoreRequest');
});


Route::prefix('mechanic')->middleware('guest:mechanic')->group(function () {
    Route::get('/register/create', [MechanicController::class, 'RegisterPage']);
    Route::post('/register/store', [MechanicController::class, 'RegisterStore']);

    Route::get('/login', [MechanicController::class, 'loginPage']);
    Route::get('/login', [MechanicController::class, 'login']);
});

Route::prefix('mechanic')->middleware('auth:mechanic')->group(function () {
    Route::get('/profile/{mechanic}', [MechanicController::class, 'ProfilePage'])->name('mechanic_profilePage');
    Route::get('/profile/edit/{mechanic}', [MechanicController::class, 'EditProfilePage'])->name('mechanic_EditProfilePage');
    Route::patch('/profile/edit/{mechanic}', [MechanicController::class, 'EditProfile'])->name('mechanic_EditProfile');

    Route::get('/EmergencyRequest/{mechanic}/show', [EmergencyRequestController::class, 'MechanicRequest'])->name('MechanicRequestReport');
    Route::post('/update-request', [EmergencyRequestController::class, 'MechanicUpdateRequest'])->name('MechanicUpdateRequestReport');

    Route::post('/delete-request', [EmergencyRequestController::class, 'MechanicDeleteRequest'])->name('MechanicDeleteRequestReport');
});
