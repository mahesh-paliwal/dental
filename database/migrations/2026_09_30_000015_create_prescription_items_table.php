<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('prescription_id')->constrained('prescriptions')->cascadeOnDelete();
            $table->string('medication_name', 200); // E.g. 'Augmentin 625mg', 'Ketorol DT'
            $table->string('dosage', 100);          // E.g. '1 tab'
            $table->string('frequency', 100);       // E.g. 'Twice daily (BD)', 'Thrice daily (TDS)'
            $table->string('duration', 100);        // E.g. '5 days'
            $table->string('instructions', 255)->nullable(); // E.g. 'After food'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
