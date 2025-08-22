<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trade_ref',
        'asset_symbol',
        'asset_name',
        'asset_type',
        'type',
        'amount',
        'quantity',
        'order_type',
        'limit_price',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'quantity' => 'decimal:8',
        'limit_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
