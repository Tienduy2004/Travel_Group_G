<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\DepartureLocation;

class AdminController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search'); // Lấy giá trị tìm kiếm nếu có
        $tours = Tour::with('destination')->when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->paginate(5); // Sử dụng paginate để phân trang
    
        return view('admin.index', compact('tours', 'search')); // Đảm bảo truyền biến $tours vào view
    }
    
    

    public function create() {
        $destinations = Destination::all(); // Lấy danh sách địa điểm từ bảng destination
        $departureLocations = DepartureLocation::all(); // Lấy danh sách địa điểm khởi hành từ bảng departure_location
        return view('admin.create', compact('destinations', 'departureLocations')); // Truyền cả hai biến vào view
    }

    public function store(Request $request) {
        // Validation cho các trường
        $this->validateTour($request);

        // Tạo mới tour
        $tour = new Tour();
        $this->saveTourData($tour, $request);

        return redirect()->route('tours.index')->with('success', 'Tour đã được thêm thành công.');
    }

    public function edit($id) {
        $tour = Tour::findOrFail($id); // Sử dụng findOrFail để tìm tour hoặc trả về lỗi 404
    $destinations = Destination::all(); // Lấy danh sách địa điểm từ bảng destination
    $departureLocations = DepartureLocation::all(); // Lấy danh sách địa điểm khởi hành từ bảng departure_location
    return view('admin.edit', compact('tour', 'destinations', 'departureLocations')); // Truyền cả hai biến vào view
    }

    public function update(Request $request, $id) {
        $tour = Tour::findOrFail($id); // Sử dụng findOrFail để xử lý lỗi
        // Validation nếu có thay đổi nào
        $this->validateTour($request, true);

        $this->saveTourData($tour, $request);
    
        return redirect()->route('tours.index')->with('success', 'Tour đã được cập nhật thành công.');
    }

    public function destroy($id) {
        $tour = Tour::findOrFail($id); // Sử dụng findOrFail để xử lý lỗi
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Tour đã được xóa thành công.');
    }

    public function search(Request $request) {
        $search = $request->input('search');
        
        $tours = Tour::where('name', 'LIKE', "%{$search}%")->paginate(5);

        if ($tours->isEmpty()) {
            return redirect()->route('tours.index')->with('error', 'Không tìm thấy tour nào với tên "' . $search . '".');
        }

        return view('admin.index', compact('tours', 'search')); // Đường dẫn tới view
    }

    private function validateTour(Request $request, $update = false) {
        // Validation cho các trường
        $rules = [
            'name' => 'required|string|max:255',
            'id_destination' => 'required|integer|exists:destination,id', // Kiểm tra id_destination tồn tại trong bảng destination
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'number_days' => 'required|integer|min:1',
            'discount_price' => 'nullable|numeric|min:0',
            'program_code' => 'required|string|max:255',
            'is_active' => 'required|boolean',
           'id_departure_location' => 'required|integer|exists:departure_location,id', // Kiểm tra id_departure_location tồn tại trong bảng departure_location
            'person' => 'required|integer|min:1',
        ];

        if (!$update) {
            $rules['image_main'] = 'required|image|mimes:png,jpg,jpeg|max:2048';
        } else {
            $rules['image_main'] = 'nullable|image|mimes:png,jpg,jpeg|max:2048'; // Ảnh có thể không cần thiết phải cập nhật
        }

        $request->validate($rules);
    }

    private function saveTourData(Tour $tour, Request $request) {
        $tour->name = $request->input('name');
        $tour->id_destination = $request->input('id_destination');
        $tour->description = $request->input('description');
        $tour->price = $request->input('price');
        $tour->number_days = $request->input('number_days');
        $tour->discount_price = $request->input('discount_price');
        $tour->program_code = $request->input('program_code');
        $tour->is_active = $request->input('is_active');
        $tour->id_departure_location = $request->input('id_departure_location');
        $tour->person = $request->input('person');

        // Xử lý lưu file ảnh
        if ($request->hasFile('image_main')) {
            $file = $request->file('image_main');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $tour->image_main = $filename;
        }

        $tour->save();
    }
}
