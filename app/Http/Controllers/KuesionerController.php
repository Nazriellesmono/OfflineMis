<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\User;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    // Mahasiswa: lihat daftar dosen yang bisa dinilai
    public function index()
    {
        $dosenList = User::where('role', 'dosen')->get();
        return view('kuesioner.index', compact('dosenList'));
    }

    // Form isi kuisoner untuk dosen tertentu
    public function create($dosen_id)
    {
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
            'mahasiswa_id' => auth()->id(),
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
        $data = Kuesioner::where('dosen_id', auth()->id())->get();

        $rata = [
            'q1' => round($data->avg('q1'), 2),
            'q2' => round($data->avg('q2'), 2),
            'q3' => round($data->avg('q3'), 2),
            'q4' => round($data->avg('q4'), 2),
            'q5' => round($data->avg('q5'), 2),
        ];

        return view('kuesioner.result', compact('data', 'rata'));
    }
}
