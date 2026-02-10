<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    // Tambahkan baris ini untuk memaksa menggunakan nama tabel yang Anda buat
    protected $table = 'detail_peminjamans'; 

    protected $fillable = ['peminjaman_id', 'alat_id', 'jumlah'];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}