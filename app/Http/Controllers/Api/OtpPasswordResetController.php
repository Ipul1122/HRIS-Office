<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Mail\SendOtpMail;

class OtpPasswordResetController extends Controller
{
    /**
     * Mengirim 4-digit OTP ke email user.
     */
    public function sendOtp(Request $request)
    {
        // 1. Validasi request
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Buat 4-digit OTP
        $otp = (string) random_int(1000, 9999);
        $email = $request->email;

        // 3. Simpan OTP (di-hash) ke database
        // Kita gunakan tabel 'password_reset_tokens' bawaan Laravel
        //
        
        // Hapus token/OTP lama jika ada
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Simpan OTP yang di-hash agar aman
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($otp), // Simpan HASH dari OTP, bukan OTP-nya
            'created_at' => Carbon::now()
        ]);

        // 4. Kirim email berisi OTP (yang BUKAN hash)
        try {
            Mail::to($email)->send(new SendOtpMail($otp, $email));
        } catch (\Exception $e) {
            // Jika GMail gagal (salah password .env, dll)
            return response()->json(['message' => 'Gagal mengirim email.', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OTP 4-digit telah dikirim ke email Anda.'], 200);
    }

    /**
     * Memverifikasi OTP dan mereset password.
     */
    public function resetWithOtp(Request $request)
    {
        // 1. Validasi request
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'min:4', 'max:4'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->email;
        $otp = $request->otp;

        // 2. Cari data OTP di database
        $tokenData = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$tokenData) {
            return response()->json(['message' => 'Email tidak ditemukan atau OTP tidak diminta.'], 404);
        }

        // 3. Cek apakah OTP kedaluwarsa (misal: 10 menit)
        $expiresAt = Carbon::parse($tokenData->created_at)->addMinutes(10);
        if (Carbon::now()->isAfter($expiresAt)) {
            // Hapus token jika kedaluwarsa
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json(['message' => 'OTP telah kedaluwarsa.'], 400);
        }

        // 4. Verifikasi OTP (cek hash)
        if (!Hash::check($otp, $tokenData->token)) {
            return response()->json(['message' => 'OTP tidak valid.'], 400);
        }

        // 5. Jika semua lolos, ganti password user
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        // 6. Hapus token/OTP dari database karena sudah dipakai
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json(['message' => 'Password berhasil direset.'], 200);
    }
}