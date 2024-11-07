@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="container mx-auto p-4 font-sans">
        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="bg-green-500 text-white font-semibold p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white font-semibold p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (($booking->amount_paid == $booking->total_price) & ($booking->booking_status == 'confirmed'))
            <div class="bg-green-500 text-white font-semibold p-4 rounded-lg mb-4">
                Bạn đã thanh toán hoàn tất.
            </div>
        @endif
        @if (($booking->amount_paid == $booking->total_price) & ($booking->booking_status == 'canceled'))
            <div class="bg-red-500 text-white font-semibold p-4 rounded-lg mb-4">
                Bạn đã hủy chuyến du lịch.
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-4 md:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-700 mb-4">THÔNG TIN LIÊN LẠC</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold text-gray-600">Họ tên</p>
                            <p class="text-gray-800">{{ $booking->contact_name }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600">Email</p>
                            <p class="text-gray-800">{{ $booking->contact_email }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600">Điện thoại</p>
                            <p class="text-gray-800">
                                {{ strlen($booking->contact_phone) > 3 ? '*******' . substr($booking->contact_phone, -3) : $booking->contact_phone }}
                            </p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600">Địa chỉ</p>
                            <p class="text-gray-800">{{ $booking->contact_address }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-600">Ghi chú</p>
                            <p class="text-gray-600">(Booking từ Travel.com.vn) {{ $booking->note }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-700 mb-4">CHI TIẾT BOOKING</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Mã đặt chỗ:</p>
                                <p class="text-red-600">{{ $booking->booking_code }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Ngày tạo:</p>
                                <p class="text-gray-800">{{ $booking->created_at->format('d/m/y H:i:s') }}</p>
                            </div>

                        </div>
                        <div>
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Trị giá booking:</p>
                                <p class="text-gray-800">{{ number_format($booking->total_price) }} đ</p>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Hình thức thanh toán:</p>
                                <p class="text-gray-800">{{ $booking->payment_method }}</p>
                            </div>
                            @if ($booking->payment_method == 'cash')
                                <div class="border border-blue-300 bg-blue-50 pr-15 pb-10 pl-1 rounded-lg mt-4">
                                    <p class="text-gray-800 mt-2 text-left">
                                        Quý khách vui lòng thanh toán tại bất kỳ văn phòng Travelle trên toàn quốc và các
                                        chi
                                        nhánh tại nước ngoài.
                                    </p>
                                </div>
                            @else
                                <div class="border border-blue-300 bg-blue-50 pr-15 pb-10 pl-1 rounded-lg mt-4">
                                    <p class="text-gray-800 mt-2 text-left">
                                        Quý khách vui lòng tiếp bấm thanh toán để có thể thanh toán trực tuyến.
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Số tiền đã thanh toán:</p>
                                <p class="text-gray-800">{{ number_format($booking->amount_paid, 0, ',', '.') }} đ</p>
                            </div>
                        </div>
                        <div>
                            @php
                                $remainingAmount = $booking->total_price - $booking->amount_paid;
                            @endphp
                            <div class="flex items-center">
                                <p class="font-semibold text-gray-600 mr-2">Số tiền còn lại:</p>
                                <p class="text-gray-800">{{ number_format($remainingAmount, 0, ',', '.') }} đ</p>
                            </div>
                        </div>
                        <div>

                            <p class="font-semibold text-gray-600 mb-2">Tình trạng:</p>
                            @if($booking->booking_status == 'canceled')
                            <p class="text-blue-600">Booking của quý khách đã hủy</p>
                            @else
                            <p class="text-blue-600">Booking của quý khách đã được chúng tôi xác nhận thành công</p>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600 mb-2">Thời hạn thanh toán:</p>
                            <p class="text-red-600">
                                {{ $booking->created_at->addDay()->format('d/m/Y H:i') }}<span class="text-black"> - (Theo
                                    giờ Việt Nam. Booking sẽ tự động hủy nếu quá thời hạn thanh toán trên)</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-700 mb-4">DANH SÁCH HÀNH KHÁCH</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-gray-600 font-semibold">Họ tên</th>
                                <th class="py-2 text-gray-600 font-semibold">Ngày sinh</th>
                                <th class="py-2 text-gray-600 font-semibold">Giới tính</th>
                                <th class="py-2 text-gray-600 font-semibold">Độ tuổi</th>
                                <th class="py-2 text-gray-600 font-semibold">Phòng đơn</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($booking->passengers as $passenger)
                                @php
                                    // Tính tuổi của hành khách
                                    $yearOld = \Carbon\Carbon::parse($passenger->birthdate)->age;
                                @endphp
                                <!-- Duyệt qua từng hành khách -->
                                <tr>
                                    <td class="py-2 text-gray-800">{{ $passenger->name }}</td>
                                    <!-- Truy cập thuộc tính name của hành khách -->
                                    <td class="py-2 text-gray-800">
                                        {{ date('d/m/Y', strtotime($passenger->birthdate)) }}</td>
                                    <td class="py-2 text-gray-800">{{ $passenger->gender }}</td>
                                    <td class="py-2 text-gray-800">Người lớn ({{ $yearOld }} Tuổi)</td>
                                    @if (empty($passenger->single_room))
                                        <td class="py-2 text-gray-800">Không</td>
                                    @else
                                        <td class="py-2 text-gray-800">Có</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="mt-4 font-semibold text-right">Tổng cộng: <span
                            class="text-red-600">{{ number_format($remainingAmount) }} đ</span></p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-700 mb-4">PHIẾU XÁC NHẬN BOOKING</h2>
                    <img src="{{ asset('img/tours/' . $booking->tour->image_main) }}" alt="Tour destination"
                        class="w-full h-40 object-cover rounded-lg mb-4">
                    <p class="font-semibold mb-2 text-gray-800">
                        {{ $booking->tour->name }}
                        ({{ \Illuminate\Support\Str::limit($booking->tour->description, 70, '...') }})
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold text-gray-600">Số booking:</p>
                            <p class="text-red-600">{{ $booking->booking_code }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600">MÃ TOUR:</p>
                            <p class="text-gray-800">{{$booking->tour->program_code}}</p>
                        </div>
                    </div>
                    <h3 class="font-semibold mt-4 mb-2 text-gray-600">THÔNG TIN CHUYẾN BAY</h3>
                    @if (isset($flightAway) == false || isset($returnFlight) == false)
                        <div class="col-span-full text-center">
                            <h4 class="text-red-600">Chưa có chuyến bay</h4>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            <div class="border-t pt-2">
                                <div class="flex justify-between text-gray-800 mb-2">
                                    <p class="font-semibold text-gray-600 ">Ngày đi -
                                        {{ \Carbon\Carbon::parse($flightAway->departure_date)->format('d/m/Y') }}</p>
                                    <p class="font-bold text-blue-400">{{ $flightAway->flight_code }}</p>
                                </div>

                                <div class="flex justify-between text-gray-800">
                                    <p class="mb-1">
                                        {{ \Carbon\Carbon::parse($flightAway->departure_time)->format('H:i') }}
                                    </p>
                                    <p>{{ \Carbon\Carbon::parse($flightAway->arrival_time)->format('H:i') }}</p>
                                </div>
                                <div class="flex justify-center">
                                    <p class="border-b-4 border-gray-300 w-48"> </p>
                                </div>
                                <div class="flex justify-between items-center text-gray-800 mb-2">
                                    <p>{{ $flightAway->departure_location }}</p>

                                    <p>{{ $flightAway->arrival_location }}</p>
                                </div>
                                <div class="flex justify-center">
                                    <p class="text-green-400">{{ $flightAway->airline }}</p>
                                </div>
                            </div>
                            <div class="border-t pt-2">
                                <div class="flex justify-between text-gray-800 mb-2">
                                    <p class="font-semibold text-gray-600">Ngày về -
                                        {{ \Carbon\Carbon::parse($returnFlight->departure_date)->format('d/m/Y') }}</p>
                                    <p class="font-bold text-blue-400">{{ $returnFlight->flight_code }}</p>
                                </div>

                                <div class="flex justify-between text-gray-800">
                                    <p class="mb-1">
                                        {{ \Carbon\Carbon::parse($returnFlight->departure_time)->format('H:i') }}
                                    </p>
                                    <p>{{ \Carbon\Carbon::parse($returnFlight->arrival_time)->format('H:i') }}</p>
                                </div>
                                <div class="flex justify-center">
                                    <p class="border-b-4 border-gray-300 w-48"> </p>
                                </div>
                                <div class="flex justify-between items-center text-gray-800">
                                    <p>{{ $returnFlight->departure_location }}</p>
                                    <p>{{ $returnFlight->arrival_location }}</p>
                                </div>
                                <div class="flex justify-center">
                                    <p class="text-green-400">{{ $returnFlight->airline }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if ($booking->payment_method == 'transfer' && $remainingAmount != 0)
                    <div class="flex justify-center items-center mt-6">
                        <form action="{{ route('payment.create') }}" method="POST" class="w-full max-w-md">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                                Thanh Toán
                            </button>
                        </form>
                    </div>
                @endif
                @if ($booking->booking_status != 'canceled' && $remainingAmount != 0)
                    <div class="flex justify-center items-center mt-6">
                        <form action="{{ route('bookings.cancel') }}" method="POST" class="w-full max-w-md">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <button type="submit"
                                class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                                Hủy chuyến du lịch
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
