<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

        'price_single_room',
        'number_days',          // Số ngày 1 tour
        'image_main',          // Ảnh chính của tour
        'program_code',        // Mã chương trình của tour
        'is_active',           // Trạng thái hoạt động của tour
        'id_departure_location',
        'person',
        'slug',
    ];

    // Tạo sự kiện để tự động tạo slug khi thêm tour mới
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            $tour->slug = self::createUniqueSlug($tour->name);
        });
    }

    // Hàm để tạo slug duy nhất
    public static function createUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = self::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    // Định nghĩa các quan hệ với các model khác
    public function images()
    {
        return $this->hasMany(ImageTour::class, 'tour_id', 'id');
    }

    public function departureSchedules()
    {
        return $this->hasMany(DepartureSchedule::class, 'tour_id', 'id')->orderBy('price');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'tour_id', 'id');
    }

    public function importantInfos()
    {
        return $this->hasMany(ImportantInformation::class, 'tour_id', 'id');
    }

    public function tripInformations()
    {
        return $this->hasMany(TripInformation::class, 'tour_id', 'id');
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

    // Lấy các tour gợi ý, ngoại trừ tour hiện tại
    public function suggestedTours($limit = 3)
    {
        return self::where('id', '!=', $this->id)->take($limit)->get();
    }

    // Lấy lịch khởi hành có giá thấp nhất
    public function minPriceSchedule()
    {
        return $this->departureSchedules()->orderBy('price')->first();
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
