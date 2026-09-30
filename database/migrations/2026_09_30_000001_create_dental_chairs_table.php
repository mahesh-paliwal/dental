<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_chairs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->string('name', 100); // E.g. 'Chair 1 Main Operatory', 'Chair 2 Surgical & Implants', 'CBCT & OPG Diagnostic Bay'
            $table->enum('chair_type', ['main_operatory', 'surgical_implants', 'diagnostic_bay', 'general'])->default('general');
            $table->string('room_number', 50)->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'inactive'])->default('available');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['clinic_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_chairs');
    }
};
