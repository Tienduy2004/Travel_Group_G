<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartureScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departure_schedule')->insert([
            ['tour_id' => 1, 'date' => '2024-12-01', 'price' => 3000000, 'seat_number' => 9],
            ['tour_id' => 1, 'date' => '2024-12-15', 'price' => 2000000, 'seat_number' => 7],
            ['tour_id' => 2, 'date' => '2024-11-20', 'price' => 7000000, 'seat_number' => 7],
            ['tour_id' => 3, 'date' => '2024-10-10', 'price' => 12000000, 'seat_number' => 9],
            ['tour_id' => 4, 'date' => '2024-09-05', 'price' => 8000000, 'seat_number' => 10],
            ['tour_id' => 5, 'date' => '2024-08-15', 'price' => 15000000, 'seat_number' => 9],
            ['tour_id' => 6, 'date' => '2024-07-20', 'price' => 18000000, 'seat_number' => 10],
            ['tour_id' => 7, 'date' => '2024-06-25', 'price' => 20000000, 'seat_number' => 10],
            ['tour_id' => 8, 'date' => '2024-05-30', 'price' => 6000000, 'seat_number' => 9],
            ['tour_id' => 9, 'date' => '2024-04-15', 'price' => 5500000, 'seat_number' => 8],
        ]);
    }
}
