<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class departure_location extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departure_location')->insert([
            ['name' => 'Việt Nam'],
            ['name' => 'Thái Lan'],
            ['name' => 'Nhật Bản'],
            ['name' => 'Hàn Quốc'],
            ['name' => 'Mỹ'],
            ['name' => 'Anh'],
            ['name' => 'Pháp'],
            ['name' => 'Úc'],
            ['name' => 'Canada'],
            ['name' => 'Ấn Độ'],
            ['name' => 'Malaysia'],
            ['name' => 'Singapore'],
            ['name' => 'Indonesia'],
            ['name' => 'Tây Ban Nha'],
            ['name' => 'Ý'],
            ['name' => 'Đức']
        ]);
    }
}
