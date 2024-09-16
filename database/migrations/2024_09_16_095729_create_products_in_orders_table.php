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
        Schema::create('products_in_orders', function (Blueprint $table) {
            $table->id('products_in_orders_ID');
            $table->foreignId('product_ID')->constrained('products', 'product_id')->onDelete('cascade');
            $table->foreignId('order_ID')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('size', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_in_orders');
    }
};
