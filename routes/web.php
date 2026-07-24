<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModifierGroupController;
use App\Http\Controllers\ModifierOptionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/settings', [ShopProfileController::class, 'index'])->name('settings.index');
    Route::put('/settings', [ShopProfileController::class, 'update'])->name('settings.update');
});

Route::resource('categories', CategoryController::class)->except(['show']);

Route::resource('products', ProductController::class)->except(['show']);
Route::patch('products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])
    ->name('products.toggle-availability');

Route::resource('modifier-groups', ModifierGroupController::class)->except(['show']);
Route::post('modifier-groups/{modifierGroup}/options', [ModifierOptionController::class, 'store'])
    ->name('modifier-options.store');
Route::put('modifier-options/{modifierOption}', [ModifierOptionController::class, 'update'])
    ->name('modifier-options.update');
Route::delete('modifier-options/{modifierOption}', [ModifierOptionController::class, 'destroy'])
    ->name('modifier-options.destroy');