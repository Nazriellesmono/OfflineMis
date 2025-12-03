@extends('layouts.guest')
@section('title', 'Login Mahasiswa')

@section('content')
<div class="flex w-[900px] bg-white rounded-2xl shadow-2xl overflow-hidden">
  
  <!-- Kiri (Form Login) -->
  <div class="flex flex-col justify-center w-1/2 px-10 py-12">
    <div class="flex items-center gap-3 mb-8">
      <div class="relative w-10 h-10">
        <i class="fa-solid fa-gears text-[var(--lavender-grey)] text-3xl"></i>
        <div class="absolute top-1/2 left-0 w-full h-[3px] bg-[var(--punch-red)] rotate-[-45deg]"></div>
      </div>
      <div class="flex flex-col leading-tight">
        <span class="text-[var(--punch-red)] font-extrabold text-lg">OFFLINE</span>
        <span class="text-[var(--space-indigo)] font-semibold text-xs tracking-widest">MIS PANEL</span>
      </div>
    </div>

    <h2 class="text-2xl font-semibold text-[var(--space-indigo)] mb-6">Login Mahasiswa</h2>

    @if($errors->any())
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-[var(--lavender-grey)]">Email</label>
        <input type="email" name="email" required
          class="w-full mt-1 px-3 py-2 border border-[var(--lavender-grey)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--punch-red)]">
      </div>

      <div>
        <label class="block text-sm font-medium text-[var(--lavender-grey)]">Password</label>
        <input type="password" name="password" required
          class="w-full mt-1 px-3 py-2 border border-[var(--lavender-grey)] rounded-md focus:outline-none focus:ring-2 focus:ring-[var(--punch-red)]">
      </div>

      <button type="submit"
        class="w-full bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white font-semibold py-2 rounded-md transition">
        Login
      </button>

      <p class="text-center text-sm text-[var(--lavender-grey)]">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[var(--punch-red)] hover:underline">Register</a>
      </p>
    </form>
  </div>

  <!-- Kanan (Ilustrasi / Informasi) -->
  <div class="w-1/2 bg-[var(--space-indigo)] flex flex-col justify-center items-center text-center text-white p-10">
    <img src="https://cdn-icons-png.flaticon.com/512/747/747086.png" alt="Login Illustration" class="w-64 mb-6">
    <h3 class="text-lg font-semibold text-[var(--platinum)]">Selamat Datang di Sistem OFFLINE MIS</h3>
    <p class="text-sm text-[var(--lavender-grey)] mt-2">Kelola data akademik Anda dengan mudah dan cepat.</p>
  </div>
</div>
@endsection
