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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login', 150);
            $table->string('password', 250);
            $table->string('surname', 150);
            $table->string('name', 150);
            $table->string('user_email', 150);
            $table->string('user_phone', 20);
            $table->string('user_address', 250);
            $table->foreignId('user_id') ->constrained('roles', 'role_') ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
