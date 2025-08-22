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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->string('min_price')->nullable();
            $table->string('max_price')->nullable();
            $table->string('minr')->nullable();
            $table->string('maxr')->nullable();
            $table->string('gift')->nullable();
            $table->string('expected_return')->nullable();
            $table->string('type')->nullable();
            $table->string('increment_interval')->nullable();
            $table->string('increment_type')->nullable();
            $table->string('increment_amount')->nullable();
            $table->string('expiration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
