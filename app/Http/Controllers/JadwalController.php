<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frs;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install dompdf

class JadwalController extends Controller
{
    public function index()
    {
        // ambil semua FRS milik user login
        $frs = Frs::where('user_id', auth()->id())->orderBy('semester')->get();
        return view('jadwal.index', compact('frs'));
    }

    public function exportPdf()
    {
        $frs = Frs::where('user_id', auth()->id())->orderBy('semester')->get();
        $pdf = Pdf::loadView('jadwal.pdf', compact('frs'))->setPaper('a4', 'portrait');
        return $pdf->download('jadwal_kuliah.pdf');
    }
}
