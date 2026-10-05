<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'buyer_sku_code')) {
                $table->string('buyer_sku_code')->nullable()->unique();
            }
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable();
            }
            if (!Schema::hasColumn('products', 'seller_product_status')) {
                $table->boolean('seller_product_status')->default(true);
            }
            if (!Schema::hasColumn('products', 'buyer_product_status')) {
                $table->boolean('buyer_product_status')->default(true);
            }
            if (!Schema::hasColumn('products', 'desc')) {
                $table->text('desc')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['buyer_sku_code', 'category', 'brand', 'seller_product_status', 'buyer_product_status', 'desc']);
        });
    }
};
