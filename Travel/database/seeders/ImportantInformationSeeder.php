<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportantInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('important_information')->insert([
            ['tour_id' => 1, 'title' => 'Thông tin quan trọng', 'information' => 'Vui lòng mang theo giấy tờ tùy thân và bảo hiểm du lịch.'],
            ['tour_id' => 1, 'title' => 'Chú ý', 'information' => 'Hãy mang theo tiền mặt để chi tiêu cá nhân.'],
            ['tour_id' => 1, 'title' => 'Thông tin thời tiết', 'information' => 'Hạ Long thường có thời tiết mát mẻ vào mùa hè.'],
            ['tour_id' => 1, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 10% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 1, 'title' => 'Thông tin an toàn', 'information' => 'Chúng tôi khuyến khích bạn giữ liên lạc với nhóm hướng dẫn.'],
            ['tour_id' => 1, 'title' => 'Thông tin sức khỏe', 'information' => 'Khách hàng cần có sức khỏe tốt để tham gia các hoạt động.'],
            ['tour_id' => 2, 'title' => 'Thông tin quan trọng', 'information' => 'Vui lòng kiểm tra hộ chiếu trước khi đi.'],
            ['tour_id' => 2, 'title' => 'Chú ý', 'information' => 'Mang theo ô dù trong mùa mưa ở Bangkok.'],
            ['tour_id' => 2, 'title' => 'Thông tin thời tiết', 'information' => 'Bangkok thường nóng ẩm quanh năm.'],
            ['tour_id' => 2, 'title' => 'Khuyến mãi', 'information' => 'Giảm 15% cho nhóm từ 4 người trở lên.'],
            ['tour_id' => 2, 'title' => 'Thông tin an toàn', 'information' => 'Cẩn thận với đồ đạc cá nhân khi tham quan.'],
            ['tour_id' => 2, 'title' => 'Thông tin sức khỏe', 'information' => 'Nên tiêm phòng trước khi đi.'],
            ['tour_id' => 3, 'title' => 'Thông tin quan trọng', 'information' => 'Cần có visa để nhập cảnh vào Nhật Bản.'],
            ['tour_id' => 3, 'title' => 'Chú ý', 'information' => 'Nên mang theo tiền mặt vì một số nơi không chấp nhận thẻ tín dụng.'],
            ['tour_id' => 3, 'title' => 'Thông tin thời tiết', 'information' => 'Tokyo có thể lạnh vào mùa đông, vui lòng chuẩn bị áo ấm.'],
            ['tour_id' => 3, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 10% cho khách hàng đăng ký trực tuyến.'],
            ['tour_id' => 3, 'title' => 'Thông tin an toàn', 'information' => 'Tham gia tour theo nhóm để đảm bảo an toàn.'],
            ['tour_id' => 3, 'title' => 'Thông tin sức khỏe', 'information' => 'Khách hàng cần có sức khỏe tốt để tham gia các hoạt động.'],
            ['tour_id' => 4, 'title' => 'Thông tin quan trọng', 'information' => 'Kiểm tra lịch trình chuyến bay trước khi đi.'],
            ['tour_id' => 4, 'title' => 'Chú ý', 'information' => 'Mang theo thẻ bảo hiểm y tế và giấy tờ tùy thân.'],
            ['tour_id' => 4, 'title' => 'Thông tin thời tiết', 'information' => 'Seoul có thể lạnh vào mùa đông, vui lòng chuẩn bị áo ấm.'],
            ['tour_id' => 4, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 15% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 4, 'title' => 'Thông tin an toàn', 'information' => 'Chúng tôi khuyến khích bạn giữ liên lạc với nhóm hướng dẫn.'],
            ['tour_id' => 4, 'title' => 'Thông tin sức khỏe', 'information' => 'Nên tiêm phòng cúm trước khi đi.'],
            ['tour_id' => 5, 'title' => 'Thông tin quan trọng', 'information' => 'Đảm bảo kiểm tra giờ khởi hành trước chuyến đi.'],
            ['tour_id' => 5, 'title' => 'Chú ý', 'information' => 'Mang theo tiền mặt để chi tiêu cá nhân.'],
            ['tour_id' => 5, 'title' => 'Thông tin thời tiết', 'information' => 'New York có thể lạnh vào mùa đông, vui lòng chuẩn bị áo ấm.'],
            ['tour_id' => 5, 'title' => 'Khuyến mãi', 'information' => 'Giảm 10% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 5, 'title' => 'Thông tin an toàn', 'information' => 'Cần cẩn thận với đồ đạc cá nhân khi tham quan.'],
            ['tour_id' => 5, 'title' => 'Thông tin sức khỏe', 'information' => 'Nên có bảo hiểm du lịch khi tham gia tour.'],
            ['tour_id' => 6, 'title' => 'Thông tin quan trọng', 'information' => 'Cần có visa để nhập cảnh vào Anh.'],
            ['tour_id' => 6, 'title' => 'Chú ý', 'information' => 'Mang theo ô dù trong mùa mưa ở London.'],
            ['tour_id' => 6, 'title' => 'Thông tin thời tiết', 'information' => 'London thường có thời tiết lạnh và ẩm.'],
            ['tour_id' => 6, 'title' => 'Khuyến mãi', 'information' => 'Giảm 15% cho nhóm từ 5 người trở lên.'],
            ['tour_id' => 6, 'title' => 'Thông tin an toàn', 'information' => 'Tham gia tour theo nhóm để đảm bảo an toàn.'],
            ['tour_id' => 6, 'title' => 'Thông tin sức khỏe', 'information' => 'Khách hàng cần có sức khỏe tốt để tham gia các hoạt động.'],
            ['tour_id' => 7, 'title' => 'Thông tin quan trọng', 'information' => 'Vui lòng mang theo giấy tờ tùy thân và bảo hiểm du lịch.'],
            ['tour_id' => 7, 'title' => 'Chú ý', 'information' => 'Nên đặt trước vé tham quan một số địa điểm nổi tiếng.'],
            ['tour_id' => 7, 'title' => 'Thông tin thời tiết', 'information' => 'Paris có thể có mưa bất chợt, vui lòng chuẩn bị ô.'],
            ['tour_id' => 7, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 10% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 7, 'title' => 'Thông tin an toàn', 'information' => 'Tham gia tour theo nhóm để đảm bảo an toàn.'],
            ['tour_id' => 7, 'title' => 'Thông tin sức khỏe', 'information' => 'Khách hàng cần có sức khỏe tốt để tham gia các hoạt động.'],
            ['tour_id' => 8, 'title' => 'Thông tin quan trọng', 'information' => 'Kiểm tra visa trước khi tham gia tour.'],
            ['tour_id' => 8, 'title' => 'Chú ý', 'information' => 'Mang theo thẻ bảo hiểm y tế và giấy tờ tùy thân.'],
            ['tour_id' => 8, 'title' => 'Thông tin thời tiết', 'information' => 'Sydney có thể có thời tiết đẹp quanh năm.'],
            ['tour_id' => 8, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 15% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 8, 'title' => 'Thông tin an toàn', 'information' => 'Cần cẩn thận với đồ đạc cá nhân khi tham quan.'],
            ['tour_id' => 8, 'title' => 'Thông tin sức khỏe', 'information' => 'Nên có bảo hiểm du lịch khi tham gia tour.'],
            ['tour_id' => 9, 'title' => 'Thông tin quan trọng', 'information' => 'Đảm bảo kiểm tra giờ khởi hành trước chuyến đi.'],
            ['tour_id' => 9, 'title' => 'Chú ý', 'information' => 'Mang theo tiền mặt để chi tiêu cá nhân.'],
            ['tour_id' => 9, 'title' => 'Thông tin thời tiết', 'information' => 'Toronto có thể lạnh vào mùa đông, vui lòng chuẩn bị áo ấm.'],
            ['tour_id' => 9, 'title' => 'Khuyến mãi', 'information' => 'Giảm 10% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 9, 'title' => 'Thông tin an toàn', 'information' => 'Cần cẩn thận với đồ đạc cá nhân khi tham quan.'],
            ['tour_id' => 9, 'title' => 'Thông tin sức khỏe', 'information' => 'Nên có bảo hiểm du lịch khi tham gia tour.'],
            ['tour_id' => 10, 'title' => 'Thông tin quan trọng', 'information' => 'Cần có visa để nhập cảnh vào Đức.'],
            ['tour_id' => 10, 'title' => 'Chú ý', 'information' => 'Mang theo ô dù trong mùa mưa ở Berlin.'],
            ['tour_id' => 10, 'title' => 'Thông tin thời tiết', 'information' => 'Berlin có thể lạnh vào mùa đông, vui lòng chuẩn bị áo ấm.'],
            ['tour_id' => 10, 'title' => 'Khuyến mãi', 'information' => 'Giảm giá 15% cho khách hàng đăng ký trước 1 tháng.'],
            ['tour_id' => 10, 'title' => 'Thông tin an toàn', 'information' => 'Cần cẩn thận với đồ đạc cá nhân khi tham quan.'],
            ['tour_id' => 10, 'title' => 'Thông tin sức khỏe', 'information' => 'Khách hàng cần có sức khỏe tốt để tham gia các hoạt động.'],
        ]);
    }
}
