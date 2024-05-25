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
        'nama_warung',
        'nama_jajanan',
        'jumlah',
        'total_harga',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'total_harga' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }

    public function jajanan(): BelongsTo
    {
        return $this->belongsTo(Jajanan::class);
    }
}
