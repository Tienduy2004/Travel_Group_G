<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search'); // Lấy giá trị tìm kiếm nếu có
        $admins = Admin::when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->paginate(5); // Sử dụng paginate để phân trang
    
        // Đảm bảo bạn đã truyền biến $admins vào view
        return view('admin.index', compact('admins', 'search'));
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
            'price' => 'required|numeric|min:0',
        ]);

        // Nếu dữ liệu hợp lệ, lưu vào database
        $admins = new Admin();
        $admins->name = $request->input('name');
        $admins->location = $request->input('location');
        $admins->time = $request->input('time');
        $admins->quantity = $request->input('quantity');
        $admins->rating = $request->input('rating'); // Lưu giá trị rating
        $admins->price = $request->input('price'); // Lưu giá trị price

        // Xử lý lưu file ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $admins->image = $filename;
        }

        $admins->save();

        return redirect()->route('admins.index')->with('success', 'Tour đã được thêm thành công.');
    }

    public function edit($id) {
        $admins = Admin::find($id);
        return view('admin.edit', compact('admins')); // Sửa đường dẫn tới view
    }

    public function update(Request $request, $id) {
        $admins = Admin::find($id);
    
        // Validation nếu có thay đổi nào
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time' => 'required|in:1 ngày,2 ngày,3 ngày,4 ngày,5 ngày,6 ngày',
            'quantity' => 'required|integer|min:1',
            'rating' => 'required|integer|min:1|max:5',
            'price' => 'required|numeric|min:0', // Thêm điều kiện cho price
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Ảnh có thể không cần thiết phải cập nhật
        ]);
      
        // Cập nhật thông tin tour
        $admins->name = $request->input('name');
        $admins->location = $request->input('location');
        $admins->time = $request->input('time');
        $admins->quantity = $request->input('quantity');
        $admins->rating = $request->input('rating');
        $admins->price = $request->input('price'); // Cập nhật giá
    
        // Kiểm tra nếu có file ảnh mới
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $admins->image = $filename;
        }
       
        $admins->save();
    
        return redirect()->route('admins.index')->with('success', 'Tour đã được cập nhật thành công.');
    }
    

    public function destroy($id) {
        $admins = Admin::find($id);
        $admins->delete();

        return redirect()->route('admins.index')->with('success', 'Tour đã được xóa thành công.'); // Thêm thông báo xóa thành công
    }

    public function search(Request $request) {
        $search = $request->input('search');
        
        // Tìm kiếm tour dựa trên tên tour với phân trang
        $admins = Admin::where('name', 'LIKE', "%{$search}%")->paginate(5);

        // Kiểm tra xem có tour nào được tìm thấy không
        if ($admins->isEmpty()) {
            return redirect()->route('admins.index')->with('error', 'Không tìm thấy tour nào với tên "' . $search . '". ');
        }
    
        return view('admin.index', compact('admins', 'search')); // Sửa đường dẫn tới view
    }
}
