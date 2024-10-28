<?php

namespace App\Http\Controllers;

use App\Services\PayOSService;
use Illuminate\Http\Request;

class PayOSController extends Controller
{
    protected $payOSService;

    public function __construct(PayOSService $payOSService)
    {
        $this->payOSService = $payOSService;
    }

    // Phương thức tạo và xử lý thanh toán
    public function createPayment(Request $request)
    {
        $orderId = $request->input('order_id'); // ID đơn hàng hoặc mã booking
        $amount = $request->input('amount'); // Số tiền cần thanh toán

        // Gọi service để tạo yêu cầu thanh toán PayOS
        $paymentResponse = $this->payOSService->createPayment($orderId, $amount);

        if (isset($paymentResponse['status']) && $paymentResponse['status'] == 'success') {
            // Redirect đến URL thanh toán của PayOS
            return redirect()->away($paymentResponse['payment_url']);
        }

        // Nếu có lỗi, xử lý và thông báo cho người dùng
        return redirect()->back()->withErrors(['error' => 'Không thể tạo yêu cầu thanh toán. Vui lòng thử lại.']);
    }

    // Phương thức xử lý sau khi thanh toán thành công
    public function paymentSuccess(Request $request)
    {
        // Xử lý khi thanh toán thành công (cập nhật trạng thái đơn hàng, gửi email, v.v.)
        return view('booking.success');
    }

    // Phương thức xử lý khi thanh toán bị hủy hoặc thất bại
    public function paymentCancel(Request $request)
    {
        // Xử lý khi thanh toán bị hủy (thông báo cho người dùng, giữ nguyên trạng thái đơn hàng, v.v.)
        return view('booking.cancel');
    }
}
