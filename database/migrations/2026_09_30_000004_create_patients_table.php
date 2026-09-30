<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignUuid('attending_doctor_id')->nullable()->constrained('dentist_profiles')->nullOnDelete();
            $table->string('patient_id', 50)->unique(); // E.g. 'RD-2024-0412'
            $table->string('full_name', 150);
            $table->string('phone', 20)->index(); // Indian phone +91
            $table->unsignedSmallInteger('age')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('blood_group', 10)->default('Unknown');
            $table->string('city', 100)->default('Jaipur');
            $table->text('residential_address')->nullable();
            $table->text('medical_alerts')->nullable(); // Allergies, medical alerts
            $table->enum('treatment_status', [
                'active_treatments',
                'follow_ups_due',
                'completed',
                'inactive',
            ])->default('active_treatments');
            $table->decimal('billing_balance', 10, 2)->default(0.00); // Pending due
            $table->string('recent_treatment', 200)->nullable();
            $table->dateTime('last_visit_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['full_name', 'phone']);
            $table->index(['treatment_status', 'billing_balance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
