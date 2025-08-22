<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('txn_id')->nullable();
            $table->unsignedBigInteger('user')->nullable(); // consider changing to foreignId if linked to users table
            $table->string('amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('Description')->default('Cryptocurrency Funding');
            $table->string('type')->default('Credit');
            $table->text('accountname')->nullable();
            $table->integer('plan')->nullable();
            $table->string('status')->nullable();
            $table->string('proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
