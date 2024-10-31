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
            $table->id();
            $table->string('name'); 
            $table->unsignedBigInteger('id_destination');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('number_days')->unsigned()->default(1);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('image_main');
            $table->string('program_code');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('id_departure_location');
            $table->integer('person')->unsigned()->default(3);
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
