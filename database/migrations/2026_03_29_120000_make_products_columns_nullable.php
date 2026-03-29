<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Allow null so draft products can be created before multi-step form is completed
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_category_id']);
            $table->dropForeign(['ar_eu_id']);

            $table->foreignId('category_id')->nullable()->change()->constrained()->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->change()->constrained()->nullOnDelete();
            $table->foreignId('ar_eu_id')->nullable()->change()->constrained('ar_addresses')->nullOnDelete();

            $table->string('name')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('intended_use')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_category_id']);
            $table->dropForeign(['ar_eu_id']);

            $table->foreignId('category_id')->nullable(false)->change()->constrained()->cascadeOnDelete();
            $table->foreignId('product_category_id')->nullable(false)->change()->constrained()->cascadeOnDelete();
            $table->foreignId('ar_eu_id')->nullable(false)->change()->constrained('ar_addresses')->cascadeOnDelete();

            $table->string('name')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->text('intended_use')->nullable(false)->change();
        });
    }
};
