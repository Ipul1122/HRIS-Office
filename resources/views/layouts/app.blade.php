<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title','HRIS')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-dvh bg-gray-50">
  <div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow p-6">
      <h1 class="text-2xl font-semibold mb-6">@yield('heading','HRIS')</h1>

      @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
          <ul class="list-disc ps-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </div>

    <p class="mt-6 text-center text-sm text-gray-500">&copy; {{ date('Y') }} HRIS</p>
  </div>
</body>
</html>
