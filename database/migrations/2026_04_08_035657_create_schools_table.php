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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('npsn');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('tahun_ajaran');
            $table->string('nama_bengkel');
            $table->string('nama_kepsek');
            $table->string('nip_kepsek');
            $table->string('foto_kepsek');
            $table->string('nama_kabeng');
            $table->string('nip_kabeng');
            $table->string('foto_kabeng');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
