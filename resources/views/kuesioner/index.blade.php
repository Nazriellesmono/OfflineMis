@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
  <h2 class="text-2xl font-semibold mb-4">Pilih Dosen untuk Dinilai</h2>

  <ul class="space-y-2">
    @foreach($dosenList as $d)
      <li class="border p-3 rounded-md flex justify-between">
        <span>{{ $d->name }}</span>
        <a href="{{ route('mahasiswa.kuesioner.create', $d->id) }}" class="text-red-600 hover:underline">Isi Kuesioner</a>
      </li>
    @endforeach
  </ul>
</div>
@endsection
