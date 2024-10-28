<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ImportantInformation;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\DepartureSchedule;
use App\Models\ImageTour;
use App\Models\Itinerary;
use App\Models\TripInformation;
use App\Models\VehicleInformation;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;
use Illuminate\Support\Facades\Crypt;

class TourController extends Controller
{
    public function encryptId($id)
    {
        return Crypt::encryptString($id);
    }

    public function show($slug)
    {

        // Lấy tour theo slug
        $tour = Tour::where('slug', $slug)->firstOrFail();

        // Lấy hình ảnh của tour
        $images = $tour->images;

        // Lấy lịch khởi hành của tour
        $departureSchedules = $tour->departureSchedules;

        // Lấy lịch trình của tour
        $itineraries = $tour->itineraries;

        // Lấy thông tin quan trọng của tour
        $importantInfos = $tour->importantInfos;

        // Lấy lịch trình có giá thấp nhất
        $minPriceSchedule = $tour->minPriceSchedule();

        // Lấy thông tin từ bảng trip_information
        $tripInformations = $tour->tripInformations;

        // Lấy danh sách các tour gợi ý (ngoại trừ tour hiện tại)
        $suggestedTours = $tour->suggestedTours(3);
        


        return view('tours.show', compact('tour', 'images', 'departureSchedules', 'itineraries', 'importantInfos', 'minPriceSchedule', 'tripInformations', 'suggestedTours'));
    }

    public function showBookingPage($id, Request $request)
{
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in to book a tour.');
    }

    $tour = Tour::find($id);
    
    // Lấy departure_schedule_id đã mã hóa từ yêu cầu
    $encodedScheduleId = $request->query('departure_schedule_id');

    // Giải mã ID
    $decodedScheduleId = base64_decode($encodedScheduleId); // Giải mã Base64
    list($key, $scheduleId) = explode('-', $decodedScheduleId); // Tách key và id

    // Kiểm tra xem key có khớp không
    if ($key !== env('YOUR_SECRET_KEY')) {
        return redirect()->route('tours.show', ['slug' => $tour->slug])->with('error', 'Invalid schedule ID');
    }

    $selectedSchedule = DepartureSchedule::find($scheduleId); // Tìm lịch trình bằng ID

    if (!$tour || !$selectedSchedule) {
        return redirect()->route('tours.show', ['slug' => $tour->slug])->with('error', 'Tour or schedule not found');
    }
    
    $encryptedTourId = encrypt($tour->id);
    $encryptedDepartureScheduleId = encrypt($selectedSchedule->id);
    
    return view('booking.booking', compact('tour', 'selectedSchedule', 'encryptedTourId', 'encryptedDepartureScheduleId'));
}
}
