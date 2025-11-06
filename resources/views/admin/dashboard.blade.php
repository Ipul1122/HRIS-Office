@extends('layouts.app')
@section('title','Dashboard Admin')
@section('heading','Dashboard Admin')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('admin')->user()->name }} (Admin)</p>
<form method="POST" action="{{ route('admin.logout') }}">
  @csrf
  <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
</form>
@endsection
