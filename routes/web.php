<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;

// CHAT
use App\Http\Controllers\ChatController;

// OWNER
use App\Http\Controllers\Owner\OwnerChatController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\OwnerBookingController;

// USER
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\User\BookingPaymentController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTER OTP
|--------------------------------------------------------------------------
*/
Route::get('/register', fn () => redirect()->route('register.email'))->name('register');

Route::get('/register/email', [AuthOtpController::class, 'showEmailForm'])
    ->name('register.email');

Route::post('/register/email', [AuthOtpController::class, 'sendCode'])
    ->name('register.send');

Route::get('/register/verify', [AuthOtpController::class, 'showVerifyForm'])
    ->name('register.verify');

Route::post('/register/verify', [AuthOtpController::class, 'completeRegister'])
    ->name('register.complete');

/*
|--------------------------------------------------------------------------
| OWNER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->group(function () {

    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])
        ->name('owner.dashboard');

    Route::prefix('owner/properties')->name('owner.properties.')->group(function () {
        Route::get('/', [PropertyController::class, 'index'])->name('index');
        Route::get('/create', [PropertyController::class, 'create'])->name('create');
        Route::post('/', [PropertyController::class, 'store'])->name('store');
        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');

        Route::post('/image/{image}/set-main', [PropertyController::class, 'setMain'])
            ->name('image.setMain');

        Route::delete('/image/{image}', [PropertyController::class, 'deleteImage'])
            ->name('image.delete');
    });

    Route::get('/owner/bookings', [OwnerBookingController::class, 'index'])
        ->name('owner.booking.index');

    Route::post('/owner/bookings/{booking}/{status}', [OwnerBookingController::class, 'updateStatus'])
        ->name('owner.booking.update');

    // CHAT OWNER
    Route::get('/owner/chats', [OwnerChatController::class, 'index'])
        ->name('owner.chats');

    Route::get('/owner/chat/{chat}', [OwnerChatController::class, 'show'])
        ->name('owner.chat.show');

    Route::post('/owner/chat/{chat}/send', [OwnerChatController::class, 'send'])
        ->name('owner.chat.send');
});

/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [UserPropertyController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/property/{property}', [UserPropertyController::class, 'show'])
        ->name('user.property.show');

    Route::post('/user/property/{property}/booking', [UserBookingController::class, 'store'])
        ->name('user.booking.store');

    Route::get('/user/bookings', [UserBookingController::class, 'myBookings'])
        ->name('user.booking.my');

    /*
    |--------------------------------------------------------------------------
    | MIDTRANS PAYMENT (USER)
    |--------------------------------------------------------------------------
    */
    Route::get('/booking/{booking}/pay', [BookingPaymentController::class, 'pay'])
        ->name('booking.pay');

    // CHAT USER
    Route::post('/chat/start/{property}', [ChatController::class, 'start'])
        ->name('chat.start');

    Route::get('/chat/{chat}', [ChatController::class, 'show'])
        ->name('chat.show');

    Route::post('/chat/{chat}/send', [ChatController::class, 'send'])
        ->name('chat.send');

    Route::get('/chat/{chat}/messages', [ChatController::class, 'messages'])
        ->name('chat.messages');

    Route::get('/user/chats', [ChatController::class, 'index'])
        ->name('user.chats');
});

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (NO AUTH, NO ROLE)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [BookingPaymentController::class, 'callback'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => 'Admin Dashboard');
});

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));
use App\Http\Controllers\PaymentController;

Route::post('/midtrans/webhook', [PaymentController::class, 'handle']);
