<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'pedagang_id',
    ];

    // belongsTo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }

    // hasMany
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
