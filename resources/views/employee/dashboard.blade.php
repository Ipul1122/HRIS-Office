@extends('layouts.app')
@section('title','Dashboard Pegawai')
@section('heading','Dashboard Pegawai')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('employee')->user()->name }} (Pegawai)</p>
<form method="POST" action="{{ route('employee.logout') }}">
  @csrf
  <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
</form>
@endsection
