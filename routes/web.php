<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\Owner\OwnerBookingController;


// =====================
// AUTH
// =====================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================
// OWNER (HANYA PEMILIK)
// =====================

Route::middleware(['role:owner'])->group(function () {

    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])
        ->name('owner.dashboard');


    // ===== PROPERTIES =====
    Route::prefix('/owner/properties')->name('owner.properties.')->group(function () {

        Route::get('/', [PropertyController::class, 'index'])->name('index');

        Route::get('/create', [PropertyController::class, 'create'])->name('create');

        Route::post('/', [PropertyController::class, 'store'])->name('store');

        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');

        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');

        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');

        // SET FOTO UTAMA
        Route::post('/image/{image}/set-main', [PropertyController::class, 'setMain'])
            ->name('image.setMain');

        // HAPUS FOTO
        Route::delete('/image/{image}', [PropertyController::class, 'deleteImage'])
            ->name('image.delete');
    });


    // ===== BOOKING MASUK =====
    Route::get('/owner/bookings', [OwnerBookingController::class, 'index'])
        ->name('owner.booking.index');

    Route::post('/owner/bookings/{booking}/{status}', [OwnerBookingController::class, 'updateStatus'])
        ->name('owner.booking.update');
});


// =====================
// USER
// =====================

Route::middleware(['role:user'])->group(function () {

    // daftar kos + filter
    Route::get('/user/dashboard', [UserPropertyController::class, 'index'])
        ->name('user.dashboard');

    // detail property
    Route::get('/user/property/{property}', [UserPropertyController::class, 'show'])
        ->name('user.property.show');

    // ajukan booking
    Route::post('/user/property/{property}/booking', [UserBookingController::class, 'store'])
        ->name('user.booking.store');

    // booking saya
    Route::get('/user/bookings', [UserBookingController::class, 'myBookings'])
        ->name('user.booking.my');
});


// =====================
// ADMIN
// =====================

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Admin Dashboard';
    });
});


// =====================
// DEFAULT
// =====================

Route::get('/', function () {
    return redirect('/login');
});
