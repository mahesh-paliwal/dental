<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->string('file_type', 50); // MIME type (DICOM, PNG, JPEG, PDF)
            $table->unsignedBigInteger('file_size_bytes');
            $table->enum('category', [
                'cbct_3d',            // CBCT scans
                'opg_panoramic',      // OPG Diagnostic Bay
                'rvg_xray',           // Intraoral RVG
                'intraoral_photo',    // Intraoral camera photo
                'treatment_consent',  // Signed consent document
                'other',
            ])->default('cbct_3d');
            $table->string('tooth_number', 10)->nullable();
            $table->text('notes')->nullable();
            $table->foreignUuid('uploaded_by_user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_attachments');
    }
};
