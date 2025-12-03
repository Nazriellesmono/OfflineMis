@extends('layouts.app')
@section('title', 'Upload Bukti Daftar Ulang')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-lg mx-auto">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
      <i class="fa-solid fa-upload text-[var(--punch-red)]"></i>
      Upload Bukti Daftar Ulang
    </h2>
    <a href="{{ route('daftar_ulang.index') }}" 
       class="text-[var(--punch-red)] hover:text-[var(--flag-red)] text-sm font-medium transition flex items-center gap-1">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Notifikasi -->
  @if(session('success'))
    <div class="mb-5 p-3 bg-green-50 border border-green-400 text-green-700 rounded-lg flex items-center gap-2 shadow-sm">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="mb-5 p-3 bg-red-50 border border-[var(--flag-red)] text-[var(--flag-red)] rounded-lg shadow-sm">
      <strong class="block mb-1">Terjadi kesalahan:</strong>
      <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form -->
  <form action="{{ route('daftar_ulang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Foto Bukti Daftar Ulang</label>
      <input type="file" name="foto" accept="image/*" required
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 text-[var(--space-indigo)] focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none">
      <p class="text-xs text-[var(--lavender-grey)] mt-1">Format: JPG, PNG, atau JPEG (maks 2MB).</p>
    </div>

    <div class="text-right">
      <button type="submit" 
              class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-6 py-2 rounded-lg shadow transition">
        <i class="fa-solid fa-paper-plane mr-1"></i> Upload
      </button>
    </div>
  </form>
</div>
@endsection
