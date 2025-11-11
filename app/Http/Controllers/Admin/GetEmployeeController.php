<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class GetEmployeeController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan dan jumlahnya.
     */
    public function getEmployee() 
    {
        $employeeCount = Employee::count();

        $employees = Employee::select(
            'employee_id', 
            'employee_code', 
            'base_salary', 
            'phone_number', 
            'address', 
            'ktp_number', 
            'gender', 
            'birth_date', 
            'join_date'
        )->get();

        return view('admin.getEmployee.index', compact('employees', 'employeeCount'));
    }
}