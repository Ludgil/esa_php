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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 100)->nullable(); 
            $table->string('street', 100)->nullable(); 
            $table->string('number', 10)->nullable();
            $table->string('postal_code', 10)->nullable(); 
            $table->string('city', 50)->nullable(); 
            $table->string('phone', 20)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
