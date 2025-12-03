@extends('layouts.app')
@section('title', 'Tambah FRS')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-2xl mx-auto">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)]">Tambah Mata Kuliah</h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">Masukkan data mata kuliah untuk FRS Anda.</p>
    </div>
    <a href="{{ route('frs.index') }}" 
       class="text-[var(--punch-red)] hover:text-[var(--flag-red)] text-sm font-medium transition flex items-center gap-1">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Form -->
  <form method="POST" action="{{ route('frs.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mata Kuliah</label>
      <input type="text" name="matkul" required 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]">
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Semester</label>
      <input type="number" name="semester" min="1" max="8" required 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]">
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">SKS</label>
      <input type="number" name="sks" min="1" max="6" required 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]">
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Bukti Foto (opsional)</label>
      <input type="file" name="bukti_foto"
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:outline-none text-[var(--space-indigo)]">
    </div>

    <div class="flex justify-end gap-3 pt-4">
      <a href="{{ route('frs.index') }}" 
         class="px-5 py-2 rounded-lg border border-[var(--lavender-grey)] text-[var(--lavender-grey)] hover:bg-[var(--platinum)] transition">
        Batal
      </a>
      <button type="submit" 
              class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-6 py-2 rounded-lg shadow transition">
        Simpan
      </button>
    </div>
  </form>

</div>
@endsection
