<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $fillable = [
        'txn_id',
        'date',
        'user',
        'amount',
        'columns',
        'bal',
        'accountname',
        'type',
        'accountnumber',
        'bankname',
        'Accounttype',
        'Description',
        'bankaddress',
        'country',
        'swiftcode',
        'iban',
        'to_deduct',
        'status',
        'payment_mode',
        'paydetails',
        'crypto_currency',
        'crypto_network',
        'wallet_address',
        'paypal_email',
        'wise_fullname',
        'wise_email',
        'wise_country',
        'skrill_email',
        'skrill_fullname',
        'venmo_username',
        'venmo_phone',
        'zelle_email',
        'zelle_phone',
        'zelle_name',
        'cash_app_tag',
        'cash_app_fullname',
        'revolut_fullname',
        'revolut_email',
        'revolut_phone',
        'alipay_id',
        'alipay_fullname',
        'wechat_id',
        'wechat_name',
    ];

    // If linked to users
    public function userAccount()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
