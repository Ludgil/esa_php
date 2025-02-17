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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->time('start_hour');
            $table->time('end_hour');
            $table->float('price');
            $table->integer('number_of_people');
            $table->unsignedBigInteger('week_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('appointment_date');
            $table->boolean('billed')->default(false);
            $table->timestamps();

            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
