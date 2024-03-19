<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function jajanan(): BelongsTo
    {
        return $this->belongsTo(Jajanan::class);
    }
}
