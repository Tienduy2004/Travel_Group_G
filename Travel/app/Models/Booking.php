<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';


    protected $fillable = [
        'tour_id',
        'departure_schedule_id',
        'user_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_address',
        'adult_count',
        'child_count',
        'single_rooms',
        'total_price',
        'amount_paid',
        'note',
        'payment_method',
        'booking_status',
        'booking_code',
    ];


    // Mối quan hệ với Passenger
    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'booking_id', 'id');
    }
    public function paymentOrders()
    {
        return $this->hasMany(paymentOrder::class, 'booking_id', 'id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class);
    }

    // Phương thức lấy danh sách booking theo user_id
    public static function getBookingsByUserId($userId)
    {
        return self::where('user_id', $userId)->with('tour', 'departureSchedule')->get();
    }
    public static function getBookingNewsByUserId($userId)
    {
        // Lấy thời gian 2 ngày trước
        $twoDaysAgo = now()->subDays(2);
        return self::where('user_id', $userId)
        ->where('created_at', '>=', $twoDaysAgo) // Kiểm tra thời gian tạo booking
            ->with('tour', 'departureSchedule')
            ->get();
    }

    public static function findByBookingCode($bookingCode)
    {
        return self::with('passengers', 'tour', 'departureSchedule.flight')
            ->where('booking_code', $bookingCode)
            ->firstOrFail(); // Sử dụng firstOrFail() để lấy booking hoặc throw lỗi 404 nếu không tìm thấy
    }
}
