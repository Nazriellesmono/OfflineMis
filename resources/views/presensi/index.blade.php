@extends('layouts.app')
@section('title', 'Presensi')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-calendar-check text-[var(--punch-red)]"></i>
        Presensi {{ $user->role === 'mahasiswa' ? 'Saya' : 'Mahasiswa' }}
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        {{ $user->role === 'mahasiswa' 
            ? 'Pantau kehadiran kuliah Anda di setiap minggu per mata kuliah.' 
            : 'Kelola dan catat kehadiran mahasiswa berdasarkan mata kuliah dan minggu ke.' }}
      </p>
    </div>

    @if($user->role === 'dosen')
      <a href="{{ route('dosen.presensi.create') }}" 
         class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2.5 rounded-xl shadow flex items-center gap-2 transition text-sm font-semibold">
        <i class="fa-solid fa-plus"></i> Tambah Presensi
      </a>
    @endif
  </div>

  <!-- Notifikasi -->
  @if(session('success'))
    <div class="mb-5 p-3 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Tabel Presensi -->
  @if($presensis->isEmpty())
    <p class="text-[var(--lavender-grey)] italic text-center py-6">Belum ada data presensi.</p>
  @else
    <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
      <table class="min-w-full text-sm text-left">
        <thead>
          <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
            @if($user->role === 'dosen')
              <th class="px-6 py-3 font-medium">Mahasiswa</th>
            @endif
            <th class="px-6 py-3 font-medium">Mata Kuliah</th>
            <th class="px-6 py-3 text-center font-medium">Minggu ke</th>
            <th class="px-6 py-3 text-center font-medium">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[var(--lavender-grey)]/30">
          @foreach($presensis as $p)
            <tr class="hover:bg-[var(--platinum)]/60 transition">
              @if($user->role === 'dosen')
                <td class="px-6 py-3 text-[var(--space-indigo)] font-medium">{{ $p->user->name ?? '-' }}</td>
              @endif
              <td class="px-6 py-3 text-[var(--space-indigo)]">{{ $p->matkul }}</td>
              <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $p->minggu }}</td>
              <td class="px-6 py-3 text-center font-semibold 
                {{ $p->status === 'Hadir' ? 'text-green-600' : ($p->status === 'Izin' ? 'text-yellow-600' : 'text-[var(--punch-red)]') }}">
                {{ $p->status }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- Persentase Mahasiswa -->
  @if($user->role === 'mahasiswa' && isset($persenKehadiran))
    <div class="mt-8 bg-[var(--platinum)]/70 rounded-xl p-5 text-center">
      <h3 class="text-lg font-semibold text-[var(--space-indigo)] mb-1">Persentase Kehadiran</h3>
      <p class="text-3xl font-bold text-[var(--punch-red)]">{{ $persenKehadiran }}%</p>
      @if($persenKehadiran >= 90)
        <p class="text-[var(--lavender-grey)] text-sm mt-1">🎯 Luar biasa! Kehadiranmu sangat baik.</p>
      @elseif($persenKehadiran >= 75)
        <p class="text-[var(--lavender-grey)] text-sm mt-1">👍 Kehadiran cukup baik, tetap pertahankan.</p>
      @else
        <p class="text-[var(--lavender-grey)] text-sm mt-1">⚠️ Kehadiranmu perlu diperbaiki, jangan sering absen ya.</p>
      @endif
    </div>
  @endif

</div>
@endsection
