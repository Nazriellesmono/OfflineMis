@extends('layouts.app')
@section('title', 'Jadwal Kuliah')

@section('content')
<div class="p-8 bg-white rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h1 class="text-3xl font-bold text-[var(--space-indigo)]">Jadwal Kuliah</h1>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        Berikut adalah daftar mata kuliah yang telah Anda ambil pada semester ini.
      </p>
    </div>

    <a href="{{ route('jadwal.pdf') }}" 
       class="bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-xl shadow flex items-center gap-2 transition text-sm font-semibold">
      <i class="fa-solid fa-file-pdf"></i> Download PDF
    </a>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
    <table class="min-w-full text-sm text-left">
      <thead>
        <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
          <th class="px-6 py-3 font-medium">Mata Kuliah</th>
          <th class="px-6 py-3 text-center font-medium">Semester</th>
          <th class="px-6 py-3 text-center font-medium">SKS</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-[var(--lavender-grey)]/30">
        @forelse($frs as $item)
        <tr class="hover:bg-[var(--platinum)]/60 transition">
          <td class="px-6 py-3 text-[var(--space-indigo)] font-medium">{{ $item->matkul }}</td>
          <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $item->semester }}</td>
          <td class="px-6 py-3 text-center text-[var(--space-indigo)]">{{ $item->sks }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center text-[var(--lavender-grey)] py-6 italic">Belum ada data FRS</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Footer Summary -->
  @if($frs->count() > 0)
    <div class="mt-6 flex justify-end">
      <div class="text-sm text-[var(--lavender-grey)]">
        Total Mata Kuliah: <span class="font-semibold text-[var(--space-indigo)]">{{ $frs->count() }}</span> |
        Total SKS: 
        <span class="font-semibold text-[var(--punch-red)]">
          {{ $frs->sum('sks') }}
        </span>
      </div>
    </div>
  @endif

</div>
@endsection
