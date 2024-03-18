<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pedagang_id',
        'image',
        'nominal_bayar',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }
}
