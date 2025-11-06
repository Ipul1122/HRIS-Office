<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthController extends Controller
{
    public function showLogin()
    {
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = $request->boolean('remember');

        // Pastikan hanya EMPLOYEE yang bisa login di form ini
        $credentials['role'] = 'employee';

        if (! Auth::guard('employee')->attempt($credentials, $remember)) {
            return back()->withErrors(['email' => 'Email/password salah atau bukan pegawai.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('employee.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('employee.login');
    }
}
