<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsCont extends Model
{
    protected $table = 'settings_conts';

    protected $fillable = [
        'use_crypto_feature',
        'fee',
        'btc',
        'eth',
        'ltc',
        'link',
        'bnb',
        'aave',
        'usdt',
        'bch',
        'xlm',
        'xrp',
        'ada',
        'currency_rate',
        'minamt',
        'use_transfer',
        'min_transfer',
        'purchase_code',
        'transfer_charges',
        'bnc_secret_key',
        'bnc_api_key',
        'flw_secret_hash',
        'flw_secret_key',
        'flw_public_key',
        'local_currency',
        'commission_p2p',
        'enable_p2p',
        'base_currency',
        'telegram_bot_api',
    ];
}
