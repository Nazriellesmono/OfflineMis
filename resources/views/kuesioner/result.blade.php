@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
  <h2 class="text-2xl font-semibold mb-4">Hasil Kuesioner Dosen</h2>

  <table class="w-full border text-center">
    <thead class="bg-red-600 text-white">
      <tr>
        <th>Pertanyaan</th>
        <th>Rata-rata</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rata as $key => $val)
        <tr class="border-b">
          <td>{{ strtoupper($key) }}</td>
          <td>{{ $val }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h3 class="text-xl mt-6 font-semibold">Saran dari Mahasiswa</h3>
  <ul class="list-disc pl-6 mt-2">
    @foreach($data as $d)
      @if($d->saran)
        <li>"{{ $d->saran }}"</li>
      @endif
    @endforeach
  </ul>
</div>
@endsection
