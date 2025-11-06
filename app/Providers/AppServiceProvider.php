<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // PENTING: Mengarahkan link reset password ke frontend Anda
        ResetPassword::createUrlUsing(function (object $user, string $token) {
            // Ganti 'http://frontend.test/reset-password' dengan URL
            // halaman reset password di aplikasi frontend Anda (React/Vue/dll)
            return 'http://frontend.test/reset-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
