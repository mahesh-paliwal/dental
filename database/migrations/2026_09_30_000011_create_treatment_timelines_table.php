<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_timelines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->foreignUuid('treatment_plan_id')->nullable()->constrained('treatment_plans')->nullOnDelete();
            $table->foreignUuid('procedure_id')->nullable()->constrained('dental_procedures')->nullOnDelete();
            $table->string('procedure_name', 200); // Denormalized for fast display
            $table->string('tooth_number', 10)->nullable(); // FDI 11-48
            $table->date('treatment_date');
            $table->text('clinical_notes')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->timestamps();

            $table->index(['patient_id', 'treatment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_timelines');
    }
};
