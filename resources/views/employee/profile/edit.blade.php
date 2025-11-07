@extends('layouts.app')
@section('title','Edit Profil Pegawai | HRIS')
@section('content')


<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Akun</h3>
                            <div class="mt-2">
                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Kepegawaian</h3>
                            <div class="mt-2">
                                <p><strong>Kode Pegawai:</strong> {{ $employee->employee_code ?? '-' }}</p>
                                <p><strong>Tanggal Bergabung:</strong> {{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d F Y') : '-' }}</p>
                                <p><strong>Gaji Pokok:</strong> Rp {{ number_format($employee->base_salary, 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Perbarui informasi pribadi Anda.
                            </p>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone_number" class="block font-medium text-sm text-gray-700">Nomor Telepon</label>
                                <input id="phone_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" />
                            </div>

                            <div>
                                <label for="birth_date" class="block font-medium text-sm text-gray-700">Tanggal Lahir</label>
                                <input id="birth_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" />
                            </div>

                            <div>
                                <label for="ktp_number" class="block font-medium text-sm text-gray-700">Nomor KTP</label>
                                <input id="ktp_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text" name="ktp_number" value="{{ old('ktp_number', $employee->ktp_number) }}" />
                            </div>

                            <div>
                                <label for="gender" class="block font-medium text-sm text-gray-700">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">Pilih...</option>
                                    <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block font-medium text-sm text-gray-700">Alamat</label>
                                <textarea id="address" name="address" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('address', $employee->address) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                 <a href="{{ route('employee.dashboard') }}" class="rounded-lg bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">
                    Kembali Ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection