<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
   
    public function index(Request $request)
{
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!auth()->guard('admin')->check()) {
        // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập và thông báo lỗi
        return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }

    // Nếu đã đăng nhập, kiểm tra xem người dùng có phải là admin không
    $admin = auth()->guard('admin')->user();
    if ($admin->role !== 'admin') {
        // Nếu không phải admin, trả về lỗi 403 với thông báo
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    // Nếu đã đăng nhập và có quyền admin, thực hiện tìm kiếm và phân trang cho khuyến mãi
    $search = $request->input('search'); // Từ khóa tìm kiếm
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

    // Thông báo nếu không có kết quả tìm kiếm
    $message = null;
    if (($search || $startDate || $endDate) && $promotions->isEmpty()) {
        $message = 'Không tìm thấy khuyến mãi nào với các tiêu chí tìm kiếm.';
    }

    // Trả về view với dữ liệu khuyến mãi và thông báo
    return view('admin.promotions.index', compact('promotions', 'search', 'startDate', 'endDate', 'message'));
}
public function danhsachkhuyenmai(Request $request)
{
    $hasPromotions = Promotion::exists(); // Kiểm tra xem bảng promotions có dữ liệu hay không

    $promotions = Promotion::all()->map(function ($promotion) {
        $promotion->start_date = Carbon::parse($promotion->start_date);
        $promotion->end_date = Carbon::parse($promotion->end_date);
        return $promotion;
    });

    return view('admin.promotions.danhsachkhuyenmai', compact('promotions', 'hasPromotions'));
}

public function applyPromotion(Request $request)
{
    $programCode = $request->input('program_code');
    $currentTotalAmount = $request->input('original_price'); // Lấy tổng tiền hiện tại từ request

    $promotion = Promotion::where('code', $programCode)
                          ->whereDate('start_date', '<=', now())
                          ->whereDate('end_date', '>=', now())
                          ->first();

    if ($promotion) {
        // Tính toán giá sau khi áp dụng khuyến mãi dựa trên tổng tiền hiện tại
        $discountedPrice = $currentTotalAmount * (1 - $promotion->discount_percentage / 100);
        return response()->json([
            'discounted_price' => $discountedPrice,
            'message' => 'Áp dụng thành công mã khuyến mãi.',
        ]);
    } else {
        return response()->json([
            'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.',
        ], 400);
    }
}

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:promotions',
            'description' => 'nullable|string', 
            'start_date' => 'required|date|after_or_equal:today', 
            'end_date' => 'required|date|after_or_equal:start_date', 
            'discount_percentage' => 'required|integer|min:0|max:100',
        ]);
    
        Promotion::create($request->all());
    
        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được tạo thành công.');
    }

    // Phương thức edit để hiển thị form chỉnh sửa khuyến mãi
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:promotions,code,' . $promotion->id,
            'description' => 'nullable|string', // Không giới hạn độ dài mô tả
            'start_date' => 'required|date|after_or_equal:today', // Ngày bắt đầu không được trong quá khứ
            'end_date' => 'required|date|after_or_equal:start_date', // Ngày kết thúc không được nhỏ hơn ngày bắt đầu
            'discount_percentage' => 'required|integer|min:0|max:100',
        ]);
    
        $promotion->update($request->all());
    
        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được cập nhật thành công.');
    }

    // Phương thức destroy để xóa khuyến mãi
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công.');
    }
}