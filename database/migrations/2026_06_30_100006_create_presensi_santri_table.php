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
            $table->increments('id');
            $table->unsignedInteger('presensi_kegiatan_id');
            $table->foreign('presensi_kegiatan_id')->references('id')->on('presensi_kegiatan')->cascadeOnDelete();
            $table->unsignedInteger('santri_id');
            $table->foreign('santri_id')->references('id')->on('santri')->cascadeOnDelete();
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
