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
        Schema::create('pony_weeks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pony_id');
            $table->unsignedBigInteger('week_id');
            $table->integer('max_work_hours')->default(0);
            $table->integer('assigned_hours')->default(0);
            $table->timestamps();

            $table->foreign('pony_id')->references('id')->on('ponies')->onDelete('cascade');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade');

            $table->unique(['pony_id', 'week_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pony_weeks');
    }
};
