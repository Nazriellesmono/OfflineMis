<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'OFFLINE MIS') }}</title>

  {{-- Pastikan semua asset dibundle oleh Vite --}}
  <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
<script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --space-indigo: #2b2d42;
      --lavender-grey: #8d99ae;
      --platinum: #edf2f4;
      --punch-red: #ef233c;
      --flag-red: #d90429;
    }

    .sidebar {
      transition: transform 0.3s ease-in-out;
      background-color: var(--space-indigo);
    }

    .sidebar-hidden {
      transform: translateX(-100%);
    }

    .sidebar a, .sidebar button {
      color: var(--platinum);
      transition: background 0.25s ease;
    }

    .sidebar a:hover, .sidebar button:hover {
      background-color: var(--punch-red);
    }

    .topbar {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .topbar h2 {
      color: var(--flag-red);
    }

    .sidebar a.active {
      background-color: var(--flag-red);
    }

    .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 1rem;
      border-bottom: 1px solid rgba(255,255,255,0.15);
    }
    .logo-icon {
      position: relative;
    }
    .logo-icon i {
      font-size: 22px;
      color: var(--lavender-grey);
    }
    .logo-icon .strike {
      position: absolute;
      width: 24px;
      height: 3px;
      background: var(--punch-red);
      transform: rotate(-45deg);
      top: 12px;
      left: -2px;
    }
    .logo-text span:first-child {
      color: var(--punch-red);
      font-weight: 700;
      font-size: 14px;
      display: block;
      letter-spacing: 1px;
    }
    .logo-text span:last-child {
      color: var(--platinum);
      font-weight: 500;
      font-size: 12px;
      letter-spacing: 2px;
    }
  </style>
</head>

<body class="bg-[var(--platinum)] flex">

  {{-- Sidebar --}}
  <aside id="sidebar"
    class="sidebar fixed top-0 left-0 w-64 h-full text-white shadow-xl z-40 transform -translate-x-full md:translate-x-0">

    {{-- Logo --}}
    <div class="logo-container">
      <div class="logo-icon">
        <i class="fa-solid fa-gears"></i>
        <div class="strike"></div>
      </div>
      <div class="logo-text">
        <span>OFFLINE</span>
        <span>MIS PANEL</span>
      </div>
    </div>

    <nav class="mt-3 text-sm">
      <a href="{{ route('home') }}" 
         class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

      @php $role = auth()->user()->role ?? ''; @endphp

      @if($role === 'mahasiswa')
        <a href="{{ route('frs.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('frs.*') ? 'active' : '' }}">FRS</a>
        <a href="{{ route('jadwal.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">Jadwal</a>
        <a href="{{ route('mahasiswa.nilai.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}">Nilai</a>
        <a href="{{ route('mahasiswa.presensi.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('mahasiswa.presensi.*') ? 'active' : '' }}">Presensi</a>
        <a href="{{ route('mahasiswa.kuesioner.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('mahasiswa.kuesioner.*') ? 'active' : '' }}">Kuesioner</a>
        <a href="{{ route('daftar_ulang.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('daftar_ulang.*') ? 'active' : '' }}">Daftar Ulang</a>

      @elseif($role === 'dosen')
        <a href="{{ route('dosen.nilai.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('dosen.nilai.*') ? 'active' : '' }}">Nilai Mahasiswa</a>
        <a href="{{ route('dosen.presensi.index') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('dosen.presensi.*') ? 'active' : '' }}">Presensi</a>
        <a href="{{ route('dosen.daftar_ulang.list') }}" class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('dosen.daftar_ulang.*') ? 'active' : '' }}">Daftar Ulang</a>
      @endif

      <a href="{{ route('change-password') }}" 
         class="block py-2.5 px-6 hover:bg-[var(--punch-red)] {{ request()->routeIs('change-password') ? 'active' : '' }}">Ubah Password</a>

      <form action="{{ route('logout') }}" method="POST" class="mt-4 border-t border-[rgba(255,255,255,0.1)]">
        @csrf
        <button type="submit" class="w-full text-left py-2.5 px-6 hover:bg-[var(--punch-red)]">Logout</button>
      </form>
    </nav>
  </aside>

  {{-- Overlay --}}
  <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-30 md:hidden"></div>

  {{-- Main Content --}}
  <div class="flex-1 min-h-screen transition-all duration-300 md:ml-64 relative z-10">
    {{-- Header --}}
    <header class="topbar p-4 flex items-center justify-between sticky top-0 z-50">
      <button id="menu-btn" class="text-[var(--space-indigo)] focus:outline-none md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <h2 class="text-lg md:text-xl font-semibold ml-10 md:ml-0">Dashboard</h2>

      <div class="text-sm text-[var(--lavender-grey)] hidden md:block">
        {{ auth()->user()->name ?? 'Guest' }} ({{ $role ?? '-' }})
      </div>
    </header>

    <main class="p-6">
      @yield('content')
    </main>
  </div>

  {{-- Script JS --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const menuBtn = document.getElementById('menu-btn');

      menuBtn.addEventListener('click', () => {
        const isHidden = sidebar.classList.contains('-translate-x-full');
        sidebar.classList.toggle('-translate-x-full', !isHidden);
        overlay.classList.toggle('hidden', !isHidden);
      });

      overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
      });

      if (window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
      }
    });
  </script>

  <script src="https://kit.fontawesome.com/a2d9a0c123.js" crossorigin="anonymous"></script>
</body>
</html>
