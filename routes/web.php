<?php

use App\Models\ServiceType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\ServiceTypeController;
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
        // Admin profile routes
        Route::get('/profile/{admin}', [AdminController::class, 'ProfilePage'])->name('admin.profile');
        Route::get('/profile/edit/{admin}', [AdminController::class, 'EditProfilePage'])->name('admin.profile.edit');
        Route::patch('/profile/edit/{admin}', [AdminController::class, 'EditProfile'])->name('admin.profile.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Admin Service Request Routes
        Route::get('/service-requests', [App\Http\Controllers\Admin\ServiceRequestController::class, 'index'])->name('admin.service-requests.index');
        Route::get('/service-requests/{serviceRequest}', [App\Http\Controllers\Admin\ServiceRequestController::class, 'show'])->name('admin.service-requests.show');
        Route::put('/service-requests/{serviceRequest}', [App\Http\Controllers\Admin\ServiceRequestController::class, 'update'])->name('admin.service-requests.update');

        // Admin Customer Routes
        Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');

        // Admin Mechanic Routes
        Route::get('/mechanics', [App\Http\Controllers\Admin\MechanicController::class, 'index'])->name('admin.mechanics.index');
        Route::get('/mechanics/{mechanic}', [App\Http\Controllers\Admin\MechanicController::class, 'show'])->name('admin.mechanics.show');

        // Admin Emergency Request Routes
        Route::get('/emergency-requests', [App\Http\Controllers\Admin\EmergencyRequestController::class, 'index'])->name('admin.emergency-requests.index');
        Route::get('/emergency-requests/{emergencyRequest}', [App\Http\Controllers\Admin\EmergencyRequestController::class, 'show'])->name('admin.emergency-requests.show');
        Route::put('/emergency-requests/{emergencyRequest}', [App\Http\Controllers\Admin\EmergencyRequestController::class, 'update'])->name('admin.emergency-requests.update');

        // Admin Review Routes
        Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::get('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('admin.reviews.show');

        // Admin Payment Routes
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
        Route::get('/payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');

        // Admin Service Type Routes
        Route::get('/service-types', [App\Http\Controllers\Admin\ServiceTypeController::class, 'index'])->name('admin.service-types.index');
        Route::get('/service-types/create', [App\Http\Controllers\Admin\ServiceTypeController::class, 'create'])->name('admin.service-types.create');
        Route::post('/service-types', [App\Http\Controllers\Admin\ServiceTypeController::class, 'store'])->name('admin.service-types.store');
        Route::get('/service-types/{serviceType}/edit', [App\Http\Controllers\Admin\ServiceTypeController::class, 'edit'])->name('admin.service-types.edit');
        Route::put('/service-types/{serviceType}', [App\Http\Controllers\Admin\ServiceTypeController::class, 'update'])->name('admin.service-types.update');
        Route::delete('/service-types/{serviceType}', [App\Http\Controllers\Admin\ServiceTypeController::class, 'destroy'])->name('admin.service-types.destroy');

        // Admin management Routes
        Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.admins.index');
        Route::get('/admins/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admin.admins.create');
        Route::post('/admins', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admin.admins.store');
        Route::get('/admins/{admin}/edit', [App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('admin.admins.edit');
        Route::put('/admins/{admin}', [App\Http\Controllers\Admin\AdminController::class, 'update'])->name('admin.admins.update');
        Route::delete('/admins/{admin}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admin.admins.destroy');
    });
});

// Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth:admin'])
    ->name('admin.dashboard');

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

        Route::post('/EmergencyRequest/delete', [EmergencyRequestController::class, 'MechanicDeleteRequestEmergency'])->name('emergency.request.delete');

        // Use Resource Route for Service Requests
        Route::resource('service-requests', ServiceRequestController::class)->only(['index', 'create', 'store']);

        // Regular Service Requests
        Route::prefix('service-request')->group(function () {
            Route::post('/update', [ServiceRequestController::class, 'MechanicUpdateRequestRegular'])->name('customer.service.update');
            Route::post('/delete', [ServiceRequestController::class, 'MechanicDeleteRequestRegular'])->name('customer.service.delete');

            Route::post('/accept', [ServiceRequestController::class, 'MechanicAcceptRequestRegular'])->name('customer.service.accept');
            Route::post('/reject', [ServiceRequestController::class, 'MechanicRejectRequestRegular'])->name('customer.service.reject');

            Route::post('/change-ServiceType', [ServiceTypeController::class, 'ChangeServiceType'])->name('customer.serviceType.Change');
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


        Route::get('/checkout/{serviceRequestId}', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
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


            Route::post('/accept', [EmergencyRequestController::class, 'MechanicAcceptRequestEmergency'])->name('mechanic.emergency.accept');
            Route::post('/reject', [EmergencyRequestController::class, 'MechanicRejectRequestEmergency'])->name('mechanic.emergency.reject');
        });

        // Regular Service Requests
        Route::prefix('service-request')->group(function () {
            Route::post('/update', [ServiceRequestController::class, 'MechanicUpdateRequestRegular'])->name('mechanic.service.update');
            Route::post('/delete', [ServiceRequestController::class, 'MechanicDeleteRequestRegular'])->name('mechanic.service.delete');

            Route::post('/accept', [ServiceRequestController::class, 'MechanicAcceptRequestRegular'])->name('mechanic.service.accept');
            Route::post('/reject', [ServiceRequestController::class, 'MechanicRejectRequestRegular'])->name('mechanic.service.reject');
        });

        // Service Types
        Route::prefix('service-type')->group(function () {
            Route::get('index', [ServiceTypeController::class, 'index'])->name('mechanic.service-type.index');

            Route::get('/create', [ServiceTypeController::class, 'create'])->name('mechanic.service-type.create');
            Route::post('/store', [ServiceTypeController::class, 'store'])->name('mechanic.service-type.store');

            Route::get('/edit/{ServiceType}', [ServiceTypeController::class, 'edit'])->name('mechanic.service-type.edit');
            Route::put('/update/{ServiceType}', [ServiceTypeController::class, 'update'])->name('mechanic.service-type.update');

            Route::post('/delete', [ServiceTypeController::class, 'destroy'])->name('mechanic.service-type.delete');
        });
    });
});
/* ------------------------------------------------------------End MECHANIC------------------------------------------------------------ */
