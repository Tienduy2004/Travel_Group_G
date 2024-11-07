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
        Schema::create('flights', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('flight_code', 10); // Mã chuyến bay
            $table->date('departure_date'); // Ngày đi
            $table->time('departure_time'); // Giờ đi
            $table->time('arrival_time'); // Giờ đến
            $table->string('departure_location', 100); // Điểm khởi hành
            $table->string('arrival_location', 100); // Điểm đến
            $table->string('airline', 50); // Hãng hàng không
            $table->enum('flight_type', ['one_way', 'round_trip']);
            $table->unsignedBigInteger('departure_schedule_id'); // ID của lịch khởi hành
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
