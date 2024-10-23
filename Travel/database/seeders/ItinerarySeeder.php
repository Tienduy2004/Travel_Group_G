<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('itinerary')->insert([
            ['tour_id' => 1, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Hà Nội, tham quan Hồ Gươm, phố cổ, và thưởng thức cà phê phố cổ.'],
            ['tour_id' => 1, 'title' => 'Tham quan địa điểm B', 'description' => 'Khám phá Hạ Long, tham gia các hoạt động thể thao nước và ăn tối tại nhà hàng trên bờ biển.'],
            ['tour_id' => 1, 'title' => 'Đến thành phố biển', 'description' => 'Khởi hành từ TP.HCM, đến thành phố biển, check-in tại khách sạn và tham gia tiệc tối.'],
            ['tour_id' => 1, 'title' => 'Tham quan bãi biển', 'description' => 'Tham gia các hoạt động thể thao nước tại bãi biển, ăn trưa tại nhà hàng bên biển.'],
            ['tour_id' => 1, 'title' => 'Khám phá văn hóa', 'description' => 'Tham quan các di sản văn hóa, thưởng thức ẩm thực đặc sản và tham gia các buổi biểu diễn văn nghệ.'],
            ['tour_id' => 1, 'title' => 'Trở về', 'description' => 'Tham quan địa điểm C vào buổi sáng, ăn trưa tại địa phương, và trở về Hà Nội vào buổi chiều.'],
            ['tour_id' => 2, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Bangkok, tham quan Grand Palace và thưởng thức ẩm thực địa phương.'],
            ['tour_id' => 2, 'title' => 'Tham quan văn hóa', 'description' => 'Khám phá văn hóa truyền thống tại Chiang Mai và tham gia lễ hội Songkran.'],
            ['tour_id' => 2, 'title' => 'Khám phá ẩm thực', 'description' => 'Thưởng thức ẩm thực đường phố tại Bangkok và tham gia vào các tour du lịch mạo hiểm tại Phuket.'],
            ['tour_id' => 3, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Tokyo, tham quan Senso-ji và trải nghiệm lễ hội Hanami.'],
            ['tour_id' => 3, 'title' => 'Khám phá ẩm thực', 'description' => 'Khám phá ẩm thực Nhật Bản tại Tsukiji và tham gia vào các hoạt động văn hóa tại Kyoto.'],
            ['tour_id' => 4, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Seoul, tham quan các địa điểm nổi tiếng và khám phá ẩm thực Hàn Quốc.'],
            ['tour_id' => 5, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ New York, tham quan Central Park và Times Square.'],
            ['tour_id' => 6, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ London, tham quan các địa điểm nổi tiếng và khám phá ẩm thực Anh.'],
            ['tour_id' => 7, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Sydney, tham quan Opera House và trải nghiệm các hoạt động biển.'],
            ['tour_id' => 8, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Toronto, tham quan CN Tower và khám phá ẩm thực Canada.'],
            ['tour_id' => 9, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Delhi, tham quan Taj Mahal và khám phá ẩm thực Ấn Độ.'],
            ['tour_id' => 10, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Kuala Lumpur, tham quan Petronas Towers và trải nghiệm các hoạt động giải trí.'],
            ['tour_id' => 11, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Barcelona, tham quan Sagrada Família và khám phá văn hóa Catalonia.'],
            ['tour_id' => 12, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Rome, tham quan Đấu trường La Mã và khám phá ẩm thực Ý.'],
            ['tour_id' => 13, 'title' => 'Khởi hành và tham quan', 'description' => 'Khởi hành từ Berlin, tham quan Bức tường Berlin và khám phá lịch sử Đức.'],
        ]);
    }
}
