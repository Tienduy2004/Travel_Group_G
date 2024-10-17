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
            $table->id(); // Tạo trường id tự động tăng
            $table->unsignedBigInteger('tour_id'); // ID tour
            $table->date('date'); // Ngày khởi hành
            $table->decimal('price', 10, 2); // Giá tại thời điểm khởi hành
            $table->integer('seat_number')->default(0); // Số ghế 
            $table->timestamps(); // Các trường created_at và updated_at
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
