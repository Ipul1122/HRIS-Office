@extends('layouts.app')
@section('title','Login Admin | HRIS')

@section('content')
<form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
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
    Masuk (Admin)
  </button>
</form>
@endsection
