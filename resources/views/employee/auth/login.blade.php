@extends('layouts.app')
@section('title','Login Pegawai | HRIS')
@section('heading','Login Pegawai')

@section('content')
<form method="POST" action="{{ route('employee.login.submit') }}" class="space-y-4">
  @csrf
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
  <label class="inline-flex items-center gap-2 text-sm">
    <input type="checkbox" name="remember" class="rounded border-gray-300"> Ingat saya
  </label>
  <button class="w-full rounded-lg bg-gray-900 text-white py-2.5 font-medium hover:bg-black">
    Masuk (Pegawai)
  </button>

  <p class="text-center text-sm">
    Belum punya akun?
    <a href="{{ route('employee.register') }}" class="text-gray-900 underline">Daftar</a>
  </p>
  {{-- ... (Form login Anda) ... --}}

  <div class="flex items-center justify-end mt-4">
      <a class="underline text-sm text-gray-600 hover:text-gray-900"
        href="{{ route('employee.password.request.form') }}">
          Lupa password Anda?
      </a>
  </div>
</form>
@endsection
