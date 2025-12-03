<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Mahasiswa
            $table->foreignId('frs_id')->constrained('frs')->onDelete('cascade'); // Matkul
            $table->integer('minggu'); // 1 - 16
            $table->enum('status', ['H', 'A', 'I', 'S', 'X', '-'])->default('-');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
