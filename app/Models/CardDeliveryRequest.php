<?php
// app/Models/CardDeliveryRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDeliveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'full_name',
        'address',
        'nearest_airport',
        'phone_number',
        'email',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // In CardDeliveryRequest model
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
