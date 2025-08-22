<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_Plan extends Model
{
    use HasFactory;

    protected $table = 'user_plans';

    protected $fillable = [
        'plan',
        'user',
        'amount',
        'active',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'profit_earned',
        'facility',
        'duration',
        'purpose',
        'income',
    ];
}
