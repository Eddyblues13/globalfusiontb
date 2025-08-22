<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $settings = Setting::where('id', 1)->first();

        if ($settings->enable_verification == 'true') {
            $this->notify(new VerifyEmail);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kyc_id',
        'irs_filing_id',
        'name',
        'lastname',
        'middlename',
        'amount',
        'usernumber',
        'pin',
        'pinstatus',
        'action',
        'limit',
        'accounttype',
        'allowtransfer',
        'transferaction',
        'code1',
        'code2',
        'code3',
        'codestatus',
        'signalstatus',
        'email',
        'username',
        'password',
        'dob',
        'cstatus',
        'userupdate',
        'assign_to',
        'address',
        'country',
        'currency',
        'phone',
        'dashboard_style',
        'bank_name',
        'account_name',
        'account_number',
        'swift_code',
        'acnt_type_active',
        'btc_address',
        'eth_address',
        'ltc_address',
        'usdt_address',
        'plan',
        'user_plan',
        'account_bal',
        'roi',
        'bonus',
        'ref_bonus',
        'signup_bonus',
        'auto_trade',
        'bonus_released',
        'ref_by',
        'ref_link',
        'account_verify',
        'entered_at',
        'activated_at',
        'last_growth',
        'account_status',
        'status',
        'trade_mode',
        'act_session',
        'withdrawotp',
        'sendotpemail',
        'sendroiemail',
        'sendpromoemail',
        'sendinvplanemail',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'entered_at' => 'datetime',
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
        'amount' => 'integer',
        'limit' => 'integer',
        'account_bal' => 'float',
        'roi' => 'float',
        'bonus' => 'float',
        'ref_bonus' => 'float',
        'bonus_released' => 'integer',
        'account_number' => 'integer',
        'pinstatus' => 'integer',
        'allowtransfer' => 'integer',
        'transferaction' => 'integer',
        'codestatus' => 'integer',
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array
     */
    protected $attributes = [
        'limit' => 500000,
        'allowtransfer' => 0,
        'transferaction' => 0,
        'codestatus' => 0,
        'dashboard_style' => 'light',
        'account_bal' => 0,
        'bonus_released' => 0,
        'account_status' => 'inactive',
        'status' => 'active',
        'trade_mode' => 'on',
        'sendotpemail' => 'Yes',
        'sendroiemail' => 'Yes',
        'sendpromoemail' => 'Yes',
        'sendinvplanemail' => 'Yes',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function dp()
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function wd()
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    // public function tuser(){
    //     return $this->belongsTo(Admin::class, 'assign_to');
    // }

    // public function dplan(){
    //     return $this->belongsTo(Plans::class, 'plan');
    // }

    // public function plans(){
    //     return $this->hasMany(User_plans::class,'user', 'id');
    // }

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }

    /**
     * Get the cards for the user.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the notifications associated with the user.
     */
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    /**
     * Get the count of unread notifications for this user.
     * 
     * @return int
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * Get the KYC record associated with the user.
     */
    // public function kyc()
    // {
    //     return $this->belongsTo(Kyc::class, 'kyc_id');
    // }

    public function loans()
    {
        return $this->hasMany(\App\Models\Loan::class);
    }
}
