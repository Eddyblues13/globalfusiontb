<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsPrivacy extends Model
{
    use HasFactory;

    protected $table = 'terms_privacies';

    // Allow mass assignment for these fields
    protected $fillable = [
        'description',
        'useterms',
    ];
}
