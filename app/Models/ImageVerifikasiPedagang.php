<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageVerifikasiPedagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pedagang_id',
        'image',
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }
}
