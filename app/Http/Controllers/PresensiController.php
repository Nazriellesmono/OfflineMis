<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Frs;
use App\Models\Presensi;

class PresensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Jika mahasiswa
        if ($user->role === 'mahasiswa') {
            $frs = Frs::where('user_id', $user->id)->get();
            $presensis = Presensi::where('user_id', $user->id)
                ->whereIn('matkul', $frs->pluck('matkul'))
                ->get();

            $hadir = $presensis->whereIn('status', ['H', 'IH'])->count();
            $total = $presensis->count();
            $persenKehadiran = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

            return view('presensi.index', compact('presensis', 'persenKehadiran', 'user'));
        }

        // Jika dosen
        if ($user->role === 'dosen') {
            $presensis = Presensi::with('user')->get();
            return view('presensi.index', compact('presensis', 'user'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->with('frs')->get();
        return view('presensi.create', compact('mahasiswas'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'matkul' => 'required|string|max:255',
        'minggu' => 'required|integer|min:1|max:16',
        'status' => 'required|string|max:2',
    ]);

    // Cari frs_id dari tabel FRS berdasarkan user_id dan matkul
    $frs = Frs::where('user_id', $request->user_id)
              ->where('matkul', $request->matkul)
              ->first();

    Presensi::create([
        'user_id' => $request->user_id,
        'frs_id'  => $frs ? $frs->id : null,  // 🧩 tambahkan ini
        'matkul'  => $request->matkul,
        'minggu'  => $request->minggu,
        'status'  => strtoupper($request->status),
    ]);

    return redirect()->route('dosen.presensi.index')
        ->with('success', 'Presensi berhasil disimpan.');
}

}
