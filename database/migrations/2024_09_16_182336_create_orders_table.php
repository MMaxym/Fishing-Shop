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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('shipping_method_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('discount_id')->nullable()->constrained()->onDelete('set null');
            $table->string('address');
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 50)->default('Створено');
            $table->timestamp('created')->default(now());
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