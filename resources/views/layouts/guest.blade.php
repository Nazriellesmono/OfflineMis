<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Login | OFFLINE MIS')</title>

  {{-- Pastikan CSS & JS masuk ke bundle build --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Font Awesome CDN --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --space-indigo: #2b2d42;
      --lavender-grey: #8d99ae;
      --platinum: #edf2f4;
      --punch-red: #ef233c;
      --flag-red: #d90429;
    }

    body {
      background-color: var(--platinum);
    }
  </style>
</head>

<body class="flex items-center justify-center min-h-screen">
  {{-- Konten utama login/register --}}
  @yield('content')
</body>
</html>
