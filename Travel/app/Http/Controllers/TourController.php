<?php

namespace App\Http\Controllers;

use App\Models\ImportantInformation;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\DepartureSchedule;
use App\Models\ImageTour;
use App\Models\Itinerary;
use App\Models\TripInformation;
use App\Models\VehicleInformation;


class TourController extends Controller
{
    public function show($id)
    {
        // Lấy tour theo ID
        $tour = Tour::findOrFail($id);

        // Lấy hình ảnh của tour
        $images = ImageTour::where('tour_id', $tour->id)->get();

        // Lấy lịch khởi hành của tour
        // Lấy lịch khởi hành của tour và bao gồm thông tin về địa điểm khởi hành
        $departureSchedules = DepartureSchedule::where('tour_id', $tour->id)->get();


        // Lấy lịch trình của tour
        $itineraries = Itinerary::where('tour_id', $tour->id)->get();

        // Lấy thông tin quan trọng của tour
        $importantInfos = ImportantInformation::where('tour_id', $tour->id)->get();


        $minPriceSchedule = $departureSchedules->sortBy('price')->first(); // Lấy lịch trình có giá thấp nhất
        // Lấy thông tin từ bảng trip_information
        $tripInformations = TripInformation::where('tour_id', $tour->id)->get();
        // Lấy danh sách các tour khác (ngoại trừ tour hiện tại)
        $suggestedTours = Tour::where('id', '!=', $id)->take(3)->get();

        return view('tours.show', compact('tour', 'images', 'departureSchedules', 'itineraries', 'importantInfos', 'minPriceSchedule', 'tripInformations','suggestedTours'));
    }
}
