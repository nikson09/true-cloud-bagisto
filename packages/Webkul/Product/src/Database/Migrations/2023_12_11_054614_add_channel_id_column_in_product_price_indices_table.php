<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tablePrefix = DB::getTablePrefix();
        $tableName = $tablePrefix . 'product_price_indices';

        // Check if foreign key constraints exist before dropping them
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_NAME IN (?, ?)
        ", [$tableName, $tablePrefix.'product_price_indices_product_id_foreign', $tablePrefix.'product_price_indices_customer_group_id_foreign']);

        $existingForeignKeys = array_column($foreignKeys, 'CONSTRAINT_NAME');

        // Check if unique constraint exists
        $uniqueConstraints = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_TYPE = 'UNIQUE' 
            AND CONSTRAINT_NAME = ?
        ", [$tableName, $tablePrefix.'product_price_indices_product_id_customer_group_id_unique']);

        $hasUniqueConstraint = !empty($uniqueConstraints);

        Schema::table('product_price_indices', function (Blueprint $table) use ($tablePrefix, $existingForeignKeys, $hasUniqueConstraint) {
            // Only drop foreign keys if they exist
            if (in_array($tablePrefix.'product_price_indices_product_id_foreign', $existingForeignKeys)) {
                $table->dropForeign($tablePrefix.'product_price_indices_product_id_foreign');
            }
            if (in_array($tablePrefix.'product_price_indices_customer_group_id_foreign', $existingForeignKeys)) {
                $table->dropForeign($tablePrefix.'product_price_indices_customer_group_id_foreign');
            }
            
            // Only drop unique constraint if it exists
            if ($hasUniqueConstraint) {
                $table->dropUnique($tablePrefix.'product_price_indices_product_id_customer_group_id_unique');
            }

            $table->integer('channel_id')->unsigned()->default(1)->after('customer_group_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('customer_group_id')->references('id')->on('customer_groups')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');

            $table->unique(['product_id', 'customer_group_id', 'channel_id'], 'price_indices_product_id_customer_group_id_channel_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tablePrefix = DB::getTablePrefix();
        $tableName = $tablePrefix . 'product_price_indices';

        // Check if foreign key constraints exist before dropping them
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_NAME IN (?, ?, ?)
        ", [$tableName, 'product_price_indices_product_id_foreign', 'product_price_indices_customer_group_id_foreign', 'product_price_indices_channel_id_foreign']);

        $existingForeignKeys = array_column($foreignKeys, 'CONSTRAINT_NAME');

        // Check if unique constraint exists
        $uniqueConstraints = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_TYPE = 'UNIQUE' 
            AND CONSTRAINT_NAME = ?
        ", [$tableName, 'price_indices_product_id_customer_group_id_channel_id_unique']);

        $hasUniqueConstraint = !empty($uniqueConstraints);

        Schema::table('product_price_indices', function (Blueprint $table) use ($tablePrefix, $existingForeignKeys, $hasUniqueConstraint) {
            // Only drop foreign keys if they exist
            if (in_array('product_price_indices_product_id_foreign', $existingForeignKeys)) {
                $table->dropForeign(['product_id']);
            }
            if (in_array('product_price_indices_customer_group_id_foreign', $existingForeignKeys)) {
                $table->dropForeign(['customer_group_id']);
            }
            if (in_array('product_price_indices_channel_id_foreign', $existingForeignKeys)) {
                $table->dropForeign(['channel_id']);
            }
            
            // Only drop unique constraint if it exists
            if ($hasUniqueConstraint) {
                $table->dropUnique('price_indices_product_id_customer_group_id_channel_id_unique');
            }

            $table->foreign('customer_group_id', $tablePrefix.'product_price_indices_customer_group_id_foreign')->references('id')->on('customer_groups');
            $table->foreign('product_id', $tablePrefix.'product_price_indices_product_id_foreign')->references('id')->on('products');
            $table->unique(['product_id', 'customer_group_id'], $tablePrefix.'product_price_indices_product_id_customer_group_id_unique');
            $table->dropColumn('channel_id');
        });
    }
};
