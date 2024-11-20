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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // Mã khuyến mãi
            $table->text('description')->nullable(); // Mô tả khuyến mãi
            $table->datetime('start_date'); // Ngày bắt đầu (bao gồm cả giờ)
            $table->datetime('end_date'); // Ngày kết thúc (bao gồm cả giờ)
            $table->integer('discount_percentage'); // Giảm bao nhiêu phần trăm
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
