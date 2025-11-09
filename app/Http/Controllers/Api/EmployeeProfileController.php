<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class EmployeeProfileController extends Controller
{
    /**
     * Menampilkan profil employee yang sedang login.
     */
    public function show(Request $request)
    {
        // 1. Dapatkan data user yang sedang login (via token)
        $user = $request->user();

        // Jika $user null (seharusnya tidak terjadi jika auth:sanctum benar)
        if (!$user) {
             return response()->json(['message' => 'User tidak terotentikasi.'], 401);
        }

        // 2. Ambil data employee terkait
        $employeeProfile = $user->employee;

        if (!$employeeProfile) {
            return response()->json([
                'message' => 'Profil employee tidak ditemukan.'
            ], 404);
        }

        // 3. Kembalikan data profil
        return response()->json([
            'message' => 'Profil berhasil diambil',
            'data' => $employeeProfile
        ]);
    }
}