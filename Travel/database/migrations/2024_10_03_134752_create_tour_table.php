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
        Schema::create('tour', function (Blueprint $table) {
            $table->string('ma_tour')->primary();
            $table->string('name');
            $table->unsignedBigInteger('id_destination')->nullable();
            $table->integer('days')->nullable();
            $table->integer('person')->nullable();
            $table->float('price')->nullable();
            $table->unsignedBigInteger('id_image')->nullable();
            $table->text('image_main')->nullable();
            $table->unsignedInteger('id_itinerary')->nullable();
            $table->unsignedInteger('id_trip_information')->nullable();
            $table->unsignedInteger('id_important_information')->nullable();
            $table->unsignedBigInteger('id_departure_schedule')->nullable();
        
            $table->foreign('id_destination')->references('id')->on('destination');
            $table->foreign('id_image')->references('id_image')->on('image_tour');
            $table->foreign('id_itinerary')->references('id_itinerary')->on('itineraty');
            $table->foreign('id_trip_information')->references('id_trip_information')->on('trip_information');
            $table->foreign('id_important_information')->references('id_important_information')->on('important_information');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour');
    }
};
