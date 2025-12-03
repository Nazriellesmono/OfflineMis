@extends('layouts.app')
@section('title', 'Daftar Ulang')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-[var(--lavender-grey)]/30">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
      <h2 class="text-3xl font-bold text-[var(--space-indigo)] flex items-center gap-2">
        <i class="fa-solid fa-file-arrow-up text-[var(--punch-red)]"></i>
        Daftar Ulang
      </h2>
      <p class="text-[var(--lavender-grey)] text-sm mt-1">
        {{ auth()->user()->role === 'mahasiswa' 
          ? 'Unggah bukti daftar ulang untuk verifikasi administrasi.' 
          : 'Pantau dan verifikasi unggahan daftar ulang mahasiswa.' }}
      </p>
    </div>

    @if(auth()->user()->role === 'mahasiswa')
      <a href="{{ route('daftar_ulang.create') }}" 
         class="bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2.5 rounded-xl shadow flex items-center gap-2 transition text-sm font-semibold">
        <i class="fa-solid fa-upload"></i> Upload Bukti
      </a>
    @endif
  </div>

  <!-- Notifikasi -->
  @if(session('success'))
    <div class="mb-5 p-3 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @elseif(session('error'))
    <div class="mb-5 p-3 bg-red-50 border border-[var(--flag-red)] text-[var(--flag-red)] rounded-lg shadow-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-xmark"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  {{-- ===========================
      ROLE: MAHASISWA
  ============================ --}}
  @if(auth()->user()->role === 'mahasiswa')
    @if($data->isEmpty())
      <p class="text-[var(--lavender-grey)] italic text-center py-6">Belum ada data daftar ulang yang diunggah.</p>
    @else
      <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
        <table class="min-w-full text-sm text-left">
          <thead>
            <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
              <th class="px-6 py-3 font-medium">Tanggal Upload</th>
              <th class="px-6 py-3 font-medium text-center">Bukti Foto</th>
              <th class="px-6 py-3 font-medium text-center">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[var(--lavender-grey)]/30">
            @foreach($data as $d)
              <tr class="hover:bg-[var(--platinum)]/60 transition">
                <td class="px-6 py-3 text-[var(--space-indigo)]">{{ $d->created_at->format('d-m-Y H:i') }}</td>
                <td class="px-6 py-3 text-center">
                  @if($d->bukti_foto && Storage::disk('public')->exists($d->bukti_foto))
                    <img src="{{ asset('storage/' . $d->bukti_foto) }}" 
                         alt="Bukti Daftar Ulang" class="w-20 h-20 object-cover rounded-lg shadow border border-[var(--lavender-grey)]/40 mx-auto">
                  @else
                    <span class="text-[var(--lavender-grey)] italic">Tidak ada foto</span>
                  @endif
                </td>
                <td class="px-6 py-3 text-center font-semibold">
                  @if($d->status === 'pending')
                    <span class="text-yellow-600">Menunggu Konfirmasi</span>
                  @elseif($d->status === 'diterima')
                    <span class="text-green-700">Diterima</span>
                  @else
                    <span class="text-[var(--punch-red)]">Ditolak</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  @endif


  {{-- ===========================
      ROLE: DOSEN
  ============================ --}}
  @if(auth()->user()->role === 'dosen')
    @if($daftarUlangs->isEmpty())
      <p class="text-[var(--lavender-grey)] italic text-center py-6">Belum ada mahasiswa yang mengunggah daftar ulang.</p>
    @else
      <div class="overflow-x-auto rounded-xl border border-[var(--lavender-grey)]/30">
        <table class="min-w-full text-sm text-left">
          <thead>
            <tr class="bg-[var(--space-indigo)] text-[var(--platinum)]">
              <th class="px-6 py-3 font-medium">Mahasiswa</th>
              <th class="px-6 py-3 text-center font-medium">Bukti Foto</th>
              <th class="px-6 py-3 text-center font-medium">Status</th>
              <th class="px-6 py-3 text-center font-medium">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[var(--lavender-grey)]/30">
            @foreach($daftarUlangs as $d)
              <tr class="hover:bg-[var(--platinum)]/60 transition">
                <td class="px-6 py-3 text-[var(--space-indigo)] font-medium">{{ $d->user->name ?? '-' }}</td>
                <td class="px-6 py-3 text-center">
                  @if($d->bukti_foto && Storage::disk('public')->exists($d->bukti_foto))
                    <img src="{{ asset('storage/' . $d->bukti_foto) }}" 
                         alt="Bukti Daftar Ulang" class="w-20 h-20 object-cover rounded-lg shadow border border-[var(--lavender-grey)]/40 mx-auto">
                  @else
                    <span class="text-[var(--lavender-grey)] italic">Tidak ada foto</span>
                  @endif
                </td>
                <td class="px-6 py-3 text-center font-semibold">
                  @if($d->status === 'pending')
                    <span class="text-yellow-600">Pending</span>
                  @elseif($d->status === 'diterima')
                    <span class="text-green-700">Diterima</span>
                  @else
                    <span class="text-[var(--punch-red)]">Ditolak</span>
                  @endif
                </td>
                <td class="px-6 py-3 text-center">
                  <div class="flex flex-wrap justify-center gap-2">
                    {{-- Update Status --}}
                    <form action="{{ route('dosen.daftar_ulang.status', $d->id) }}" method="POST" class="inline-flex items-center gap-1">
                      @csrf
                      <select name="status" 
                              class="border border-[var(--lavender-grey)] rounded-lg text-sm px-2 py-1 text-[var(--space-indigo)]">
                        <option value="pending" {{ $d->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ $d->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $d->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                      </select>
                      <button type="submit" 
                              class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs transition">
                        Update
                      </button>
                    </form>

                    {{-- Move / Copy --}}
                    <form action="{{ route('dosen.daftar_ulang.file', $d->id) }}" method="POST" class="inline-flex items-center gap-1">
                      @csrf
                      <select name="action" 
                              class="border border-[var(--lavender-grey)] rounded-lg text-sm px-2 py-1 text-[var(--space-indigo)]">
                        <option value="move">Move</option>
                        <option value="copy">Copy</option>
                      </select>
                      <button type="submit" 
                              class="bg-[var(--space-indigo)] hover:bg-[var(--lavender-grey)] text-white px-3 py-1.5 rounded-lg text-xs transition">
                        OK
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
  @endif

</div>
@endsection
