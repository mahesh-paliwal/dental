<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_follow_up_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->date('preferred_date');
            $table->enum('preferred_time_slot', [
                'morning',   // 10:00 AM to 01:00 PM
                'afternoon', // 02:00 PM to 05:00 PM
                'evening',    // 05:00 PM to 08:30 PM
            ]);
            $table->text('pain_symptoms')->nullable(); // Reason for visit / any pain or symptoms
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])->default('pending');
            $table->enum('confirmation_channel', ['whatsapp', 'phone_call'])->default('whatsapp'); // Pooja confirms via WhatsApp/Call
            $table->foreignUuid('confirmed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('created_appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->text('staff_response_notes')->nullable();
            $table->timestamps();

            $table->index(['patient_id', 'status']);
            $table->index(['preferred_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_follow_up_requests');
    }
};
