<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\FrsController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Middleware\RoleMiddleware;

// ========================
// Guest Routes
// ========================
Route::middleware('guest', PreventBackHistory::class)->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// ========================
// Authenticated Routes
// ========================
Route::middleware(['auth', PreventBackHistory::class])->group(function () {

    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('change-password', [AuthController::class, 'changePassword']);

    // =====================================================
    // MAHASISWA ROUTES
    // =====================================================
    Route::prefix('mahasiswa')->middleware([RoleMiddleware::class . ':mahasiswa'])->group(function () {
        // ----------------- FRS -----------------
        Route::resource('frs', FrsController::class);

        // ----------------- Jadwal -----------------
        Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/pdf', [JadwalController::class, 'exportPdf'])->name('jadwal.pdf');

        // ----------------- Nilai -----------------
        Route::get('nilai', [NilaiController::class, 'index'])->name('mahasiswa.nilai.index');

        // ----------------- Kuesioner -----------------
        Route::get('kuesioner', [KuesionerController::class, 'index'])->name('mahasiswa.kuesioner.index');
        Route::get('kuesioner/{dosen_id}', [KuesionerController::class, 'create'])->name('mahasiswa.kuesioner.create');
        Route::post('kuesioner', [KuesionerController::class, 'store'])->name('mahasiswa.kuesioner.store');

        // ----------------- Daftar Ulang -----------------
        Route::get('daftar_ulang', [DaftarUlangController::class, 'index'])->name('daftar_ulang.index');
        Route::get('daftar_ulang/create', [DaftarUlangController::class, 'create'])->name('daftar_ulang.create');
        Route::post('daftar_ulang', [DaftarUlangController::class, 'store'])->name('daftar_ulang.store');

        // ----------------- Presensi -----------------
        Route::get('presensi', [PresensiController::class, 'index'])->name('mahasiswa.presensi.index');
    });

    // =====================================================
    // DOSEN ROUTES
    // =====================================================
    Route::prefix('dosen')->middleware([RoleMiddleware::class . ':dosen'])->group(function () {

        // ----------------- Nilai -----------------
        Route::get('nilai', [NilaiController::class, 'index'])->name('dosen.nilai.index');
        Route::get('nilai/create', [NilaiController::class, 'create'])->name('dosen.nilai.create');
        Route::get('nilai/matkul/{user_id}', [NilaiController::class, 'getMatkulByMahasiswa'])->name('dosen.nilai.getMatkul');
        Route::post('nilai', [NilaiController::class, 'store'])->name('dosen.nilai.store');
        Route::get('nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('dosen.nilai.edit');
        Route::put('nilai/{nilai}', [NilaiController::class, 'update'])->name('dosen.nilai.update');
        Route::delete('nilai/{nilai}', [NilaiController::class, 'destroy'])->name('dosen.nilai.destroy');

        // ----------------- Kuesioner -----------------
        Route::get('kuesioner', [KuesionerController::class, 'show'])->name('dosen.kuesioner.show');

        // ----------------- Daftar Ulang -----------------
        Route::get('daftar_ulang', [DaftarUlangController::class, 'index'])->name('dosen.daftar_ulang.list');
        Route::post('daftar_ulang/{id}/status', [DaftarUlangController::class, 'updateStatus'])->name('dosen.daftar_ulang.status');
        Route::post('daftar_ulang/{id}/file', [DaftarUlangController::class, 'moveOrCopy'])->name('dosen.daftar_ulang.file');

        // ----------------- Presensi -----------------
        Route::get('presensi', [PresensiController::class, 'index'])->name('dosen.presensi.index');
        Route::get('presensi/create', [PresensiController::class, 'create'])->name('dosen.presensi.create');
        Route::post('presensi', [PresensiController::class, 'store'])->name('dosen.presensi.store');
    });

});
