<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', [
                'bank_transfer',
                'paypal_withdrawal',
                'crypto_deposit',
                'crypto_withdrawal',
                'check_deposit',
                'loan_request'
            ]);
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->string('status')->default('pending'); // pending, processing, completed, failed, cancelled

            // Recipient/Bank Details (for bank transfers)
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('routing_number')->nullable();

            // PayPal Details
            $table->string('paypal_email')->nullable();

            // Crypto Details
            $table->string('wallet_type')->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('crypto_type')->nullable();

            // Check Deposit Details
            $table->string('front_cheque_path')->nullable();

            // Loan Details
            $table->string('loan_type')->nullable();
            $table->integer('repayment_period')->nullable(); // in days
            $table->text('loan_reason')->nullable();

            // Common fields
            $table->text('description')->nullable();
            $table->string('reference_id')->unique()->nullable();
            $table->string('transaction_pin')->nullable(); // Hashed version

            // Timestamps
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'type']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
