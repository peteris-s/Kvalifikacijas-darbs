<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_order_items', function (Blueprint $table) {
            $table->id();

            // Pasūtījums
            $table->foreignId('customer_order_id')
                ->constrained('customer_orders')
                ->cascadeOnDelete();

            // Pasūtītā prece
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Pasūtītais daudzums
            $table->unsignedInteger('quantity');

            $table->timestamps();

            // Viena un tā pati prece vienā pasūtījumā
            // nevar būt pievienota vairākas reizes.
            $table->unique([
                'customer_order_id',
                'product_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_order_items');
    }
};