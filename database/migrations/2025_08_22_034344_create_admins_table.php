<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->dateTime('token_2fa_expiry')->useCurrent();
            $table->string('enable_2fa')->default('disabled');
            $table->string('token_2fa')->nullable();
            $table->string('pass_2fa')->nullable();
            $table->string('phone')->nullable();
            $table->string('dashboard_style')->default('dark');
            $table->rememberToken();
            $table->string('password_token', 100)->nullable();
            $table->string('acnt_type_active')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
