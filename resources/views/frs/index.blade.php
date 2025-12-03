@extends('layouts.app')
@section('title', 'FRS')

@section('content')
<div class="p-8 bg-white rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h1 class="text-3xl font-bold text-[var(--space-indigo)]">Daftar FRS</h1>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        Kelola daftar mata kuliah dan bukti FRS Anda di sini.
      </p>
    </div>
    <a href="{{ route('frs.create') }}" 
       class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2.5 rounded-xl shadow transition flex items-center gap-2 text-sm font-semibold">
      <i class="fa-solid fa-plus"></i> Tambah Mata Kuliah
    </a>
  </div>

  <!-- Alert Success -->
  @if(session('success'))
    <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-5 shadow-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Search Bar -->
  <form method="GET" action="{{ route('frs.index') }}" class="mb-6 flex flex-wrap gap-2 items-center">
    <input type="text" name="search" placeholder="Cari Mata Kuliah..." 
           value="{{ $search ?? '' }}"
           class="border border-[var(--lavender-grey)] rounded-lg px-4 py-2 w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-[var(--punch-red)] text-[var(--space-indigo)] placeholder-[var(--lavender-grey)]">
    <button type="submit" 
            class="bg-[var(--space-indigo)] hover:bg-[var(--punch-red)] text-white px-5 py-2 rounded-lg flex items-center gap-2 transition text-sm">
      <i class="fa-solid fa-magnifying-glass"></i> Cari
    </button>
  </form>

  <!-- Tabel Data -->
  <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
    <table class="min-w-full text-sm text-left">
      <thead>
        <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
          <th class="px-6 py-3 font-medium">Mata Kuliah</th>
          <th class="px-6 py-3 text-center font-medium">Semester</th>
          <th class="px-6 py-3 text-center font-medium">SKS</th>
          <th class="px-6 py-3 text-center font-medium">Bukti</th>
          <th class="px-6 py-3 text-center font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-[var(--lavender-grey)]/30">
        @forelse($frs as $item)
        <tr class="hover:bg-[var(--platinum)]/60 transition">
          <td class="px-6 py-3 font-medium text-[var(--space-indigo)]">{{ $item->matkul }}</td>
          <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $item->semester }}</td>
          <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $item->sks }}</td>
          <td class="px-6 py-3 text-center">
            @if($item->bukti_foto)
              <img src="{{ asset('storage/'.$item->bukti_foto) }}" 
                   class="w-16 h-16 object-cover rounded-lg border border-[var(--lavender-grey)]/40 mx-auto">
            @else
              <span class="text-[var(--lavender-grey)] italic">Tidak ada</span>
            @endif
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <a href="{{ route('frs.edit', $item->id) }}"
              class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs transition">
              <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <form action="{{ route('frs.destroy', $item->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button onclick="return confirm('Hapus data ini?')"
                class="inline-flex items-center gap-1 bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-3 py-1.5 rounded-lg text-xs transition">
                <i class="fa-solid fa-trash"></i> Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-[var(--lavender-grey)] py-6 italic">Belum ada data FRS</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $frs->appends(['search' => $search])->links() }}
  </div>

</div>
@endsection
