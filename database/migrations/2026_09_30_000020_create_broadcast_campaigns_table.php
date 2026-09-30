<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcast_campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->foreignUuid('template_id')->nullable()->constrained('broadcast_templates')->nullOnDelete();
            $table->string('title', 200); // Campaign name
            $table->enum('channel', ['sms', 'whatsapp', 'in_portal_notice'])->default('sms');
            $table->enum('audience_segment', [
                'all_patients',              // All 6,428 patients
                'six_month_scaling_recall', // 6-month scaling & GBT recall
                'active_treatment_plans',   // Active treatments (RCT, Implants, Aligners)
                'rct_follow_up',            // RCT follow-up
                'dental_implant_patients',  // Dental implant follow-up
                'aligners_smile_patients',  // Aligners & smile makeover
                'custom',
            ])->default('all_patients');
            $table->text('message_body');
            $table->string('dlt_sender_id', 20)->default('DRRENU'); // Registered DLT Header
            $table->unsignedInteger('total_recipients')->default(0);
            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('delivered_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->unsignedInteger('credits_used')->default(0);
            $table->enum('status', ['draft', 'scheduled', 'sending', 'completed', 'failed'])->default('draft');
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->foreignUuid('created_by_user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['channel', 'status']);
            $table->index(['scheduled_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_campaigns');
    }
};
