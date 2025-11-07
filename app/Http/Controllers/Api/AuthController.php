<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Employee; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 

class AuthController extends Controller
{
    /**
     * Registrasi Employee.
     */
    public function registerEmployee(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Gunakan Transaction
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee', // Hardcode role 'employee' saat registrasi
            ]);

            // === INI SOLUSINYA ===
            Employee::create([
                'user_id' => $user->id,
                'join_date' => Carbon::today(), // Set join_date ke hari ini
            ]);
            // ======================
            
            DB::commit(); // Simpan

            // Buat token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Kembalikan response JSON
            return response()->json([
                'message' => 'Registrasi berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika error
            return response()->json([
                'message' => 'Registrasi gagal, terjadi kesalahan server.'
            ], 500);
        }
    }

    /**
     * Login untuk Employee.
     */
    public function loginEmployee(Request $request)
    {
        return $this->login($request, 'employee');
    }

    /**
     * Login untuk Admin.
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

        $credentials['role'] = $role;

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email/password salah atau role tidak sesuai.'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
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