<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\OtpPasswordResetController;

// Registrasi Employee (Admin tidak boleh register via API)
Route::post('/employee/register', [AuthController::class, 'registerEmployee']);

// Login (terpisah untuk Employee dan Admin)
Route::post('/employee/login', [AuthController::class, 'loginEmployee']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

// Rute yang dilindungi token
Route::middleware('auth:sanctum')->group(function () {
    // Endpoint untuk mengambil data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint untuk logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/otp/send', [OtpPasswordResetController::class, 'sendOtp']);

Route::post('/otp/reset', [OtpPasswordResetController::class, 'resetWithOtp']);