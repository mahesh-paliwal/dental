<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcast_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150); // E.g. '6-month scaling and GBT recall', '20% whitening privilege offer'
            $table->enum('channel', ['sms', 'whatsapp', 'in_portal_notice'])->default('sms');
            $table->string('dlt_template_id', 100)->nullable(); // Indian Telecom DLT Template ID
            $table->text('message_template'); // Text with variables: {patient_name}, {doctor_name}, {clinic_phone}, {portal_link}
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_templates');
    }
};
