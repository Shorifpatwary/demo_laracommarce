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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('body'); // Review content
            $table->integer('rating'); // Review rating (e.g., 1 to 5)

            $table->boolean('approved')->default(true);
            $table->boolean('featured')->default(true);

            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
