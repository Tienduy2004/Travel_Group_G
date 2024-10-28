@extends('layouts.app')

@section('content')
    @if (is_null($tour) || empty($tour->id) || is_null($minPriceSchedule) || empty($minPriceSchedule))
        <div class="tour-page">
            <div class="container mt-4">
                <div class="col-12 text-center">
                    <h4 class="text-danger">Tour does not exist</h4>
                </div>
            </div>

        </div>
    @else
        <div class="tour-page">
            <div class="container mt-4">
                <h2>{{ $tour->name }}</h2>
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
                                <h3>Introduction to the tour</h3>
                                <p><strong>Description:</strong> {{ $tour->description }}</p>
                            </div>
                        </div>


                        <!-- Departure Schedule Section -->
                        <div class="row mt-4" id="scheduleTableContainer">
                            <div class="col-lg-12">
                                <h3>Departure Schedule</h3>
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
                                    <h4 id="currentMonthDisplay">Current Month: {{ date('F Y') }}</h4>
                                    <table class="table table-bordered" id="scheduleTable">
                                        <thead>
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
                                                $daysInMonth = cal_days_in_month(
                                                    CAL_GREGORIAN,
                                                    $currentMonth,
                                                    $currentYear,
                                                );
                                                $firstDayOfMonth = strtotime(
                                                    "first day of {$currentYear}-{$currentMonth}",
                                                );
                                                $startDay = date('w', $firstDayOfMonth);
                                                // Điều chỉnh startDay để bắt đầu từ thứ Hai
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
                                                                $dateString = date(
                                                                    'Y-m-d',
                                                                    strtotime(
                                                                        "{$currentYear}-{$currentMonth}-{$currentDay}",
                                                                    ),
                                                                );
                                                                $schedule = $departureSchedules->firstWhere(
                                                                    'date',
                                                                    $dateString,
                                                                );
                                                                $price = $schedule
                                                                    ? number_format($schedule->price) . ' VND'
                                                                    : '';

                                                            @endphp
                                                            <td class="{{ $schedule ? 'clickable-day' : 'no-price' }}"
                                                                data-price="{{ $schedule ? json_encode($schedule) : '{}' }}"
                                                                onclick="updatePrice({{ $schedule ? json_encode($schedule) : '{}' }})">
                                                                {{ $currentDay }}<br>
                                                                <span style="font-weight: bold;">{{ $price }}</span>
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
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <h3>More Information About the Trip</h3>
                                @if ($tripInformations->isEmpty())
                                    <p>No additional trip information available.</p>
                                @else
                                    <div class="row">
                                        @foreach ($tripInformations as $tripInfo)
                                            <div class="col-lg-4 col-md-6 mb-4">
                                                <div class="card text-center equal-card">
                                                    <div class="card-body">
                                                        <img class="icon"
                                                            src="{{ asset('img/tours/trip_information/' . $tripInfo->tripDirectory->icon) }}"
                                                            alt="" />
                                                        <h5 class="card-title">{{ $tripInfo->tripDirectory->title }}</h5>
                                                        <p class="card-text">{{ $tripInfo->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Schedule Section -->
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <h3>Schedule</h3>
                                <div class="accordion" id="scheduleAccordion">
                                    @php $day = 1; @endphp <!-- Bắt đầu đếm ngày từ 1 -->
                                    @foreach ($itineraries as $itinerary)
                                        <div class="card">
                                            <div class="card-header" id="day{{ $day }}">
                                                <h5 class="mb-0">
                                                    <button style="inline-block" class="btn btn-link" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapseDay{{ $day }}"
                                                        aria-expanded="{{ $day == 1 ? 'true' : 'false' }}"
                                                        aria-controls="collapseDay{{ $day }}">
                                                        Day {{ $day }}: {{ $itinerary->title }}
                                                        <!-- Sử dụng title từ trip information -->
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseDay{{ $day }}"
                                                class="collapse {{ $day == 1 ? 'show' : '' }}"
                                                aria-labelledby="day{{ $day }}" data-parent="#scheduleAccordion">
                                                <div class="card-body">
                                                    {{ $itinerary->description }} <!-- Mô tả cho từng lịch trình -->
                                                </div>
                                            </div>
                                        </div>
                                        @php $day++; @endphp <!-- Tăng biến đếm ngày sau mỗi lần lặp -->
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Important Information Section -->
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <h3>Important Information</h3>

                                @if ($importantInfos->isEmpty())
                                    <p>No important information available for this tour.</p>
                                @else
                                    <div class="accordion" id="importantInfoAccordion">
                                        <div class="row">
                                            @foreach ($importantInfos as $index => $info)
                                                <div class="col-md-6 mb-3"> <!-- Sử dụng col-md-6 để chia thành 2 cột -->
                                                    <div class="card">
                                                        <div class="card-header" id="heading{{ $index }}">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link" type="button"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapse{{ $index }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{ $index }}">
                                                                    {{ $info->title }}
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapse{{ $index }}" class="collapse"
                                                            aria-labelledby="heading{{ $index }}"
                                                            data-parent="#importantInfoAccordion">
                                                            <div class="card-body">
                                                                {{ $info->information }}
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
                        <div class="card p-3">
                            <div class="price_old"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <p style="font-weight: bold; margin: 0;">Price:</p>
                                <p id="originalPrice" style="text-decoration: line-through; margin: 0;">
                                    {{ number_format($tour->price) }} VND / Guest</p>
                            </div>
                            <h4 id="discountPrice" class="text-danger">
                                {{ number_format($minPriceSchedule->price) }} VND / Guest
                            </h4>
                            <p>Program code: <span style="font-weight: bold;">{{ $tour->program_code }}</span></p>
                            <p>Depart: <span style="font-weight: bold;"
                                    id="departureLocation">{{ $tour->departureLocation->name }}</span></p>
                            <p>Departure date: <span style="font-weight: bold;"
                                    id="departureDate">{{ date('d-m-Y', strtotime($minPriceSchedule->date)) }}</span></p>
                            <p>Time: <span style="font-weight: bold;">{{ $tour->number_days }} Days</span></p>
                            <p>Number of seats left: <span style="font-weight: bold;"
                                    id="seatNumber">{{ $minPriceSchedule->seat_number }}</span></p>
                            @auth
                                <!-- Nếu người dùng đã đăng nhập, hiện nút Book Now -->
                                <button class="btn btn-primary btn-block" id="bookNowBtn" type="button"
                                    onclick="redirectToBookingPage({{ $tour->id}})">
                                    Book Now
                                </button>
                            @else
                                <!-- Nếu người dùng chưa đăng nhập, hiện nút Đăng nhập hoặc thông báo yêu cầu đăng nhập -->
                                <a href="{{ route('login') }}" class="btn btn-secondary btn-block">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                <h2 style="text-align: center">Other tours</h2>
                <div class="row">
                    @if ($suggestedTours->isEmpty())
                        <div class="col-12 text-center">
                            <h4 class="text-danger">There are no tours</h4>
                        </div>
                    @else
                        @foreach ($suggestedTours as $tour)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="package-item bg-white mb-2">
                                    <div class="image_tour">
                                        <img class="img-fluid" src="{{ asset('img/tours/' . $tour->image_main) }}"
                                            alt="{{ $tour->name }}" loading="lazy">
                                    </div>

                                    <div class="p-4">
                                        <div class="d-flex justify-content-between mb-3">
                                            <small class="m-0"><i
                                                    class="fa fa-map-marker-alt text-primary mr-2"></i>{{ $tour->destination->name ?? 'Unknown Destination' }}</small>
                                            <small class="m-0"><i
                                                    class="fa fa-calendar-alt text-primary mr-2"></i>{{ $tour->number_days }}
                                                days</small>
                                            <small class="m-0"><i
                                                    class="fa fa-user text-primary mr-2"></i>{{ $tour->person }}
                                                Person</small>
                                        </div>
                                        <a class="h5 text-decoration-none"
                                            href="{{ route('tours.show', ['slug' => $tour->slug]) }}">{{ $tour->name }}</a>
                                        <div class="border-top mt-4 pt-4">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="m-0">Price:</h5>
                                                <h5 class="m-0">{{ number_format($tour->price) }} VND</h5>
                                            </div>
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
            const minPriceScheduleId = {{ $minPriceSchedule->id }};

            function encodeIdWithKey(key, id) {
                // Nối key và id lại với nhau
                const combined = `${key}-${id}`;
                // Mã hóa bằng Base64
                return btoa(combined);
            }
            

            function redirectToBookingPage(id) {
                
                // Nếu không có lịch trình nào được chọn, sử dụng lịch trình có giá thấp nhất
                const scheduleIdToUse = selectedScheduleId || minPriceScheduleId;

                const key = '{{ env('YOUR_SECRET_KEY') }}'; // Lấy khóa bí mật từ .env
                const encodedScheduleId = encodeIdWithKey(key, scheduleIdToUse); // Mã hóa ID

                const url = `/booking/${id}?departure_schedule_id=${encodedScheduleId}`; // Sử dụng ID đã mã hóa
                window.location.href = url; // Chuyển hướng đến URL
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
