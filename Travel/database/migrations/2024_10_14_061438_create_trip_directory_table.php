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
        Schema::create('trip_directory', function (Blueprint $table) {
            $table->id(); // Trường id tự động tăng
            $table->string('icon')->nullable(); // Biểu tượng đại diện
            $table->string('title'); // Tiêu đề thông tin
            $table->timestamps(); // Các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_directory');
    }
};
