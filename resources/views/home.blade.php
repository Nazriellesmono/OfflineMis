@extends('layouts.app')
@section('title', 'Home')

@section('content')
@php
    $role = auth()->user()->role;
    $name = auth()->user()->name;
@endphp

<div class="space-y-10">

    <!-- 🧭 Hero Section -->
    <section class="bg-white rounded-2xl shadow-sm p-8 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 space-y-4">
            <h1 class="text-3xl font-bold text-[var(--space-indigo)]">Selamat Datang, {{ $name }} 👋</h1>
            <p class="text-[var(--lavender-grey)] text-base">
                Anda login sebagai: 
                <span class="font-semibold text-[var(--punch-red)] capitalize">{{ $role }}</span>
            </p>

            @if($role === 'mahasiswa')
                <a href="{{ route('jadwal.index') }}" 
                   class="inline-block mt-4 bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2 rounded-md font-medium transition">
                    Lihat Jadwal Hari Ini
                </a>
            @elseif($role === 'dosen')
                <a href="{{ route('dosen.presensi.index') }}" 
                   class="inline-block mt-4 bg-[var(--punch-red)] hover:bg-[var(--flag-red)] text-white px-5 py-2 rounded-md font-medium transition">
                    Lihat Kelas Saya
                </a>
            @endif
        </div>

        <div class="md:w-1/2 flex justify-center mt-6 md:mt-0">
            @if($role === 'mahasiswa')
                <img src="https://cdn-icons-png.flaticon.com/512/747/747086.png" alt="Mahasiswa Laptop" class="w-72 md:w-80 drop-shadow-lg">
            @else
                <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Dosen Mengajar" class="w-72 md:w-80 drop-shadow-lg">
            @endif
        </div>
    </section>

    <!-- 📊 Statistik Ringkas Berdasarkan Role -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if($role === 'mahasiswa')
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">Total SKS Aktif</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">22 SKS</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">IP Semester Lalu</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">3.75</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">Kehadiran Semester Ini</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">96%</h3>
            </div>
        @elseif($role === 'dosen')
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">Kelas Hari Ini</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">3 Kelas</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">Mahasiswa Bimbingan</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">12 Orang</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <p class="text-[var(--lavender-grey)] text-sm mb-1">Tugas Belum Dinilai</p>
                <h3 class="text-2xl font-semibold text-[var(--space-indigo)]">5 Tugas</h3>
            </div>
        @endif
    </section>

    <!-- 🗞️ Info Akademik -->
    <section class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-[var(--space-indigo)] mb-4">Info Akademik</h2>
        <div class="space-y-3">
            <div class="flex items-start gap-3 border-l-4 border-[var(--punch-red)] pl-3">
                <i class="fa-solid fa-bullhorn text-[var(--punch-red)] mt-1"></i>
                <div>
                    <p class="text-[var(--space-indigo)] font-medium">Pengisian FRS Semester Genap</p>
                    <p class="text-[var(--lavender-grey)] text-sm">Dibuka mulai 10 Januari - 20 Januari 2026</p>
                </div>
            </div>

            <div class="flex items-start gap-3 border-l-4 border-[var(--punch-red)] pl-3">
                <i class="fa-solid fa-calendar-days text-[var(--punch-red)] mt-1"></i>
                <div>
                    <p class="text-[var(--space-indigo)] font-medium">Jadwal Ujian Tengah Semester</p>
                    <p class="text-[var(--lavender-grey)] text-sm">Akan diumumkan pada 15 Februari 2026</p>
                </div>
            </div>

            <div class="flex items-start gap-3 border-l-4 border-[var(--punch-red)] pl-3">
                <i class="fa-solid fa-circle-info text-[var(--punch-red)] mt-1"></i>
                <div>
                    <p class="text-[var(--space-indigo)] font-medium">Perbarui Data Mahasiswa</p>
                    <p class="text-[var(--lavender-grey)] text-sm">Pastikan biodata Anda sudah lengkap di menu profil</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
