<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->string('title', 200); // E.g. 'Dental Implant - Tooth #16', 'Full Mouth Aligners', 'RCT with Zirconia Crown'
            $table->enum('treatment_type', ['rct', 'implants', 'aligners', 'crowns_bridges', 'periodontics', 'general'])->default('general');
            $table->enum('status', ['proposed', 'active', 'completed', 'cancelled'])->default('active');
            $table->decimal('total_estimated_cost', 10, 2)->default(0.00);
            $table->date('start_date')->nullable();
            $table->date('expected_completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
