<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Owner\OwnerChatController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\OwnerBookingController;
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\User\BookingPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Register OTP (EMAIL)
|--------------------------------------------------------------------------
*/

// redirect /register ke form email OTP
Route::get('/register', fn () => redirect()->route('register.email'))->name('register');

// form email
Route::get('/register/email', [AuthOtpController::class, 'showEmailForm'])->name('register.email');

// kirim OTP
Route::post('/register/email', [AuthOtpController::class, 'sendCode'])->name('register.send');

// form input OTP
Route::get('/register/verify', [AuthOtpController::class, 'showVerifyForm'])->name('register.verify');

// submit OTP + buat akun
Route::post('/register/verify', [AuthOtpController::class, 'completeRegister'])->name('register.complete');

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner', 'blocked'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('index');
            Route::get('/create', [PropertyController::class, 'create'])->name('create');
            Route::post('/', [PropertyController::class, 'store'])->name('store');
            Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
            Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
            Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');

            Route::post('/image/{image}/set-main', [PropertyController::class, 'setMain'])->name('image.main');
            Route::delete('/image/{image}', [PropertyController::class, 'deleteImage'])->name('image.delete');
        });

        Route::get('/bookings', [OwnerBookingController::class, 'index'])->name('booking.index');
        Route::post('/bookings/{booking}/{status}', [OwnerBookingController::class, 'updateStatus'])->name('booking.update');

        Route::get('/chats', [OwnerChatController::class, 'index'])->name('chats');
        Route::get('/chat/{chat}', [OwnerChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{chat}/send', [OwnerChatController::class, 'send'])->name('chat.send');
    });

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user', 'blocked'])->group(function () {

    Route::get('/user/dashboard', [UserPropertyController::class, 'index'])->name('user.dashboard');
    Route::get('/user/property/{property}', [UserPropertyController::class, 'show'])->name('user.property.show');

    Route::post('/user/property/{property}/booking', [UserBookingController::class, 'store'])->name('user.booking.store');
    Route::get('/user/bookings', [UserBookingController::class, 'myBookings'])->name('user.booking.my');

    Route::get('/booking/{booking}/pay', [BookingPaymentController::class, 'pay'])->name('booking.pay');

    Route::post('/chat/start/{property}', [ChatController::class, 'start'])->name('chat.start');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chat}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{chat}/messages', [ChatController::class, 'messages'])->name('chat.messages');
    Route::get('/user/chats', [ChatController::class, 'index'])->name('user.chats');
});

/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/webhook', [PaymentController::class, 'handle'])->name('midtrans.webhook');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class,'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class,'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class,'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class,'destroy'])->name('users.destroy');
    Route::post('/users/{user}/block', [AdminUserController::class,'toggleBlock'])->name('users.block');

    Route::get('/owners/{user}/properties', [AdminDashboardController::class,'properties'])->name('owners.properties');

    Route::get('/bookings', [AdminUserController::class,'bookings'])->name('bookings.index');

    Route::delete('/properties/{property}', [AdminDashboardController::class,'destroyProperty'])->name('properties.destroy');
});

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match(auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        'user'  => redirect()->route('user.dashboard'),
        default => redirect()->route('login'),
    };

});

/*
|--------------------------------------------------------------------------
| CLEAN CACHE
|--------------------------------------------------------------------------
*/

Route::get('/bersih-bersih', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return '<h1>Cache Berhasil Dibersihkan!</h1>';
});
