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
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('good_item_id')->constrained('good_items')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('catatan', 255)->nullable();
            $table->string('catatan_admin', 255)->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->timestamp('tanggal_pinjam')->nullable();
            $table->timestamp('tanggal_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_requests');
    }
};
