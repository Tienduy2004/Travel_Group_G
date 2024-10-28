<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function showPaymentForm($bookingId)
    {
        // Lấy thông tin booking từ database
        $booking = Booking::findOrFail($bookingId);
        return view('booking.payment', compact('booking'));
    }

    public function processPayment(Request $request, $bookingId)
    {
        // Xử lý thanh toán tại đây
        // Kiểm tra phương thức thanh toán
        $paymentMethod = $request->input('payment_method');
        
        // Thêm logic tích hợp với API thanh toán tương ứng
        // Ví dụ: PayOS, ZaloPay, VNPay, Momo, Credit Card
        
        // Giả sử thanh toán thành công
        $booking = Booking::findOrFail($bookingId);
        $booking->update(['booking_status' => 'paid']); // Cập nhật trạng thái booking

        return redirect()->route('booking.success')->with('message', 'Payment successful!');
    }
}
