<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jajanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pedagang_id',
        'nama',
        'deskripsi',
        'harga',
        'image',
        'tersedia',
        'kategori',
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }
}
