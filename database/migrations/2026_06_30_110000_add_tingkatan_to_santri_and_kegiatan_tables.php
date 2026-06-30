<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->enum('tingkatan', ['tsanawiyah', 'aliyah', 'takhassus'])
                  ->default('tsanawiyah')
                  ->after('kelas');
        });

        Schema::table('kegiatan_pondok', function (Blueprint $table) {
            $table->enum('tingkatan', ['tsanawiyah', 'aliyah', 'takhassus', 'semua'])
                  ->default('semua')
                  ->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn('tingkatan');
        });

        Schema::table('kegiatan_pondok', function (Blueprint $table) {
            $table->dropColumn('tingkatan');
        });
    }
};
