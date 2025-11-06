<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = $request->boolean('remember');

        // Pastikan hanya ADMIN yang bisa login di form ini
        $credentials['role'] = 'admin';

        if (! Auth::guard('admin')->attempt($credentials, $remember)) {
            return back()->withErrors(['email' => 'Email/password salah atau bukan admin.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
