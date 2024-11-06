<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    // Phương thức index để hiển thị danh sách khuyến mãi kèm theo phân trang và tìm kiếm
    public function index(Request $request)
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $search = $request->input('search'); // Lấy giá trị từ form tìm kiếm
        $startDate = $request->input('start_date'); // Ngày bắt đầu
        $endDate = $request->input('end_date');     // Ngày kết thúc

        // Lọc dữ liệu theo từ khóa và ngày tháng nếu có
        $promotions = Promotion::when($search, function ($query, $search) {
            return $query->where('code', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->when($startDate, function ($query, $startDate) {
            return $query->whereDate('start_date', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->whereDate('end_date', '<=', $endDate);
        })
        ->paginate(5); // Phân trang

        // Tạo thông báo tìm kiếm
        $message = null;
        if (($search || $startDate || $endDate) && $promotions->isEmpty()) {
            $message = 'Không tìm thấy khuyến mãi nào với các tiêu chí tìm kiếm.';
        }

        // Trả về view với dữ liệu khuyến mãi và thông báo
        return view('admin.promotions.index', compact('promotions', 'search', 'startDate', 'endDate', 'message'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $request->validate([
            'code' => 'required|string|max:255|unique:promotions',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|integer|min:0|max:100',
        ]);

        Promotion::create($request->all());

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được tạo thành công.');
    }

    public function edit(Promotion $promotion)
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $request->validate([
            'code' => 'required|string|max:255|unique:promotions,code,' . $promotion->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|integer|min:0|max:100',
        ]);

        $promotion->update($request->all());

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được cập nhật thành công.');
    }

    public function destroy(Promotion $promotion)
    {
        // Kiểm tra quyền admin
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công.');
    }
}
