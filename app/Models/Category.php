<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'user_id'];

    // Relasi ke model Keuangan
    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

