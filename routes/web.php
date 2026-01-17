<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\Owner\OwnerChatController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\OwnerBookingController;
use App\Http\Controllers\Owner\PropertyController as OwnerPropertyController;

use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\User\UserChatController;
use App\Http\Controllers\User\BookingPaymentController;
use App\Http\Controllers\User\UserPropertyController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminOwnerController;

use App\Http\Controllers\PaymentController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', fn () => redirect()->route('register.email'))->name('register');

Route::get('/register/email', [AuthOtpController::class, 'showEmailForm'])->name('register.email');
Route::post('/register/email', [AuthOtpController::class, 'sendCode'])->name('register.send');
Route::get('/register/verify', [AuthOtpController::class, 'showVerifyForm'])->name('register.verify');
Route::post('/register/verify', [AuthOtpController::class, 'completeRegister'])->name('register.complete');

Route::get('/dev-login/{role}', function ($role) {
    if (!in_array($role, ['admin', 'owner', 'user'])) return 'Role tidak valid';
    $user = \App\Models\User::where('role', $role)->first();
    if (!$user) return "User dengan role {$role} belum ada";
    Auth::login($user);
    return redirect('/');
});

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [OwnerPropertyController::class, 'index'])->name('index');
            Route::get('/create', [OwnerPropertyController::class, 'create'])->name('create');
            Route::post('/', [OwnerPropertyController::class, 'store'])->name('store');
            Route::get('/{property}/edit', [OwnerPropertyController::class, 'edit'])->name('edit');
            Route::put('/{property}', [OwnerPropertyController::class, 'update'])->name('update');
            Route::delete('/{property}', [OwnerPropertyController::class, 'destroy'])->name('destroy');
            Route::patch('/images/{image}/main', [OwnerPropertyController::class, 'setMainImage'])->name('image.main');
            Route::delete('/images/{image}', [OwnerPropertyController::class, 'deleteImage'])->name('image.delete');
        });
        
        Route::post('/bookings/{booking}/update', [OwnerBookingController::class, 'update'])
            ->name('booking.update');

        Route::get('/bookings', [OwnerBookingController::class, 'index'])->name('booking.index');
        Route::get('/chats', [OwnerChatController::class, 'index'])->name('chats');
        Route::get('/chats/{chat}', [OwnerChatController::class, 'show'])->name('chat.show');
        Route::post('/chats/{chat}/send', [OwnerChatController::class, 'send'])->name('chat.send');
    });

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [UserPropertyController::class, 'index'])->middleware(['auth', 'block'])->name('user.dashboard');

    Route::get('/user/bookings', [UserBookingController::class, 'myBookings'])->name('user.booking.my');
    Route::post('/user/bookings/{property}', [UserBookingController::class, 'store'])->name('user.booking.store');

    Route::get('/user/bookings/{booking}/pay', [BookingPaymentController::class, 'pay'])->name('booking.pay');

    Route::get('/user/chats', [UserChatController::class, 'index'])->name('user.chats');

    Route::get('/user/chats/{chat}', [UserChatController::class, 'show'])
        ->name('user.chats.show');

    Route::post('/user/chats/{chat}/send', [UserChatController::class, 'send'])
        ->name('chat.send');

    Route::get('/user/chats/{chat}/messages', [UserChatController::class, 'messages'])
        ->name('chat.messages');

    Route::post('/user/chats/start/{owner}', [UserChatController::class, 'start'])
        ->name('chat.start');

});

Route::prefix('user')
    ->middleware(['auth', 'block'])
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserPropertyController::class, 'index'])->name('dashboard');
        Route::get('/properties', [UserPropertyController::class, 'index'])->name('property.index');
        Route::get('/properties/{property}', [UserPropertyController::class, 'show'])->name('property.show');
    });

Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/', [OwnerPropertyController::class, 'index'])->name('index');
    Route::get('/create', [OwnerPropertyController::class, 'create'])->name('create');
    Route::post('/', [OwnerPropertyController::class, 'store'])->name('store');
    Route::get('/{property}/edit', [OwnerPropertyController::class, 'edit'])->name('edit');
    Route::put('/{property}', [OwnerPropertyController::class, 'update'])->name('update');
    Route::delete('/{property}', [OwnerPropertyController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/block', [AdminUserController::class, 'block'])->name('users.block');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');

        Route::get('/owners/{owner}/properties', [AdminOwnerController::class, 'properties'])
            ->name('owners.properties');

        Route::delete('/properties/{property}', [\App\Http\Controllers\Admin\AdminPropertyController::class, 'destroy'])
            ->name('properties.destroy');
    });


Route::get('/', function () {
    if (!auth()->check()) return redirect()->route('login');

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        'user'  => redirect()->route('user.dashboard'),
        default => redirect()->route('login'),
    };
});

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'cleared';
});

Route::get('/fix-storage-path', function () {
    \DB::statement("UPDATE property_images SET file_path = CONCAT('storage/', file_path) WHERE file_path NOT LIKE 'storage/%'");
    return 'FIXED';
});

Route::get('/debug-storage', function () {
    return [
        'exists_public_storage' => file_exists(public_path('storage')),
        'exists_sample_file' => file_exists(public_path('storage/properties')),
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage'),
    ];
});

use App\Http\Controllers\MidtransCallbackController;

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);
