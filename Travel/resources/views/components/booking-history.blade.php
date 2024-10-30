@props(['bookings'])

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mt-6">
    @forelse($bookings as $booking)
        <div class="p-6 bg-white border rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
            <img src="{{ asset('img/tours/' . $booking->tour->image_main) }}" alt="Tour destination"
                 class="w-full h-40 object-cover rounded-lg mb-4">
            <h2 class="font-semibold text-xl text-gray-800 mb-2">Mã Đặt Chỗ: {{ $booking->booking_code }}</h2>
            <p class="text-gray-600"><strong>Ngày tạo:</strong> {{ $booking->created_at->format('d/m/y') }}</p>
            <p class="text-gray-600"><strong>Tên tour:</strong> {{ $booking->tour->name }}</p>
            <p class="text-gray-600"><strong>Địa điểm Khởi Hành:</strong> {{ $booking->tour->departureLocation->name }}</p>
            <p class="text-gray-600"><strong>Trạng Thái:</strong> 
                <span class="font-medium {{ $booking->booking_status == 'confirmed' ? 'text-green-600' : 'text-red-500' }}">
                    {{ ucfirst($booking->booking_status) }}
                </span>
            </p>
            <p class="text-gray-600"><strong>Tổng Giá:</strong> 
                <span class="font-semibold text-blue-600">{{ number_format($booking->total_price, 0) }} VNĐ</span>
            </p>
            <p class="text-gray-600"><strong>Số Tiền Đã Thanh Toán:</strong> 
                <span class="font-semibold text-red-600">{{ number_format($booking->amount_paid, 0) }} VNĐ</span>
            </p>
            <div class="mt-4 text-center">
                <a href="{{ route('booking.payment', ['bookingCode' => $booking->booking_code]) }}"
                   class="inline-block bg-blue-500 text-white rounded-full px-4 py-2 text-sm font-medium hover:bg-blue-600 transition-colors duration-200">
                    Xem Chi Tiết
                </a>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">Chưa có booking nào.</p>
    @endforelse
</div>
