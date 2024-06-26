<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedagang extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'nama_warung',
        'nama_pedagang',
        'banner',
        'status',
        'jam_buka',
        'jam_tutup',
        'daerah_dagang',
        'average_rating',
        'dokumen_sertifikat_halal',
        'sertifikasi_halal',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'average_rating' => 'float',
        'sertifikasi_halal' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // hasMany
    public function jajanan(): HasMany
    {
        return $this->hasMany(Jajanan::class);
    }

    public function imageVerifikasi(): HasMany
    {
        return $this->hasMany(ImageVerifikasi::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function langganan(): HasMany
    {
        return $this->hasMany(Langganan::class);
    }

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
