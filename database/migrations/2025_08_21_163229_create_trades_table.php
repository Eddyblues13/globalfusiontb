<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('trade_ref')->unique();
            $table->string('asset_symbol', 20);
            $table->string('asset_name');
            $table->enum('asset_type', ['stock', 'crypto', 'forex']);
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('amount', 15, 2);
            $table->decimal('quantity', 15, 8);
            $table->enum('order_type', ['market', 'limit', 'stop']);
            $table->decimal('limit_price', 15, 2)->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('asset_symbol');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trades');
    }
}