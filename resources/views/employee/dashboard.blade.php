@extends('layouts.app')
@section('title','Dashboard Pegawai')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('employee')->user()->name }} (Pegawai)</p>

<div class="mt-4 p-4 bg-gray-100 rounded-lg border border-gray-200">
    <h3 class="font-semibold text-lg text-gray-800">Kode Keamanan Pegawai</h3>
    <p class="text-gray-600 mt-1 text-sm">Gunakan kode ini saat Anda perlu melakukan perubahan penting pada data profil Anda.</p>
    
    @if ($employee && $employee->employee_code)
        {{-- Container Flex --}}
        <div class="flex items-stretch gap-2 mt-3">
            <div class="flex-1 bg-white p-3 rounded-md border border-gray-300 flex items-center justify-center">
                <span id="securityCode" class="text-2xl font-bold text-gray-900 tracking-widest">
                    {{ $employee->employee_code }}
                </span>
            </div>

            <button type="button" onclick="copyToClipboard()" 
                    class="px-4 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors flex items-center justify-center cursor-pointer"
                    title="Salin Kode">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span class="ml-2 font-medium hidden sm:inline">Salin</span>
            </button>
        </div>

        <p id="copyMessage" class="text-green-600 text-sm mt-2 hidden font-medium transition-all">
            ✓ Kode berhasil disalin ke clipboard!
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
@vite(['resources/js/employeeDashboard.js'])

@endsection