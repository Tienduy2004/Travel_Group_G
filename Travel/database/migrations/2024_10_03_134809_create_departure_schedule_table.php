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
        Schema::create('departure_schedule', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_day');
            $table->dateTime('end_day');
            $table->string('time')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('ma_tour');
            $table->string('depart')->nullable();
            $table->float('price')->nullable();
        
            $table->foreign('ma_tour')->references('ma_tour')->on('tour');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_schedule');
    }
};
