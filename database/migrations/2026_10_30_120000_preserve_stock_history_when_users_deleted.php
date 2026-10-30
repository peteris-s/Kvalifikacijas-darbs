<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'stock_receipts',
        'stock_issues',
        'inventory_adjustments',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Restoring a non-nullable column is unsafe if any user has been deleted.
        // Deliberately do not restore cascading deletion of audit history.
        throw new \RuntimeException('Rollback is intentionally disabled: restoring the old user_id constraints could destroy historical data or fail on NULL values.');
    }
};
