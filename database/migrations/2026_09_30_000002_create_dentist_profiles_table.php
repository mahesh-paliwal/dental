<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dentist_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('license_number', 100)->nullable()->unique();
            $table->string('designation', 100)->default('Dentist'); // E.g. 'Chief Dentist', 'Implantologist', 'Orthodontist'
            $table->enum('specialization', [
                'chief_dentist',
                'implantologist',
                'orthodontist',
                'endodontist',
                'periodontist',
                'prosthodontist',
                'oral_surgeon',
                'general_dentist',
            ])->default('general_dentist');
            $table->string('qualification', 255)->default('BDS');
            $table->text('bio')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(500.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dentist_profiles');
    }
};
