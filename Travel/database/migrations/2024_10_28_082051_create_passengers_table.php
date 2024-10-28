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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính tự động tăng
            $table->string('name', 50); // Tên hành khách
            $table->date('birthdate'); // Ngày Sinh
            $table->enum('gender', ['Nam', 'Nữ']); // Giới tính (có thể null)
            $table->enum('passenger_type', ['adult', 'child']); // Loại hành khách (người lớn hoặc trẻ em)
            $table->unsignedBigInteger('booking_id'); // ID của booking liên quan
            $table->timestamps(); // Thời gian tạo và cập nhật (created_at và updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
