<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->foreignId('warehouse_location_id')
                ->nullable()
                ->after('category_id')
                ->constrained('warehouse_locations')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropForeign([
                'warehouse_location_id'
            ]);

            $table->dropColumn(
                'warehouse_location_id'
            );

        });
    }
};