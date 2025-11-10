<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee; // Pastikan model Employee di-import
use Illuminate\Http\Request;

class GetEmployeeController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan dan jumlahnya.
     */
    public function getEmployee() // Mengubah nama method dari index()
    {
        // 1. Mengambil jumlah total employee
        $employeeCount = Employee::count();

        // 2. Mengambil record employee dengan kolom yang spesifik
        $employees = Employee::select(
            'user_id', 
            'employee_code', 
            'base_salary', 
            'phone_number', 
            'address', 
            'ktp_number', 
            'gender', 
            'birth_date', 
            'join_date'
        )->get();

        // 3. Mengirim data ke view baru
        //    (resources/views/admin/getEmployee/index.blade.php)
        return view('admin.getEmployee.index', compact('employees', 'employeeCount'));
    }
}