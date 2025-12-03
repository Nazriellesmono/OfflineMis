@extends('layouts.app')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-6">
  <h2 class="text-2xl font-bold text-red-700 mb-6">Tambah Presensi Mahasiswa</h2>

  <form action="{{ route('dosen.presensi.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label class="block font-semibold mb-2">Mahasiswa</label>
      <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg p-2" required>
        <option value="">-- Pilih Mahasiswa --</option>
        @foreach($mahasiswas as $mhs)
          <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-2">Mata Kuliah</label>
      <select name="matkul" id="matkul" class="w-full border p-2 rounded" required>
  <option value="">-- Pilih Mata Kuliah --</option>
  @foreach($mhs->frs as $matkul)
    <option value="{{ $matkul->matkul }}">{{ $matkul->matkul }} ({{ $matkul->semester }})</option>
  @endforeach
</select>

    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-2">Minggu ke-</label>
      <input type="number" name="minggu" min="1" max="16" class="w-full border border-gray-300 rounded-lg p-2" required>
    </div>

    <div class="mb-4">
      <label class="block font-semibold mb-2">Status Presensi</label>
      <select name="status" class="w-full border border-gray-300 rounded-lg p-2" required>
        <option value="H">Hadir (H)</option>
        <option value="IH">Hadir 2x seminggu (IH)</option>
        <option value="A">Alpa (A)</option>
        <option value="I">Izin (I)</option>
        <option value="S">Sakit (S)</option>
        <option value="X">Terlambat FRS (X)</option>
      </select>
    </div>

    <button type="submit" 
            class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800">
      Simpan Presensi
    </button>
  </form>
</div>
@endsection
