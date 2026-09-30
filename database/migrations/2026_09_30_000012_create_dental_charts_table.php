<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_charts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->unsignedTinyInteger('tooth_number'); // FDI numbering: 11-18, 21-28, 31-38, 41-48
            $table->enum('status', [
                'healthy',
                'completed_rct',
                'zirconia_ceramic_crown',
                'titanium_implant',
                'caries',
                'composite_filling',
                'porcelain_veneer',
                'extracted_missing',
            ])->default('healthy');
            $table->text('clinical_notes_material')->nullable(); // Free-text "Clinical Notes / Material"
            $table->dateTime('updated_at_clinical');
            $table->timestamps();

            $table->unique(['patient_id', 'tooth_number']);
            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_charts');
    }
};
