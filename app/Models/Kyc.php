<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{

    protected $table = 'kycs';

    protected $fillable = [
        'user_id',
        'title',
        'gender',
        'zipcode',
        'phone_number',
        'dob',
        'social_media',
        'address',
        'city',
        'state',
        'country',
        'document_type',
        'frontimg',
        'backimg',
        'status',
        'statenumber',
        'accounttype',
        'employer',
        'income',
        'kinname',
        'kinaddress',
        'relationship',
        'age',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
