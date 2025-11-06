<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', fn() => redirect()->route('employee.login'));

// ================= Employee Auth =================
Route::middleware('guest:employee')->group(function () {
    Route::get('/login', [EmployeeAuthController::class, 'showLogin'])->name('employee.login');
    Route::post('/login', [EmployeeAuthController::class, 'login'])->name('employee.login.submit');

    // Register employee (admin dibuat via seeder)
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('employee.register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('employee.register.submit');
});

Route::middleware('auth:employee')->group(function () {
    Route::get('/dashboard', fn () => view('employee.dashboard'))->name('employee.dashboard');
    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');
});

// ================= Admin Auth ====================
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        // contoh halaman admin-only
        Route::get('/users', fn () => 'Kelola User (Admin)')->name('admin.users.index');
    });
});
