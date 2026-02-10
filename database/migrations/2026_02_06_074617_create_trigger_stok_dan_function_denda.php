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
        // Trigger untuk mengurangi stok otomatis saat peminjaman disetujui
        DB::unprepared('
            CREATE TRIGGER kurangi_stok_alat AFTER UPDATE ON peminjamans
            FOR EACH ROW
            BEGIN
                IF NEW.status = "disetujui" AND OLD.status = "menunggu" THEN
                    UPDATE alats SET stok = stok - 1 WHERE id = NEW.alat_id;
                END IF;
            END
        ');

        // Function untuk menghitung denda (contoh: 5000 per hari keterlambatan)
        DB::unprepared("
            DROP FUNCTION IF EXISTS hitung_denda;

            CREATE FUNCTION hitung_denda(
                tgl_rencana DATE,
                tgl_aktual DATE
            )
            RETURNS DECIMAL(10,2)
            DETERMINISTIC
            BEGIN
                DECLARE selisih INT;
                DECLARE total_denda DECIMAL(10,2);

                SET selisih = DATEDIFF(tgl_aktual, tgl_rencana);

                IF selisih > 0 THEN
                    SET total_denda = selisih * 5000;
                ELSE
                    SET total_denda = 0;
                END IF;

                RETURN total_denda;
            END;
        ");

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trigger_stok_dan_function_denda');
    }
};
