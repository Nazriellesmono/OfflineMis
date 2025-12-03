<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DaftarUlang;
use App\Models\User;

class DaftarUlangController extends Controller
{
    /**
     * Index Gabungan (Mahasiswa & Dosen)
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            // Mahasiswa hanya melihat datanya sendiri
            $data = DaftarUlang::where('user_id', $user->id)->latest()->get();
            return view('daftar_ulang.index', compact('data'));
        }

        if ($user->role === 'dosen') {
            // Dosen melihat seluruh data mahasiswa
            $daftarUlangs = DaftarUlang::with('user')->latest()->get();
            return view('daftar_ulang.index', compact('daftarUlangs'));
        }

        abort(403, 'Akses tidak diizinkan.');
    }

    /**
     * Mahasiswa – Form upload
     */
    public function create()
    {
        if (auth()->user()->role !== 'mahasiswa') {
            abort(403, 'Hanya mahasiswa yang dapat mengunggah daftar ulang.');
        }

        return view('daftar_ulang.create');
    }

    /**
     * Mahasiswa – Upload foto daftar ulang
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'mahasiswa') {
            abort(403, 'Hanya mahasiswa yang dapat mengunggah daftar ulang.');
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto')->store('daftar_ulang', 'public');

        DaftarUlang::create([
            'user_id' => auth()->id(),
            'bukti_foto' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('daftar_ulang.index')
            ->with('success', 'Foto daftar ulang berhasil diunggah, menunggu persetujuan dosen.');
    }

    /**
     * Dosen – Update status (approve / reject)
     */
    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'dosen') {
            abort(403, 'Hanya dosen yang dapat mengubah status.');
        }

        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $du = DaftarUlang::findOrFail($id);
        $du->status = $request->status;
        $du->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Dosen – Move / Copy file ke folder lain di storage/public
     */
    public function moveOrCopy(Request $request, $id)
{
    $request->validate([
        'action' => 'required|in:move,copy',
    ]);

    $du = DaftarUlang::findOrFail($id);

    if (!$du->bukti_foto || !Storage::disk('public')->exists($du->bukti_foto)) {
        return back()->with('error', 'File tidak ditemukan di storage.');
    }

    $fileName = basename($du->bukti_foto);
    $destinationFolder = $request->action === 'move' ? 'move' : 'copy';
    $destinationPath = $destinationFolder . '/' . $fileName;

    Storage::disk('public')->makeDirectory($destinationFolder);

    if ($request->action === 'move') {
        Storage::disk('public')->move($du->bukti_foto, $destinationPath);
        $du->bukti_foto = $destinationPath;
        $du->save();
    } else {
        Storage::disk('public')->copy($du->bukti_foto, $destinationPath);
    }

    return back()->with('success', ucfirst($request->action) . ' file berhasil.');
}

}
