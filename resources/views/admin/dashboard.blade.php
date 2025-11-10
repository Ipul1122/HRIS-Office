@extends('layouts.app')
@section('title','Dashboard Admin')

@section('content')
<p class="mb-4">Selamat datang, {{ auth('admin')->user()->name }} (Admin)</p>
{{-- ... (Konten dashboard admin lainnya) ... --}}

<div class="card mt-4">
    <div class="card-header">Quick Links</div>
    <div class="card-body">
        {{-- Menggunakan nama rute baru: admin.getEmployee --}}
        <a href="{{ route('admin.getEmployee.index') }}" class="btn btn-primary">
            View All Employees
        </a>
    </div>
</div>

{{-- ... (Konten dashboard admin lainnya) ... --}}
<form method="POST" action="{{ route('admin.logout') }}">
  @csrf
  <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
</form>
@endsection
