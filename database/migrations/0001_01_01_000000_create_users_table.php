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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kyc_id')->nullable();
            $table->string('irs_filing_id', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('lastname', 40)->nullable();
            $table->string('middlename', 40)->nullable();
            $table->integer('amount')->nullable();
            $table->string('usernumber', 22)->nullable()->unique();
            $table->string('pin', 8)->nullable();
            $table->integer('pinstatus')->nullable();
            $table->string('action', 255)->nullable();
            $table->integer('limit')->default(500000);
            $table->string('accounttype', 45)->nullable();
            $table->integer('allowtransfer')->default(0);
            $table->integer('transferaction')->default(0);
            $table->string('code1', 30)->nullable();
            $table->string('code2', 40)->nullable();
            $table->string('code3', 50)->nullable();
            $table->integer('codestatus')->nullable();
            $table->string('signalstatus', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('username', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->date('dob')->nullable();
            $table->string('cstatus', 255)->nullable();
            $table->text('userupdate')->nullable();
            $table->string('assign_to', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('country', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('currency', 10)->default('USD'); // Added currency field
            $table->string('dashboard_style', 255)->default('light');
            $table->string('bank_name', 255)->nullable();
            $table->string('account_name', 255)->nullable();
            $table->integer('account_number')->nullable();
            $table->string('swift_code', 255)->nullable();
            $table->string('acnt_type_active', 255)->nullable();
            $table->string('btc_address', 255)->nullable();
            $table->string('eth_address', 255)->nullable();
            $table->string('ltc_address', 255)->nullable();
            $table->string('usdt_address', 191)->nullable();
            $table->string('plan', 255)->nullable();
            $table->string('user_plan', 255)->nullable();
            $table->float('account_bal')->default(0);
            $table->float('roi')->nullable();
            $table->float('bonus')->nullable();
            $table->float('ref_bonus')->nullable();
            $table->string('signup_bonus', 255)->nullable();
            $table->string('auto_trade', 255)->nullable();
            $table->integer('bonus_released')->default(0);
            $table->string('ref_by', 255)->nullable();
            $table->string('ref_link', 255)->nullable();
            $table->string('account_verify', 255)->nullable();
            $table->datetime('entered_at')->nullable();
            $table->datetime('activated_at')->nullable();
            $table->datetime('last_growth')->nullable();
            $table->string('account_status', 255)->default('inactive');
            $table->string('status', 25)->default('active');
            $table->string('trade_mode', 255)->default('on');
            $table->string('act_session', 255)->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('profile_photo_path', 255)->nullable();
            $table->string('withdrawotp', 255)->nullable();
            $table->string('sendotpemail', 255)->default('Yes');
            $table->string('sendroiemail', 255)->default('Yes');
            $table->string('sendpromoemail', 255)->default('Yes');
            $table->string('sendinvplanemail', 255)->default('Yes');
            $table->timestamps();

            // Indexes
            $table->index('usernumber');
            $table->index('email');
            $table->index('username');
            $table->index('kyc_id');
            $table->index('account_status');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
