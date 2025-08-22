<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('txn_id')->nullable();
            $table->timestamp('date', 6)->nullable();
            $table->unsignedBigInteger('user')->nullable(); // could be foreignId if linked to users
            $table->string('amount')->nullable();
            $table->string('columns')->nullable();
            $table->string('bal')->nullable();
            $table->string('accountname')->nullable();
            $table->string('type', 50)->nullable();
            $table->text('accountnumber')->nullable();
            $table->string('bankname')->nullable();
            $table->string('Accounttype')->nullable();
            $table->text('Description')->nullable();
            $table->string('bankaddress')->nullable();
            $table->string('country')->nullable();
            $table->string('swiftcode', 50)->nullable();
            $table->string('iban', 35)->nullable();
            $table->string('to_deduct')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('paydetails')->nullable();
            $table->timestamps();

            // extra payment channels
            $table->string('crypto_currency', 50)->nullable();
            $table->string('crypto_network', 50)->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('wise_fullname')->nullable();
            $table->string('wise_email')->nullable();
            $table->string('wise_country', 100)->nullable();
            $table->string('skrill_email')->nullable();
            $table->string('skrill_fullname')->nullable();
            $table->string('venmo_username')->nullable();
            $table->string('venmo_phone', 50)->nullable();
            $table->string('zelle_email')->nullable();
            $table->string('zelle_phone', 50)->nullable();
            $table->string('zelle_name')->nullable();
            $table->string('cash_app_tag')->nullable();
            $table->string('cash_app_fullname')->nullable();
            $table->string('revolut_fullname')->nullable();
            $table->string('revolut_email')->nullable();
            $table->string('revolut_phone', 50)->nullable();
            $table->string('alipay_id')->nullable();
            $table->string('alipay_fullname')->nullable();
            $table->string('wechat_id')->nullable();
            $table->string('wechat_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
