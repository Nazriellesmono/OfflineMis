<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuesioner; // Pastikan baris ini ada
use App\Models\User;      // Pastikan baris ini ada
use Illuminate\Support\Facades\Auth; // Tambahan untuk keamanan auth()

class KuesionerController extends Controller
{
    // Mahasiswa: lihat daftar dosen yang bisa dinilai
    public function index()
    {
        // Pastikan hanya mengambil user dengan role dosen
        $dosenList = User::where('role', 'dosen')->get();
        return view('kuesioner.index', compact('dosenList'));
    }

    // Form isi kuisoner untuk dosen tertentu
    public function create($dosen_id)
    {
        // Cari dosen, jika tidak ketemu akan otomatis 404
        $dosen = User::findOrFail($dosen_id);
        return view('kuesioner.create', compact('dosen'));
    }

    // Simpan hasil kuesioner
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
            'q1' => 'required|integer|min:1|max:5',
            'q2' => 'required|integer|min:1|max:5',
            'q3' => 'required|integer|min:1|max:5',
            'q4' => 'required|integer|min:1|max:5',
            'q5' => 'required|integer|min:1|max:5',
            'saran' => 'nullable|string',
        ]);

        Kuesioner::create([
            'mahasiswa_id' => Auth::id(), // Menggunakan Auth Facade
            'dosen_id' => $request->dosen_id,
            'q1' => $request->q1,
            'q2' => $request->q2,
            'q3' => $request->q3,
            'q4' => $request->q4,
            'q5' => $request->q5,
            'saran' => $request->saran,
        ]);

        return redirect()->route('mahasiswa.kuesioner.index')->with('success', 'Kuesioner berhasil dikirim!');
    }

    // Dosen: lihat hasil kuisoner
    public function show()
    {
        // Ambil data kuesioner milik dosen yang sedang login
        $data = Kuesioner::where('dosen_id', Auth::id())->get();

        // Hitung rata-rata jika data ada
        if ($data->count() > 0) {
            $rata = [
                'q1' => round($data->avg('q1'), 2),
                'q2' => round($data->avg('q2'), 2),
                'q3' => round($data->avg('q3'), 2),
                'q4' => round($data->avg('q4'), 2),
                'q5' => round($data->avg('q5'), 2),
            ];
        } else {
            // Nilai default jika belum ada yang mengisi
            $rata = [
                'q1' => 0, 'q2' => 0, 'q3' => 0, 'q4' => 0, 'q5' => 0
            ];
        }

        return view('kuesioner.result', compact('data', 'rata'));
    }
}