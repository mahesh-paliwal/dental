<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->string('item_name', 200); // E.g. 'AirFlow PLUS Powder (GBT)', 'Zirconia Blocks', 'Composite Syringes'
            $table->string('sku', 100)->unique();
            $table->string('category', 100)->default('Clinical Consumables');
            $table->string('unit', 50)->default('box');
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_alert_threshold')->default(10);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
