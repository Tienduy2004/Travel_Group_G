<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trip_information')->insert([
            ['id_trip_directory' => 1, 'content' => 'Tham quan Hồ Gươm, phố cổ Hà Nội và thưởng thức cà phê phố cổ.', 'tour_id' => 1],
            ['id_trip_directory' => 2, 'content' => 'Những món hải sản tươi ngon tại Hạ Long.', 'tour_id' => 1],
            ['id_trip_directory' => 3, 'content' => 'Một trong những ngôi chùa nổi tiếng tại Bangkok.', 'tour_id' => 1],
            ['id_trip_directory' => 4, 'content' => 'Trải nghiệm văn hóa Geisha tại Kyoto.', 'tour_id' => 1],
            ['id_trip_directory' => 5, 'content' => 'Tham gia vào các hoạt động trượt tuyết tại Busan.', 'tour_id' => 1],
            ['id_trip_directory' => 6, 'content' => 'Đến thăm biểu tượng của Paris.', 'tour_id' => 1],
            ['id_trip_directory' => 1, 'content' => 'Khám phá các món ăn đặc sản tại Bangkok.', 'tour_id' => 2],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Grand Palace và Wat Pho.', 'tour_id' => 2],
            ['id_trip_directory' => 3, 'content' => 'Khám phá văn hóa truyền thống tại Chiang Mai.', 'tour_id' => 2],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào lễ hội Songkran.', 'tour_id' => 2],
            ['id_trip_directory' => 5, 'content' => 'Thưởng thức ẩm thực đường phố tại Bangkok.', 'tour_id' => 2],
            ['id_trip_directory' => 6, 'content' => 'Tham gia vào các tour du lịch mạo hiểm tại Phuket.', 'tour_id' => 2],
            ['id_trip_directory' => 1, 'content' => 'Khám phá Tokyo với các địa điểm nổi tiếng.', 'tour_id' => 3],
            ['id_trip_directory' => 2, 'content' => 'Tham quan ngôi đền Senso-ji và khu phố Asakusa.', 'tour_id' => 3],
            ['id_trip_directory' => 3, 'content' => 'Tham gia lễ hội Hanami ngắm hoa anh đào.', 'tour_id' => 3],
            ['id_trip_directory' => 4, 'content' => 'Khám phá ẩm thực Nhật Bản tại Tsukiji.', 'tour_id' => 3],
            ['id_trip_directory' => 5, 'content' => 'Trải nghiệm mua sắm tại Ginza.', 'tour_id' => 3],
            ['id_trip_directory' => 6, 'content' => 'Khám phá các điểm tham quan tại Kyoto.', 'tour_id' => 3],
            ['id_trip_directory' => 1, 'content' => 'Tham quan các địa điểm nổi tiếng tại Seoul.', 'tour_id' => 4],
            ['id_trip_directory' => 2, 'content' => 'Khám phá ẩm thực Hàn Quốc tại Myeongdong.', 'tour_id' => 4],
            ['id_trip_directory' => 3, 'content' => 'Tham gia vào các hoạt động giải trí tại Lotte World.', 'tour_id' => 4],
            ['id_trip_directory' => 4, 'content' => 'Tham quan các ngôi đền và cung điện cổ.', 'tour_id' => 4],
            ['id_trip_directory' => 5, 'content' => 'Trải nghiệm văn hóa truyền thống Hàn Quốc.', 'tour_id' => 4],
            ['id_trip_directory' => 6, 'content' => 'Khám phá các món ăn đường phố tại Seoul.', 'tour_id' => 4],
            ['id_trip_directory' => 1, 'content' => 'Khám phá vẻ đẹp tự nhiên tại New York.', 'tour_id' => 5],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Central Park và Times Square.', 'tour_id' => 5],
            ['id_trip_directory' => 3, 'content' => 'Khám phá các bảo tàng nổi tiếng.', 'tour_id' => 5],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các hoạt động văn hóa tại Broadway.', 'tour_id' => 5],
            ['id_trip_directory' => 5, 'content' => 'Thưởng thức ẩm thực đa dạng tại New York.', 'tour_id' => 5],
            ['id_trip_directory' => 6, 'content' => 'Khám phá lịch sử tại Ellis Island.', 'tour_id' => 5],
            ['id_trip_directory' => 1, 'content' => 'Tham quan các địa điểm nổi tiếng tại London.', 'tour_id' => 6],
            ['id_trip_directory' => 2, 'content' => 'Khám phá ẩm thực Anh tại Borough Market.', 'tour_id' => 6],
            ['id_trip_directory' => 3, 'content' => 'Tham gia vào các hoạt động văn hóa tại West End.', 'tour_id' => 6],
            ['id_trip_directory' => 4, 'content' => 'Khám phá lịch sử tại Tower of London.', 'tour_id' => 6],
            ['id_trip_directory' => 5, 'content' => 'Tham quan Buckingham Palace.', 'tour_id' => 6],
            ['id_trip_directory' => 6, 'content' => 'Trải nghiệm cuộc sống tại Camden Market.', 'tour_id' => 6],
            ['id_trip_directory' => 1, 'content' => 'Khám phá các địa điểm nổi tiếng tại Sydney.', 'tour_id' => 7],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Sydney Opera House và Harbour Bridge.', 'tour_id' => 7],
            ['id_trip_directory' => 3, 'content' => 'Tham gia vào các hoạt động biển tại Bondi Beach.', 'tour_id' => 7],
            ['id_trip_directory' => 4, 'content' => 'Khám phá ẩm thực Úc tại Darling Harbour.', 'tour_id' => 7],
            ['id_trip_directory' => 5, 'content' => 'Tham quan các vườn quốc gia gần Sydney.', 'tour_id' => 7],
            ['id_trip_directory' => 6, 'content' => 'Trải nghiệm cuộc sống tại khu phố The Rocks.', 'tour_id' => 7],
            ['id_trip_directory' => 1, 'content' => 'Khám phá vẻ đẹp thiên nhiên tại Toronto.', 'tour_id' => 8],
            ['id_trip_directory' => 2, 'content' => 'Tham quan CN Tower và Royal Ontario Museum.', 'tour_id' => 8],
            ['id_trip_directory' => 3, 'content' => 'Khám phá ẩm thực Canada tại St. Lawrence Market.', 'tour_id' => 8],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các hoạt động giải trí tại Niagara Falls.', 'tour_id' => 8],
            ['id_trip_directory' => 5, 'content' => 'Trải nghiệm văn hóa đa dạng tại Toronto.', 'tour_id' => 8],
            ['id_trip_directory' => 6, 'content' => 'Tham quan các công viên lớn tại Toronto.', 'tour_id' => 8],
            ['id_trip_directory' => 1, 'content' => 'Khám phá vẻ đẹp văn hóa tại Delhi.', 'tour_id' => 9],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Taj Mahal và các di tích lịch sử khác.', 'tour_id' => 9],
            ['id_trip_directory' => 3, 'content' => 'Khám phá ẩm thực Ấn Độ tại Chandni Chowk.', 'tour_id' => 9],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các lễ hội văn hóa tại Delhi.', 'tour_id' => 9],
            ['id_trip_directory' => 5, 'content' => 'Khám phá đời sống địa phương tại Delhi.', 'tour_id' => 9],
            ['id_trip_directory' => 6, 'content' => 'Tham quan các công trình kiến trúc độc đáo.', 'tour_id' => 9],
            ['id_trip_directory' => 1, 'content' => 'Khám phá vẻ đẹp văn hóa tại Kuala Lumpur.', 'tour_id' => 10],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Petronas Twin Towers và Batu Caves.', 'tour_id' => 10],
            ['id_trip_directory' => 3, 'content' => 'Khám phá ẩm thực Malaysia tại Jalan Alor.', 'tour_id' => 10],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các hoạt động giải trí tại Sunway Lagoon.', 'tour_id' => 10],
            ['id_trip_directory' => 5, 'content' => 'Khám phá lịch sử tại Malacca.', 'tour_id' => 10],
            ['id_trip_directory' => 6, 'content' => 'Tham quan các khu phố cổ tại Kuala Lumpur.', 'tour_id' => 10],
            ['id_trip_directory' => 1, 'content' => 'Khám phá các món ăn nổi tiếng tại Barcelona.', 'tour_id' => 11],
            ['id_trip_directory' => 2, 'content' => 'Tham quan La Sagrada Família và Park Güell.', 'tour_id' => 11],
            ['id_trip_directory' => 3, 'content' => 'Khám phá văn hóa Catalonia tại Barcelona.', 'tour_id' => 11],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các lễ hội địa phương.', 'tour_id' => 11],
            ['id_trip_directory' => 5, 'content' => 'Khám phá các bãi biển nổi tiếng tại Barcelona.', 'tour_id' => 11],
            ['id_trip_directory' => 6, 'content' => 'Trải nghiệm cuộc sống tại Las Ramblas.', 'tour_id' => 11],
            ['id_trip_directory' => 1, 'content' => 'Khám phá các địa điểm nổi tiếng tại Rome.', 'tour_id' => 12],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Đấu trường La Mã và Vatican.', 'tour_id' => 12],
            ['id_trip_directory' => 3, 'content' => 'Khám phá ẩm thực Ý tại Rome.', 'tour_id' => 12],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các hoạt động văn hóa tại Rome.', 'tour_id' => 12],
            ['id_trip_directory' => 5, 'content' => 'Khám phá lịch sử tại các di tích cổ đại.', 'tour_id' => 12],
            ['id_trip_directory' => 6, 'content' => 'Tham quan các bảo tàng nổi tiếng tại Rome.', 'tour_id' => 12],
            ['id_trip_directory' => 1, 'content' => 'Khám phá vẻ đẹp văn hóa tại Berlin.', 'tour_id' => 13],
            ['id_trip_directory' => 2, 'content' => 'Tham quan Bức tường Berlin và Brandenburg Gate.', 'tour_id' => 13],
            ['id_trip_directory' => 3, 'content' => 'Khám phá ẩm thực Đức tại Berlin.', 'tour_id' => 13],
            ['id_trip_directory' => 4, 'content' => 'Tham gia vào các hoạt động văn hóa tại Berlin.', 'tour_id' => 13],
            ['id_trip_directory' => 5, 'content' => 'Khám phá lịch sử tại các di tích nổi tiếng.', 'tour_id' => 13],
            ['id_trip_directory' => 6, 'content' => 'Tham quan các bảo tàng nổi tiếng tại Berlin.', 'tour_id' => 13],
        ]);
    }
}
