<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cart_id',
        'jajanan_id',
        'jumlah',
        'total_harga',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function jajanan()
    {
        return $this->belongsTo(Jajanan::class);
    }
}
