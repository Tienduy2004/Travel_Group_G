<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    use HasFactory;
     // Tên bảng
     protected $table = 'payment_orders';

     // Các thuộc tính có thể gán trực tiếp
     protected $fillable = [
         'booking_id',
     ];
 
     // Quan hệ với bảng `bookings`
     public function booking()
     {
         return $this->belongsTo(Booking::class);
     }
}
