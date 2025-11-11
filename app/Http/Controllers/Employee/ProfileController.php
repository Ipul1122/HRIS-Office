<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk verifikasi employee_code.
     * (METODE BARU)
     */
    public function showVerifyCodeForm()
    {
        if (session('employee_code_verified')) {
            return redirect()->route('employee.profile.edit');
        }
        
        return view('employee.profile.verify-code');
    }

    /**
     * Memproses employee_code yang disubmit.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string',
        ]);

        $user = Auth::user();
        $employee = $user->employee; 

        if ($employee && $request->employee_code === $employee->employee_code) {
            
            // Jika cocok, simpan flag di session
            $request->session()->put('employee_code_verified', true);
            
            // Redirect ke halaman edit profil yang sebenarnya
            return redirect()->route('employee.profile.edit');
        }

        // Jika gagal, kembalikan ke form verifikasi dengan error
        return back()->withErrors(['employee_code' => 'Employee code yang Anda masukkan tidak valid.']);
    }


    /**
     * Menampilkan form edit profil untuk employee yang sedang login.
     */
    public function edit()
    {
        if (!session('employee_code_verified')) {
            return redirect()->route('employee.profile.verify.form')
                             ->with('warning', 'Anda harus memasukkan employee code untuk mengakses profil.');
        }
        // --- SELESAI PERUBAHAN ---

        $user = Auth::user();
        
        $employee = Employee::firstOrCreate(
            ['employee_id' => $user->id], // Kunci untuk mencari
            [
                'join_date' => $user->created_at->toDateString() 
            ]
        );

        // Tampilkan view edit
        return view('employee.profile.edit', compact('user', 'employee'));
    }

    /**
     * Meng-update profil employee.
     */
    public function update(Request $request)
    {
        if (!session('employee_code_verified')) {
            return redirect()->route('employee.profile.verify.form');
        }

        $user = Auth::user();
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

        $request->session()->forget('employee_code_verified');

        return redirect()->route('employee.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}