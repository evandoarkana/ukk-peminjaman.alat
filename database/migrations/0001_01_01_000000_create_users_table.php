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
        // Tabel Utama Users sesuai kebutuhan fitur CRUD User
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Lengkap pengguna
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            /** * Pembagian Level Pengguna (Privilege User) [cite: 28, 70]
             * - Admin: CRUD data [cite: 30]
             * - Petugas: Menyetujui & Laporan [cite: 30]
             * - Peminjam: Mengajukan peminjaman [cite: 30]
             */
            $table->enum('role', ['admin', 'petugas', 'peminjam'])->default('peminjam'); 
            
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Token Reset Password (Standar Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel Sesi untuk manajemen autentikasi login [cite: 30, 44]
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};