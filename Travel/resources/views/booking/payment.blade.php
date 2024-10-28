@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container mx-auto p-4 font-sans">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-4 md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">THÔNG TIN LIÊN LẠC</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold text-gray-600">Họ tên</p>
                        <p class="text-gray-800">E + PHÙNG TRẦN TIẾN DUY</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Email</p>
                        <p class="text-gray-800">duyphung344@gmail.com</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Điện thoại</p>
                        <p class="text-gray-800">*******253</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Địa chỉ</p>
                        <p class="text-gray-800">Vĩnh phú 42,Vĩnh phú,Thuận An,Bình Dương</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="font-semibold text-gray-600">Ghi chú</p>
                        <p class="text-gray-600">(Booking từ Travel.com.vn) 25/10: Hưng liên hệ khách báo hủy, đặt nhầm</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">CHI TIẾT BOOKING</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold text-gray-600">Mã đặt chỗ:</p>
                        <p class="text-red-600">241025EJRH5</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Ngày tạo:</p>
                        <p class="text-gray-800">25/10/2024 17:50</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Trị giá booking:</p>
                        <p class="text-gray-800">0 đ</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Hình thức thanh toán:</p>
                        <p class="text-gray-800">Tiền mặt</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Số tiền đã thanh toán:</p>
                        <p class="text-gray-800">0 đ</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Số tiền còn lại:</p>
                        <p class="text-gray-800">0 đ</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Tình trạng:</p>
                        <p class="text-red-600">Booking của quý khách đã hủy</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Thời hạn thanh toán:</p>
                        <p class="text-red-600">26/10/2024 05:50 - (Theo giờ Việt Nam. Booking sẽ tự động hủy nếu quá thời hạn thanh toán trên)</p>
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
                        <tr>
                            <td class="py-2 text-gray-800">PHÙNG TRẦN TIẾN DUY</td>
                            <td class="py-2 text-gray-800">06/04/2004</td>
                            <td class="py-2 text-gray-800">Nam</td>
                            <td class="py-2 text-gray-800">Người lớn (20 Tuổi)</td>
                            <td class="py-2 text-gray-800">Có</td>
                        </tr>
                    </tbody>
                </table>
                <p class="mt-4 font-semibold text-right">Tổng cộng: <span class="text-red-600">0 đ</span></p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">PHIẾU XÁC NHẬN BOOKING</h2>
                <img src="/placeholder.svg" alt="Tour destination" class="w-full h-40 object-cover rounded-lg mb-4">
                <p class="font-semibold mb-2 text-gray-800">Thái Lan: Bangkok - Pattaya (Khám phá Bảo tàng Sáp Louis Tussaud Pattaya, chùa Wat Ar...)</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold text-gray-600">Số booking:</p>
                        <p class="text-gray-800">241025EJRH5</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">MÃ TOUR:</p>
                        <p class="text-gray-800">NNSGN1303-006-160125VU-V-F</p>
                    </div>
                </div>
                <h3 class="font-semibold mt-4 mb-2 text-gray-600">THÔNG TIN CHUYẾN BAY</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div class="border-t pt-2">
                        <p class="font-semibold text-gray-600">Ngày đi - 16/01/2025</p>
                        <div class="flex justify-between text-gray-800">
                            <p>12:00</p>
                            <p>13:30</p>
                        </div>
                        <div class="flex justify-between items-center text-gray-800">
                            <p>SGN</p>
                            <img src="/placeholder.svg" alt="Airline" class="h-6 w-6">
                            <p>BKK</p>
                        </div>
                    </div>
                    <div class="border-t pt-2">
                        <p class="font-semibold text-gray-600">Ngày về - 20/01/2025</p>
                        <div class="flex justify-between text-gray-800">
                            <p>14:30</p>
                            <p>16:10</p>
                        </div>
                        <div class="flex justify-between items-center text-gray-800">
                            <p>BKK</p>
                            <img src="/placeholder.svg" alt="Airline" class="h-6 w-6">
                            <p>SGN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
