<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_procedures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('procedure_categories')->restrictOnDelete();
            $table->string('code', 50)->unique(); // Internal code or ADA code
            $table->string('name', 200); // E.g. 'Single Sitting RCT', 'Titanium Implant Placement', 'GBT Full Mouth Scaling', 'Zirconia Crown'
            $table->text('description')->nullable();
            $table->decimal('standard_rate', 10, 2)->default(4500.00); // Standard Clinic Pricing (₹)
            $table->unsignedInteger('sitting_duration_minutes')->default(45); // Sitting duration
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_procedures');
    }
};
