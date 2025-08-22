<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
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
