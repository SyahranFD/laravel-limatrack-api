<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaTerlarang extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'latitude',
        'longitude',
        'radius',
        'nama',
        'daerah'
    ];

    protected $casts = [
        'radius' => 'integer',
    ];
}
