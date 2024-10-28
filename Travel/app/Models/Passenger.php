<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    // Định nghĩa bảng tương ứng
    protected $table = 'passengers';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'birthdate',
        'gender',
        'booking_id',
        'passenger_type',
    ];

    // Mối quan hệ với Booking (nếu cần)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
