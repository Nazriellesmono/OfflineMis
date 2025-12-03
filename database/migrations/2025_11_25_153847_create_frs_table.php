<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('frs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('matkul');
        $table->integer('semester');
        $table->integer('sks')->default(3);
        $table->string('bukti_foto')->nullable();
        $table->timestamps();
    });
}

};
