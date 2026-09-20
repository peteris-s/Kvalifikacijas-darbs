<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->id();

            // Pasūtījuma numurs no interneta veikala
            $table->string('order_number');

            // Izsniegtā prece
            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            // Darbinieks, kurš veica izsniegšanu
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            // Izsniegtais daudzums
            $table->unsignedInteger('quantity');

            // Papildu piezīmes
            $table->text('notes')->nullable();

            // Kad prece tika izsniegta
            $table->dateTime('issued_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_issues');
    }
};