<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code');
            $table->string('unit')->nullable();
            $table->string('tags')->nullable();
            $table->string('video')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('selling_price')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('stock_quantity')->nullable();
            $table->integer('warehouse')->nullable();
            $table->string('description');
            $table->string('thumbnail')->nullable();
            $table->string('images')->nullable();
            $table->boolean('featured')->nullable();
            $table->boolean('today_deal')->nullable();
            $table->integer('status')->nullable();
            $table->integer('flash_deal_id')->nullable();
            $table->boolean('cash_on_delivery')->nullable();

            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
