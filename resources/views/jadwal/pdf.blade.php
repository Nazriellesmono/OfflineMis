<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Kuliah</title>
  <style>
    :root {
      --space-indigo: #2b2d42;
      --lavender-grey: #8d99ae;
      --platinum: #edf2f4;
      --punch-red: #ef233c;
    }

    body {
      font-family: sans-serif;
      font-size: 12px;
      color: var(--space-indigo);
      background: var(--platinum);
      margin: 20px;
    }

    h2 {
      text-align: center;
      color: var(--space-indigo);
      margin-bottom: 10px;
    }

    p {
      margin: 4px 0;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border: 1px solid var(--lavender-grey);
    }

    th, td {
      border: 1px solid var(--lavender-grey);
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: var(--space-indigo);
      color: var(--platinum);
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f7f7f9;
    }

    .footer {
      text-align: right;
      margin-top: 20px;
      font-size: 11px;
      color: var(--lavender-grey);
    }
  </style>
</head>
<body>
  <h2>Jadwal Kuliah Mahasiswa</h2>
  <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
  <p><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}</p>

  <table>
    <thead>
      <tr>
        <th>Mata Kuliah</th>
        <th>Semester</th>
        <th>SKS</th>
      </tr>
    </thead>
    <tbody>
      @forelse($frs as $item)
      <tr>
        <td>{{ $item->matkul }}</td>
        <td>{{ $item->semester }}</td>
        <td>{{ $item->sks }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="font-style: italic; color: var(--lavender-grey);">Belum ada data FRS</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    Total Mata Kuliah: <strong>{{ $frs->count() }}</strong> &nbsp; | &nbsp;
    Total SKS: <strong style="color: var(--punch-red);">{{ $frs->sum('sks') }}</strong>
  </div>
</body>
</html>
