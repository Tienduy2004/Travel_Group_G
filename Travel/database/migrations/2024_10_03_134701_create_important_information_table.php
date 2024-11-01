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
        Schema::create('important_information', function (Blueprint $table) {
            $table->id(); // Tạo trường id tự động tăng
            $table->unsignedBigInteger('tour_id'); // ID tour
            $table->string('title'); // Tiêu đề thông tin
            $table->text('information'); // Thông tin quan trọng
            $table->timestamps(); // Các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('important_information');
    }
};
