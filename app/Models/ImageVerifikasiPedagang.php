<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageVerifikasiPedagang extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'pedagang_id',
        'image',
    ];

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }
}
