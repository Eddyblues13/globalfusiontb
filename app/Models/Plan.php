<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'min_price',
        'max_price',
        'minr',
        'maxr',
        'gift',
        'expected_return',
        'type',
        'increment_interval',
        'increment_type',
        'increment_amount',
        'expiration',
    ];
}
