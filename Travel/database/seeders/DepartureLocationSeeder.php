<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartureLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departure_location')->insert([
            ['name' => 'Hà Nội'],
            ['name' => 'TP Hồ Chí Minh'],
            ['name' => 'Đà Nẵng'],
            ['name' => 'Nha Trang'],
            ['name' => 'Hạ Long'],
            ['name' => 'Huế'],
            ['name' => 'Vũng Tàu'],

        ]);
    }
}
