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
        Schema::create('settings_conts', function (Blueprint $table) {
            $table->id();
            $table->string('use_crypto_feature', 20)->default('true');
            $table->float('fee')->default(0);

            $table->string('btc', 20)->default('enabled');
            $table->string('eth', 20)->default('enabled');
            $table->string('ltc', 20)->default('enabled');
            $table->string('link', 20)->default('enabled');
            $table->string('bnb', 255)->default('enabled');
            $table->string('aave', 250)->default('enabled');
            $table->string('usdt', 250)->default('enabled');
            $table->string('bch', 255)->default('enabled');
            $table->string('xlm', 255)->default('enabled');
            $table->string('xrp', 255)->default('enabled');
            $table->string('ada', 255)->default('enabled');

            $table->integer('currency_rate')->nullable();
            $table->integer('minamt')->nullable();
            $table->boolean('use_transfer')->default(true);
            $table->integer('min_transfer')->default(0);
            $table->string('purchase_code', 191)->nullable()->default('xxxxxx');
            $table->integer('transfer_charges')->default(0);

            $table->string('bnc_secret_key', 191)->nullable();
            $table->string('bnc_api_key', 191)->nullable();
            $table->string('flw_secret_hash', 191)->nullable();
            $table->string('flw_secret_key', 191)->nullable();
            $table->string('flw_public_key', 191)->nullable();

            $table->string('local_currency', 20)->nullable();
            $table->float('commission_p2p')->nullable();
            $table->string('enable_p2p', 20)->nullable();
            $table->string('base_currency', 20)->nullable();
            $table->string('telegram_bot_api', 192)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_conts');
    }
};
