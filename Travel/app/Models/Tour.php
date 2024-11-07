<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    // Khai báo bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'tour'; // Đặt tên bảng nếu khác tên mặc định

    protected $fillable = [
        'name',                // Tên tour
        'id_destination',      // ID điểm đến (không ràng buộc khóa ngoại)
        'description',         // Mô tả chi tiết về tour
        'price',               // Giá gốc của tour
        'number_days',         // Số ngày 1 tour
        'discount_price',      // Giá sau khi giảm (nếu có)
        'image_main',          // Ảnh chính của tour
        'program_code',        // Mã chương trình của tour
        'is_active',           // Trạng thái hoạt động của tour
        'id_departure_location', // ID điểm khởi hành
        'person',              // Số người
    ];

    // Định nghĩa các quan hệ với các model khác
    public function images()
    {
        return $this->hasMany(ImageTour::class, 'tour_id', 'id');
    }

    public function departureSchedules()
    {
        return $this->hasMany(DepartureSchedule::class, 'tour_id', 'id');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'tour_id', 'id');
    }

    // Định nghĩa mối quan hệ với DepartureLocation
    public function departureLocation()
    {
        return $this->belongsTo(DepartureLocation::class, 'id_departure_location');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'id_destination');
    }
}
