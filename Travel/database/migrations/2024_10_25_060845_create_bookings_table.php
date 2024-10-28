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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính tự động tăng
            $table->unsignedBigInteger('tour_id'); // ID của tour được đặt
            $table->unsignedBigInteger('departure_schedule_id'); // ID của lịch khởi hành
            $table->unsignedBigInteger('user_id'); // ID của lịch khởi hành
            $table->string('contact_name', 50); // Tên khách hàng
            $table->string('contact_email'); // Email khách hàng
            $table->string('contact_phone', 15); // Số điện thoại khách hàng
            $table->string('contact_address')->nullable(); // Địa chỉ khách hàng (có thể null)
            $table->integer('adult_count')->default(1); // Số lượng người lớn
            $table->integer('child_count')->default(0); // Số lượng trẻ em
            $table->integer('single_rooms')->default(0);
            $table->decimal('total_price', 15, 2); // Tổng giá trị đặt tour
            $table->text('note')->nullable(); // Ghi chú (có thể null)
            $table->enum('payment_method', ['cash', 'transfer']); // Phương thức thanh toán
            $table->enum('booking_status', ['pending', 'confirmed', 'canceled'])->default('pending'); // Trạng thái đặt tour
            $table->timestamps(); // Thời gian tạo và cập nhật (created_at và updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
