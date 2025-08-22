<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('code1', 25)->nullable();
            $table->string('code2', 25)->nullable();
            $table->string('code3', 25)->nullable();
            $table->string('code4', 25)->nullable();
            $table->text('description')->nullable();
            $table->integer('code1status')->default(1);
            $table->integer('code2status')->default(1);
            $table->integer('code3status')->default(1);
            $table->integer('otp')->default(0);
            $table->integer('sms')->default(0);
            $table->string('currency')->nullable();
            $table->integer('intreast')->nullable();
            $table->string('s_currency')->nullable();
            $table->string('capt_secret')->nullable();
            $table->string('capt_sitekey')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('location')->nullable();
            $table->string('s_s_k')->nullable();
            $table->string('s_p_k')->nullable();
            $table->string('pp_cs')->nullable();
            $table->string('pp_ci')->nullable();
            $table->string('keywords')->nullable();
            $table->string('site_title')->nullable();
            $table->string('site_address')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('trade_mode')->nullable();
            $table->string('google_translate')->nullable();
            $table->string('weekend_trade')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('timezone')->nullable();
            $table->string('mail_server', 20)->nullable();
            $table->string('emailfrom')->nullable();
            $table->string('emailfromname')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_encrypt')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('google_secret')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_redirect')->nullable();
            $table->string('referral_commission')->nullable();
            $table->string('referral_commission1')->nullable();
            $table->string('referral_commission2')->nullable();
            $table->string('referral_commission3')->nullable();
            $table->string('referral_commission4')->nullable();
            $table->string('referral_commission5')->nullable();
            $table->string('signup_bonus')->nullable();
            $table->integer('deposit_bonus')->nullable();
            $table->longText('tawk_to')->nullable();
            $table->string('enable_2fa')->default('no');
            $table->string('enable_kyc')->default('no');
            $table->string('enable_kyc_registration', 191)->nullable();
            $table->string('enable_with')->nullable();
            $table->string('enable_verification')->default('true');
            $table->string('enable_social_login')->nullable();
            $table->string('withdrawal_option')->default('auto');
            $table->string('deposit_option')->nullable();
            $table->string('auto_merchant_option', 191)->default('Coinpayment');
            $table->string('dashboard_option')->nullable();
            $table->string('enable_annoc')->nullable();
            $table->text('subscription_service')->nullable();
            $table->string('captcha')->nullable();
            $table->boolean('return_capital')->default(1);
            $table->string('tido')->nullable();
            $table->string('address_o')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('should_cancel_plan')->default(1);
            $table->string('commission_type')->nullable();
            $table->string('commission_fee')->nullable();
            $table->string('monthlyfee')->nullable();
            $table->string('quarterlyfee')->nullable();
            $table->string('yearlyfee')->nullable();
            $table->string('newupdate')->nullable();
            $table->longText('modules')->nullable();
            $table->string('redirect_url', 192)->nullable();
            $table->text('address')->nullable();
            $table->string('website_theme', 191)->default('purpose.css');
            $table->string('credit_card_provider', 191)->default('Paystack');
            $table->string('deduction_option', 191)->default('userRequest');
            $table->text('welcome_message')->nullable();
            $table->string('install_type', 20)->nullable();
            $table->string('merchant_key', 192)->nullable();
            $table->text('code1message')->nullable();
            $table->text('code2message')->nullable();
            $table->text('code3message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
