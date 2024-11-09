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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained(); // Tạo quan hệ với bảng conversations
            $table->foreignId('sender_id')->constrained('users'); // Quan hệ với người gửi
            $table->foreignId('receiver_id')->constrained('users'); // Quan hệ với người nhận
            $table->text('content'); // Nội dung tin nhắn
            $table->timestamp('read_at')->nullable(); // Thời gian tin nhắn được đọc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
