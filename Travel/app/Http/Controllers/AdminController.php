<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\DepartureLocation;
use App\Models\Promotion;

class AdminController extends Controller
{
    public function index(Request $request) {
        return $this->trangchu($request); 
    }
    
    public function trangchu(Request $request) {
        $search = $request->input('search'); 
        $tours = Tour::with('destination')->when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->paginate(5); 
    
        return view('admin.trangchu', compact('tours', 'search')); 
    }

    public function create() {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'admin') {
         
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        $destinations = Destination::all(); 
        $departureLocations = DepartureLocation::all(); 
        return view('admin.create', compact('destinations', 'departureLocations')); 
    }

    public function store(Request $request) {
       
        $this->validateTour($request);

       
        $tour = new Tour();
        $this->saveTourData($tour, $request);

        return redirect()->route('tours.trangchu')->with('success', 'Tour đã được thêm thành công.');
    }

    public function edit($id) {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'admin') {
         
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        $tour = Tour::findOrFail($id); 
        $destinations = Destination::all(); 
        $departureLocations = DepartureLocation::all(); 
        
        return view('admin.edit', compact('tour', 'destinations', 'departureLocations'));
    }

    public function update(Request $request, $id) {
        $tour = Tour::findOrFail($id); // Tìm tour theo ID hoặc trả về lỗi 404

        // Thực hiện validation cho dữ liệu cập nhật
        $this->validateTour($request, true);

        // Lưu dữ liệu
        $this->saveTourData($tour, $request);

        return redirect()->route('tours.trangchu')->with('success', 'Tour đã được cập nhật thành công.');
    }

    public function destroy($id) {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'admin') {
         
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        $tour = Tour::findOrFail($id); // Sử dụng findOrFail để xử lý lỗi
        $tour->delete();

        return redirect()->route('tours.trangchu')->with('success', 'Tour đã được xóa thành công.');
    }

    public function search(Request $request) {
        $search = $request->input('search');
        
        $tours = Tour::where('name', 'LIKE', "%{$search}%")->paginate(5);

        if ($tours->isEmpty()) {
            return redirect()->route('tours.trangchu')->with('error', 'Không tìm thấy tour nào với tên "' . $search . '".');
        }

        return view('admin.trangchu', compact('tours', 'search')); // Đường dẫn tới view
    }

    // Phương thức validateTour
    private function validateTour(Request $request, $update = false) {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'id_destination' => 'required|integer|exists:destination,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_single_room' => 'nullable|numeric|min:0', // Cho phép trường này có thể là null hoặc số không âm
            'number_days' => 'required|integer|min:1',
            'program_code' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'id_departure_location' => 'required|integer|exists:departure_location,id',
            'person' => 'required|integer|min:1',
        ];

        if (!$update) {
            $rules['image_main'] = 'required|image|mimes:png,jpg,jpeg,jfif|max:2048';
        } else {
            $rules['image_main'] = 'nullable|image|mimes:png,jpg,jpeg,jfif|max:2048';
        }

        $request->validate($rules);
    }


  

private function saveTourData(Tour $tour, Request $request) {
    $tour->name = $request->input('name');
    $tour->slug = $request->input('slug') ?: \Str::slug($request->input('name'));
    $tour->id_destination = $request->input('id_destination');
    $tour->description = $request->input('description');
    $tour->price = $request->input('price');
    $tour->price_single_room = $request->input('price_single_room') ?? 0;
    $tour->number_days = $request->input('number_days');
    $tour->program_code = $request->input('program_code') ?: '';
    $tour->is_active = $request->input('is_active');
    $tour->id_departure_location = $request->input('id_departure_location');
    $tour->person = $request->input('person');

    // Kiểm tra nếu có program_code, trừ giá dựa trên discount_percentage
    if ($tour->program_code) {
        // Lấy khuyến mãi dựa trên mã code
        $promotion = Promotion::where('code', $tour->program_code)->first();
        if ($promotion) {
            // Giảm giá theo tỷ lệ phần trăm
            $discountAmount = $tour->price * ($promotion->discount_percentage / 100);
            $tour->price = max(0, $tour->price - $discountAmount); 
        }
    }

   
    if ($request->hasFile('image_main')) {
        $file = $request->file('image_main');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('img/tours'), $filename);
        $tour->image_main = $filename;
    }

    $tour->save();
}

}

