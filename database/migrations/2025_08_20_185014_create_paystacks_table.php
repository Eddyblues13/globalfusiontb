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
        Schema::create('paystacks', function (Blueprint $table) {
            $table->id();
            $table->text('paystack_public_key')->nullable();
            $table->text('paystack_secret_key')->nullable();
            $table->string('paystack_url', 255)->nullable();
            $table->string('paystack_email', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paystacks');
    }
};
