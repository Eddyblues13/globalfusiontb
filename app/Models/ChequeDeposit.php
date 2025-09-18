<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'cheque_number',
        'bank_name',
        'account_holder',
        'front_image',
        'back_image',
        'status',
        'txn_id',
        'user_id'
    ];


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
