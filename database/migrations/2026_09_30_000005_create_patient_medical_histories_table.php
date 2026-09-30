<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_medical_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->unique()->constrained('patients')->cascadeOnDelete();
            $table->text('allergies')->nullable(); // Penicillin, Latex, Local Anesthetics
            $table->boolean('has_diabetes')->default(false);
            $table->boolean('has_hypertension')->default(false);
            $table->boolean('has_cardiac_disease')->default(false);
            $table->boolean('has_bleeding_disorder')->default(false);
            $table->boolean('is_pregnant')->default(false);
            $table->text('current_medications')->nullable();
            $table->text('medical_notes')->nullable();
            $table->foreignUuid('recorded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_medical_histories');
    }
};
