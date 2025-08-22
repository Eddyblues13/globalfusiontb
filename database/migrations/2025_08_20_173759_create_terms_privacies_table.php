<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terms_privacies', function (Blueprint $table) {
            $table->id(); // `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->text('description'); // `description` TEXT NOT NULL
            $table->string('useterms', 255)->default('yes'); // `useterms` VARCHAR(255) DEFAULT 'yes'
            $table->timestamps(); // `created_at` and `updated_at` TIMESTAMP NULLABLE
        });

        // Insert initial data
        DB::table('terms_privacies')->insert([
            'description' => '<p><strong>Our Commitment to You:</strong></p>
<p>Thank you for showing interest in our service. In order for us to provide you with our service, we are required to collect and process certain personal data about you and your activity.</p>
<p>By entrusting us with your personal data, we would like to assure you of our commitment to keep such information private and to operate in accordance with all regulatory laws and all EU data protection laws, including General Data Protection Regulation (GDPR) 679/2016 (EU).</p>
<!-- rest of your HTML content here -->',
            'useterms' => 'no',
            'created_at' => '2020-12-14 15:39:57',
            'updated_at' => '2022-07-05 11:23:49',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_privacies');
    }
};
