<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\OtpPasswordResetController;

// Registrasi Employee
Route::post('/employee/register', [AuthController::class, 'registerEmployee']);

// Login
Route::post('/employee/login', [AuthController::class, 'loginEmployee']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);


// Rute OTP
Route::post('/otp/send', [OtpPasswordResetController::class, 'sendOtp']);
Route::post('/otp/reset', [OtpPasswordResetController::class, 'resetWithOtp']);

// Rute yang dilindungi token (untuk Employee)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
