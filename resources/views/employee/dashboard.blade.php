@extends('layouts.app')
@section('title','Dashboard Pegawai')
@section('heading','Dashboard Pegawai')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('employee')->user()->name }} (Pegawai)</p>

<div class="flex space-x-2">
    <a href="{{ route('employee.profile.edit') }}" class="rounded-lg bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">
        Edit Profil
    </a>

    <form method="POST" action="{{ route('employee.logout') }}">
      @csrf
      <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
    </form>
</div>
@endsection