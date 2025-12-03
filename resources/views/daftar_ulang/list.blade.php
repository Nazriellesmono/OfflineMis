@extends('layouts.app')
@section('title', 'Daftar Ulang Mahasiswa')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30 max-w-6xl mx-auto">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-users text-[var(--punch-red)]"></i>
        Daftar Ulang Mahasiswa
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        Verifikasi bukti daftar ulang mahasiswa dan kelola file administrasi.
      </p>
    </div>
  </div>

  <!-- Tabel -->
  @if($daftarUlangs->isEmpty())
    <p class="text-[var(--lavender-grey)] italic text-center py-6">Belum ada data daftar ulang mahasiswa.</p>
  @else
    <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
      <table class="min-w-full text-sm text-left">
        <thead>
          <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
            <th class="px-6 py-3 font-medium">Mahasiswa</th>
            <th class="px-6 py-3 text-center font-medium">Bukti Foto</th>
            <th class="px-6 py-3 text-center font-medium">Status</th>
            <th class="px-6 py-3 font-medium">Catatan</th>
            <th class="px-6 py-3 text-center font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[var(--lavender-grey)]/30">
          @foreach($daftarUlangs as $item)
            <tr class="hover:bg-[var(--platinum)]/60 transition">
              <!-- Mahasiswa -->
              <td class="px-6 py-3 text-[var(--space-indigo)] font-medium text-center md:text-left">
                {{ $item->user->name }}
              </td>

              <!-- Bukti Foto -->
              <td class="px-6 py-3 text-center">
                <div class="inline-block relative">
                  <img src="{{ asset('storage/' . $item->bukti_foto) }}" 
                       alt="Bukti" 
                       class="w-24 h-24 object-cover rounded-lg border-2 
                              @if($item->status === 'disetujui') border-green-500 
                              @elseif($item->status === 'ditolak') border-[var(--punch-red)] 
                              @else border-yellow-500 @endif 
                              shadow-sm mx-auto">
                </div>
                <p class="text-xs text-[var(--lavender-grey)] break-all mt-1">{{ $item->bukti_foto }}</p>
              </td>

              <!-- Status -->
              <td class="px-6 py-3 text-center font-semibold">
                @if($item->status === 'disetujui')
                  <span class="text-green-700">Disetujui</span>
                @elseif($item->status === 'ditolak')
                  <span class="text-[var(--punch-red)]">Ditolak</span>
                @else
                  <span class="text-yellow-600">Pending</span>
                @endif
              </td>

              <!-- Catatan -->
              <td class="px-6 py-3 text-[var(--space-indigo)] text-center md:text-left">
                {{ $item->catatan ?? '-' }}
              </td>

              <!-- Aksi -->
              <td class="px-6 py-3 text-center">
                <div class="flex flex-col md:flex-row justify-center gap-3">

                  {{-- Update Status --}}
                  <form method="POST" 
                        action="{{ route('dosen.daftar_ulang.status', $item->id) }}" 
                        class="flex flex-col gap-2 w-full md:w-auto">
                    @csrf
                    <select name="status" 
                            class="border border-[var(--lavender-grey)] rounded-lg p-2 text-sm text-[var(--space-indigo)]">
                      <option value="disetujui">Setujui</option>
                      <option value="ditolak">Tolak</option>
                    </select>
                    <input type="text" 
                           name="catatan" 
                           placeholder="Catatan..." 
                           class="border border-[var(--lavender-grey)] rounded-lg p-2 text-sm text-[var(--space-indigo)]">
                    <button type="submit" 
                            class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-4 py-2 rounded-lg text-sm transition">
                      Update
                    </button>
                  </form>

                  {{-- Copy / Move File --}}
                  <form method="POST" 
                        action="{{ route('dosen.daftar_ulang.file', $item->id) }}" 
                        class="flex gap-2 items-center justify-center">
                    @csrf
                    <select name="action" 
                            class="border border-[var(--lavender-grey)] rounded-lg p-2 text-sm text-[var(--space-indigo)]">
                      <option value="copy">Copy</option>
                      <option value="move">Move</option>
                    </select>
                    <button type="submit" 
                            class="bg-[var(--space-indigo)] hover:bg-[var(--lavender-grey)] text-white px-4 py-2 rounded-lg text-sm transition">
                      Proses
                    </button>
                  </form>

                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
