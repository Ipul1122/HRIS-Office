<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | HRIS</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-dvh bg-gray-50">
  <nav class="bg-white border-b">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
      <h1 class="text-lg font-semibold">HRIS Dashboard</h1>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="rounded-lg bg-gray-900 text-white px-4 py-2 hover:bg-black">Logout</button>
      </form>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-8">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="font-semibold text-lg mb-2">Selamat datang, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-600">
          Ini halaman dashboard awal. Nanti akan diisi data HRIS (total karyawan, departemen, cuti, dll).
        </p>
      </div>
    </div>
  </main>
</body>
</html>
