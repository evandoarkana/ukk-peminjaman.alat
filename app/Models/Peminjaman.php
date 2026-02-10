<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memperbaiki error tersebut
    protected $table = 'peminjamans';

        protected $fillable = [
            'kode_peminjaman', 
            'user_id', 
            'alat_id', 
            'jumlah', // Pastikan ini ada agar jumlah tidak tertukar/default
            'tgl_pinjam', 
            'tgl_kembali_rencana', 
            'denda',
            'status', 
            'petugas_id'
        ];

    // Relasi tetap sama...
    public function user() { return $this->belongsTo(User::class); }
    public function alat() {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
    public function detailPeminjaman() {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
    public function pengembalian() { return $this->hasOne(Pengembalian::class); }
}