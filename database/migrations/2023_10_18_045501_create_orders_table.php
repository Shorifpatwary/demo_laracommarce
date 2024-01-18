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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('note')->nullable();
            $table->integer('total_price');
            // orde status
            $table->enum(
                'status',
                [
                    'initiated',
                    'completed',
                    'processing',
                    'shipped',
                    'delivered',
                    'canceled',
                    'refunded',
                    'pending payment',
                    'payment received',
                    'out for delivery',
                    'expired',
                    'on-hold',
                    'backordered',
                    'returned',
                    'partially shipped',
                    'awaiting fulfillment',
                    'fraud detected',
                    'pending approval',
                    'on backorder',
                ]
            )->default('pending payment');
            // table foraign relation .  
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            // Foreign key for shipping address
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_addresses')->cascadeOnDelete();

            // Foreign key for billing address
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
