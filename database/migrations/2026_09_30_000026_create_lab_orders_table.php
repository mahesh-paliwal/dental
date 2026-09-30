<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lab_id')->constrained('dental_labs')->restrictOnDelete();
            $table->foreignUuid('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->string('order_number', 50)->unique(); // E.g. 'LAB-2026-0120'
            $table->enum('restoration_type', [
                'zirconia_ceramic_crown',
                'porcelain_veneer',
                'clear_aligner_set',
                'implant_abutment_crown',
                'acrylic_denture',
                'cast_partial_denture',
                'other',
            ]);
            $table->string('tooth_number', 50); // E.g. FDI #16
            $table->string('shade', 50)->nullable(); // E.g. VITA A2, BL1
            $table->date('order_date');
            $table->date('due_date');
            $table->date('received_date')->nullable();
            $table->enum('status', ['sent', 'in_progress', 'received', 'fitted', 'remake', 'cancelled'])->default('sent');
            $table->decimal('lab_cost', 10, 2)->default(0.00);
            $table->text('instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lab_id', 'status']);
            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_orders');
    }
};
