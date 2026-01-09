<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
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
=======

// =======================
// AUTH
// =======================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;

// =======================
// CHAT
// =======================
use App\Http\Controllers\ChatController;

// =======================
// OWNER
// =======================
use App\Http\Controllers\Owner\OwnerChatController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\OwnerBookingController;

// =======================
// USER
// =======================
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\User\BookingPaymentController;

// =======================
// MIDTRANS WEBHOOK
// =======================
use App\Http\Controllers\PaymentController;

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
>>>>>>> zulfatah

    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])
        ->name('owner.dashboard');

<<<<<<< HEAD

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
=======
    Route::prefix('owner/properties')->name('owner.properties.')->group(function () {
        Route::get('/', [PropertyController::class, 'index'])->name('index');
        Route::get('/create', [PropertyController::class, 'create'])->name('create');
        Route::post('/', [PropertyController::class, 'store'])->name('store');
        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');

        Route::post('/image/{image}/set-main', [PropertyController::class, 'setMain'])
            ->name('image.setMain');

>>>>>>> zulfatah
        Route::delete('/image/{image}', [PropertyController::class, 'deleteImage'])
            ->name('image.delete');
    });

<<<<<<< HEAD

    // ===== BOOKING MASUK =====
=======
>>>>>>> zulfatah
    Route::get('/owner/bookings', [OwnerBookingController::class, 'index'])
        ->name('owner.booking.index');

    Route::post('/owner/bookings/{booking}/{status}', [OwnerBookingController::class, 'updateStatus'])
        ->name('owner.booking.update');
<<<<<<< HEAD
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
=======

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
| MIDTRANS WEBHOOK (PUBLIC, NO AUTH)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/webhook', [PaymentController::class, 'handle'])
    ->name('midtrans.webhook');

/*
|--------------------------------------------------------------------------
| DEBUG ROUTE (SEMENTARA)
|--------------------------------------------------------------------------
| HAPUS SETELAH APP_KEY BERES
*/
Route::get('/test-key', function () {
    return response()->json([
        'app_key' => config('app.key'),
        'cipher'  => config('app.cipher'),
    ]);
});

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
>>>>>>> zulfatah
