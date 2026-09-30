<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_consents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->enum('consent_type', [
                'dpdp_act_data_privacy',
                'root_canal_treatment',
                'dental_implant_surgery',
                'clear_aligners_orthodontic',
                'tooth_extraction',
                'local_anesthesia',
            ]);
            $table->boolean('is_agreed')->default(true);
            $table->text('digital_signature_hash')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->dateTime('agreed_at');
            $table->foreignUuid('witnessed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['patient_id', 'consent_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_consents');
    }
};
