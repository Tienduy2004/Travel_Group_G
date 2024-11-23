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

    // Phương thức tạo booking
    public static function storeBooking($tourId, $departureScheduleId, $userId, $hoTen, $email, $dienThoai, 
        $diaChi, $adultCount, $childCount, $singleRooms, $total_price, $note, $paymentMethod, $bookingCode)
    {
        // Tạo booking mới
        return self::create([
            'tour_id' => $tourId,
            'departure_schedule_id' => $departureScheduleId,
            'user_id' => $userId,
            'contact_name' => $hoTen,
            'contact_email' => $email,
            'contact_phone' => $dienThoai,
            'contact_address' => $diaChi,
            'adult_count' => $adultCount,
            'child_count' => $childCount,
            'single_rooms' => count($singleRooms),
            'total_price' => $total_price,
            'note' => $note,
            'payment_method' => $paymentMethod,
            'amount_paid' => 0,
            'booking_code' => $bookingCode,
        ]);
    }

    // Phương thức lưu thông tin hành khách lớn
    public function storeAdultPassengers($bookingId, $passengerNames_Adult, $passengerBirthdates_Adult, $passengerGenders_Adult, $singleRooms)
    {
        foreach ($passengerNames_Adult as $index => $name) {
            Passenger::create([
                'booking_id' => $bookingId,
                'name' => $name,
                'birthdate' => isset($passengerBirthdates_Adult[$index]) ? $passengerBirthdates_Adult[$index] : null,
                'gender' => isset($passengerGenders_Adult[$index]) ? $passengerGenders_Adult[$index] : null,
                'single_room' => isset($singleRooms[$index]) ? (bool)$singleRooms[$index] : false,
                'passenger_type' => 'adult',
            ]);
        }
    }

    // Phương thức lưu thông tin hành khách trẻ em
    public function storeChildPassengers($bookingId, $passengerNames_Child, $passengerBirthdates_Child, $passengerGenders_Child)
    {
        if (!empty($passengerNames_Child)) {
            foreach ($passengerNames_Child as $index => $name) {
                Passenger::create([
                    'booking_id' => $bookingId,
                    'name' => $name,
                    'birthdate' => isset($passengerBirthdates_Child[$index]) ? $passengerBirthdates_Child[$index] : null,
                    'gender' => isset($passengerGenders_Child[$index]) ? $passengerGenders_Child[$index] : null,
                    'single_room' => false,
                    'passenger_type' => 'child',
                ]);
            }
        }
    }
}
