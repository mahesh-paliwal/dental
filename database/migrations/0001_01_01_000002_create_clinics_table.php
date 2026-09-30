<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150)->default('Dr. Renu Dental Clinic');
            $table->string('code', 50)->unique()->default('DR-RENU-JAIPUR');
            $table->string('registration_number', 100)->default('RJ-DC-2015');
            $table->string('certifications', 255)->default('CBCT and GBT certified');
            $table->string('phone', 30)->default('+91 9650935061');
            $table->string('email', 150)->nullable();
            $table->string('address_line1', 255)->default('33, Shiv Shakti Nagar');
            $table->string('address_line2', 255)->nullable()->default('Nirman Nagar');
            $table->string('city', 100)->default('Jaipur');
            $table->string('state', 100)->default('Rajasthan');
            $table->string('postal_code', 20)->default('302019');
            $table->string('country', 100)->default('India');
            $table->string('timezone', 50)->default('Asia/Kolkata');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
