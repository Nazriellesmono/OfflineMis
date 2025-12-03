<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuesioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');

            // contoh 5 pertanyaan dengan skala 1–5
            $table->tinyInteger('q1'); // penguasaan materi
            $table->tinyInteger('q2'); // cara penyampaian materi
            $table->tinyInteger('q3'); // kejelasan penjelasan
            $table->tinyInteger('q4'); // kedisiplinan waktu
            $table->tinyInteger('q5'); // keterbukaan terhadap pertanyaan

            $table->text('saran')->nullable(); // opsional saran teks
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'dosen_id']); // agar 1 mahasiswa isi 1x per dosen
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioners');
    }
};
