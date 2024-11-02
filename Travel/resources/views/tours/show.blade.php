@extends('layouts.app')

@section('content')
    @if (is_null($tour) || empty($tour->id))
        <div class="tour-page">
            <div class="container mt-4">
                <div class="col-12 text-center">
                    <h4 class="text-danger">Tour does not exist</h4>
                </div>
            </div>

        </div>
    @else
        <div class="tour-page">
            <div class="container max-w-screen-xl mx-auto p-5">
                <h2 class="m-4 text-3xl">{{ $tour->name }}</h2>
                <div class="row">
                    <!-- Phần 1: Nội dung chính -->
                    <div class="col-lg-8">
                        <div id="tour-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Hiển thị hình ảnh chính của tour -->
                                <div class="carousel-item active">
                                    <img src="{{ asset('img/tours/' . $tour->image_main) }}" class="d-block w-100"
                                        alt="{{ $tour->name }}">
                                </div>
                                <!-- Hiển thị các hình ảnh khác -->
                                @foreach ($images as $image)
                                    <div class="carousel-item">
                                        <img src="{{ asset('img/tours/' . $image->image) }}" class="d-block w-100"
                                            alt="{{ $tour->name }}">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#tour-carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#tour-carousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>

                        <!-- Introductio Section -->
                        <div class="row mt-4 intro-section">
                            <div class="col-lg-12">
                                <h3 class="text-2xl">Introduction to the tour</h3>
                                <p><strong>Description:</strong> {{ $tour->description }}</p>
                            </div>
                        </div>


                        <!-- Departure Schedule Section -->
                        <div class="row mt-4" id="scheduleTableContainer">
                            <div class="col-lg-12">
                                <h3 class="text-2xl">Departure Schedule</h3>
                                <!-- Ô chọn tháng -->
                                <div class="mt-4">
                                    <label for="monthSelect">Select Month:</label>
                                    <div id="monthGrid" class="d-flex flex-wrap">
                                        @php
                                            // Lấy tất cả tháng từ cơ sở dữ liệu
                                            $months = $departureSchedules
                                                ->pluck('date')
                                                ->map(function ($date) {
                                                    return date('n-Y', strtotime($date));
                                                })
                                                ->unique();
                                        @endphp

                                        @foreach ($months as $month)
                                            @php
                                                $monthParts = explode('-', $month);
                                                $monthNumber = $monthParts[0];
                                                $yearNumber = $monthParts[1];
                                                $isSelected = $monthNumber == date('n') && $yearNumber == date('Y');
                                            @endphp
                                            <div class="month-option {{ $isSelected ? 'selected' : '' }}"
                                                data-month="{{ $month }}"
                                                onclick="updateSchedule('{{ $month }}')">
                                                {{ date('F', mktime(0, 0, 0, $monthNumber, 1)) }} {{ $yearNumber }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <h4 class="text-2xl mt-4" id="currentMonthDisplay">Current Month: {{ date('F Y') }}
                                    </h4>
                                    <table class="table table-bordered" id="scheduleTable">
                                        <thead class="table-header">
                                            <tr>
                                                <th>Mon</th>
                                                <th>Tue</th>
                                                <th>Wed</th>
                                                <th>Thu</th>
                                                <th>Fri</th>
                                                <th>Sat</th>
                                                <th>Sun</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Tính số ngày trong tháng đầu tiên
                                                $currentMonth = date('n');
                                                $currentYear = date('Y');
                                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                                                $firstDayOfMonth = strtotime("first day of {$currentYear}-{$currentMonth}");
                                                $startDay = date('w', $firstDayOfMonth);
                                                $startDay = $startDay === 0 ? 6 : $startDay - 1; // Đổi Chủ Nhật (0) thành thứ Bảy (6)
                                    
                                                $currentDay = 1;
                                            @endphp
                                    
                                            @for ($week = 0; $week < 6; $week++)
                                                <tr>
                                                    @for ($day = 0; $day < 7; $day++)
                                                        @if (($week === 0 && $day < $startDay) || $currentDay > $daysInMonth)
                                                            <td></td>
                                                        @else
                                                            @php
                                                                // Tìm ngày có giá trong mảng $departureSchedules
                                                                $dateString = date('Y-m-d', strtotime("{$currentYear}-{$currentMonth}-{$currentDay}"));
                                                                $schedule = $departureSchedules->firstWhere('date', $dateString);
                                                                $price = $schedule ? number_format($schedule->price) . ' VND' : '';
                                                            @endphp
                                                            <td class="{{ $schedule ? 'clickable-day' : 'no-price' }}"
                                                                data-price="{{ $schedule ? json_encode($schedule) : '{}' }}"
                                                                onclick="updatePrice({{ $schedule ? json_encode($schedule) : '{}' }})">
                                                                {{ $currentDay }}<br>
                                                                <span>{{ $price }}</span>
                                                            </td>
                                                            @php
                                                                $currentDay++;
                                                            @endphp
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div id="priceDisplay" class="mt-3"></div>
                            </div>
                        </div>

                        <!-- More Information Section -->
                        <div class="mt-4 flex flex-wrap">
                            <div class="w-full">
                                <h3 class="text-3xl font-bold mb-6 text-center text-gray-800">More Information About the
                                    Trip</h3>
                                @if ($tripInformations->isEmpty())
                                    <p class="text-center text-lg text-gray-600">No additional trip information available.
                                    </p>
                                @else
                                    <div class="flex flex-wrap w-full">
                                        @foreach ($tripInformations as $tripInfo)
                                            <div class="w-full lg:w-1/3 md:w-1/2 p-2 flex justify-center">
                                                <div
                                                    class="bg-white shadow-lg rounded-lg text-center transition-transform transform hover:scale-105 hover:shadow-xl duration-300">
                                                    <div class="p-4">
                                                        <img class="icon mb-4 mx-auto h-24 w-24 object-cover"
                                                            src="{{ asset('img/tours/trip_information/' . $tripInfo->tripDirectory->icon) }}"
                                                            alt="{{ $tripInfo->tripDirectory->title }}" />
                                                        <h5 class="text-xl font-semibold text-gray-800">
                                                            {{ $tripInfo->tripDirectory->title }}
                                                        </h5>
                                                        <p class="text-gray-700 text-center mt-2 w-full">
                                                            {{ $tripInfo->content }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Schedule Section -->
                        <div class="mt-4">
                            <div class="w-full">
                                <h3 class="text-3xl font-bold text-center mb-6 text-gray-800">Schedule</h3>
                                <div class="accordion" id="scheduleAccordion">
                                    @php $day = 1; @endphp <!-- Bắt đầu đếm ngày từ 1 -->
                                    @foreach ($itineraries as $itinerary)
                                        <div
                                            class="border border-gray-300 rounded-lg mb-4 shadow-md transition-shadow duration-300 hover:shadow-lg">
                                            <div class="bg-white text-white p-4 cursor-pointer rounded-t-lg"
                                                id="day{{ $day }}"
                                                onclick="toggleCollapse('collapseDay{{ $day }}')"
                                                onmousedown="event.preventDefault();"> <!-- Ngăn chọn văn bản -->
                                                <h5 class="mb-0 font-semibold">
                                                    Day {{ $day }}: {{ $itinerary->title }}
                                                </h5>
                                            </div>
                                            <div id="collapseDay{{ $day }}"
                                                class="overflow-hidden transition-all duration-300 max-h-0">
                                                <div class="p-4 border-t border-gray-300 bg-gray-100">
                                                    <p class="text-gray-700">{{ $itinerary->description }}</p>
                                                    <!-- Mô tả cho từng lịch trình -->
                                                </div>
                                            </div>
                                        </div>
                                        @php $day++; @endphp <!-- Tăng biến đếm ngày sau mỗi lần lặp -->
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleCollapse(id) {
                                const content = document.getElementById(id);
                                const isOpen = content.style.maxHeight;

                                if (isOpen) {
                                    content.style.maxHeight = null;
                                } else {
                                    content.style.maxHeight = content.scrollHeight + "px"; // Đặt chiều cao tối đa bằng chiều cao nội dung
                                }
                            }
                        </script>


                        <!-- Important Information Section -->
                        <div class="row mt-8">
                            <div class="col-lg-12">
                                <h3 class="text-3xl font-bold mb-6">Important Information</h3>

                                @if ($importantInfos->isEmpty())
                                    <p class="text-gray-500">No important information available for this tour.</p>
                                @else
                                    <div class="accordion" id="importantInfoAccordion">
                                        <div class="row">
                                            @foreach ($importantInfos as $index => $info)
                                                <div class="col-md-6 mb-4"> <!-- Sử dụng col-md-6 để chia thành 2 cột -->
                                                    <div
                                                        class="card bg-white  border border-gray-200 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                                                        <div class="card-header bg-gray  text-yellow-200 rounded-t-lg cursor-pointer"
                                                            id="heading{{ $index }}">
                                                            <h5 class="mb-0">
                                                                <button
                                                                    class="flex justify-between w-full text-left p-4 bg-transparent focus:outline-none"
                                                                    type="button" data-toggle="collapse"
                                                                    data-target="#collapse{{ $index }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{ $index }}">
                                                                    <span
                                                                        class="font-semibold ">{{ $info->title }}</span>
                                                                    <span class="ml-2 text-yellow-400">&#x25BC;</span>
                                                                    <!-- Icon mũi tên -->
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapse{{ $index }}" class="collapse"
                                                            aria-labelledby="heading{{ $index }}"
                                                            data-parent="#importantInfoAccordion">
                                                            <div class="card-body p-4 bg-white rounded-b-lg">
                                                                <p class="text-gray-700">{{ $info->information }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Section -->
                    <div class="col-lg-4 fixed-right">
                        @if (is_null($minPriceSchedule) || empty($minPriceSchedule))
                            <div class="card p-3">
                                <div class="price_old"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <p style="font-weight: bold; margin: 0;">Price:</p>
                                    <p id="originalPrice" style="text-decoration: line-through; margin: 0;">
                                        {{ number_format($tour->price) }} VND / Guest</p>

                                </div>
                                <h4 id="discountPrice" class="text-danger">
                                    {{ number_format($tour->price) }} VND / Guest
                                </h4>
                                <p>Hiện tại chưa có lịch trình có chuyến du lịch này.</p>
                                @auth
                                    <!-- Nếu người dùng đã đăng nhập, hiện nút Book Now -->
                                    <button class="btn btn-primary btn-block" id="bookNowBtn" type="button"
                                        onclick="redirectToBookingPage({{ $tour->id }})">
                                        Book Now
                                    </button>
                                @else
                                    <!-- Nếu người dùng chưa đăng nhập, hiện nút Đăng nhập hoặc thông báo yêu cầu đăng nhập -->
                                    <a href="{{ route('login') }}" class="btn btn-secondary btn-block">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        @else
                            <div class="card p-4 mb-4 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3" id="priceOldSection">
                                    @if ($tour->price >= $minPriceSchedule->price)
                                        <h5 class="font-weight-bold">Price:</h5>
                                        <span id="originalPrice" class="text-gray font-weight-bold line-through">
                                            {{ number_format($tour->price) }} VND / Guest
                                        </span>
                                    @endif
                                </div>
                                <h4 id="discountPrice" class="text-danger font-weight-bold mb-3">
                                    {{ number_format($minPriceSchedule->price) }} VND / Guest
                                </h4>
                                <p class="text-muted">Program code: <span
                                        class="font-weight-bold">{{ $tour->program_code }}</span></p>
                                <p class="text-muted">Depart: <span class="font-weight-bold"
                                        id="departureLocation">{{ $tour->departureLocation->name }}</span></p>
                                <p class="text-muted">Departure date: <span class="font-weight-bold"
                                        id="departureDate">{{ date('d-m-Y', strtotime($minPriceSchedule->date)) }}</span>
                                </p>
                                <p class="text-muted">Time: <span class="font-weight-bold">{{ $tour->number_days }}
                                        Days</span></p>
                                <p class="text-muted">Number of seats left: <span class="font-weight-bold"
                                        id="seatNumber">{{ $minPriceSchedule->seat_number }}</span></p>
                                @auth
                                    <!-- Nếu người dùng đã đăng nhập, hiện nút Book Now -->
                                    <button class="btn btn-primary btn-block mt-3" id="bookNowBtn" type="button"
                                        onclick="redirectToBookingPage({{ $tour->id }})">
                                        Book Now
                                    </button>
                                @else
                                    <!-- Nếu người dùng chưa đăng nhập, hiện nút Đăng nhập hoặc thông báo yêu cầu đăng nhập -->
                                    <a href="{{ route('login') }}" class="btn btn-secondary btn-block mt-3">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
                <h2 class="text-center text-2xl font-semibold my-8">Other Tours</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if ($suggestedTours->isEmpty())
                        <div class="col-span-full text-center">
                            <h4 class="text-red-600 text-lg">There are no tours</h4>
                        </div>
                    @else
                        @foreach ($suggestedTours as $suggestedTour)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full">
                                <div class="relative">
                                    <img class="w-full h-48 object-cover"
                                        src="{{ asset('img/tours/' . $suggestedTour->image_main) }}"
                                        alt="{{ $suggestedTour->name }}" loading="lazy">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-2">
                                        <span class="flex items-center"><i
                                                class="fa fa-map-marker-alt text-primary mr-1"></i>{{ $suggestedTour->destination->name ?? 'Unknown Destination' }}</span>
                                        <span class="flex items-center"><i
                                                class="fa fa-calendar-alt text-primary mr-1"></i>{{ $suggestedTour->number_days }}
                                            days</span>
                                        <span class="flex items-center"><i
                                                class="fa fa-user text-primary mr-1"></i>{{ $suggestedTour->person }}
                                            Person</span>
                                    </div>
                                    <a href="{{ route('tours.show', ['slug' => $suggestedTour->slug]) }}"
                                        class="text-xl font-semibold text-gray-800 hover:text-blue-600 transition duration-200 mb-4">
                                        {{ $suggestedTour->name }}
                                    </a>
                                    <div class="border-t mt-auto pt-4">
                                        <div class="flex justify-between items-center">
                                            <h5 class="text-lg font-medium text-gray-700">Price:</h5>
                                            <h5 class="text-lg font-bold text-red-600">
                                                {{ number_format($suggestedTour->price) }} VND</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
        <script>
            let selectedScheduleId = null;

            @if (isset($minPriceSchedule))
                const minPriceScheduleId = {{ $minPriceSchedule->id }};
            @else
                const minPriceScheduleId = null; // Hoặc giá trị mặc định nếu không tìm thấy lịch trình
            @endif



            function redirectToBookingPage(id) {

                // Nếu không có lịch trình nào được chọn, sử dụng lịch trình có giá thấp nhất
                const scheduleIdToUse = selectedScheduleId || minPriceScheduleId;

                // Gọi endpoint để mã hóa ID
                $.ajax({
                    url: `/encrypt-id/${scheduleIdToUse}`, // Gọi endpoint mã hóa ID
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const encodedScheduleId = data.encryptedId; // Nhận ID đã mã hóa
                        const url =
                            `/booking/${id}?departure_schedule_id=${encodedScheduleId}`; // Sử dụng ID đã mã hóa
                        window.location.href = url; // Chuyển hướng đến URL
                    },
                    error: function(xhr, status, error) {
                        console.error('Error encrypting ID:', error);
                        console.error('Response:', xhr.responseText); // Để kiểm tra phản hồi
                    }
                });
            }



            function formatDate(dateString) {
                // Tách các phần ngày, tháng, năm từ chuỗi
                const [year, month, day] = dateString.split('-');

                // Định dạng lại thành 'd m y'
                return `${day}-${month}-${year}`;
            }
            const departureSchedules = @json($departureSchedules);


            function updateSchedule(selectedMonthYear) {
                const [selectedMonth, currentYear] = selectedMonthYear.split('-'); // Tách tháng và năm
                const daysInMonth = new Date(currentYear, selectedMonth, 0).getDate(); // Số ngày trong tháng
                const firstDayOfMonth = new Date(currentYear, selectedMonth - 1, 1); // Ngày đầu tiên của tháng
                const startDay = (firstDayOfMonth.getDay() === 0) ? 6 : firstDayOfMonth.getDay() -
                    1; // Ngày trong tuần đầu tháng (điều chỉnh để bắt đầu từ thứ Hai)
                let currentDay = 1;
                let scheduleHtml = '';

                // Lấy dữ liệu giá từ PHP
                const priceData = {};
                departureSchedules.forEach(schedule => {
                    const dateParts = schedule.date.split('-'); // Chia ngày thành phần
                    const month = dateParts[1]; // Tháng
                    const day = dateParts[2]; // Ngày
                    const price = Number(schedule.price).toLocaleString('en-US') + ' VND'; // Định dạng số
                    priceData[`${month}-${day}`] = schedule; // Lưu giá theo định dạng 'mm-dd'
                });

                // Tạo HTML cho bảng lịch trình
                for (let week = 0; week < 6; week++) {
                    scheduleHtml += '<tr>';
                    for (let day = 0; day < 7; day++) {
                        if (week === 0 && day < startDay || currentDay > daysInMonth) {
                            scheduleHtml += '<td></td>'; // Ô trống cho các ngày không thuộc tháng
                        } else {
                            const dateString =
                                `${currentYear}-${String(selectedMonth).padStart(2, '0')}-${String(currentDay).padStart(2, '0')}`; // Định dạng ngày
                            const schedule = priceData[
                                    `${String(selectedMonth).padStart(2, '0')}-${String(currentDay).padStart(2, '0')}`] ||
                                null; // Tìm lịch trình

                            const price = schedule ? Number(schedule.price).toLocaleString('en-US') + ' VND' : ''; // Lấy giá
                            const scheduleData = schedule ? JSON.stringify(schedule).replace(/"/g, '&quot;') :
                                '{}'; // Escape dấu nháy
                            scheduleHtml += `
                <td class="${schedule ? 'clickable-day' : 'no-price'}" 
                    data-price="${scheduleData}" 
                    onclick="updatePrice(${schedule ? scheduleData : 'null'})">
                    ${currentDay}<br>
                    <span style="font-weight: bold;">${price}</span>
                </td>`;
                            currentDay++;
                        }
                    }
                    scheduleHtml += '</tr>';
                }

                // Cập nhật bảng lịch trình
                document.querySelector('#scheduleTable tbody').innerHTML = scheduleHtml;

                // Cập nhật thông tin tháng hiện tại hiển thị
                const monthDisplay = document.querySelector('#currentMonthDisplay');
                monthDisplay.innerHTML =
                    `Current Month: ${new Date(firstDayOfMonth).toLocaleString('en-US', { month: 'long', year: 'numeric' })}`;

                // Bỏ chọn tất cả tháng và chỉ đánh dấu tháng được chọn
                document.querySelectorAll('.month-option').forEach(option => {
                    option.classList.remove('selected');
                });
                document.querySelector(`.month-option[data-month="${selectedMonthYear}"]`).classList.add('selected');
            }

            function updatePrice(schedule) {
                // Xóa class 'selected' khỏi tất cả các ô
                const allDays = document.querySelectorAll('#scheduleTable td');
                allDays.forEach(day => {
                    day.classList.remove('selected'); // Xóa class selected khỏi tất cả ô
                });

                if (schedule) {
                    const price = Number(schedule.price).toLocaleString('en-US') + ' VND / Guest';
                    const date = formatDate(schedule.date);
                    const seatNumber = schedule.seat_number;

                    // Cập nhật thông tin vào các phần tử HTML
                    document.getElementById('discountPrice').innerHTML = price;

                    // Ẩn giá cũ nếu giá giảm lớn hơn giá cũ
                    const originalPrice = Number({{ $tour->price }});
                    const currentPrice = Number(schedule.price);
                    const priceOldSection = document.getElementById('priceOldSection');
                    if (currentPrice >= originalPrice) {
                        priceOldSection.style.display = 'none'; // Ẩn phần giá cũ
                    } else {
                        priceOldSection.style.display = 'flex'; // Hiện phần giá cũ
                    }

                    document.getElementById('departureDate').innerHTML = date;
                    document.getElementById('seatNumber').innerHTML = seatNumber;



                    // Cập nhật biến selectedScheduleId
                    selectedScheduleId = schedule.id; // Cập nhật ID lịch trình đã chọn

                    // Tô màu cho ô được chọn
                    if (schedule.date) {
                        const dateParts = schedule.date.split('-'); // Kiểm tra sự tồn tại của schedule.date
                        if (dateParts.length === 3) { // Đảm bảo dateParts có đủ ba phần (year, month, day)
                            const month = dateParts[1]; // Tháng
                            const day = dateParts[2]; // Ngày

                            const cell = Array.from(document.querySelectorAll('#scheduleTable td')).find(td => {
                                const cellData = td.dataset.price ? JSON.parse(td.dataset.price) :
                                    null; // Lấy dữ liệu từ data-price
                                const cellDateParts = cellData && cellData.date ? cellData.date.split('-') :
                            []; // Kiểm tra sự tồn tại của cellData.date
                                return cellDateParts.length === 3 && cellDateParts[1] === month && cellDateParts[2] ===
                                    day; // So sánh tháng và ngày
                            });

                            if (cell) {
                                cell.classList.add('selected'); // Thêm class 'selected' vào ô được chọn
                            }
                        } else {
                            console.error("Invalid date format:", schedule.date);
                        }
                    } else {
                        console.error("Schedule does not have a date:", schedule);
                    }
                } else {
                    console.error("Schedule not found");
                }
            }
        </script>

    @endif
@endsection
