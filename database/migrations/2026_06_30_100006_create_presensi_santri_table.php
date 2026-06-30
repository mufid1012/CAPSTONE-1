<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensi_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presensi_kegiatan_id')->constrained('presensi_kegiatan')->cascadeOnDelete();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['presensi_kegiatan_id', 'santri_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_santri');
    }
};
