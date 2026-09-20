<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();

            // Pasūtījuma numurs no interneta veikala
            $table->string('order_number')->unique();

            // Pasūtījuma statuss
            $table->string('status')->default('pending');

            // Kad pasūtījums tika veikts
            $table->dateTime('ordered_at');

            // Papildu informācija
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};