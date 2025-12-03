<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            if (!Schema::hasColumn('presensis', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
            if (!Schema::hasColumn('presensis', 'matkul')) {
                $table->string('matkul')->after('user_id');
            }
            if (!Schema::hasColumn('presensis', 'semester')) {
                $table->string('semester')->nullable()->after('matkul');
            }
            if (!Schema::hasColumn('presensis', 'minggu')) {
                $table->integer('minggu')->nullable()->after('semester');
            }
            if (!Schema::hasColumn('presensis', 'status')) {
                $table->string('status', 2)->default('H')->after('minggu'); // H=hadir, A=absen
            }
        });
    }

    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'matkul', 'semester', 'minggu', 'status']);
        });
    }
};
