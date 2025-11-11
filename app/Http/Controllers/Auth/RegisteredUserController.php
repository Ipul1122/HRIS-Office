<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('employee.auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed', Rules\Password::defaults()],
        ]);

        // Gunakan Transaction untuk memastikan User dan Employee dibuat bersamaan
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'employee', // default
            ]);

            do {
                $code = strtoupper(Str::random(8));
            } while (Employee::where('employee_code', $code)->exists());

            Employee::create([
                'employee_id' => $user->id,
                'join_date' => Carbon::today(), 
                'employee_code' => $code,
            ]);

            DB::commit(); 

            event(new Registered($user));

            Auth::guard('employee')->login($user);
            $request->session()->regenerate();

            return redirect()->route('employee.dashboard');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika terjadi error
            Log::error('Registrasi gagal: '.$e->getMessage());
            return back()->withInput()->withErrors(['email' => 'Terjadi kesalahan saat registrasi.']);
        }
    }
}