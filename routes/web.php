<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\EmergencyRequestController;



/* ------------------------------------------------------------Start Auth------------------------------------------------------------ */
// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'loginPage')->name('login.page');
    Route::post('/', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::prefix('auth')->group(function () {
        Route::get('/register/create', 'RegisterPage')->name('auth.register.page');
        Route::post('/register/store', 'RegisterStore')->name('auth.register.store');
    });
});
/* ------------------------------------------------------------End Auth------------------------------------------------------------ */


/* ------------------------------------------------------------Admin Auth------------------------------------------------------------ */

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/register/create', [AdminController::class, 'RegisterPage'])->name('admin.register.page');
        Route::post('/register/store', [AdminController::class, 'RegisterStore'])->name('admin.register.store');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/profile/{admin}', [AdminController::class, 'ProfilePage'])->name('admin.profile');
        Route::get('/profile/edit/{admin}', [AdminController::class, 'EditProfilePage'])->name('admin.profile.edit');
        Route::patch('/profile/edit/{admin}', [AdminController::class, 'EditProfile'])->name('admin.profile.update');
    });
});

/* ------------------------------------------------------------Admin End------------------------------------------------------------ */



/* ------------------------------------------------------------Start Customer------------------------------------------------------------ */


Route::prefix('customer')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('/register/create', [CustomerController::class, 'create'])->name('customer.register.page');
        Route::post('/register/store', [CustomerController::class, 'store'])->name('customer.register.store');
    });

    Route::middleware('auth:customer')->group(function () {
        Route::get('/profile/{id}', [CustomerController::class, 'ProfilePage'])->name('customer.profile');
        Route::get('/profile/edit/{id}', [CustomerController::class, 'EditProfile'])->name('customer.profile.edit');
        Route::patch('/profile/edit/{id}', [CustomerController::class, 'UpdateProfile'])->name('customer.profile.update');

        Route::get('/EmergencyRequest/create', [EmergencyRequestController::class, 'index'])->name('emergency.request.create');
        Route::post('/EmergencyRequest/{customer}/store', [EmergencyRequestController::class, 'store'])->name('emergency.request.store');

        // Use Resource Route for Service Requests
        Route::resource('service-requests', ServiceRequestController::class)->only(['index', 'create', 'store']);

        // Regular Service Requests
        Route::prefix('service-request')->group(function () {
            Route::post('/update', [ServiceRequestController::class, 'MechanicUpdateRequestRegular'])->name('customer.service.update');
            Route::post('/delete', [ServiceRequestController::class, 'MechanicDeleteRequestRegular'])->name('customer.service.delete');

            Route::post('/accept', [ServiceRequestController::class, 'MechanicAcceptRequestRegular'])->name('customer.service.accept');
            Route::post('/reject', [ServiceRequestController::class, 'MechanicRejectRequestRegular'])->name('customer.service.reject');
        });

        // Review Routes
        Route::prefix('review')->group(function () {
            // Route::get('/', [ReviewController::class, 'create'])->name('reviews.create');
            Route::get('/create/{serviceRequest}', [ReviewController::class, 'create'])->name('reviews.create.specific');
            Route::post('/store/{serviceRequest}', [ReviewController::class, 'store'])->name('reviews.store');
            Route::get('/edit/{review}', [ReviewController::class, 'edit'])->name('reviews.edit');
            Route::put('/update/{review}', [ReviewController::class, 'update'])->name('reviews.update');
            // Route::get('/{customer}', [CustomerController::class, 'AllReviews'])->name('reviews.customer');
        });
    });
});
/* ------------------------------------------------------------End Customer------------------------------------------------------------ */



/* ------------------------------------------------------------Start MECHANIC------------------------------------------------------------ */
Route::prefix('mechanic')->group(function () {
    Route::middleware('guest:mechanic')->group(function () {
        Route::get('/register/create', [MechanicController::class, 'RegisterPage'])->name('mechanic.register.page');
        Route::post('/register/store', [MechanicController::class, 'RegisterStore'])->name('mechanic.register.store');
    });

    Route::middleware('auth:mechanic')->group(function () {
        Route::get('/profile/{mechanic}', [MechanicController::class, 'ProfilePage'])->name('mechanic.profile');
        Route::get('/profile/edit/{mechanic}', [MechanicController::class, 'EditProfilePage'])->name('mechanic.profile.edit');
        Route::patch('/profile/edit/{mechanic}', [MechanicController::class, 'EditProfile'])->name('mechanic.profile.update');

        // Emergency Requests for Mechanics
        Route::prefix('emergency-request')->group(function () {
            Route::get('/{mechanic}/show', [EmergencyRequestController::class, 'MechanicRequest'])->name('mechanic.emergency.show');
            Route::post('/update', [EmergencyRequestController::class, 'MechanicUpdateRequestEmergency'])->name('mechanic.emergency.update');
            Route::post('/delete', [EmergencyRequestController::class, 'MechanicDeleteRequestEmergency'])->name('mechanic.emergency.delete');
        });

        // Regular Service Requests
        Route::prefix('service-request')->group(function () {
            Route::post('/update', [ServiceRequestController::class, 'MechanicUpdateRequestRegular'])->name('mechanic.service.update');
            Route::post('/delete', [ServiceRequestController::class, 'MechanicDeleteRequestRegular'])->name('mechanic.service.delete');

            Route::post('/accept', [ServiceRequestController::class, 'MechanicAcceptRequestRegular'])->name('mechanic.service.accept');
            Route::post('/reject', [ServiceRequestController::class, 'MechanicRejectRequestRegular'])->name('mechanic.service.reject');
        });
    });
});
/* ------------------------------------------------------------End MECHANIC------------------------------------------------------------ */
