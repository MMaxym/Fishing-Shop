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
            $table->id('order_ID');
            $table->foreignId('user_ID')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('payment_method_ID')->constrained('payment_methods', 'payment_method_id')->onDelete('set null');
            $table->foreignId('shipping_method_ID')->constrained('shipping_methods', 'shipping_method_id')->onDelete('set null');
            $table->foreignId('discount_ID')->nullable()->constrained('discounts', 'discount_id')->onDelete('set null');
            $table->string('address', 250);
            $table->decimal('total_amount', 10, 2);
            $table->string('order_status', 50)->default('Створено');
            $table->date('created_at');
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
