@extends('layouts.app')
@section('title','Dashboard Pegawai')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('employee')->user()->name }} (Pegawai)</p>

<div class="mt-4 p-4 bg-gray-100 rounded-lg border border-gray-200">
    <h3 class="font-semibold text-lg text-gray-800">Kode Keamanan Pegawai</h3>
    <p class="text-gray-600 mt-1 text-sm">Gunakan kode ini saat Anda perlu melakukan perubahan penting pada data profil Anda.</p>
    
    @if ($employee && $employee->employee_code)
        <p class="text-2xl font-bold text-gray-900 mt-2 tracking-widest bg-white p-3 rounded-md text-center">
            {{ $employee->employee_code }}
        </p>
    @else
        <p class="text-sm text-red-600 mt-2">
            Kode pegawai Anda belum ter-generate. Silakan hubungi administrator.
        </p>
    @endif
</div>


<div class="flex space-x-2 mt-6">
    <a href="{{ route('employee.profile.edit') }}" class="rounded-lg bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">
        Edit Profil
    </a>

    <form method="POST" action="{{ route('employee.logout') }}">
      @csrf
      <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
    </form>
</div>
@endsection