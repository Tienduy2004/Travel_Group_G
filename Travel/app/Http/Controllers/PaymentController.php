<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use \Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function showPaymentForm($bookingCode)
    {
        $userId = Auth::user()->id;
        
        // Lấy thông tin booking từ model bằng booking_code
        $booking = Booking::findByBookingCode($bookingCode);

        // Kiểm tra xem ID người dùng có trùng với ID trong booking không
        if ($userId === $booking->user_id) {
            // Khởi tạo các biến chuyến bay rỗng
            $flightAway = null;
            $returnFlight = null;

            // Kiểm tra và phân loại chuyến bay
            foreach ($booking->departureSchedule->flight as $flight) {
                if ($flight->flight_type === "one_way") {
                    $flightAway = $flight;
                } elseif ($flight->flight_type === "round_trip") {
                    $returnFlight = $flight;
                }
            }
            return view('booking.payment', compact('booking', 'flightAway', 'returnFlight'));
        } else {
            // Nếu không trùng, có thể chuyển hướng hoặc thông báo lỗi
            return redirect()->route('home');
        }
    }

    public function createPaymentLink(Request $request)
    {
        // Kiểm tra xem booking đã tồn tại
        $booking = Booking::with('tour')->findOrFail($request->booking_id);

        $paymentOrder = PaymentOrder::create([
            'booking_id' => $booking->id,
        ]);

        // Dữ liệu cần thiết để gửi đến API
        $data = [
            'orderCode' => $paymentOrder->id, // Mã đơn hàng
            'amount' => (int) ($booking->total_price), // Số tiền thanh toán, chuyển đổi sang integer
            'description' => Str::limit('Tour #' . $booking->tour->slug, 25),
            'buyerName' => $booking->contact_name,
            'buyerEmail' => $booking->contact_email,
            'buyerPhone' => $booking->contact_phone,
            'buyerAddress' => $booking->contact_address, // Có thể cập nhật thêm
            'items' => [
                [
                    'name' => $booking->tour->name,
                    'quantity' => 1, // Số lượng sản phẩm
                    'price' => (int) ($booking->total_price) // Chuyển đổi sang integer
                ]
            ],
            'cancelUrl' => url('payment/cancel'), // Đường dẫn huỷ
            'returnUrl' => url('/payment/success'), // Đường dẫn thành công
            'expiredAt' => now()->addMinutes(30)->timestamp, // Thời gian hết hạn của link
        ];
        // Tạo chữ ký
        $signature = hash_hmac(
            'sha256',
            'amount=' . $data['amount'] .
                '&cancelUrl=' . $data['cancelUrl'] .
                '&description=' . $data['description'] .
                '&orderCode=' . $data['orderCode'] .
                '&returnUrl=' . $data['returnUrl'],
            env('PAYOS_CHECKSUM_KEY')
        );
        // Gửi yêu cầu đến API
        $response = Http::withHeaders([
            'x-api-key' => env('PAYOS_API_KEY'),
            'x-client-id' => env('PAYOS_CLIENT_ID'),
        ])->post('https://api-merchant.payos.vn/v2/payment-requests', array_merge($data, ['signature' => $signature]));
        // dd($data, $response->json());
        // Kiểm tra kết quả
        if ($response->successful()) {
            // $paymentData = $response->json();
            // dd($paymentData->data->checkoutUrl);
            return redirect()->away($response->json()['data']['checkoutUrl']);
        } else {
            dd($response->body()); // Hiển thị phản hồi từ API
            return back()->withErrors(['error' => 'Không thể tạo link thanh toán.']);
        }
    }

    public function cancelPaymentLink(Request $request)
    {

        $paymentOrder = PaymentOrder::findOrFail($request->input('orderCode'));

        return redirect()->route('booking.payment', [$paymentOrder->booking->booking_code])->with('success', 'Đã hủy thanh toán thành công.');
    }

    public function successPaymentLink(Request $request)
    {
        $orderCode = $request->input('orderCode');
        $paymentOrder = PaymentOrder::findOrFail($orderCode);
        $booking = Booking::findOrFail($paymentOrder->booking_id);

        // Gửi yêu cầu GET đến API
        try {
            $response = Http::withHeaders([
                'x-api-key' => env('PAYOS_API_KEY'),
                'x-client-id' => env('PAYOS_CLIENT_ID'),
            ])->get("https://api-merchant.payos.vn/v2/payment-requests/{$orderCode}");

            // Lấy dữ liệu từ phản hồi
            $data = $response->json();

            // Kiểm tra mã phản hồi
            if ($data['code'] === '00') {
                // Xử lý dữ liệu thành công
                $paymentData = $data['data'];

                // Kiểm tra xem amountPaid có tồn tại và là số hợp lệ
                if (isset($paymentData['amountPaid']) && is_numeric($paymentData['amountPaid'])) {
                    $amountPaid = (float) $paymentData['amountPaid']; // Chuyển đổi sang float

                    $booking->update([
                        'amount_paid' => $booking->amount_paid + $amountPaid, // Cập nhật số tiền đã thanh toán
                        'booking_status' => 'confirmed',
                    ]);

                    // Chuyển hướng đến route 'booking.payment' với thông tin về booking_id
                    return redirect()->route('booking.payment', [$paymentOrder->booking->booking_code])
                        ->with('success', 'Đã thanh toán thành công.');
                } else {
                    return redirect()->route('booking.payment', [$paymentOrder->booking->booking_code])
                        ->with('error', 'Số tiền thanh toán không hợp lệ.');
                }
            } else {
                // Xử lý lỗi nếu không thành công
                return redirect()->route('booking.payment', [$paymentOrder->booking->booking_code])
                    ->with('error', 'Đã xảy ra lỗi trong quá trình thanh toán.');
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có vấn đề xảy ra trong quá trình gửi yêu cầu
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
