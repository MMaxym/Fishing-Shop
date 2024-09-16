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
            $table->id('product_ID');
            $table->foreignId('product_category_id')->constrained('categories', 'category_ID')->onDelete('cascade');
            $table->foreignId('discount_id')->nullable()->constrained('discounts', 'discount_ID')->onDelete('set null');
            $table->string('product_article', 100);
            $table->string('product_name', 100);
            $table->string('product_description', 350);
            $table->string('product_size', 100)->nullable();
            $table->string('product_other', 150)->nullable();
            $table->string('product_image', 300)->nullable();
            $table->integer('product_quantity');
            $table->decimal('product_price', 10, 2);
            $table->boolean('is_active')->default(true);
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
