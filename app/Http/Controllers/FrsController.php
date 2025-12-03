<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frs;

class FrsController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Frs::where('user_id', auth()->id());

    if ($search) {
        $query->where('matkul', 'like', "%$search%");
    }

    $frs = $query->paginate(5); 

    return view('frs.index', compact('frs', 'search'));
}


    public function create()
    {
        return view('frs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matkul' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'sks' => 'required|integer|min:1|max:6',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('bukti_foto')) {
            $filename = $request->file('bukti_foto')->store('uploads', 'public');
        }

        Frs::create([
            'user_id' => auth()->id(),
            'matkul' => $request->matkul,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'bukti_foto' => $filename,
        ]);

        return redirect()->route('frs.index')->with('success', 'FRS berhasil ditambahkan!');
    }

    public function edit(Frs $fr)
    {
        // pastikan hanya pemilik bisa edit
        if ($fr->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return view('frs.edit', compact('fr'));
    }

    public function update(Request $request, Frs $fr)
    {
        if ($fr->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'matkul' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'sks' => 'required|integer|min:1|max:6',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $fr->bukti_foto = $request->file('bukti_foto')->store('uploads', 'public');
        }

        $fr->update([
            'matkul' => $request->matkul,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'bukti_foto' => $fr->bukti_foto,
        ]);

        return redirect()->route('frs.index')->with('success', 'FRS berhasil diperbarui!');
    }

    public function destroy(Frs $fr)
    {
        if ($fr->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $fr->delete();
        return redirect()->route('frs.index')->with('success', 'FRS berhasil dihapus!');
    }
}
