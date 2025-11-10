{{-- resources/views/admin/getEmployee/index.blade.php --}}

{{-- Asumsi Anda menggunakan layout utama 'layouts.app' --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <h2 class="mb-4">Employee Management</h2>

            <div class="alert alert-info" role="alert">
                <strong>Total Registered Employees: {{ $employeeCount }}</strong>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Employee Records') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Employee Code</th>
                                    <th>Base Salary</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>KTP Number</th>
                                    <th>Gender</th>
                                    <th>Birth Date</th>
                                    <th>Join Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->user_id }}</td>
                                        <td>{{ $employee->employee_code }}</td>
                                        <td>{{ $employee->base_salary }}</td>
                                        <td>{{ $employee->phone_number }}</td>
                                        <td>{{ $employee->address }}</td>
                                        <td>{{ $employee->ktp_number }}</td>
                                        <td>{{ $employee->gender }}</td>
                                        <td>{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d M Y') : '' }}</td>
                                        <td>{{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d M Y') : '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No employee data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection