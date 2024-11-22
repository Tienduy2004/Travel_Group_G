<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Budget;
use App\Models\ImportantInformation;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\DepartureSchedule;
use App\Models\Destination;
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
        // Mã hóa ID
        $encryptedId = Crypt::encryptString($id);
        return response()->json(['encryptedId' => $encryptedId]);
    }

    public function show($slug)
    {

        // Lấy tour theo slug
        $tour = Tour::findBySlugOrFail($slug);

        // Lấy hình ảnh của tour
        $images = $tour->images;

        // Lấy lịch khởi hành của tour lớn hơn ngày hiện tại ít nhất 1 ngày
        $departureSchedules = $tour->upcomingDepartureSchedules();

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
        $decodedScheduleId = Crypt::decryptString($encodedScheduleId);

        $selectedSchedule = DepartureSchedule::find($decodedScheduleId); // Tìm lịch trình bằng ID

        if (!$tour || !$selectedSchedule) {
            return redirect()->route('tours.show', ['slug' => $tour->slug])->with('error', 'Tour or schedule not found');
        }

        $encryptedTourId = encrypt($tour->id);
        $encryptedDepartureScheduleId = encrypt($selectedSchedule->id);

        $flightAway = null;
        $returnFlight = null;

        // Kiểm tra và phân loại chuyến bay
        foreach ($selectedSchedule->flight as $flight) {
            if ($flight->flight_type === "one_way") {
                $flightAway = $flight;
            } elseif ($flight->flight_type === "round_trip") {
                $returnFlight = $flight;
            }
        }

        return view('booking.booking', compact('tour', 'selectedSchedule', 'encryptedTourId', 'encryptedDepartureScheduleId', 'flightAway', 'returnFlight'));
    }

    public function searchResults(Request $request)
    {
        $destination = $request->input('destination');
        $date = $request->input('date');
        $budgetOption = $request->input('budget');

        // Lấy khoảng ngân sách từ cơ sở dữ liệu dựa trên lựa chọn ngân sách của người dùng
        $budget = Budget::getBudgetRange($budgetOption);
        // Gọi phương thức search trong model Tour
        $results = Tour::search($destination, $date, $budget);

        return view('home.search-results', compact('results'));
    }
}
