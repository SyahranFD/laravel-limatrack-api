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

    // belongsTo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // hasMany
    public function jajanan()
    {
        return $this->hasMany(Jajanan::class);
    }

    public function imageVerifikasiPedagang()
    {
        return $this->hasMany(ImageVerifikasiPedagang::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function langganan()
    {
        return $this->hasMany(Langganan::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
