<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paystack extends Model
{
    use HasFactory;

    protected $table = 'paystacks';

    protected $fillable = [
        'paystack_public_key',
        'paystack_secret_key',
        'paystack_url',
        'paystack_email',
    ];
}
