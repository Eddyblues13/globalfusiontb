<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'token_2fa_expiry',
        'enable_2fa',
        'token_2fa',
        'pass_2fa',
        'phone',
        'dashboard_style',
        'password_token',
        'acnt_type_active',
        'status',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'pass_2fa',
        'token_2fa',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'token_2fa_expiry' => 'datetime',
    ];
}
