@extends('layouts.app')
@section('title','Register Pegawai | HRIS')
@section('heading','Buat Akun Pegawai')

@section('content')
<form method="POST" action="{{ route('employee.register.submit') }}" class="space-y-4">
  @csrf
  <div>
    <label class="block text-sm font-medium mb-1">Nama</label>
    <input type="text" name="name" value="{{ old('name') }}" required
           class="w-full rounded-lg border-gray-300 focus:border-gray-500 focus:ring-gray-500">
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required
           class="w-full rounded-lg border-gray-300 focus:border-gray-500 focus:ring-gray-500">
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Password</label>
    <input type="password" name="password" required
           class="w-full rounded-lg border-gray-300 focus:border-gray-500 focus:ring-gray-500">
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" required
           class="w-full rounded-lg border-gray-300 focus:border-gray-500 focus:ring-gray-500">
  </div>
  <button class="w-full rounded-lg bg-gray-900 text-white py-2.5 font-medium hover:bg-black">
    Daftar (Pegawai)
  </button>
</form>
@endsection
