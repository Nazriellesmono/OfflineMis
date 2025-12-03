<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Frs;

class NilaiController extends Controller
{
    /**
     * INDEX
     * - Mahasiswa: hanya nilai dirinya + IPK
     * - Dosen: semua nilai mahasiswa
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            // Ambil FRS mahasiswa
            $frs = Frs::where('user_id', $user->id)->get();
            $frsMatkul = $frs->pluck('matkul');

            // Ambil nilai berdasarkan matkul FRS
            $nilais = Nilai::where('user_id', $user->id)
                ->whereIn('matkul', $frsMatkul)
                ->get();

            // Hitung IPK
            $totalBobot = 0;
            $totalSks = 0;

            foreach ($nilais as $n) {
                $n->huruf = $this->konversiNilai($n->nilai);
                $matkulData = $frs->firstWhere('matkul', $n->matkul);
                $sks = $matkulData->sks ?? 0;
                $totalSks += $sks;
                $totalBobot += $this->bobotNilai($n->huruf) * $sks;
            }

            $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : null;
            return view('nilai.index', compact('nilais', 'ipk'));
        }

        // Jika Dosen
        else {
            // Ambil semua nilai dengan relasi user (mahasiswa)
            $nilais = Nilai::with('user')->get();
            return view('nilai.index', compact('nilais'));
        }
    }

    /**
     * FORM TAMBAH NILAI (Dosen)
     * Dosen akan melihat daftar mahasiswa (yang punya FRS)
     */
    public function create()
    {
        // Ambil semua mahasiswa yang sudah punya FRS
        $mahasiswas = User::where('role', 'mahasiswa')
            ->whereHas('frs')
            ->with('frs')
            ->get();

        return view('nilai.create', compact('mahasiswas'));
    }

    /**
     * Ambil daftar mata kuliah dari FRS mahasiswa (untuk AJAX)
     */
    public function getMatkulByMahasiswa($user_id)
    {
        $matkuls = Frs::where('user_id', $user_id)
            ->select('matkul', 'semester')
            ->get();

        return response()->json($matkuls);
    }

    /**
     * SIMPAN NILAI (Dosen)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'matkul' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil data FRS mahasiswa untuk ambil semester
        $frs = Frs::where('user_id', $request->user_id)
            ->where('matkul', $request->matkul)
            ->first();

        Nilai::create([
            'user_id' => $request->user_id,
            'matkul' => $request->matkul,
            'semester' => $frs->semester ?? '-',
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    /**
     * EDIT NILAI (Dosen)
     */
    public function edit(Nilai $nilai)
    {
        return view('nilai.edit', compact('nilai'));
    }

    /**
     * UPDATE NILAI (Dosen)
     */
    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $nilai->update([
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * HAPUS NILAI (Dosen)
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    /**
     * KONVERSI Nilai Angka → Huruf
     */
    private function konversiNilai($angka)
    {
        if ($angka >= 85) return 'A';
        if ($angka >= 80) return 'AB';
        if ($angka >= 75) return 'B';
        if ($angka >= 70) return 'BC';
        if ($angka >= 65) return 'C';
        if ($angka >= 60) return 'CD';
        if ($angka >= 55) return 'D';
        if ($angka >= 50) return 'DE';
        return 'E';
    }

    /**
     * KONVERSI Nilai Huruf → Bobot IPK
     */
    private function bobotNilai($huruf)
    {
        return match ($huruf) {
            'A'  => 4.0,
            'AB' => 3.7,
            'B'  => 3.3,
            'BC' => 3.0,
            'C'  => 2.7,
            'CD' => 2.3,
            'D'  => 2.0,
            'DE' => 1.7,
            default => 1.0,
        };
    }
}
