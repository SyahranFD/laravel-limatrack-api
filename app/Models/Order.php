<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'pedagang_id',
        'nama_user',
        'status',
        'metode_pembayaran',
        'total_keseluruhan'
    ];

    protected $casts = [
        'total_keseluruhan' => 'integer'
    ];

    // belongsTo
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(Pedagang::class);
    }

    // hasMany
    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
