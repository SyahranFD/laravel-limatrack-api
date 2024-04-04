<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Iklan extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'pedagang_id',
        'image',
        'nominal_bayar',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'nominal_bayar' => 'integer'
    ];

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }
}
