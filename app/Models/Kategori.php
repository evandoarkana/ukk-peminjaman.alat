<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori']; // Sesuai fitur CRUD kategori [cite: 30]

    // Relasi: Satu kategori memiliki banyak alat 
    public function alats()
    {
        return $this->hasMany(Alat::class);
    }
}