<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DepartureSchedule;
use App\Models\Passenger;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use \Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {

        // Lấy thông tin từ yêu cầu
        $hoTen = $request->input('hoTen_contact');
        $dienThoai = $request->input('dienThoai_contact');
        $email = $request->input('email_contact');
        $diaChi = $request->input('diaChi_contact');
        $adultCount = $request->input('adultCount', 1); // Mặc định là 1 nếu không có input
        $childCount = $request->input('childCount', 0); // Mặc định là 0 nếu không có input
        $passengerNames_Adult = $request->input('passengerName_Adult'); // Mảng chứa tên hành khách
        $passengerBirthdates_Adult = $request->input('passengerBirthdate_Adult', []); // Mảng chứa ngày sinh
        $passengerGenders_Adult = $request->input('passengerGender_Adult', []); // Mảng chứa giới tính
        $passengerNames_Child = $request->input('passengerName_Child'); // Mảng chứa tên hành khách
        $passengerBirthdates_Child = $request->input('passengerBirthdate_Child', []); // Mảng chứa ngày sinh
        $passengerGenders_Child = $request->input('passengerGender_Child', []); // Mảng chứa giới tính
        $singleRooms = $request->input('singleRoom', []); // Số lượng phòng đơn
        $note = $request->input('note', null); // Ghi chú
        $paymentMethod = $request->input('paymentMethod');
        $tourId = decrypt($request->input('tour_id'));
        $departureScheduleId = decrypt($request->input('departure_schedule_id'));
        $total_price = (float)$request->input('total_price');

        // Thêm các trường khác nếu cần
        // dd(
        //     $hoTen,
        //     $dienThoai,
        //     $email,
        //     $diaChi,
        //     $adultCount,
        //     $childCount,
        //     $passengerNames_Adult,
        //     $passengerBirthdates_Adult,
        //     $passengerGenders_Adult,
        //     $passengerNames_Child,
        //     $passengerBirthdates_Child,
        //     $passengerGenders_Child,
        //     count($singleRooms),
        //     $note,
        //     $paymentMethod,
        //     $tourId,
        //     $departureScheduleId,
        //     $total_price
        // );


        $userId = Auth::user()->id;

        // Tạo mã đặt chỗ
        $bookingCode = $this->generateBookingCode();

        // Tạo một booking mới

        $booking = Booking::create([
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

        // Lưu thông tin hành khách lớn
        foreach ($passengerNames_Adult as $index => $name) {
            Passenger::create([
                'booking_id' => $booking->id,
                'name' => $name,
                'birthdate' => isset($passengerBirthdates_Adult[$index]) ? $passengerBirthdates_Adult[$index] : null,
                'gender' => isset($passengerGenders_Adult[$index]) ? $passengerGenders_Adult[$index] : null,
                'single_room' => isset($singleRooms[$index]) ? (bool)$singleRooms[$index] : false,
                'passenger_type' => 'adult',
            ]);
        }

        // Lưu thông tin hành khách trẻ em
        if (!empty($passengerNames_Child)) {
            foreach ($passengerNames_Child as $index => $name) {
                Passenger::create([
                    'booking_id' => $booking->id,
                    'name' => $name,
                    'birthdate' => isset($passengerBirthdates_Child[$index]) ? $passengerBirthdates_Child[$index] : null,
                    'gender' => isset($passengerGenders_Child[$index]) ? $passengerGenders_Child[$index] : null,
                    'single_room' => false,
                    'passenger_type' => 'child',
                ]);
            }
        }

        // Giảm số lượng ghế trong lịch khởi hành
        $departureSchedule = DepartureSchedule::findOrFail($departureScheduleId);
        $totalPassengers = $adultCount + $childCount; // Tổng số hành khách
        if ($departureSchedule->seat_number >= $totalPassengers) {
            $departureSchedule->seat_number -= $totalPassengers;
            $departureSchedule->save();
        } else {
            return redirect()->back()->withErrors(['error' => 'Không đủ số ghế để đặt.']);
        }

        // Chuyển hướng đến trang thanh toán với booking_id
        return redirect()->route('booking.payment', ['bookingCode' => $booking->booking_code]);
    }

    protected function generateBookingCode()
    {
        $date = now()->format('ymd'); // Lấy ngày theo định dạng YYMMDD
        $randomString = strtoupper(Str::random(5)); // Tạo chuỗi ngẫu nhiên 5 ký tự
        $bookingCode = $date . $randomString; // Kết hợp ngày và chuỗi ngẫu nhiên

        // Kiểm tra sự duy nhất của mã
        while (Booking::where('booking_code', $bookingCode)->exists()) {
            $randomString = strtoupper(Str::random(5)); // Tạo lại chuỗi ngẫu nhiên
            $bookingCode = $date . $randomString; // Kết hợp lại
        }

        return $bookingCode;
    }

    public function cancel(Request $request)
    {
        // Kiểm tra xem booking đã tồn tại
        $booking = Booking::findOrFail($request->booking_id);
        $booking->update([
            'booking_status' => 'canceled',
            'note' => 'Khách hàng đã hủy chuyến đi vào ngày: ' . now()->format('d/m/Y H:i:s'), // Định dạng thời gian
            'total_price' => 0,
        ]);
        
        // Giảm số lượng ghế trong lịch khởi hành
        $departureSchedule = DepartureSchedule::findOrFail($booking->departure_schedule_id);
        $totalPassengers = $booking->adult_count + $booking->child_count; // Tổng số hành khách
        $departureSchedule->seat_number += $totalPassengers;
        $departureSchedule->save();

        return redirect()->back()->with('success', 'Bạn đã hủy chuyến đi du lịch thành công.');
    }
}
