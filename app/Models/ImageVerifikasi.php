<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageVerifikasi extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
