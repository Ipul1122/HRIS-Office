@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Verifikasi Employee Code') }}</div>

                <div class="card-body">
                    <p>Silakan masukkan employee code Anda untuk mengakses halaman profil.</p>

                    {{-- Tampilkan pesan warning jika ada --}}
                    @if (session('warning'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.profile.verify.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="employee_code" class="form-label">{{ __('Employee Code') }}</label>
                            <input id="employee_code" class="form-control @error('employee_code') is-invalid @enderror" 
                                   type="text" 
                                   name="employee_code" 
                                   required 
                                   autofocus>
                            
                            @error('employee_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Verifikasi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection