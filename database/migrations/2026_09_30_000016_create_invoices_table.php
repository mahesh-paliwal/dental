<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('clinic_id')->constrained('clinics')->restrictOnDelete();
            $table->foreignUuid('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->string('invoice_number', 50)->unique(); // E.g. 'INV-2026-0812'
            $table->date('invoice_date');
            $table->decimal('standard_rate', 10, 2)->default(0.00); // Standard Clinic Rate (₹)
            $table->decimal('privilege_discount', 10, 2)->default(0.00); // Privilege Discount (₹)
            $table->decimal('taxable_amount', 10, 2)->default(0.00); // Standard Rate - Privilege Discount
            $table->decimal('cgst_rate', 5, 2)->default(0.00);
            $table->decimal('cgst_amount', 10, 2)->default(0.00);
            $table->decimal('sgst_rate', 5, 2)->default(0.00);
            $table->decimal('sgst_amount', 10, 2)->default(0.00);
            $table->decimal('igst_rate', 5, 2)->default(0.00);
            $table->decimal('igst_amount', 10, 2)->default(0.00);
            $table->decimal('net_payable', 10, 2)->default(0.00); // Live Net Payable (₹)
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('balance_due', 10, 2)->default(0.00);
            $table->enum('payment_mode', [
                'upi_phonepe_gpay',
                'cash',
                'card',
                'bajaj_finserv_emi',
                'net_banking',
            ])->default('upi_phonepe_gpay');
            $table->enum('status', ['paid', 'partially_paid', 'unpaid', 'void'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'status']);
            $table->index(['invoice_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
