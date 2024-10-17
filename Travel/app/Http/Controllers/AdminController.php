<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $tours = Tour::all(); // Lấy tất cả tour từ database
        return view('admin.index', compact('tours')); // Sửa đường dẫn tới view
    }

    public function create() {
        return view('admin.create'); // Sửa đường dẫn tới view
    }

    public function store(Request $request) {
        // Validation cho các trường
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time' => 'required|in:1 ngày,2 ngày,3 ngày,4 ngày,5 ngày,6 ngày',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Nếu dữ liệu hợp lệ, lưu vào database
        $tour = new Tour();
        $tour->name = $request->input('name');
        $tour->location = $request->input('location');
        $tour->time = $request->input('time');
        $tour->quantity = $request->input('quantity');
        $tour->rating = $request->input('rating'); // Lưu giá trị rating

        // Xử lý lưu file ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $tour->image = $filename;
        }

        $tour->save();

        return redirect()->route('tours.index')->with('success', 'Tour đã được thêm thành công.');
    }

    public function edit($id) {
        $tour = Tour::find($id);
        return view('admin.edit', compact('tour')); // Sửa đường dẫn tới view
    }

    public function update(Request $request, $id) {
        $tour = Tour::find($id);
      
        $tour->name = $request->input('name');
        $tour->location = $request->input('location');
        $tour->time = $request->input('time');
        $tour->quantity = $request->input('quantity');
        $tour->rating = $request->input('rating');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $tour->image = $filename;
        }
       
        $tour->save();
    
        return redirect()->route('tours.index')->with('success', 'Tour đã được cập nhật thành công.');
    }

    public function destroy($id) {
        $tour = Tour::find($id);
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Tour đã được xóa thành công.'); // Thêm thông báo xóa thành công
    }

    public function search(Request $request) {
        $search = $request->input('search');
        
        // Tìm kiếm tour dựa trên tên tour
        $tours = Tour::where('name', 'LIKE', "%{$search}%")->get();
    
        // Kiểm tra xem có tour nào được tìm thấy không
        if ($tours->isEmpty()) {
            return redirect()->route('tours.index')->with('error', 'Không tìm thấy tour nào với tên "' . $search . '". ');
        }
    
        return view('admin.index', compact('tours')); // Sửa đường dẫn tới view
    }
}
