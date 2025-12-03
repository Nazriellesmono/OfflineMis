@extends('layouts.app')
@section('title', 'Nilai')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-chart-column text-[var(--punch-red)]"></i> Nilai Akademik
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        Lihat atau kelola nilai mahasiswa berdasarkan peran Anda.
      </p>
    </div>

    @if(auth()->user()->role === 'dosen')
      <a href="{{ route('dosen.nilai.create') }}" 
         class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2.5 rounded-xl shadow flex items-center gap-2 transition text-sm font-semibold">
        <i class="fa-solid fa-plus"></i> Tambah Nilai
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

  <!-- Role Mahasiswa -->
  @if(auth()->user()->role === 'mahasiswa')
    @if($nilais->isEmpty())
      <p class="text-[var(--lavender-grey)] italic text-center py-6">Belum ada nilai yang diinput oleh dosen.</p>
    @else
      <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
        <table class="min-w-full text-sm text-left">
          <thead>
            <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
              <th class="px-6 py-3 font-medium">Mata Kuliah</th>
              <th class="px-6 py-3 text-center font-medium">Semester</th>
              <th class="px-6 py-3 text-center font-medium">Nilai Angka</th>
              <th class="px-6 py-3 text-center font-medium">Nilai Huruf</th>
              <th class="px-6 py-3 text-center font-medium">Keterangan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[var(--lavender-grey)]/30">
            @foreach($nilais as $n)
              <tr class="hover:bg-[var(--platinum)]/60 transition">
                <td class="px-6 py-3 text-[var(--space-indigo)] font-medium">{{ $n->matkul }}</td>
                <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->semester ?? '-' }}</td>
                <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->nilai }}</td>
                <td class="px-6 py-3 text-center font-semibold text-[var(--punch-red)]">{{ $n->huruf ?? '-' }}</td>
                <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->keterangan ?? '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- IPK -->
      <div class="mt-6 bg-[var(--platinum)]/70 rounded-xl p-4 text-center">
        <h3 class="text-lg font-semibold text-[var(--space-indigo)]">
          Indeks Prestasi Kumulatif (IPK)
        </h3>
        <p class="text-3xl font-bold text-[var(--punch-red)] mt-1">
          {{ $ipk ?? '-' }}
        </p>
      </div>
    @endif

  <!-- Role Dosen -->
  @elseif(auth()->user()->role === 'dosen')
    <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
      <table class="min-w-full text-sm text-left">
        <thead>
          <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
            <th class="px-6 py-3 font-medium">Mahasiswa</th>
            <th class="px-6 py-3 font-medium">Mata Kuliah</th>
            <th class="px-6 py-3 text-center font-medium">Semester</th>
            <th class="px-6 py-3 text-center font-medium">Nilai</th>
            <th class="px-6 py-3 text-center font-medium">Keterangan</th>
            <th class="px-6 py-3 text-center font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[var(--lavender-grey)]/30">
          @forelse($nilais as $n)
            <tr class="hover:bg-[var(--platinum)]/60 transition">
              <td class="px-6 py-3 text-[var(--space-indigo)] font-medium">{{ $n->user->name ?? '-' }}</td>
              <td class="px-6 py-3 text-[var(--space-indigo)]">{{ $n->matkul ?? '-' }}</td>
              <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->semester ?? '-' }}</td>
              <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->nilai }}</td>
              <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $n->keterangan ?? '-' }}</td>
              <td class="px-6 py-3 text-center space-x-2">
                <a href="{{ route('dosen.nilai.edit', $n->id) }}" 
                   class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs transition">
                   <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="{{ route('dosen.nilai.destroy', $n->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Hapus nilai ini?')"
                          class="inline-flex items-center gap-1 bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-3 py-1.5 rounded-lg text-xs transition">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-[var(--lavender-grey)] py-6 italic">Belum ada data nilai.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
