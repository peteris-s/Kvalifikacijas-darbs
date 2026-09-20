<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * STOCK RECEIPTS
         *
         * Iepriekš product_id bija ar cascadeOnDelete().
         * Tagad datubāze neļaus izdzēst preci,
         * ja tai eksistē preču saņemšanas vēsture.
         */
        Schema::table('stock_receipts', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->restrictOnDelete();
        });


        /*
         * INVENTORY ADJUSTMENTS
         *
         * Arī inventarizācijas vēsture tiek aizsargāta.
         */
        Schema::table('inventory_adjustments', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        /*
         * Atgriežam stock_receipts uz iepriekšējo
         * cascadeOnDelete() uzvedību.
         */
        Schema::table('stock_receipts', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });


        /*
         * Atgriežam inventory_adjustments uz iepriekšējo
         * cascadeOnDelete() uzvedību.
         */
        Schema::table('inventory_adjustments', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }
};