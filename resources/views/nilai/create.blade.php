@extends('layouts.app')
@section('title', 'Tambah Nilai Mahasiswa')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-2xl mx-auto">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-plus text-[var(--punch-red)]"></i> Tambah Nilai Mahasiswa
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">Masukkan nilai mahasiswa berdasarkan FRS yang sudah diambil.</p>
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
  <form action="{{ route('dosen.nilai.store') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Pilih Mahasiswa -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mahasiswa</label>
      <select name="user_id" id="user_id" 
              class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 text-[var(--space-indigo)] focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none" required>
        <option value="">-- Pilih Mahasiswa --</option>
        @foreach($mahasiswas as $mhs)
          <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Pilih Mata Kuliah -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Mata Kuliah (diambil dari FRS)</label>
      <select name="matkul" id="matkul" disabled 
              class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 text-[var(--space-indigo)] bg-[var(--platinum)] focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none" required>
        <option value="">-- Pilih Mahasiswa Terlebih Dahulu --</option>
      </select>
    </div>

    <!-- Nilai Angka -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Nilai Angka</label>
      <input type="number" name="nilai" min="0" max="100" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 text-[var(--space-indigo)] focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none" required>
    </div>

    <!-- Keterangan -->
    <div>
      <label class="block text-sm font-semibold text-[var(--space-indigo)] mb-1">Keterangan (opsional)</label>
      <input type="text" name="keterangan" 
             class="w-full border border-[var(--lavender-grey)] rounded-lg px-4 py-2 text-[var(--space-indigo)] focus:ring-2 focus:ring-[var(--punch-red)] focus:outline-none">
    </div>

    <!-- Tombol -->
    <div class="flex justify-end gap-3 pt-4">
      <a href="{{ route('dosen.nilai.index') }}" 
         class="px-5 py-2 rounded-lg border border-[var(--lavender-grey)] text-[var(--lavender-grey)] hover:bg-[var(--platinum)] transition">
        Batal
      </a>
      <button type="submit" 
              class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-6 py-2 rounded-lg shadow transition">
        Simpan Nilai
      </button>
    </div>
  </form>

</div>

{{-- AJAX untuk ambil matkul mahasiswa --}}
<script>
document.getElementById('user_id').addEventListener('change', function() {
  const userId = this.value;
  const matkulSelect = document.getElementById('matkul');

  if (!userId) {
    matkulSelect.innerHTML = '<option value="">-- Pilih Mahasiswa Terlebih Dahulu --</option>';
    matkulSelect.disabled = true;
    return;
  }

  fetch(`/dosen/nilai/matkul/${userId}`)
    .then(res => res.json())
    .then(data => {
      matkulSelect.disabled = false;
      matkulSelect.innerHTML = '';

      if (data.length === 0) {
        matkulSelect.innerHTML = '<option value="">Mahasiswa ini belum mengambil FRS.</option>';
        matkulSelect.disabled = true;
      } else {
        data.forEach(item => {
          matkulSelect.innerHTML += `<option value="${item.matkul}">${item.matkul} (Semester ${item.semester})</option>`;
        });
      }
    })
    .catch(err => {
      console.error(err);
      alert('Gagal mengambil data FRS mahasiswa.');
    });
});
</script>
@endsection
