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
        return $this->hasMany(DepartureSchedule::class, 'tour_id', 'id');
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
        return $this->departureSchedules()
            ->where('date', '>', now()->addDay()) // Lọc lịch khởi hành từ ngày mai trở đi
            ->where('seat_number', '>', 0)
            ->orderBy('price')             // Sắp xếp theo giá từ thấp đến cao
            ->first();
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tour_id', 'id');
    }

    public static function getLatestTours($limit)
    {
        return self::latest()->take($limit)->get(); // Lấy 6 tour mới nhất theo thứ tự thời gian tạo
    }

    public function upcomingDepartureSchedules()
    {
        return $this->departureSchedules()
            ->where('date', '>', now()->addDay())
            ->where('seat_number', '>', 0)
            ->get();
    }

    // Phương thức để lấy tour đang hoạt động cùng với điểm đến
    public static function getActiveToursWithDestination($perPage = 6)
    {
        return self::with('destination') // Kết nối với model Destination
            ->where('is_active', true)    // Lọc tour đang hoạt động
            ->paginate($perPage);          // Phân trang với số bản ghi tùy chọn
    }

    // Hàm tìm kiếm tour theo các tiêu chí
    public static function search($keyword, $date, $budget)
    {
        return self::with('destination', 'departureSchedules')
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$keyword])
                    ->orWhereHas('destination', function ($query) use ($keyword) {
                        $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$keyword]);
                    });
            })
            ->when($date, function ($query) use ($date) {
                $query->whereHas('departureSchedules', function ($query) use ($date) {
                    $query->whereDate('date', $date);
                });
            })
            ->when($budget, function ($query) use ($budget) {
                $query->whereHas('departureSchedules', function ($query) use ($budget) {
                    if ($budget->min_price !== null && $budget->max_price !== null) {
                        $query->whereBetween('price', [$budget->min_price, $budget->max_price])
                            ->where('seat_number', '>', 0)
                            ->where('date', '>', now()->addDay());
                    } elseif ($budget->min_price !== null) {
                        $query->where('price', '>=', $budget->min_price)
                            ->where('seat_number', '>', 0)
                            ->where('date', '>', now()->addDay());
                    }
                });
            })
            ->whereHas('departureSchedules', function ($query) {
                $query->where('seat_number', '>', 0)
                    ->where('date', '>', now()->addDay());
            })
            ->get();
    }

    public static function findBySlugOrFail($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
