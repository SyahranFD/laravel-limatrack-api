<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaTerlarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'latitude',
        'longitude',
        'radius',
    ];
}
