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
            ['name' => 'Trà vinh'],
            ['name' => 'Sóc trăng'],
            ['name' => 'Cần Thơ'],
            ['name' => 'Long An'],
            ['name' => 'Hà Giang'],
            ['name' => 'Vĩnh Long'],
            ['name' => 'Hà Nội'],
            ['name' => 'Bạc Liêu'],
            ['name' => 'Cà Mau']
        ]);
    }
}
