<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'daftar_keuangan';

    protected $fillable = [
        'pemasukan', 'pengeluaran', 'kategori_id', 'tanggal', 'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}


