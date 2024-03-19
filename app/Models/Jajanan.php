<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jajanan extends Model
{
    use HasFactory;

    public $incrementing = false;

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

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }
}
