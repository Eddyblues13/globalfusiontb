<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tp_Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['user', 'plan', 'amount', 'type'];
}
