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
        Schema::create('presensi_kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kegiatan_pondok_id');
            $table->foreign('kegiatan_pondok_id')->references('id')->on('kegiatan_pondok')->cascadeOnDelete();
            $table->unsignedInteger('ustadz_id');
            $table->foreign('ustadz_id')->references('id')->on('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->text('materi')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['valid', 'invalid', 'pending'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_kegiatan');
    }
};
