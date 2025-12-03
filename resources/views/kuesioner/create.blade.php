@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
  <h2 class="text-2xl font-semibold mb-4">Kuesioner untuk {{ $dosen->name }}</h2>

  <form method="POST" action="{{ route('mahasiswa.kuesioner.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">

    @for($i = 1; $i <= 5; $i++)
      <div>
        <label class="block font-semibold mb-1">Pertanyaan {{ $i }}</label>
        <select name="q{{ $i }}" required class="border rounded-md p-2 w-full">
          <option value="">-- Pilih Skala (1–5) --</option>
          @for($n = 1; $n <= 5; $n++)
            <option value="{{ $n }}">{{ $n }}</option>
          @endfor
        </select>
      </div>
    @endfor

    <div>
      <label class="block font-semibold mb-1">Saran (opsional)</label>
      <textarea name="saran" rows="3" class="border rounded-md p-2 w-full"></textarea>
    </div>

    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
      Kirim Kuesioner
    </button>
  </form>
</div>
@endsection
