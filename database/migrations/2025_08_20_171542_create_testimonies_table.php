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
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto increment
            $table->string('ref_key')->nullable();
            $table->string('position')->nullable();
            $table->string('name')->nullable();
            $table->string('what_is_said')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonies');
    }
};
