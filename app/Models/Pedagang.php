<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'nama_warung',
        'nama_pedagang',
        'image',
        'buka',
        'jam_buka',
        'jam_tutup',
        'daerah_dagang',
        'average_rating',
        'sertifikasi_halal',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
