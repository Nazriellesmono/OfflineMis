<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('daftar_ulang', 'daftar_ulangs');
    }

    public function down(): void
    {
        Schema::rename('daftar_ulangs', 'daftar_ulang');
    }
};
