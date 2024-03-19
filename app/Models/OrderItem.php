<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'order_id',
        'jajanan_id',
        'jumlah',
        'total_harga',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function jajanan()
    {
        return $this->belongsTo(Jajanan::class);
    }
}
