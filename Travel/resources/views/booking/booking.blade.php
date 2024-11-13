@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
<script src="{{ asset('js/nhankhuyenmai.js') }}"></script>

<div class="booking-page">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">ĐẶT TOUR</h1>
        <div id="seatAvailability" style="display:none; color: red; margin-top: 10px;">
            Rất tiếc, tour hiện tại số chỗ còn nhận chỉ còn: <span id="remainingSeats"></span> chỗ.
        </div>
        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="tour_id" value="{{ $encryptedTourId }}">
            <input type="hidden" name="departure_schedule_id" value="{{ $encryptedDepartureScheduleId }}">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-2/3">
                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">THÔNG TIN LIÊN LẠC</h2>
                        <div class="bg-blue-50 p-3 rounded-md mb-4 text-sm">
                            <span class="inline-block mr-2">ℹ️</span>
                            Để nhận ưu đãi, quý khách vui lòng đăng ký thành viên hoặc đăng nhập
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="hoTen" class="block mb-1">Họ tên *</label>
                                <input type="text" name="hoTen_contact" id="hoTen" class="w-full p-2 border rounded"
                                    placeholder="Nhập họ tên" required />
                            </div>
                            <div>
                                <label for="dienThoai" class="block mb-1">Điện thoại *</label>
                                <input type="tel" name="dienThoai_contact" id="dienThoai"
                                    class="w-full p-2 border rounded" placeholder="Nhập số điện thoại" required />
                            </div>
                            <div>
                                <label for="email" class="block mb-1">Email *</label>
                                <input type="email" name="email_contact" id="email" class="w-full p-2 border rounded"
                                    placeholder="Nhập email" required />
                            </div>
                            <div>
                                <label for="diaChi" class="block mb-1">Địa chỉ</label>
                                <input type="text" name="diaChi_contact" id="diaChi" class="w-full p-2 border rounded"
                                    placeholder="Nhập địa chỉ" required />
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">HÀNH KHÁCH</h2>
                        <div class="flex justify-between items-center mb-4">
                            <span>Người lớn</span>
                            <div class="flex items-center">
                                <button type="button" onclick="decrement('adultCount')"
                                    class="px-3 py-1 border rounded-l">-</button>
                                <input type="text" name="adultCount" id="adultCount" value="1" readonly
                                    class="w-12 text-center border-t border-b" />
                                <button type="button" onclick="increment('adultCount')"
                                    class="px-3 py-1 border rounded-r">+</button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Trẻ em</span>
                            <div class="flex items-center">
                                <button type="button" onclick="decrement('childCount')"
                                    class="px-3 py-1 border rounded-l">-</button>
                                <input type="text" name="childCount" id="childCount" value="0" readonly
                                    class="w-12 text-center border-t border-b" />
                                <button type="button" onclick="increment('childCount')"
                                    class="px-3 py-1 border rounded-r">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">THÔNG TIN HÀNH KHÁCH</h2>
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="vietnameseNationality" class="mr-2" required />
                            <label for="vietnameseNationality">Tôi xác nhận rằng tất cả hành khách đều có quốc tịch Việt
                                Nam</label>
                        </div>
                        <div id="passengerInfoContainer">
                            <div class="mb-4">
                                <label class="block mb-1">Người lớn 1 (Từ 12 tuổi trở lên)</label>
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <input type="text" name="passengerName[]" placeholder="Họ tên"
                                        class="p-2 border rounded" required />
                                    <input type="date" name="passengerBirthdate[]" placeholder="Ngày sinh"
                                        class="p-2 border rounded" required />
                                    <div class="relative">
                                        <select name="passengerGender[]"
                                            class="w-full p-2 border rounded appearance-none" required>
                                            <option value="">Giới tính</option>
                                            <option value="Nam">Nam</option>
                                            <option value="Nữ">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <label class="block mb-1">Phòng đơn</label>
                                        <input name="singleRoom[]" type="checkbox" id="singleRoomToggle"
                                            class="react-switch-checkbox hidden"
                                            onchange="handleSingleRoomToggle(this)">
                                        <label for="singleRoomToggle"
                                            class="react-switch-label block w-12 h-6 rounded-full cursor-pointer bg-gray-300">
                                            <span
                                                class="react-switch-button absolute top-1 left-1 w-4 h-4 rounded-full bg-white transition-transform transform-gpu duration-300"></span>
                                        </label>
                                    </div>
                                    <span class="text-right font-semibold">{{ $tour->price_single_room }} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="program_code">Mã chương trình:</label>
                        <input type="text" name="program_code" id="program_code" placeholder="Nhập mã chương trình..."
                            value="{{ old('program_code') }}">
                        <button type="button" id="check_promotion_button">Kiểm tra mã</button>
                        <span id="discounted_price"></span>
                    </div>
                    <script>
                        const originalPrice = {{ $tour-> price }};
                    </script>
                    <script src="{{ asset('js/nhankhuyenmai.js') }}"></script>

                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">GHI CHÚ</h2>
                        <textarea name="note" class="w-full p-2 border rounded" rows="4"
                            placeholder="Vui lòng nhập nội dung ghi chú bằng tiếng Anh hoặc tiếng Việt"></textarea>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">CÁC HÌNH THỨC THANH TOÁN</h2>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="payment-1" name="paymentMethod" value="cash" class="mr-2"
                                    required />
                                <label for="payment-1">Tiền mặt</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="payment-2" name="paymentMethod" value="transfer" class="mr-2"
                                    required />
                                <label for="payment-2">Chuyển khoản</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-blue-600 mb-4">TÓM TẮT CHUYẾN ĐI</h2>
                        <img src="{{ asset('img/tours/' . $tour->image_main) }}?height=200&width=400" alt="Tour Image"
                            class="w-full rounded-lg mb-4" />
                        <h3 class="font-semibold mb-2">{{ $tour->name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">Mã Tour: {{ $tour->program_code }}</p>
                        <div class="bg-gray-100 p-3 rounded-md mb-4">
                            <p class="mb-1"><span class="font-semibold">Khởi hành:</span>
                                {{ $tour->departureLocation->name }}</p>
                            <p class="mb-1"><span class="font-semibold">Thời gian:</span> {{ $tour->number_days }}
                                Days</p>
                        </div>
                        @php
                        $total_price_guest = $selectedSchedule->price + $tour->price_single_room;
                        $total_price = $total_price_guest;
                        @endphp
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between mb-2">
                                <span>KHÁCH HÀNG + PHỤ THU</span>
                                <span id="price-guest" class="font-semibold">{{ number_format($total_price_guest) }}
                                    ₫</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Người lớn</span>
                                <span id="adultPrice"> {{ number_format($selectedSchedule->price) }} đ</span>
                            </div>
                            <div id="childGuest" class="flex justify-between text-sm text-gray-600 mb-2"
                                style="display: none;">
                                <span>Trẻ em</span>
                                <span id="childPrice">0 đ</span> <!-- Thêm dòng này để hiển thị giá tour cho trẻ em -->
                            </div>
                            <div id="single-room" class="flex justify-between text-sm text-gray-600">
                                <span>Phụ thu phòng đơn</span>
                                <span id="singleRoomCharge">{{ number_format($tour->price_single_room) }} đ</span>
                            </div>
                        </div>
                        <div class="border-t pt-4 mb-4">
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
                                            {{ \Carbon\Carbon::parse($flightAway->departure_date)->format('d/m/Y') }}
                                        </p>
                                        <p class="font-bold text-blue-400">{{ $flightAway->flight_code }}</p>
                                    </div>

                                    <div class="flex justify-between text-gray-800">
                                        <p class="mb-1">
                                            {{ \Carbon\Carbon::parse($flightAway->departure_time)->format('H:i') }}
                                        </p>
                                        <p>{{ \Carbon\Carbon::parse($flightAway->arrival_time)->format('H:i') }}
                                        </p>
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
                                            {{ \Carbon\Carbon::parse($returnFlight->departure_date)->format('d/m/Y') }}
                                        </p>
                                        <p class="font-bold text-blue-400">{{ $returnFlight->flight_code }}</p>
                                    </div>

                                    <div class="flex justify-between text-gray-800">
                                        <p class="mb-1">
                                            {{ \Carbon\Carbon::parse($returnFlight->departure_time)->format('H:i') }}
                                        </p>
                                        <p>{{ \Carbon\Carbon::parse($returnFlight->arrival_time)->format('H:i') }}
                                        </p>
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
                        <div class="border-t pt-4 mb-4">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Tổng tiền</span>
                                <span class="text-red-600" id="totalAmount">{{ number_format($total_price) }}
                                    ₫</span>
                            </div>
                        </div>
                        <input id="totalAmount_input" type="hidden" name="total_price" value="{{ $total_price }}">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Tiếp tục đặt
                            tour</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let adultCount = 1;
    let childCount = 0;
    let pricePerAdult = {{ $selectedSchedule-> price }};
    let pricePerChild = pricePerAdult * 0.9; // Giá tour cho trẻ em giảm 10%
    let priceSingleRoom = {{ $tour-> price_single_room }};
    let maxSeats = {{ $selectedSchedule-> seat_number }}; // Số ghế tối đa


    const maxAdultAge = 12; // Đặt tuổi tối thiểu cho người lớn
    const maxChildAge = 11; // Đặt tuổi tối đa cho trẻ em
    const minChildAge = 2; // Đặt tuổi tối thiểu cho trẻ em
    const today = new Date();
    const minBirthdateAdult = new Date(today.getFullYear() - maxAdultAge, today.getMonth(), today.getDate())
        .toISOString().split("T")[0];
    const minBirthdateChild = new Date(today.getFullYear() - maxChildAge, today.getMonth(), today.getDate())
        .toISOString().split("T")[0];
    const maxBirthdateChild = new Date(today.getFullYear() - minChildAge, today.getMonth(), today.getDate())
        .toISOString().split("T")[0];

    document.querySelectorAll('input[name="passengerBirthdate_Adult[]"]').forEach(input => {
        input.setAttribute("min", new Date(today.getFullYear() - maxAdultAge, today.getMonth(), today.getDate())
            .toISOString().split("T")[0]); // Tối thiểu là 12 tuổi
    });

    document.querySelectorAll('input[name="passengerBirthdate_Child[]"]').forEach(input => {
        input.setAttribute("min", new Date(today.getFullYear() - maxChildAge, today.getMonth(), today.getDate())
            .toISOString().split("T")[0]); // Tối thiểu là 2 tuổi
        input.setAttribute("max", new Date(today.getFullYear() - minChildAge, today.getMonth(), today.getDate())
            .toISOString().split("T")[0]); // Tối đa là 11 tuổi
    });

    function calculateTotal() {
        let totalSingleRoomCharge = 0;
        let totalPriceGuest = 0;

        // Kiểm tra các checkbox phòng đơn và tính tiền phụ thu
        const singleRoomToggles = document.querySelectorAll('input[type="checkbox"][id^="singleRoomToggle"]');
        singleRoomToggles.forEach(toggle => {
            if (toggle.checked) {
                totalSingleRoomCharge += priceSingleRoom; // Tính tiền phụ thu phòng đơn nếu checkbox được chọn
            }
        });

        // Tính tổng tiền khách hàng
        let totalAdultPrice = pricePerAdult * adultCount;
        let totalChildPrice = pricePerChild * childCount;
        totalPriceGuest = totalAdultPrice + totalChildPrice + totalSingleRoomCharge;

        // Cập nhật hiển thị
        document.getElementById('price-guest').textContent = `${totalPriceGuest.toLocaleString()} ₫`;
        document.getElementById('adultPrice').textContent = `${(pricePerAdult * adultCount).toLocaleString()} đ`;
        document.getElementById('childPrice').textContent = `${totalChildPrice.toLocaleString()} đ`;
        document.getElementById('singleRoomCharge').textContent = `${totalSingleRoomCharge.toLocaleString()} đ`;
        document.getElementById('totalAmount').textContent = `${totalPriceGuest.toLocaleString()} ₫`;
        document.getElementById('totalAmount_input').value = `${totalPriceGuest}`;

        // Hiển thị hoặc ẩn phần khách trẻ em dựa trên số lượng
        document.getElementById('childGuest').style.display = childCount > 0 ? "flex" : "none";
    }

    // Hàm tăng số lượng
    function increment(type) {
        // Kiểm tra tổng số ghế đã được chọn
        const totalSeatsSelected = adultCount + childCount;

        if (totalSeatsSelected >= maxSeats) {
            alert(`Không thể đặt quá ${maxSeats} chỗ.`);
            return; // Dừng nếu vượt quá số chỗ tối đa
        }

        if (type === 'adultCount') {
            if (adultCount < maxSeats) {
                adultCount++;
                document.getElementById('adultCount').value = adultCount;
                updatePassengerInfo(); // Cập nhật thông tin hành khách
                updateSingleRoomToggle(); // Cập nhật trạng thái phòng đơn
            }
        } else if (type === 'childCount') {
            childCount++;
            document.getElementById('childCount').value = childCount;
            updatePassengerInfo(); // Cập nhật thông tin hành khách cho trẻ e
            updateSingleRoomToggle(); // Cập nhật trạng thái phòng đơn
        }

        calculateTotal(); // Cập nhật tổng tiền
    }

    // Hàm giảm số lượng
    function decrement(type) {
        if (type === 'adultCount' && adultCount > 1) {
            adultCount--;
            document.getElementById('adultCount').value = adultCount;
            updatePassengerInfo(); // Cập nhật thông tin hành khách
            updateSingleRoomToggle(); // Cập nhật trạng thái phòng đơn
        } else if (type === 'childCount' && childCount > 0) {
            childCount--;
            document.getElementById('childCount').value = childCount;
            updatePassengerInfo(); // Cập nhật thông tin hành khách
            updateSingleRoomToggle(); // Cập nhật trạng thái phòng đơn
        }
        calculateTotal(); // Cập nhật tổng tiền
    }

    // Cập nhật thông tin hành khách
    function updatePassengerInfo() {
        const container = document.getElementById('passengerInfoContainer');
        container.innerHTML = ''; // Xóa nội dung cũ

        // Thêm thông tin cho người lớn
        for (let i = 0; i < adultCount; i++) {
            const adultInfo = `
            <div class="mb-4">
                <label class="block mb-1">Người lớn ${i + 1} (Từ 12 tuổi trở lên)</label>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <input type="text" name="passengerName_Adult[]" placeholder="Họ tên" class="p-2 border rounded" required/>
                    <input type="date" name="passengerBirthdate_Adult[]" placeholder="Ngày sinh" class="p-2 border rounded" max="${minBirthdateAdult}" required/>
                    <div class="relative">
                        <select name="passengerGender_Adult[]" class="w-full p-2 border rounded appearance-none" required>
                            <option>Nam</option>
                            <option>Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <label class="block mb-1">Phòng đơn</label>
                        <input type="checkbox" name="singleRoom[]" id="singleRoomToggle${i + 1}" class="react-switch-checkbox hidden" onchange="handleSingleRoomToggle(this, ${i + 1})">
                        <label for="singleRoomToggle${i + 1}" class="react-switch-label block w-12 h-6 rounded-full cursor-pointer bg-gray-300">
                            <span class="react-switch-button absolute top-1 left-1 w-4 h-4 rounded-full bg-white transition-transform transform-gpu duration-300"></span>
                        </label>
                    </div>
                    <span class="text-right font-semibold">{{ number_format($tour->price_single_room) }} đ</span>
                </div>
            </div>
        `;
            container.innerHTML += adultInfo;
        }

        // Thêm thông tin cho trẻ em (nếu có)
        for (let j = 0; j < childCount; j++) {
            const childInfo = `
            <div class="mb-4">
                <label class="block mb-1">Trẻ em ${j + 1} (Từ 2 - 11 tuổi)</label>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <input type="text" name="passengerName_Child[]" placeholder="Họ tên" class="p-2 border rounded" required/>
                    <input type="date" name="passengerBirthdate_Child[]" placeholder="Ngày sinh" class="p-2 border rounded" min="${minBirthdateChild}" max="${maxBirthdateChild}" required/>
                    <div class="relative">
                        <select name="passengerGender_Child[]" class="w-full p-2 border rounded appearance-none" required>
                            <option>Nam</option>
                            <option>Nữ</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
            container.innerHTML += childInfo;
        }
    }

    // Cập nhật trạng thái của phòng đơn
    function updateSingleRoomToggle() {
        const singleRoomToggles = document.querySelectorAll('input[type="checkbox"][id^="singleRoomToggle"]');

        singleRoomToggles.forEach((toggle, index) => {
            if (adultCount === 1 && index === 0) {
                toggle.disabled = false; // Bật cho người lớn đầu tiên
                toggle.checked = true; // Giữ trạng thái bật
            } else if (adultCount > 1) {
                toggle.disabled = false; // Bật nếu có nhiều hơn một người lớn
                toggle.checked = false; // Đặt trạng thái là tắt
            } else {
                toggle.disabled = true; // Tắt nếu không có người lớn
            }
        });
    }

    // Xử lý trạng thái toggle phòng đơn
    function handleSingleRoomToggle(toggle, index) {
        if (adultCount === 1) {
            // Ngăn không cho tắt nếu chỉ có 1 người lớn
            if (!toggle.checked) {
                toggle.checked = true; // Trở về trạng thái bật
            }
        }
        calculateTotal(); // Cập nhật tổng tiền khi thay đổi trạng thái phòng đơn
    }

    // Gọi hàm khi tải trang
    updatePassengerInfo(); // Khởi tạo thông tin hành khách
    updateSingleRoomToggle(); // Khởi tạo trạng thái phòng đơn
</script>
@endsection