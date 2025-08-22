<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [
        'txn_id',
        'user',
        'amount',
        'payment_mode',
        'Description',
        'type',
        'accountname',
        'plan',
        'status',
        'proof',
    ];

    // Optional: relationship if deposits belong to users
    public function userAccount()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
