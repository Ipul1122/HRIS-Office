<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\EmployeeAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Employee\ProfileController;
use Illuminate\Support\Facades\Auth; // Import Auth

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
    
    // --- PERBAIKAN DI SINI ---
    Route::get('/dashboard', function () {
        // Ambil id user dari guard employee
        $id = Auth::guard('employee')->id();

        // Jika ada id, ambil model Eloquent dan eager-load relation 'employee'
        $user = $id ? \App\Models\User::with('employee')->find($id) : null;

        // Dapatkan employee (atau null jika tidak ditemukan)
        $employee = $user ? $user->employee : null;

        return view('employee.dashboard', ['employee' => $employee]);
    })->name('employee.dashboard');
    // ----------------------------

    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');

    // == RUTE PROFIL ==
    Route::get('/profile', [ProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('employee.profile.update');
});

// Rute untuk MENAMPILKAN halaman/form "Lupa Password"
Route::get('employee/auth/lupa-password', function () {
    return view('employee.auth.lupa-password');
})->name('employee.password.request.form');

// Rute untuk MENAMPILKAN halaman/form "Reset Password"
Route::get('employee/auth/reset-password', function () {
    return view('employee.auth.reset-password');
})->name('employee.password.reset.form');

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