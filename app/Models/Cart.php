<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'pedagang_id',
        'jajanan_id',
        'jumlah',
        'total_harga'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }

    public function jajanan(): HasMany
    {
        return $this->hasMany(Jajanan::class);
    }
}
