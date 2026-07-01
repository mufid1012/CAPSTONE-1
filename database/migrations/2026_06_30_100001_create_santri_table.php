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
        Schema::create('santri', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('nis')->unique();
            $table->string('kelas')->nullable();
            $table->unsignedInteger('wali_murid_id')->nullable();
            $table->foreign('wali_murid_id')->references('id')->on('users')->nullOnDelete();
            $table->date('tanggal_lahir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
