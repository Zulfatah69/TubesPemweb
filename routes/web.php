<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminOwnerController;
use App\Http\Controllers\User\UserChatController;

/*
|--------------------------------------------------------------------------
| AUTH BASIC
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTER + OTP
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
| 🔥 DEV LOGIN (LOCAL ONLY)
|--------------------------------------------------------------------------
| GUNAKAN UNTUK BUKA SEMUA HALAMAN TANPA LOGIN FORM
*/
Route::get('/dev-login/{role}', function ($role) {

    if (!in_array($role, ['admin', 'owner', 'user'])) {
        return 'Role tidak valid';
    }

    $user = \App\Models\User::where('role', $role)->first();

    if (!$user) {
        return "User dengan role {$role} belum ada";
    }

    Auth::login($user);

    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner', 'blocked'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('index');
            Route::get('/create', [PropertyController::class, 'create'])->name('create');
            Route::post('/', [PropertyController::class, 'store'])->name('store');
            Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
            Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
            Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');
        });

        Route::get('/bookings', [OwnerBookingController::class, 'index'])
            ->name('booking.index');

        Route::get('/chats', [OwnerChatController::class, 'index'])
            ->name('chats');
    });

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user', 'blocked'])->group(function () {

    Route::get('/user/dashboard', [UserPropertyController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/bookings', [UserBookingController::class, 'myBookings'])
        ->name('user.booking.my');
      
    Route::get('/user/chats', [UserChatController::class, 'index'])
        ->name('user.chats');
    
    // Hanya satu route GET untuk lihat chat dengan owner tertentu
    Route::get('/user/chats/{owner}', [UserChatController::class, 'show'])
        ->name('user.chats.show');
    
    Route::post('/user/chats/{owner}/send', [UserChatController::class, 'send'])
        ->name('chat.send');
    
    // Ambil pesan chat untuk owner tertentu (AJAX)
    Route::get('/user/chats/{owner}/messages', [UserChatController::class, 'messages'])
        ->name('chat.messages');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');

        // Bookings
        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');  // <--- ini bikin route admin.bookings.index
        
        Route::get('/owners/{owner}/properties', [AdminOwnerController::class, 'properties'])
            ->name('owners.properties');

        Route::post('/users/{user}/block', [AdminUserController::class, 'block'])
            ->name('users.block');
        
        // Hapus user
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

    });
/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        'user'  => redirect()->route('user.dashboard'),
        default => redirect()->route('login'),
    };
});

/*
|--------------------------------------------------------------------------
| CLEAR CACHE (DEV)
|--------------------------------------------------------------------------
*/
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'cleared';
});
