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
        Schema::table('peminjamans', function (Blueprint $table) {
            // Menambahkan kolom untuk mencatat tgl kembali asli dan nominal denda
            $table->dateTime('tgl_kembali_real')->nullable()->after('tgl_kembali_rencana');
            $table->integer('denda')->default(0)->after('tgl_kembali_real');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['tgl_kembali_real', 'denda']);
        });
    }
};
