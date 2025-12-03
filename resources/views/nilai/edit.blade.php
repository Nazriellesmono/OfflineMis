@extends('layouts.app')
@section('title', 'Edit Nilai Mahasiswa')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-2xl mx-auto">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-pen text-[var(--punch-red)]"></i> Edit Nilai Mahasiswa
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">Perbarui data nilai mahasiswa di bawah ini.</p>
    </div>
    <a href="{{ route('dosen.nilai.index') }}" 
       class="text-[var(--punch-red)] hover:text-[var(--flag-red)] text-sm font-medium transition flex items-center gap-1">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Error Alert -->
  @if ($errors->any())
    <div class="mb-5 p-3 bg-red-50 border border-[var(--flag-red)] text-[var(--flag-red)] rounded-lg shadow-sm">
      <strong class="block mb-1">Terjadi kesalahan:</strong>
      <ul class="list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form -->
  <form action="{{ route('dosen.nilai.update', $nilai->id) }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- Nama Mahasiswa -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mahasiswa</label>
      <input type="text" value="{{ $nilai->user->name ?? '-' }}" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 bg-[var(--platinum)] text-[var(--space-indigo)]" readonly>
    </div>

    <!-- Mata Kuliah -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mata Kuliah</label>
      <input type="text" value="{{ $nilai->matkul }}" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 bg-[var(--platinum)] text-[var(--space-indigo)]" readonly>
    </div>

    <!-- Semester -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Semester</label>
      <input type="text" value="{{ $nilai->semester ?? '-' }}" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 bg-[var(--platinum)] text-[var(--space-indigo)]" readonly>
    </div>

    <!-- Nilai Angka -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Nilai Angka</label>
      <input type="number" name="nilai" value="{{ $nilai->nilai }}" min="0" max="100" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]" required>
    </div>

    <!-- Keterangan -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Keterangan</label>
      <input type="text" name="keterangan" value="{{ $nilai->keterangan }}" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]">
    </div>

    <!-- Tombol -->
    <div class="flex justify-end gap-3 pt-4">
      <a href="{{ route('dosen.nilai.index') }}" 
         class="px-5 py-2 rounded-lg border border-[var(--lavender-grey)] text-[var(--lavender-grey)] hover:bg-[var(--platinum)] transition">
        Batal
      </a>
      <button type="submit" 
              class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-6 py-2 rounded-lg shadow transition">
        Perbarui Nilai
      </button>
    </div>
  </form>
</div>
@endsection
