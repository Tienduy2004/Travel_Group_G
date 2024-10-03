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
        Schema::create('vehicle_information_end', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ma_vehicle_information');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('starting_point')->nullable();
            $table->string('destination')->nullable();
            $table->time('time_start')->nullable();
            $table->time('end_time')->nullable();
        
            $table->foreign('ma_vehicle_information')->references('ma_vehicle_information')->on('vehicle_information');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_information_end');
    }
};
