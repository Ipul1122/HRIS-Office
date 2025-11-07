<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil untuk employee yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // --- LOGIKA DIPERBARUI ---
        // Gunakan firstOrCreate sebagai jaring pengaman
        // jika ada user lama yang terlanjur dibuat tanpa data employee.
        $employee = Employee::firstOrCreate(
            ['user_id' => $user->id], // Kunci untuk mencari
            [
                // Data ini hanya akan diisi JIKA record baru dibuat
                'join_date' => $user->created_at->toDateString() // Ambil tgl user dibuat
            ]
        );
        // -------------------------

        // Tampilkan view
        return view('employee.profile.edit', compact('user', 'employee'));
    }

    /**
     * Meng-update profil employee.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Pastikan $employee ada (menggunakan ->employee dari relasi)
        $employee = $user->employee;

        // Validasi data
        $validatedData = $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'ktp_number' => 'nullable|string|max:20', 
            'gender' => 'nullable|string|in:male,female',
            'birth_date' => 'nullable|date',
        ]);

        // Update data di tabel employees
        $employee->update($validatedData);

        return redirect()->route('employee.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}