<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    // Khai báo bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'tour'; // Đặt tên bảng nếu khác tên mặc định

    // Các thuộc tính có thể gán
    protected $fillable = [
        'ma_tour',
        'name',
        'id_destination',
        'days',
        'person',
        'price',
        'id_image',
        'image_main',
        'id_itinerary',
        'id_trip_information',
        'id_important_information',
        'id_departure_schedule',
    ];

    // Định nghĩa các quan hệ với các model khác
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'id_destination');
    }

    public function imageTour()
    {
        return $this->belongsTo(ImageTour::class, 'id_image');
    }

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class, 'id_itinerary');
    }

    public function tripInformation()
    {
        return $this->belongsTo(TripInformation::class, 'id_trip_information');
    }

    public function importantInformation()
    {
        return $this->belongsTo(ImportantInformation::class, 'id_important_information');
    }

    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class, 'id_departure_schedule');
    }
}
