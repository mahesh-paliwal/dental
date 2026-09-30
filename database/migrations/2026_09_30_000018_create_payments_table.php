<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignUuid('patient_id')->constrained('patients')->restrictOnDelete();
            $table->string('receipt_number', 50)->unique(); // Official clinic receipt number
            $table->decimal('amount', 10, 2);
            $table->enum('payment_mode', [
                'upi_phonepe_gpay',
                'cash',
                'card',
                'bajaj_finserv_emi',
                'net_banking',
            ]);
            $table->string('transaction_reference', 150)->nullable(); // UPI reference or card auth
            $table->dateTime('payment_date');
            $table->foreignUuid('received_by_user_id')->constrained('users')->restrictOnDelete(); // E.g. Pooja (Front Desk)
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['invoice_id', 'payment_date']);
            $table->index(['patient_id', 'payment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
