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
        Schema::create('trip_information', function (Blueprint $table) {
            $table->id(); // Tạo trường id tự động tăng
            $table->unsignedBigInteger('id_trip_directory'); // ID tour
            $table->text('content'); // Nội dung
            $table->unsignedBigInteger('tour_id'); // ID tour
            $table->timestamps(); // Các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_information');
    }
};
