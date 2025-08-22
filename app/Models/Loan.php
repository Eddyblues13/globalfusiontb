<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_type',
        'amount',
        'interest_rate',
        'interest_amount',
        'total_amount',
        'remaining_balance',
        'monthly_payment',
        'repayment_period',
        'purpose',
        'status',
        'application_date',
    ];

    protected $dates = [
        'application_date',
    ];

    // Relationship: A loan belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
