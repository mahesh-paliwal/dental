<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->string('prescription_number', 50)->unique(); // E.g. 'RX-2026-0001'
            $table->date('prescription_date');
            $table->text('post_op_advice')->nullable(); // Post-operative advice / care check-in
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'prescription_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
