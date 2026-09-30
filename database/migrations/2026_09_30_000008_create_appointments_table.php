<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignUuid('doctor_id')->constrained('dentist_profiles')->restrictOnDelete();
            $table->foreignUuid('chair_id')->nullable()->constrained('dental_chairs')->nullOnDelete(); // Chair 1, Chair 2, Diagnostic Bay
            $table->foreignUuid('procedure_id')->nullable()->constrained('dental_procedures')->nullOnDelete();
            $table->date('appointment_date');
            $table->string('time_slot', 50); // E.g. '10:30 AM - 11:15 AM'
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->enum('status', [
                'scheduled',
                'confirmed',
                'in_chair',      // Currently in chair
                'completed',
                'cancelled',
                'no_show',
            ])->default('scheduled');
            $table->boolean('is_walk_in')->default(false); // '+ Add Walk-In Patient' from Operatory Queue
            $table->unsignedInteger('queue_order')->default(0);
            $table->text('purpose')->nullable(); // Purpose of visit / scheduled procedure details
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['appointment_date', 'status']);
            $table->index(['doctor_id', 'appointment_date']);
            $table->index(['chair_id', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
