<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap tabelnya bernama 'alats'.
     */
    protected $table = 'alats';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     * Sesuai dengan spesifikasi alat di dokumen soal.
     */
    protected $fillable = [
        'kategori_id', 
        'nama_alat', 
        'spesifikasi', 
        'stok'
    ];

    /**
     * Relasi ke Model Kategori (Many-to-One).
     * Menghubungkan alat dengan kategori tertentu sesuai instruksi relasional database.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke Model Peminjaman (One-to-Many).
     * Memungkinkan pelacakan alat mana saja yang sedang dipinjam.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'alat_id');
    }
}