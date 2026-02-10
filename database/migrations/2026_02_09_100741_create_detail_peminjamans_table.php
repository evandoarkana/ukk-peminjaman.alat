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
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel peminjamans (Header)
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            // Menghubungkan ke tabel alats
            $table->foreignId('alat_id')->constrained('alats');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};
