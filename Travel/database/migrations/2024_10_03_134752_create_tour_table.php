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
            $table->id(); // Tạo trường id tự động tăng
            $table->string('name'); // Tên tour
            $table->string('slug')->unique(); // Thêm cột slug và đặt là duy nhất
            $table->unsignedBigInteger('id_destination'); // ID địa điểm
            $table->text('description'); // Mô tả tour
            $table->decimal('price', 10, 2); // Giá tour
            $table->decimal('price_single_room', 10, 2); // Giá thue phong don
            $table->integer('number_days')->unsigned()->default(1); // Thêm số ngày, mặc định là 1
            $table->string('image_main'); // Ảnh chính
            $table->string('program_code'); // Mã chương trình
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->unsignedBigInteger('id_departure_location'); // ID địa điểm khởi hành
            $table->integer('person')->unsigned()->default(3); // Số người
            $table->timestamps(); // Các trường created_at và updated_at
            $table->fullText('name');
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
