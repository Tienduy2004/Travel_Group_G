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
        $validated = $request->validate([
            'hoTen_contact' => 'required|string|max:50|regex:/^[a-zA-ZÀ-ỹ\s]*$/u',
            'dienThoai_contact' => 'required|regex:/^(0)[0-9]{9}$/',
            'email_contact' => 'required|email|max:255',
            'diaChi_contact' => 'nullable|string|max:100',
            'passengerName_Adult.*' => 'required|string|max:50|regex:/^[a-zA-ZÀ-ỹ\s]*$/u',
            'passengerBirthdate_Adult.*' => 'required|date_format:Y-m-d',
            'passengerName_Child.*' => 'required|string|max:50|regex:/^[a-zA-ZÀ-ỹ\s]*$/u',
            'passengerBirthdate_Child.*' => 'required|date_format:Y-m-d',
            'note' => 'nullable|string|max:200',
        ], [
            'hoTen_contact.max' => 'Họ tên không được vượt quá 50 ký tự.',
            'hoTen_contact.regex' => 'Họ tên không được chứa ký tự đặc biệt.',
            'dienThoai_contact.regex' => 'Số điện thoại không hợp lệ. Phải bắt đầu bằng 0 và gồm 9 chữ số tiếp theo.',
            'email_contact.email' => 'Định dạng email không hợp lệ.',
            'diaChi_contact.max' => 'Địa chỉ không được vượt quá 100 ký tự.',
            'passengerName_Adult.*.max' => 'Họ tên không được vượt quá 50 ký tự.',
            'passengerName_Adult.*.regex' => 'Họ tên không được chứa ký tự đặc biệt.',
            'passengerBirthdate_Adult.*.date_format' => 'Ngày sinh hành khách người lớn sai định dạng.',
            'passengerName_Child.*.max' => 'Họ tên không được vượt quá 50 ký tự.',
            'passengerName_Child.*.regex' => 'Họ tên không được chứa ký tự đặc biệt.',
            'passengerBirthdate_Child.*.date_format' => 'Ngày sinh hành khách trẻ em sai định dạng.',
            'note.max' => 'Ghi chú không được vượt quá 200 ký tự.'
        ]);


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

        $booking = Booking::storeBooking(
            $tourId,
            $departureScheduleId,
            $userId,
            $hoTen,
            $email,
            $dienThoai,
            $diaChi,
            $adultCount,
            $childCount,
            $singleRooms,
            $total_price,
            $note,
            $paymentMethod,
            $bookingCode
        );

        // Lưu thông tin hành khách lớn
        $booking->storeAdultPassengers(
            $booking->id,
            $request->input('passengerName_Adult'),
            $request->input('passengerBirthdate_Adult'),
            $request->input('passengerGender_Adult'),
            $singleRooms
        );

        // Lưu thông tin hành khách trẻ em
        $booking->storeChildPassengers(
            $booking->id,
            $request->input('passengerName_Child'),
            $request->input('passengerBirthdate_Child'),
            $request->input('passengerGender_Child')
        );

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
