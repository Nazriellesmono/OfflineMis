@extends('layouts.app')
@section('title', 'Edit FRS')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-2xl mx-auto">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)]"> Edit FRS</h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">Perbarui data mata kuliah yang sudah terdaftar.</p>
    </div>
    <a href="{{ route('frs.index') }}" 
       class="text-[var(--punch-red)] hover:text-[var(--flag-red)] text-sm font-medium transition flex items-center gap-1">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Form -->
  <form action="{{ route('frs.update', $fr->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mata Kuliah</label>
      <input type="text" name="matkul" value="{{ old('matkul', $fr->matkul) }}" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]" required>
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Semester</label>
      <input type="number" name="semester" value="{{ old('semester', $fr->semester) }}" min="1" max="8"
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]" required>
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">SKS</label>
      <input type="number" name="sks" value="{{ old('sks', $fr->sks) }}" min="1" max="6"
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none text-[var(--space-indigo)]" required>
    </div>

    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Bukti Foto (opsional)</label>
      <input type="file" name="bukti_foto"
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 focus:outline-none text-[var(--space-indigo)]">
      @if($fr->bukti_foto)
        <p class="mt-2 text-sm text-[var(--lavender-grey)]">
          File saat ini: 
          <a href="{{ asset('storage/'.$fr->bukti_foto) }}" target="_blank" 
             class="text-[var(--punch-red)] hover:text-[var(--flag-red)] underline">Lihat Foto</a>
        </p>
      @endif
    </div>

    <div class="flex justify-end gap-3 pt-4">
      <a href="{{ route('frs.index') }}" 
         class="px-5 py-2 rounded-lg border border-[var(--lavender-grey)] text-[var(--lavender-grey)] hover:bg-[var(--platinum)] transition">
        Batal
      </a>
      <button type="submit" 
              class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-6 py-2 rounded-lg shadow transition">
        Simpan Perubahan
      </button>
    </div>
  </form>

</div>
@endsection
