<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Registrasi Employee.
     * Logika ini didasarkan pada model User Anda.
     */
    public function registerEmployee(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee', // Hardcode role 'employee' saat registrasi
        ]);

        // Buat token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan response JSON
        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    /**
     * Login untuk Employee.
     * Menggunakan logika yang sama dengan EmployeeAuthController Anda.
     */
    public function loginEmployee(Request $request)
    {
        return $this->login($request, 'employee');
    }

    /**
     * Login untuk Admin.
     * Menggunakan logika yang sama dengan AdminAuthController Anda.
     */
    public function loginAdmin(Request $request)
    {
        return $this->login($request, 'admin');
    }

    /**
     * Fungsi helper privat untuk menangani logika login
     */
    private function login(Request $request, $role)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Tambahkan 'role' ke kredensial
        $credentials['role'] = $role;

        // Coba login (menggunakan guard 'web' / default, tapi memfilter user)
        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email/password salah atau role tidak sesuai.'
            ], 401);
        }

        // Dapatkan user
        $user = User::where('email', $request->email)->first();

        // Buat token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * Logout user (menghapus token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}