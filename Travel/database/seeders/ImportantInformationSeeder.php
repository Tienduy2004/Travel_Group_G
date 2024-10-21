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
            // Thêm các thông tin khác theo cấu trúc tương tự
        ]);
    }
}
